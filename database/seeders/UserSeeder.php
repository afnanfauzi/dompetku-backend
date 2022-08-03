<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Afnan Fauzi',
            'email' => 'afnanfauzihidayat@gmail.com',
            'password' => bcrypt('87654321'),
            'is_active' => '1'
        ]);

        $admin->assignRole('administrator');
    }
}
