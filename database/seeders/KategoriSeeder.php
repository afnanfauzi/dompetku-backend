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
            'nama_kategori' => 'Gaji',
            'is_active' => 1,
            'jenis_transaksi' => 1,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Makanan & Minuman',
            'is_active' => 1,
            'jenis_transaksi' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Kebutuhan Kucing',
            'is_active' => 1,
            'jenis_transaksi' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Keinginan',
            'is_active' => 1,
            'jenis_transaksi' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Kewajiban',
            'is_active' => 1,
            'jenis_transaksi' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Transportasi',
            'is_active' => 1,
            'jenis_transaksi' => 0,
            'user_id' => 1,
        ]);

        Kategori::create([
            'nama_kategori' => 'Pulsa & Internet',
            'is_active' => 1,
            'jenis_transaksi' => 0,
            'user_id' => 1,
        ]);
    }
}
