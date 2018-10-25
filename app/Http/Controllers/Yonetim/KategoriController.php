<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        if (request()->filled('search') || request()->filled('ust_id')) {
            request()->flash(); // Bu gelen değerleri koruma geri döndürme
            $search = request('search');
            $ust_id = request('ust_id');
            $list = Kategori::where('kategori_adi','like',"%$search%")
                ->where('ust_id',$ust_id)
                ->orderByDesc('id')
                ->paginate('2')
                ->appends(['search'=> $search, 'ust_id'=>$ust_id]);
        }else{
            request()->flush();
            $list = Kategori::orderBy('id','desc')->paginate(8);
        }

        $anakategoriler = Kategori::where('ust_id',null)->get();
        return view('yonetim.kategori.index',compact('list','anakategoriler'));
    }
    public function form($id = 0)
    {
        $entry = new Kategori; // Boş kategori kaydi
        if ($id > 0) {
            $entry = Kategori::find($id);
        }
        $kategoriler = Kategori::all();
        return view('yonetim.kategori.form', compact('entry','kategoriler'));
    }
    public function kaydet($id = 0) // id varsa güncelleştirme id 0'sa kayıt etme
    {
        $data = request()->only('kategori_adi','slug', 'ust_id');
        if (!request()->filled('slug')) {
            $data['slug'] = str_slug(request('kategori_adi'));
        }
        $this->validate(request(),[
            'kategori_adi'=>'required',
            'slug'=>(request('original_slug') != request('slug') ? 'unique:kategori,slug' : '')
        ]);
        if ($id > 0) { // güncelleme
            $entry = Kategori::where('id',$id)->firstOrFail();
            $entry->update($data);
        }
        else{ //kayıt
            $entry = Kategori::create($data);
        }

        return redirect()
            ->route('yonetim.kategori.duzenle', $entry->id)
            ->with('mesaj',($id > 0) ? 'Guncellendi' : 'Kaydedildi')
            ->with('mesaj_tur','success');
    }
    public function sil($id)
    {
        $kategori = Kategori::find($id);
        $kategori->urunler()->detach();
        $kategori->delete();

        return redirect()
            ->route('yonetim.kategori')
            ->with('mesaj','Kayıt Silindi.')
            ->with('mesaj_tur','success');
    }
}
