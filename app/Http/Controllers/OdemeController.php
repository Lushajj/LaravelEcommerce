<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart;
use App\Models\Siparis;

class OdemeController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return redirect()->route('kullanici.oturumac')
                ->with('mesaj_tur', 'info')
                ->with('mesaj', 'Ödeme işlemi için oturum açmanız gerekmektedir.');
        } elseif (count(Cart::content()) == 0) {
            return redirect()->route('anasayfa')
                ->with('mesaj_tur', 'info')
                ->with('mesaj', 'Ödeme işlemi için sepetinizde ürün olması gerekmektedir.');
        }

        $kullanici_detay = auth()->user()->detay;

        return view('odeme', compact('kullanici_detay'));
    }

    public function odemeyap()
    {
        $siparis = request()->all();
        $siparis['sepet_id'] = session('aktif_sepet_id');
        $siparis['banka'] = 'Garanti';
        $siparis['taksit_sayisi'] = 1;
        $siparis['durum'] = 'Siparişiniz Alındı';
        $siparis['siparis_tutari'] = (float) Cart::subtotal(); //Kdvsiz aldık.

        Siparis::create($siparis);
        Cart::destroy();
        session()->forget('aktif_sepet_id');

        return redirect()->route('siparisler')
            ->with('mesaj_tur', 'success')
            ->with('mesaj', 'Ödemeniz başarılı bir şekilde gerçekleşti.');
    }
}
