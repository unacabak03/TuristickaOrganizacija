<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Reservation $reservation)
    {
        abort_unless($reservation->user_id === Auth::id(), 403, 'Nedozvoljeno.');
        abort_unless($reservation->status === 'confirmed', 422, 'Recenzije su moguće samo za potvrđene rezervacije.');

        $reservation->load('tour');

        $existing = Review::where('user_id', Auth::id())
            ->where('tour_id', $reservation->tour_id)
            ->first();

        return view('reservations.review', [
            'reservation' => $reservation,
            'tour'        => $reservation->tour,
            'review'      => $existing,
        ]);
    }

    public function store(Request $request, Reservation $reservation)
    {
        abort_unless($reservation->user_id === Auth::id(), 403, 'Nedozvoljeno.');
        abort_unless($reservation->status === 'confirmed', 422, 'Recenzije su moguće samo za potvrđene rezervacije.');

        $validated = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'tour_id' => $reservation->tour_id],
            ['rating' => $validated['rating'], 'comment' => $validated['comment']]
        );

        return redirect()->route('reservation.index')->with('success', 'Vaša recenzija je sačuvana.');
    }
}
