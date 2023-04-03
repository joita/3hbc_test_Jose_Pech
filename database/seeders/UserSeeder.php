<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('admin');

        User::create([
            'name' => 'Operaciones',
            'email' => 'operaciones@example.com',
            'password' => Hash::make('12345678'),
        ])->assignRole('operations');
    }
}
