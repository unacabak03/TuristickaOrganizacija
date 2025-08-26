@extends('layouts.public')

@section('title', 'Moje rezervacije')

@push('head')
<style>
.auth-wrap {
    max-width: 1100px;
    margin: 32px auto;
}
.btn-orange {
    background:#ff7a00!important;
    color:#fff!important;
    font-weight:700;
    letter-spacing:.3px;
    transition:.2s;
    border:none;
}
.btn-orange:hover {
    background:#e86d00!important;
    color:#fff!important;
}
.badge {
    display:inline-block;
    padding:.2rem .5rem;
    border-radius:6px;
    font-size:.8rem;
}
.badge-placed {
    background:#fff3cd;
    color:#8a6d3b;
}
.badge-confirmed {
    background:#d1fae5;
    color:#065f46;
}
.badge-canceled {
    background:#fde2e2;
    color:#8a1c1c;
}
.review-form {
    display:flex;
    gap:8px;
    align-items:flex-start;
}
.review-form textarea {
    min-height: 70px;
}
.w3-table td, .w3-table th {
    vertical-align: top;
}
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="w3-card w3-white w3-round-large">
        <header class="w3-container w3-black">
            <h3 class="w3-margin">Moje rezervacije</h3>
        </header>

        <div class="w3-container w3-padding-16">
            @if (session('success'))
                <div class="w3-panel w3-pale-green w3-leftbar w3-border-green w3-round">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="w3-panel w3-pale-red w3-leftbar w3-border-red w3-round">
                    {{ $errors->first() }}
                </div>
            @endif

            @if($reservations->isEmpty())
                <p>Nemate rezervacija.</p>
            @else
                <div class="w3-responsive">
                    <table class="w3-table w3-striped w3-bordered">
                        <thead>
                            <tr class="w3-light-grey">
                                <th>Tura</th>
                                <th>Datumi</th>
                                <th>Osobe</th>
                                <th>Status</th>
                                <th>Recenzija</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($reservations as $reservation)
                            @php
                                $tour = $reservation->tour;
                                $myReview = optional($tour->reviews->first());
                            @endphp
                            <tr>
                                <td style="min-width:220px;">
                                    <a href="{{ route('tours.show', $tour) }}" class="w3-text-black w3-hover-text-red">
                                        {{ $tour->title }}
                                    </a>
                                    <div class="w3-small w3-text-gray">{{ $tour->location }}</div>
                                    <div class="w3-small"><b>Cena:</b> {{ number_format((float)$tour->price, 2, ',', '.') }} RSD</div>
                                </td>
                                <td style="min-width:170px;">
                                    <i class="fa fa-calendar"></i>
                                    {{ $tour->start_date->format('d.m.Y') }} — {{ $tour->end_date->format('d.m.Y') }}
                                </td>
                                <td>{{ (int)$reservation->number_of_people }}</td>
                                <td>
                                    @if($reservation->status === 'confirmed')
                                        <span class="badge badge-confirmed">Potvrđeno</span>
                                    @elseif($reservation->status === 'placed')
                                        <span class="badge badge-placed">U obradi</span>
                                    @else
                                        <span class="badge badge-canceled">Otkazano</span>
                                    @endif
                                </td>
                                <td style="min-width:280px;">
                                    @php
                                        $canReview = $reservation->status === 'confirmed';
                                        $isCanceled = $reservation->status === 'canceled';
                                    @endphp

                                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                        <a href="{{ $canReview ? route('reservation.review.create', $reservation) : 'javascript:void(0)' }}"
                                        class="w3-button btn-orange w3-round-small {{ $canReview ? '' : 'w3-opacity-max' }}"
                                        @if(!$canReview) aria-disabled="true" onclick="return false;" @endif
                                        title="{{ $canReview ? 'Otvori formu za recenziju' : 'Recenzija dostupna samo za potvrđene rezervacije' }}">
                                            Recenzija
                                        </a>

                                        <form method="POST" action="{{ route('reservation.cancel', $reservation) }}" onsubmit="return confirm('Da li sigurno želite da otkažete rezervaciju?');">
                                            @csrf
                                            <button type="submit"
                                                    class="w3-button w3-red w3-round-small"
                                                    @if($isCanceled) disabled @endif
                                                    title="{{ $isCanceled ? 'Rezervacija je već otkazana' : 'Otkaži rezervaciju' }}">
                                                Otkaži
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleReviewForm(id) {
    var el = document.getElementById(id);
    if (!el) return;
    el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
}
</script>
@endpush


@endsection
