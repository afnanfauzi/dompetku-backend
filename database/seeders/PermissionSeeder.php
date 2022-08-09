<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create([
            'name' => 'transaksi-create',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'transaksi-read',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'transaksi-update',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'transaksi-delete',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'hutang-create',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'hutang-read',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'hutang-update',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'kategori-create',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'kategori-read',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'kategori-update',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'dashboard-read',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'mitra-create',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'mitra-read',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'mitra-update',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'pengaturan-read',
            'guard_name' => 'web',
        ]);

        Permission::create([
            'name' => 'pengaturan-update',
            'guard_name' => 'web',
        ]);

    }
}
