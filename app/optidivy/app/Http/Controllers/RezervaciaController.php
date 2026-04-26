<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RezervaciaController extends Controller
{
    // Časy slotov – index zodpovedá číslu v DB
    const SLOTS = ['9:00', '10:00', '11:00', '15:00', '16:00'];

    public function index()
    {
        // Vezmi najbližších 14 dní
        $from = Carbon::today();
        $to   = Carbon::today()->addDays(14);

        // Načítaj obsadené sloty z DB
        $booked = Appointment::whereBetween('date', [$from, $to])
            ->where('booked', true)
            ->get()
            ->groupBy('date'); // ['2026-04-28' => [Appointment, ...]]

        // Vypočítaj voľné sloty pre každý deň
        $availableSlots = [];

        for ($d = $from->copy(); $d->lte($to); $d->addDay()) {
            // Preskočiť víkendy
            if ($d->isWeekend()) continue;

            $dateStr      = $d->toDateString();
            $bookedSlots  = isset($booked[$dateStr])
                ? $booked[$dateStr]->pluck('slot')->toArray()
                : [];

            // Voľné = všetky indexy mínus obsadené
            $availableSlots[$dateStr] = array_values(
                array_diff(array_keys(self::SLOTS), $bookedSlots)
            );
        }

        return view('rezervacia', compact('availableSlots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:today'],
            'slot' => ['required', 'integer', 'between:0,4'],
        ]);

        // Skontroluj či slot nie je medzičasom obsadený
        $conflict = Appointment::where('date', $request->date)
            ->where('slot', $request->slot)
            ->where('booked', true)
            ->exists();

        if ($conflict) {
            return back()->withErrors([
                'slot' => 'Tento termín bol medzičasom obsadený, vyber iný.'
            ]);
        }

        // Nájdi prvého dostupného optometristu
        $optometrist = User::where('role', 'optometrist')->first();

        Appointment::create([
            'customer_id'    => auth()->id(),
            'optometrist_id' => $optometrist->id,
            'date'           => $request->date,
            'slot'           => $request->slot,
            'booked'         => true,
        ]);

        return redirect()->route('rezervacia')
            ->with('success', '✓ Rezervácia potvrdená! ' .
                Carbon::parse($request->date)->translatedFormat('l d.m.') .
                ' o ' . self::SLOTS[$request->slot]);
    }
}
