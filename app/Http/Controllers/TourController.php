<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function home(Request $request)
    {
        $type = $request->query('type');

        $tours = Tour::query();

        if ($type === 'date') {
            $start = $request->query('start_date');
            $end   = $request->query('end_date');
            if ($start && $end) {
                $tours->whereDate('start_date', $start)->whereDate('end_date', $end);
            } else {
                $tours->whereRaw('1=0');
            }
        } elseif ($type === 'category') {
            $q = trim((string)$request->query('q'));
            if ($q !== '') {
                $tours->whereHas('categories', function($cq) use ($q) {
                    $cq->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
                });
            } else {
                $tours->whereRaw('1=0');
            }
        } elseif ($type === 'trip') {
            $q = trim((string)$request->query('q'));
            if ($q !== '') {
                $tours->where(function($qq) use ($q) {
                    $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
                });
            } else {
                $tours->whereRaw('1=0');
            }
        } else {
            $tours->latest()->limit(3);
        }
        $tours->withSum([
            'reservations as reserved_people' => function ($q) {
                $q->whereIn('status', ['placed', 'confirmed']);
            }
        ], 'number_of_people');

        $results = ($type ? $tours->latest()->get() : $tours->get());

        return view('welcome', [
            'results' => $results,
            'type'    => $type,
        ]);
    }

    public function show(Tour $tour)
    {
        $reserved = $tour->reservations()
            ->whereIn('status', ['placed', 'confirmed'])
            ->sum('number_of_people');

        $cap = $tour->max_participants;
        $available = is_null($cap) ? null : max(0, (int)$cap - (int)$reserved);

        $tour->load(['reviews.user'])
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');

        return view('tours.show', [
            'tour'      => $tour,
            'reserved'  => (int) $reserved,
            'available' => $available,
        ]);
    }
}
