<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrunDetay extends Model
{
    protected $table= "urun_detay";

    protected $guarded =[]; //Tüm alanlar eklenebilir.

    public $timestamps = false;

    public function urun()
    {
        return $this->belongsTo('App\Models\Urun');
    }
}
