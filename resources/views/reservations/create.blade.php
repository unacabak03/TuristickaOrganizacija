@extends('layouts.public')

@section('title', 'Rezervacija')

@push('head')
<style>
    .auth-wrap {
        max-width: 560px;
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
    .w3-input {
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
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="w3-card w3-white w3-round-large">
        <header class="w3-container w3-black">
            <h3 class="w3-margin">Rezervacija ture</h3>
        </header>

        <div class="w3-container w3-padding-16">
            @if ($errors->any())
                <div class="w3-panel w3-pale-red w3-leftbar w3-border-red w3-round">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('reservation.store', $tour) }}" class="w3-container">
                @csrf

                <div class="w3-section">
                    <label class="field-label">Tura</label>
                    <input type="text" class="w3-input w3-border w3-round-small" value="{{ $tour->title }}" disabled>
                </div>

                @if(!is_null($tour->max_participants))
                    <div class="w3-section">
                        <span class="w3-small w3-text-gray">
                            Rezervisano: <b>{{ (int)($reserved ?? 0) }}</b> /
                            {{ (int)$tour->max_participants }} —
                            Preostalo: <b>{{ (int)($available ?? 0) }}</b>
                        </span>
                    </div>
                @endif

                <div class="w3-section">
                    <label class="field-label" for="number_of_people">Broj osoba</label>
                    <input
                        name="number_of_people"
                        id="number_of_people"
                        type="number"
                        class="w3-input w3-border w3-round-small"
                        value="{{ old('number_of_people') }}"
                    >
                </div>

                <div class="w3-section" style="display:flex; justify-content:flex-end;">
                    <button
                        type="submit"
                        class="w3-button btn-orange w3-round-small"
                    >
                        Rezerviši
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
