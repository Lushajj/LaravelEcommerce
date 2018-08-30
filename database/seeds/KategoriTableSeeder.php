<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id = DB::table('kategori')->insertGetId([
            'kategori_adi'=>'Elektronik',
            'slug'=>'elektronik'
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Bilgisayar/Tablet',
            'slug'=>'bilgisayar-tablet',
            'ust_id'=>$id
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Telefon',
            'slug'=>'telefon',
            'ust_id'=>$id
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Kamera',
            'slug'=>'Kamera',
            'ust_id'=>$id
        ]);
        $id = DB::table('kategori')->insertGetId([
            'kategori_adi'=>'Kitap',
            'slug'=>'kitap'
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Çocuk',
            'slug'=>'Cocuk',
            'ust_id'=>$id
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Edebiyat',
            'slug'=>'Edebiyat',
            'ust_id'=>$id
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Sınavlara Hazırlık',
            'slug'=>'Sinavlara-hazirlik',
            'ust_id'=>$id
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Dergi',
            'slug'=>'dergi'
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Mobilya',
            'slug'=>'mobilya'
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Dekorasyon',
            'slug'=>'dekorasyon'
        ]);
        DB::table('kategori')->insert([
            'kategori_adi'=>'Kozmetik',
            'slug'=>'kozmetik'
        ]);
    }
}
