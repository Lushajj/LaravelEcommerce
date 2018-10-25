<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Models\Siparis;
use App\Models\Urun;
use App\Models\Kategori;
use App\Kullanici;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot() // Uygulama ilk çalıştığında devreye girer.
    {
        Schema::defaultStringLength(191);

        // yonetim ile başlayan tüm view dosyaları içerisinde erişilebilir değişkenler tanımlamayı sağlar.
        // yonetim.* : yonetim klasörü içerisindeki tüm view leri ifade eder.
        View::composer(['yonetim.*'], function ($view) {
            $bitisZamani = now()->addMinutes(10);
            $istatistikler = Cache::remember('istatistikler', $bitisZamani, function () { // Cache alanında kullanmayı sağlıyor.
                return [
                    'bekleyen_siparis' => Siparis::where('durum', 'Siparişiniz Alındı')->count(),
                    'tamamlanan_siparis' => Siparis::where('durum', 'Siparişiniz Tamamlandı')->count(),
                    'toplam_urun' => Urun::count(),
                    'toplam_kategori' => Kategori::count(),
                    'kullanici' => Kullanici::count(),
                ];
            });

            $view->with('istatistikler', $istatistikler);
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
