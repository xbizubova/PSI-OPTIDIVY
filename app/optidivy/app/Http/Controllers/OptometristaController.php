<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OptometristaController extends Controller
{
    const SLOTS = ['9:00', '10:00', '11:00', '15:00', '16:00'];

    public function index()
    {
        $appointments = Appointment::with('customer')
            ->where('optometrist_id', auth()->id())
            ->whereDate('date', Carbon::today())
            ->where('booked', true)
            ->orderBy('slot')
            ->get();

        return view('optometrista', compact('appointments'));
    }

    public function storePrescription(Request $request)
    {
        $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id'],
            'customer_id'    => ['required', 'exists:users,id'],
            'sphere_right'   => ['required', 'numeric'],
            'sphere_left'    => ['required', 'numeric'],
            'cylinder'       => ['required', 'numeric'],
            'axis'           => ['required', 'numeric'],
            'pupil_distance' => ['required', 'numeric'],
        ]);

        // Ulož alebo aktualizuj predpis
        Prescription::updateOrCreate(
            ['customer_id' => $request->customer_id],
            [
                'sphere_right'   => $request->sphere_right,
                'sphere_left'    => $request->sphere_left,
                'cylinder'       => $request->cylinder,
                'axis'           => $request->axis,
                'pupil_distance' => $request->pupil_distance,
            ]
        );

        // Označ rezerváciu ako dokončenú
        Appointment::find($request->appointment_id)
            ->update(['booked' => false]);

        return redirect()->route('optometrista')
            ->with('success', '✓ Predpis bol uložený.');
    }
}
