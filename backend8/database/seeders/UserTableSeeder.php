<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Administrador do Sistema',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$6oRO7.PT3loG7Ppw4KyNS.5iIB26aRnHTEV3FlVB7FfEIGDvxYaTa',
                'permissao' => 'ADM'
            ]
        );
    }
}
