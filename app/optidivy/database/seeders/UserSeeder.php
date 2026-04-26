<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Optometrista
        User::create([
            'first_name' => 'Ján',
            'last_name'  => 'Novák',
            'email'      => 'novak@optidivy.sk',
            'password'   => Hash::make('heslo123'),
            'role'       => 'optometrist',
        ]);

        // Technician
        User::create([
            'first_name' => 'Peter',
            'last_name'  => 'Kováč',
            'email'      => 'kovac@optidivy.sk',
            'password'   => Hash::make('heslo123'),
            'role'       => 'technician',
        ]);

        // Manager
        User::create([
            'first_name' => 'Mária',
            'last_name'  => 'Horváth',
            'email'      => 'horvath@optidivy.sk',
            'password'   => Hash::make('heslo123'),
            'role'       => 'manager',
        ]);

        // Zákazníci
        User::create([
            'first_name' => 'Jozef',
            'last_name'  => 'Mrkvička',
            'email'      => 'mrkvicka@gmail.com',
            'password'   => Hash::make('heslo123'),
            'role'       => 'customer',
        ]);

        User::create([
            'first_name' => 'Sára',
            'last_name'  => 'Chudá',
            'email'      => 'chuda@gmail.com',
            'password'   => Hash::make('heslo123'),
            'role'       => 'customer',
        ]);

        User::create([
            'first_name' => 'Miroslav',
            'last_name'  => 'Hollý',
            'email'      => 'holly@gmail.com',
            'password'   => Hash::make('heslo123'),
            'role'       => 'customer',
        ]);
    }
}
