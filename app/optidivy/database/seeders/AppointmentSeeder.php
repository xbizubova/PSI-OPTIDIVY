<?php

namespace Database\Seeders;

use App\Models\Appointments\Appointment;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $optometrist = User::where('email', 'novak@optidivy.sk')->first();
        $customers   = User::where('role', 'customer')->get();

        $today = now()->toDateString();

        // Sloty 0–7 zodpovedajú časom v OptometristaController::SLOTS
        // Uprav ak máš iné sloty
        $slots = [0, 1, 2];

        foreach ($customers as $index => $customer) {
            Appointment::create([
                'customer_id'    => $customer->id,
                'optometrist_id' => $optometrist->id,
                'date'           => $today,
                'slot'           => $slots[$index % count($slots)],
                'booked'         => true,
            ]);
        }
    }
}
