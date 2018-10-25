<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Urun;
use App\Models\Kategori;
use App\Models\UrunDetay;

class UrunController extends Controller
{
    public function index()
    {
        if (request()->filled('search')) {
            request()->flash();
            $search = request('search');
            $list = Urun::where('urun_adi','like',"%$search%")
                ->orWhere('aciklama','like',"%$search%")
                ->orderByDesc('id')
                ->paginate('8');
        }else{
            $list = Urun::orderBy('olusturulma_tarihi','desc')->paginate(8);
        }
        return view('yonetim.urun.index',compact('list'));
    }
    public function form($id = 0)
    {
        $entry = new Urun; // Boş urun kaydi
        $urun_kategoriler = [];
        if ($id > 0) {
            $entry = Urun::find($id);
            $urun_kategoriler = $entry->kategoriler()->pluck('kategori_id')->all(); // pluck tek bir kolon çeker
        }
        $kategoriler = Kategori::all();

        return view('yonetim.urun.form', compact('entry','kategoriler','urun_kategoriler'));
    }
    public function kaydet($id = 0) // id varsa güncelleştirme id 0'sa kayıt etme
    {
        $data = request()->only('urun_adi','slug', 'aciklama','fiyati');
        if (!request()->filled('slug')) {
            $data['slug'] = str_slug(request('urun_adi'));
        }
        $this->validate(request(),[
            'urun_adi'=>'required',
            'fiyati'=>'required',
            'slug'=>(request('original_slug') != request('slug') ? 'unique:urun,slug' : '')
        ]);
        $data_detay = request()->only(
            'goster_slider','goster_gunun_firsati','goster_one_cikan','goster_cok_satan','goster_indirimli'
        );

        $kategoriler = request('kategoriler');

        if ($id > 0) { // güncelleme
            $entry = Urun::where('id',$id)->firstOrFail();
            $entry->update($data);
            $entry->detay()->update($data_detay);
            $entry->kategoriler()->sync($kategoriler);
        }
        else{ //kayıt
            $entry = Urun::create($data);
            $entry->detay()->create($data_detay);
            $entry->kategoriler()->attach($kategoriler);
        }
        if (request()->hasFile('urun_resmi')) { //Sadece dosya seçildiği zaman devreye girer.
            $this->validate(request(), [
                'urun_resmi' => 'image|mimes:jpg,png,jpeg,gif|max:2048'
            ]);

            $urun_resmi = request()->file('urun_resmi');
            $dosyaadi = $entry->id . "-" . time() . "." . $urun_resmi->extension();

            if ($urun_resmi->isValid()) { // Geçici alanda düzgünbir şekilde yüklenip yüklenmediğini kontrol eder.
                $urun_resmi->move('uploads/urunler',$dosyaadi);

                UrunDetay::updateOrCreate(
                    ['urun_id' => $entry->id],
                    ['urun_resmi' => $dosyaadi]
                );
            }
        }
        return redirect()
            ->route('yonetim.urun.duzenle', $entry->id)
            ->with('mesaj',($id > 0) ? 'Guncellendi' : 'Kaydedildi')
            ->with('mesaj_tur','success');
    }
    public function sil($id)
    {
        $urun = Urun::find($id);
        $urun->kategoriler()->detach(); //ManytoMany yapısıyla detach kullanılıyor.
        $urun->delete();

        return redirect()
            ->route('yonetim.urun')
            ->with('mesaj','Kayıt Silindi.')
            ->with('mesaj_tur','success');
    }
}
