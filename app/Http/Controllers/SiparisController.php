<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siparis;

class SiparisController extends Controller
{
    public function index()
    {
        $siparisler = Siparis::with('sepet')
            ->whereHas('sepet', function($query) { // İlişkili olan tabloda filtreleme yapmayı sağlar.
                $query->where('kullanici_id', auth()->id());
            })
            ->orderByDesc('id')->get();

        return view('siparisler', compact('siparisler'));
    }
    public function detay($id)
    {
        $siparis = Siparis::with('sepet')
            ->whereHas('sepet', function($query) { // İlişkili olan tabloda filtreleme yapmayı sağlar.
                $query->where('kullanici_id', auth()->id());
            })
        ->where('siparis.id',$id)
        ->firstOrFail();
        return view('siparis',compact('siparis'));
    }
}
