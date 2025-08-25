@extends('layouts.public')

@section('title', 'Početna')

@push('head')
<style>
    .tour-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .tour-card {
        display: flex;
        flex-direction: row;
        height: 220px;
        border-radius: 14px;
        overflow: hidden;
    }

    .tour-card__inner {
        flex: 1;
        padding: 12px 16px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .reserve-cta {
        flex: 0 0 15%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        background: #ff7a00;
        color: #fff;
        font-weight: 700;
        height: 100%;
        transition: background .15s ease-in-out, filter .15s ease-in-out;
        text-transform: uppercase;
        letter-spacing: .5px;
    }
    .reserve-cta:hover { background: #e86d00; }

    .tour-title{
        font-size: 1.05rem; font-weight: 600; margin: 8px 0 4px;
        display: -webkit-box; -webkit-line-clamp: 1; line-clamp: 1;
        -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;
        min-height: 1.4em;
    }
    .tour-loc, .tour-dates, .tour-price, .tour-desc { margin: 4px 0; }
    .tour-desc{
        display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3;
        -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;
    }
    .tour-price { min-height: 1.2em; }
    .tour-spacer { flex: 1 1 auto; }

    .tablink {
        background: #000 !important;
        color: #fff !important;
        transition: background .2s, color .2s;
        border: none;
    }
    .tablink:hover:not(.active) {
        background: #fff !important;
        color: #000 !important;
    }

    .tablink.active:hover {
        background: #fff !important;
        color: #000 !important;
    }

    .tablink.active {
        background: #ff7a00 !important;
        color: #fff !important;
    }

    .myLink {
        min-height: 180px;
        display: none;
    }
    .myLink .w3-input {
        height: 42px;
        border-radius: 6px;
    }

    .myLink button[type="submit"] {
        width: 40%;
        max-width: 240px;
        padding: 12px 20px;
        font-weight: 600;
        border-radius: 6px;
        background: #ff7a00;
        color: #fff;
        transition: background .2s;
        margin-top: auto;
        align-self: center;
    }
    .myLink button[type="submit"]:hover {
        background: #e86d00 !important;
        color: white !important;
    }
    .myLink form {
        display: flex;
        flex-direction: column;
        height: 100%;
        justify-content: flex-end;
        align-items: stretch;
    }

    .myLink .form-row {
        display: flex;
        gap: 16px;
        width: 100%;
        margin-bottom: 16px;
    }

    .myLink .form-row .w3-half {
        flex: 1;
    }
    .myLink .form-row input {
        flex: 1;
    }

    .myLink label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        text-align: left;
    }
</style>
@endpush

@section('content')
<header class="w3-display-container w3-content w3-hide-small" style="max-width:1500px">
    <img class="w3-image" src="{{ asset('images/header.jpg') }}" alt="Header" width="1500" height="700" style="border-radius: 14px;">
    <div class="w3-display-middle" style="width:65%">
        <div class="w3-bar w3-black">
            <button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'DateTab');">
                <i class="fa fa-calendar w3-margin-right"></i>Datum
            </button>
            <button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'CategoryTab');">
                <i class="fa fa-tags w3-margin-right"></i>Kategorija
            </button>
            <button class="w3-bar-item w3-button tablink" onclick="openLink(event, 'TripTab');">
                <i class="fa fa-map-marker w3-margin-right"></i>Aranzman
            </button>
        </div>

        <div id="DateTab" class="w3-container w3-white w3-padding-16 myLink">
            <form action="{{ route('homepage') }}" method="GET">
                <input type="hidden" name="type" value="date">
                <div class="form-row">
                    <div class="w3-half">
                        <label>Datum polaska</label>
                        <input class="w3-input w3-border" type="date" name="start_date" required>
                    </div>
                    <div class="w3-half">
                        <label>Datum povratka</label>
                        <input class="w3-input w3-border" type="date" name="end_date" required>
                    </div>
                </div>
                <button class="w3-button" type="submit">Pretraži</button>
            </form>
        </div>

        <div id="CategoryTab" class="w3-container w3-white w3-padding-16 myLink">
            <form action="{{ route('homepage') }}" method="GET">
                <label>Kategorija(naslov/opis):</label>
                <input type="hidden" name="type" value="category">
                <div class="form-row">
                    <input class="w3-input w3-border" type="text" name="q" placeholder="npr. avantura, planinarenje..." required>
                </div>
                <button class="w3-button" type="submit">Pretraži</button>
            </form>
        </div>

        <div id="TripTab" class="w3-container w3-white w3-padding-16 myLink">
            <form action="{{ route('homepage') }}" method="GET">
                <label>Aranzman(naslov/opis/lokacija)</label>
                <input type="hidden" name="type" value="trip">
                <div class="form-row">
                    <input class="w3-input w3-border" type="text" name="q" placeholder="npr. Toskana, jezera, safari..." required>
                </div>
                <button class="w3-button" type="submit">Pretraži</button>
            </form>
        </div>
    </div>
