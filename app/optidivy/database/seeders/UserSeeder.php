<?php

namespace Database\Seeders;

use App\Models\Users\User;
use App\Models\Prescriptions\Prescription;
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

        $customer = User::where('email', 'mrkvicka@gmail.com')->first();

        Prescription::create([
            'customer_id'    => $customer->id,
            'sphere_right'   => -1.5,
            'sphere_left'    => -1.25,
            'cylinder'       => -0.5,
            'axis'           => 90,
            'pupil_distance' => 63.0,
        ]);
    }
}
