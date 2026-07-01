<?php

namespace Database\Seeders;

use App\Models\Dessert;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@dessert.local',
            'password' => bcrypt('admin123'),
        ]);

        $contohData = [
            [
                'nama_dessert' => 'Tiramisu Klasik',
                'komposisi' => 'Biskuit ladyfinger, mascarpone, kopi espresso, cokelat bubuk',
                'harga' => 35000,
                'kategori' => 'Cake',
            ],
            [
                'nama_dessert' => 'Es Krim Vanilla Premium',
                'komposisi' => 'Susu segar, vanilla bean, gula, krim kental',
                'harga' => 20000,
                'kategori' => 'Ice Cream',
            ],
            [
                'nama_dessert' => 'Puding Coklat Lava',
                'komposisi' => 'Cokelat dark, susu, agar-agar, gula',
                'harga' => 18000,
                'kategori' => 'Pudding',
            ],
            [
                'nama_dessert' => 'Croissant Almond',
                'komposisi' => 'Tepung terigu, mentega, almond slice, gula halus',
                'harga' => 22000,
                'kategori' => 'Pastry',
            ],
            [
                'nama_dessert' => 'Klepon Pandan',
                'komposisi' => 'Tepung ketan, gula merah, kelapa parut, daun pandan',
                'harga' => 12000,
                'kategori' => 'Traditional',
            ],
            [
                'nama_dessert' => 'Es Cendol Durian',
                'komposisi' => 'Cendol, santan, gula merah, durian',
                'harga' => 17000,
                'kategori' => 'Beverage Dessert',
            ],
        ];

        foreach ($contohData as $data) {
            Dessert::create($data);
        }
    }
}
