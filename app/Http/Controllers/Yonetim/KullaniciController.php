<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Kullanici;
use App\Models\KullaniciDetay;
use Hash;

class KullaniciController extends Controller
{
    public function oturumac()
    {
        if (request()->isMethod('POST')) {
            $this->validate(request(),[
                'email' => 'required|email',
                'sifre' => 'required'
            ]);
            $credentials = [
                'email'=> request()->get('email'),
                'password'=> request()->get('sifre'), //Laravel password olarak tanımlandığı için kendi değişkenimizi model dosyasından düzeltiyoruz.
                'yonetici_mi'=> 1,
                'aktif_mi'=> 1
            ];
            if (Auth::guard('yonetim')->attempt($credentials, request()->has('benihatirla'))) {
                return redirect()->route('yonetim.anasayfa');
            }
            else{
                return back()->withInput()->withErrors(['email'=>'Giriş hatalı !']);
            }
        }
        return view('yonetim.oturumac');
    }
    public function oturumukapat()
    {
        Auth::guard('yonetim')->logout();
        request()->session()->flush();
        request()->session()->regenerate();

        return redirect()->route('yonetim.oturumac');
    }
    public function index()
    {
        if (request()->filled('search')) {
            request()->flash();
            $search = request('search');
            $list = Kullanici::where('adsoyad','like',"%$search%")
                ->orWhere('email','like',"%$search%")
                ->orderByDesc('olusturulma_tarihi')
                ->paginate('8');
        }else{
            $list = Kullanici::orderBy('olusturulma_tarihi','asc')->paginate(8);
        }
        return view('yonetim.kullanici.index',compact('list'));
    }
    public function form($id = 0)
    {
        $entry = new Kullanici; // Boş kullanici kaydi
        if ($id > 0) {
            $entry = Kullanici::find($id);
        }
        return view('yonetim.kullanici.form', compact('entry'));
    }
    public function kaydet($id = 0) // id varsa güncelleştirme id 0'sa kayıt etme
    {
        $this->validate(request(),[
            'adsoyad'=>'required',
            'email'=>'required|email'
        ]);
        $data = request()->only('adsoyad','email');
        if (request()->filled('sifre')) {
            $data['sifre'] = Hash::make(request('sifre'));
        }
        $data['aktif_mi'] = request()->has('aktif_mi') ? 1 : 0;
        $data['yonetici_mi'] = request()->has('yonetici_mi') ? 1 : 0;

        if ($id > 0) { // güncelleme
            $entry = Kullanici::where('id',$id)->firstOrFail();
            $entry->update($data);
        }
        else{ //kayıt
            $entry = Kullanici::create($data);
        }

        KullaniciDetay::updateOrCreate(
            ['kullanici_id'=> $entry->id],
            [
                'adres'=> request('adres'),
                'telefon'=> request('telefon'),
                'ceptelefon'=> request('ceptelefon')
            ]
        );

        return redirect()
            ->route('yonetim.kullanici.duzenle', $entry->id)
            ->with('mesaj',($id > 0) ? 'Guncellendi' : 'Kaydedildi')
            ->with('mesaj_tur','success');
    }
    public function sil($id)
    {
        Kullanici::destroy($id);

        return redirect()
            ->route('yonetim.kullanici')
            ->with('mesaj','Kayıt Silindi.')
            ->with('mesaj_tur','success');
    }
}
