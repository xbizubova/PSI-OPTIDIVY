<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OptometristaController extends Controller
{
    const SLOTS = ['9:00', '10:00', '11:00', '15:00', '16:00'];

    const LENS_TYPES = [
        'clear'       => 'Číre sklá',
        'sun'         => 'Slnečné dioptrické sklá',
        'photochromic'=> 'Fotochromatické sklá',
        'blue_filter' => 'Sklá s filtrom modrého svetla',
        'polarized'   => 'Polarizačné sklá',
    ];

    public function index()
    {
        $appointments = Appointment::with('customer')
            ->where('optometrist_id', auth()->id())
            ->whereDate('date', Carbon::today())
            ->where('booked', true)
            ->orderBy('slot')
            ->get();

        $patients = $appointments->map(fn($a) => [
            'id'         => $a->id,
            'customerId' => $a->customer_id,
            'name'       => $a->customer->first_name . ' ' . $a->customer->last_name,
            'time'       => self::SLOTS[$a->slot],
        ])->values();

        $lensTypes = self::LENS_TYPES;

        return view('optometrista', compact('appointments', 'patients', 'lensTypes'));
    }

    public function storePrescription(Request $request)
    {
        $request->validate([
            'appointment_id'   => ['required', 'exists:appointments,id'],
            'customer_id'      => ['required', 'exists:users,id'],

            // OD
            'od_ostrost' => ['required', 'in:0.8-1.0,0.4-0.6,0.1-0.32'],
            'sphere_right'     => ['required', 'numeric', 'min:-20', 'max:20'],
            'cylinder'         => ['required', 'numeric', 'min:-6.0', 'max:-0.25'],
            'axis'             => ['required', 'integer', 'min:0', 'max:180'],
            'pupil_distance'   => ['required', 'numeric', 'min:50', 'max:75'],

            // OS
            'os_ostrost' => ['required', 'in:0.8-1.0,0.4-0.6,0.1-0.32'],
            'sphere_left'      => ['required', 'numeric', 'min:-20', 'max:20'],
            'os_cylinder'      => ['required', 'numeric', 'min:-6.0', 'max:-0.25'],
            'os_axis'          => ['required', 'integer', 'min:0', 'max:180'],
            'os_pupil_distance'=> ['required', 'numeric', 'min:50', 'max:75'],

            'lens_type'        => ['required', 'in:' . implode(',', array_keys(self::LENS_TYPES))],
        ], [
            'od_ostrost.required'      => 'Zadajte zrakovú ostrosť (OD).',
            'od_ostrost.min'           => 'Zraková ostrosť musí byť min. 0.32.',
            'od_ostrost.max'           => 'Zraková ostrosť musí byť max. 0.8.',
            'sphere_right.required'    => 'Zadajte SPH pre pravé oko.',
            'sphere_right.min'         => 'SPH musí byť min. -20.',
            'sphere_right.max'         => 'SPH musí byť max. +20.',
            'cylinder.required'        => 'Zadajte CYL pre pravé oko.',
            'cylinder.min'             => 'CYL musí byť min. -6.0.',
            'cylinder.max'             => 'CYL musí byť max. -0.25.',
            'axis.required'            => 'Zadajte AX pre pravé oko.',
            'axis.min'                 => 'AX musí byť min. 0°.',
            'axis.max'                 => 'AX musí byť max. 180°.',
            'pupil_distance.required'  => 'Zadajte pupilárnu vzdialenosť (OD).',
            'pupil_distance.min'       => 'Pupilárna vzdialenosť musí byť min. 50 mm.',
            'pupil_distance.max'       => 'Pupilárna vzdialenosť musí byť max. 75 mm.',

            'os_ostrost.required'      => 'Zadajte zrakovú ostrosť (OS).',
            'sphere_left.required'     => 'Zadajte SPH pre ľavé oko.',
            'os_cylinder.required'     => 'Zadajte CYL pre ľavé oko.',
            'os_axis.required'         => 'Zadajte AX pre ľavé oko.',
            'os_pupil_distance.required' => 'Zadajte pupilárnu vzdialenosť (OS).',

            'lens_type.required'       => 'Vyberte typ skiel.',
            'lens_type.in'             => 'Neplatný typ skiel.',
        ]);

        // 5a. Zákazník už má predpis → vytvor NOVÝ záznam (nie updateOrCreate)
        Prescription::create([
            'customer_id'      => $request->customer_id,
            'od_ostrost'       => $request->od_ostrost,
            'sphere_right'     => $request->sphere_right,
            'cylinder'         => $request->cylinder,
            'axis'             => $request->axis,
            'pupil_distance'   => $request->pupil_distance,
            'os_ostrost'       => $request->os_ostrost,
            'sphere_left'      => $request->sphere_left,
            'os_cylinder'      => $request->os_cylinder,
            'os_axis'          => $request->os_axis,
            'os_pupil_distance'=> $request->os_pupil_distance,
            'lens_type'        => $request->lens_type,
        ]);

        // Označ rezerváciu ako dokončenú
        Appointment::find($request->appointment_id)
            ->update(['booked' => false]);

        return redirect()->route('optometrista')
            ->with('success', '✓ Predpis bol uložený.');
    }
}
