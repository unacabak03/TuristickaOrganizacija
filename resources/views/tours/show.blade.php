@extends('layouts.public')

@section('title', $tour->title)

@push('head')
<style>
.detail-hero {
    position: relative;
    max-width: 1500px;
    margin: 0 auto;
}
.detail-hero img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 14px;
}
.detail-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #fff;
    color: #000;
    padding: 2rem;
    border-radius: 14px;
    max-width: 80%;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}
.detail-overlay h2 {
    margin-top: 0;
    margin-bottom: .5rem;
}
.detail-section {
    max-width: 1100px;
    margin: 2rem auto;
}
.review-card {
    background: #fff;
    padding: 1rem 1.25rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}
.review-user {
    font-weight: 600;
    margin-bottom: .25rem;
}
.review-rating {
    color: #ff7a00;
    font-size: .9rem;
    margin-bottom: .5rem;
}
.review-stars .fa {
    color:#ff7a00;
    font-size:1.1rem;
    margin-right:2px;
}
</style>
@endpush

@section('content')
<div class="detail-hero">
    <img src="{{ asset('images/header.jpg') }}" alt="Tour detail header">
    <div class="detail-overlay">
        <h2>{{ $tour->title }}</h2>
        <p><i class="fa fa-map-marker"></i> {{ $tour->location }}</p>
        <p><i class="fa fa-calendar"></i> 
            {{ $tour->start_date->format('d.m.Y') }} — {{ $tour->end_date->format('d.m.Y') }}
        </p>
        <p><b>Cena:</b> {{ number_format((float)$tour->price, 2, ',', '.') }} RSD</p>
        @if($tour->max_participants)
            <p><b>Maksimalno putnika:</b> {{ $tour->max_participants }}</p>
        @endif
    </div>
</div>

<div class="detail-section">
    <h3>Detaljan opis</h3>
    <p>{{ $tour->description }}</p>

    @php
        $cap = $tour->max_participants;
        $res = (int)($reserved ?? 0);
        $soldOut = !is_null($cap) && $res >= (int)$cap;
    @endphp

    @if(!is_null($cap))
        <div style="text-align:center; margin-top:1rem;">
            <div style="font-size:1.25rem; font-weight:800; color:#ff7a00;">
                Rezervisano: {{ $res }} / {{ (int)$cap }}
            </div>
        </div>
    @endif

    <div style="text-align:center; margin-top:1rem;">
        <a href="{{ $soldOut ? 'javascript:void(0)' : route('reservation.create', $tour) }}"
            class="w3-button {{ $soldOut ? 'w3-opacity-max' : '' }}"
            style="background:#ff7a00; color:#fff; font-weight:700; padding:12px 28px; border-radius:8px; text-transform:uppercase; letter-spacing:.5px;"
            @if($soldOut) aria-disabled="true" onclick="return false;" @endif>
                {{ $soldOut ? 'Rasprodato' : 'Rezerviši' }}
        </a>
    </div>
</div>

<div class="detail-section">
    <h3 style="color:#ff7a00; font-size: 2rem; font-weight: 600;">
        Recenzije
        @if(($tour->reviews_count ?? 0) > 0)
            <span style="color:#ff7a00; font-size: 2rem; font-weight: 600;">
                ({{ number_format((float)$tour->reviews_avg_rating, 1, ',') }}/5)
            </span>
        @endif
    </h3>

    @if($tour->reviews->isEmpty())
        <p>Još nema recenzija za ovu turu.</p>
    @else
        @foreach($tour->reviews as $review)
            <div class="review-card">
                <div class="review-user">{{ $review->user->name }}</div>
                <div class="review-rating review-stars" aria-label="Ocena {{ $review->rating }} od 5">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa {{ $i <= (int)$review->rating ? 'fa-star' : 'fa-star-o' }}"></i>
                    @endfor
                </div>
                <div class="review-comment">{{ $review->comment }}</div>
                <div class="w3-small w3-text-gray">
                    {{ $review->created_at?->format('d.m.Y H:i') }}
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
