<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Siparis;
use App\Models\Kategori;
use App\Models\Sepet;
use App\Models\SiparisDetay;

class SiparisController extends Controller
{
    public function index()
    {
        if (request()->filled('search')) {
            request()->flash();
            $search = request('search');
            $list = Siparis::with('sepet.kullanici') // With EagerLoading tek seferde çekmeyi sağlar.
                ->where('adsoyad','like',"%$search%")
                ->orWhere('id','like',"%$search%")
                ->orderByDesc('id')
                ->paginate('8');
        }else{
            $list = Siparis::with('sepet.kullanici')->orderBy('olusturulma_tarihi','desc')->paginate(8);
        }
        return view('yonetim.siparis.index',compact('list'));
    }
    public function form($id = 0)
    {
        if ($id > 0) {
            $entry = Siparis::with('sepet.sepet_urunler.urun')->find($id);
        }

        return view('yonetim.siparis.form', compact('entry'));
    }
    public function kaydet($id = 0) //
    {
        $this->validate(request(),[
            'adsoyad'=>'required',
            'adres'=>'required',
            'telefon'=>'required',
            'durum'=>'required',
        ]);

        $data = request()->only('adsoyad','adres', 'telefon','ceptelefon','durum');
        if ($id > 0) { // güncelleme
            $entry = Siparis::where('id',$id)->firstOrFail();
            $entry->update($data);
        }
        return redirect()
            ->route('yonetim.siparis.duzenle', $entry->id)
            ->with('mesaj','Guncellendi')
            ->with('mesaj_tur','success');
    }
    public function sil($id)
    {
        Siparis::destroy($id);
        return redirect()
            ->route('yonetim.siparis')
            ->with('mesaj','Kayıt Silindi.')
            ->with('mesaj_tur','success');
    }
}
