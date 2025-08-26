@extends('layouts.public')

@section('title', 'Recenzija — ' . $tour->title)

@push('head')
<style>
    .auth-wrap {
        max-width: 720px;
        margin: 48px auto;
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
    .w3-input, .w3-select { 
        height:42px;
    }
    .field-label {
        font-weight:600;
        margin-bottom:6px;
        display:block;
    }
    .error {
        color:#b91c1c;
        font-size:.9rem;
        margin-top:4px;
    }
    .tour-summary {
        background:#fff;
        border:1px solid #eee;
        border-radius:10px;
        padding:12px 16px;
        margin-bottom:16px;
    }
    .star-rating {
        display: inline-flex;
        flex-direction: row-reverse;
        gap: 6px;
    }
    .star-rating input {
        position: absolute;
        left: -9999px;
        opacity: 0;
    }
    .star-rating label {
        font-size: 28px;
        line-height: 1;
        color: #ddd;
        cursor: pointer;
        user-select: none;
        transition: color .15s ease;
    }
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ff7a00;
    }
    .star-rating input:checked ~ label {
        color: #ff7a00;
    }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="w3-card w3-white w3-round-large">
        <header class="w3-container w3-black">
        <h3 class="w3-margin">Recenzija</h3>
        </header>

        <div class="w3-container w3-padding-16">
            @if ($errors->any())
                <div class="w3-panel w3-pale-red w3-leftbar w3-border-red w3-round">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="tour-summary">
                <div style="font-weight:700;">{{ $tour->title }}</div>
                <div class="w3-small w3-text-gray">{{ $tour->location }}</div>
                <div class="w3-small">
                    <i class="fa fa-calendar"></i>
                    {{ $tour->start_date->format('d.m.Y') }} — {{ $tour->end_date->format('d.m.Y') }}
                </div>
            </div>

            <form method="POST" action="{{ route('reservation.review', $reservation) }}" class="w3-container">
                @csrf

                @php
                    $currentRating = (int) old('rating', (int)($review->rating ?? 0));
                @endphp

                <div class="w3-section">
                <label class="field-label">Ocena</label>

                <div class="star-rating" role="radiogroup" aria-label="Ocena">
                    <input type="radio" id="star5" name="rating" value="5" {{ $currentRating === 5 ? 'checked' : '' }}>
                    <label for="star5" title="5 zvezdica">&#9733;</label>

                    <input type="radio" id="star4" name="rating" value="4" {{ $currentRating === 4 ? 'checked' : '' }}>
                    <label for="star4" title="4 zvezdice">&#9733;</label>

                    <input type="radio" id="star3" name="rating" value="3" {{ $currentRating === 3 ? 'checked' : '' }}>
                    <label for="star3" title="3 zvezdice">&#9733;</label>

                    <input type="radio" id="star2" name="rating" value="2" {{ $currentRating === 2 ? 'checked' : '' }}>
                    <label for="star2" title="2 zvezdice">&#9733;</label>

                    <input type="radio" id="star1" name="rating" value="1" {{ $currentRating === 1 ? 'checked' : '' }}>
                    <label for="star1" title="1 zvezdica">&#9733;</label>
                </div>

                @error('rating') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="w3-section">
                    <label class="field-label" for="comment">Komentar</label>
                    <textarea name="comment" id="comment" class="w3-input w3-border w3-round-small" style="min-height:120px;" required>{{ old('comment', $review->comment ?? '') }}</textarea>
                    @error('comment') <div class="error">{{ $message }}</div> @enderror
                </div>

                <div class="w3-section" style="display:flex; gap:8px; justify-content:flex-end;">
                    <a href="{{ route('reservation.index') }}" class="w3-button w3-white w3-border w3-round-small">Nazad</a>
                    <button type="submit" class="w3-button btn-orange w3-round-small">Sačuvaj</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