</header>

<div class="w3-content" style="max-width:1400px;">
    <div class="w3-container w3-margin-top">
        <h3 class="w3-text-black" style="display:flex;align-items:center;gap:.5rem;">
            @if($type === 'date') Rezultati pretrage po datumima
            @elseif($type === 'category') Rezultati pretrage po kategoriji
            @elseif($type === 'trip') Rezultati pretrage (trip)
            @else Najnovije ture
            @endif
            <span class="w3-badge w3-black">{{ $results->count() }}</span>
        </h3>
    </div>

    @if($results->isEmpty())
        <div class="w3-panel w3-pale-red w3-border w3-round">
            <p class="w3-text-red w3-large">Nema pronađenih tura za dati upit.</p>
        </div>
        @else
        <div class="tour-list">
            @foreach($results as $tour)
                <div class="w3-card w3-white w3-hover-shadow tour-card">
                    <div class="tour-card__inner">
                        <h4 class="tour-title">{{ $tour->title }}</h4>

                        <p class="w3-opacity tour-loc">
                            <i class="fa fa-map-marker"></i>
                            {{ $tour->location }}
                        </p>

                        <p class="w3-small tour-dates">
                            <i class="fa fa-calendar"></i>
                            {{ $tour->start_date->format('d.m.Y') }} — {{ $tour->end_date->format('d.m.Y') }}
                        </p>

                        <p class="w3-large tour-price">
                            <b>{{ number_format((float)$tour->price, 2, ',', '.') }} RSD</b>
                        </p>

                        <p class="w3-small tour-desc">
                            {{ $tour->description }}
                        </p>

                        <div class="tour-spacer"></div>
                    </div>

                    <a href="javascript:void(0)" class="reserve-cta">Rezerviši</a>
                </div>
            @endforeach
        </div>
        @endif
</div>
@endsection

@push('scripts')
<script>
function openLink(evt, linkName) {
    var panels = document.getElementsByClassName("myLink");
    for (var i = 0; i < panels.length; i++) {
        panels[i].style.display = "none";
    }

    var tabs = document.getElementsByClassName("tablink");
    for (var j = 0; j < tabs.length; j++) {
        tabs[j].classList.remove("active");
    }

    var active = document.getElementById(linkName);
    if (active) active.style.display = "block";
    if (evt && evt.currentTarget) evt.currentTarget.classList.add("active");
}

document.addEventListener('DOMContentLoaded', function () {
    var type = new URLSearchParams(window.location.search).get('type');
    var map = { 'date':'DateTab', 'category':'CategoryTab', 'trip':'TripTab' };
    var targetId = map[type] || 'DateTab';
    var btns = document.getElementsByClassName('tablink');
    if (btns.length) btns[0].click();
    if (map[type]) {
        for (var i=0;i<btns.length;i++){
            var txt = btns[i].innerText.trim().toLowerCase();
            if ((type==='date' && txt.startsWith('date')) ||
                (type==='category' && txt.startsWith('category')) ||
                (type==='trip' && txt.startsWith('trip'))) {
                btns[i].click();
                break;
            }
        }
    }
});
</script>
@endpush
