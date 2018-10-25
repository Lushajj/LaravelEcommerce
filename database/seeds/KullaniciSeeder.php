<?php

use Illuminate\Database\Seeder;
use App\Kullanici;
use App\Models\KullaniciDetay;

class KullaniciSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker\Generator $faker)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Kullanici::truncate();
        KullaniciDetay::truncate();

        $kullanici_yonetici = Kullanici::create([
            'adsoyad' => 'Gökhan BATYAR',
            'email' => 'GokhanB14@gmail.com',
            'sifre' => bcrypt('12345'),
            'aktif_mi' => 1,
            'yonetici_mi' => 1
        ]);
        $kullanici_yonetici->detay()->create([
            'adres' => 'Bolu',
            'telefon' => '542 813 28 40',
            'ceptelefon' => '542 813 28 40'
        ]);

        for ($i=0; $i <50 ; $i++) {
            $kullanici_musteri = Kullanici::create([
                'adsoyad' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'sifre' => bcrypt('12345'),
                'aktif_mi' => 1,
                'yonetici_mi' => 0
            ]);
            $kullanici_musteri->detay()->create([
                'adres' => $faker->address,
                'telefon' => $faker->e164PhoneNumber,
                'ceptelefon' => $faker->e164PhoneNumber
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
