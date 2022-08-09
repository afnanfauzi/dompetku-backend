<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'administrator',
            'guard_name' => 'web',
            'is_active' => '1'
        ]);     

        $admin->givePermissionTo('transaksi-create','transaksi-read','transaksi-update','transaksi-delete','hutang-create','hutang-read','hutang-update','kategori-create','kategori-read','kategori-update','dashboard-read','mitra-create','mitra-read','mitra-update','pengaturan-read','pengaturan-update');
        

        $user = Role::create([
            'name' => 'user',
            'guard_name' => 'web',
            'is_active' => '1'
        ]);     

        $user->givePermissionTo('transaksi-create','transaksi-read','transaksi-update','transaksi-delete','hutang-create','hutang-read','hutang-update','kategori-create','kategori-read','kategori-update','dashboard-read','mitra-create','mitra-read','mitra-update');

    }
}
