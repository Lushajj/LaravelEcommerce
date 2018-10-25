<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UrunTableSeeder::class);
        $this->call(KategoriTableSeeder::class);
        $this->call(KullaniciSeeder::class);
    }
}
