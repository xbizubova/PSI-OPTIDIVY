<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today()->toDateString();

        // Dnešné rezervácie pre optometristu ID=1
        // Zákazníci ID: 4=Mrkvička, 5=Chudá, 6=Hollý
        $appointments = [
            [
                'customer_id'    => 4,
                'optometrist_id' => 1,
                'date'           => $today,
                'slot'           => 0, // 9:00
                'booked'         => true,
            ],
            [
                'customer_id'    => 5,
                'optometrist_id' => 1,
                'date'           => $today,
                'slot'           => 2, // 11:00
                'booked'         => true,
            ],
            [
                'customer_id'    => 6,
                'optometrist_id' => 1,
                'date'           => $today,
                'slot'           => 4, // 16:00
                'booked'         => true,
            ],
        ];

        foreach ($appointments as $appointment) {
            Appointment::create($appointment);
        }
    }
}
