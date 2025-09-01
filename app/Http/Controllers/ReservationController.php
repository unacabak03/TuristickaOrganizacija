<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReservationController extends Controller
{
    public function create(Tour $tour)
    {
        $reserved = Reservation::where('tour_id', $tour->id)
            ->whereIn('status', ['placed', 'confirmed'])
            ->sum('number_of_people');

        $available = is_null($tour->max_participants)
            ? null
            : max(0, (int)$tour->max_participants - (int)$reserved);

        return view('reservations.create', compact('tour', 'reserved', 'available'));
    }

    public function store(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'number_of_people' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($tour, $validated) {
            $lockedTour = Tour::whereKey($tour->id)->lockForUpdate()->first();

            $reserved = Reservation::where('tour_id', $lockedTour->id)
                ->whereIn('status', ['placed', 'confirmed'])
                ->sum('number_of_people');

            if (!is_null($lockedTour->max_participants)) {
                $willBe = (int)$reserved + (int)$validated['number_of_people'];
                if ($willBe > (int)$lockedTour->max_participants) {
                    throw ValidationException::withMessages([
                        'number_of_people' => 'Nema dovoljno slobodnih mesta za traženi broj osoba.',
                    ]);
                }
            }

            Reservation::create([
                'user_id' => Auth::id(),
                'tour_id' => $lockedTour->id,
                'status' => 'placed',
                'number_of_people' => (int)$validated['number_of_people'],
            ]);
        });

        return redirect()
            ->route('homepage')
            ->with('success', 'Uspešno ste rezervisali turu!');
    }

    public function index(Request $request)
    {
        $userId = Auth::id();

        $reservations = Reservation::where('user_id', $userId)
            ->with([
                'tour',
                'tour.reviews' => function ($q) use ($userId) {
                    $q->where('user_id', $userId);
                },
            ])
            ->orderByRaw("CASE status
                            WHEN 'confirmed' THEN 0
                            WHEN 'placed' THEN 1
                            WHEN 'canceled' THEN 2
                            ELSE 3
                        END")
            ->orderByDesc('created_at')
            ->get();

        return view('reservations.index', compact('reservations'));
    }

    public function cancel(Reservation $reservation)
    {
        abort_unless($reservation->user_id === Auth::id(), 403, 'Nedozvoljeno.');

        if ($reservation->status === 'canceled') {
            return back()->with('success', 'Rezervacija je već otkazana.');
        }

        $reservation->update(['status' => 'canceled']);

        return back()->with('success', 'Rezervacija je uspešno otkazana.');
    }

    public function dashboard()
    {
        $raw = Reservation::selectRaw('status, COUNT(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status')
            ->all();

        $labels = ['placed', 'confirmed', 'canceled'];
        $counts = array_map(fn($s) => Arr::get($raw, $s, 0), $labels);

        return view('dashboard', compact('labels', 'counts'));
    }
}
