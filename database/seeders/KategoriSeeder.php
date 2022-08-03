<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'nama_kategori' => 'Makanan & Minuman',
            'is_active' => 1,
            'plot_uang' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Transportasi',
            'is_active' => 1,
            'plot_uang' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Pulsa & Internet',
            'is_active' => 1,
            'plot_uang' => 0,
            'user_id' => 1,
        ]);
    }
}
