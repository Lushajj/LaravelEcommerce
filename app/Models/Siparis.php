<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class Siparis extends Model
{
    protected $table = "siparis";

    protected $fillable = ['sepet_id','siparis_tutari','adsoyad','adres','telefon','ceptelefon','banka','taksit_sayisi','durum'];

    const CREATED_AT = 'olusturulma_tarihi';
    const UPDATED_AT = 'guncelleme_tarihi';
    const DELETED_AT = 'silinme_tarihi';

    public function sepet()
    {
        return $this->belongsTo('App\Models\Sepet');
    }
}
