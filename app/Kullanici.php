<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kullanici extends Authenticatable
{
    use SoftDeletes;
    protected $table = "kullanici";
    protected $fillable = ['adsoyad', 'email', 'sifre','aktivasyon_anahtari','aktif_mi'];
    protected $hidden = ['sifre', 'aktivasyon_anahtari'];
    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';

    public function getAuthPassword()
    {
        return $this->sifre;
    }
}
