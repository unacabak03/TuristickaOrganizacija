<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TuristickaOrganizacija')</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="../../resources/css/app.css">

    <style>
        body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
        .myLink {display:none}
    </style>
    @stack('head')
</head>
<body class="w3-light-grey">

    <div class="w3-bar w3-white w3-border-bottom w3-xlarge">
        <a href="{{ route('homepage') }}" class="w3-bar-item w3-button w3-text-red w3-hover-red">
            <b>
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="height:50px;vertical-align:middle">
            </b>
        </a>

        <div class="w3-right">
            @auth
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('client.services.create') }}" class="w3-bar-item w3-button w3-hover-red">Zakazivanje</a>
                    <a href="{{ route('client.services.index') }}" class="w3-bar-item w3-button w3-hover-red">Moje usluge</a>
                @elseif(auth()->user()->role === 'manager')
                    <a href="{{ route('employee.services.index') }}" class="w3-bar-item w3-button w3-hover-red">Usluge za obradu</a>
                @endif

                @if(in_array(auth()->user()->role, ['admin']))
                    <a href="{{ route('dashboard') }}" class="w3-bar-item w3-button w3-hover-red">Dashboard</a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="w3-bar-item" style="display:inline;">
                    @csrf
                    <button type="submit" class="w3-button w3-red">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w3-bar-item w3-button w3-hover-red w3-text-grey" style="height: 66px;">
                    <i class="fa fa-sign-in"></i> Login
                </a>
            @endauth
        </div>
    </div>

    @if(session('success'))
    <div class="w3-content" style="max-width:1100px;">
        <div class="w3-panel w3-green w3-round w3-padding w3-margin-top">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="w3-content" style="max-width:1400px;">
        @yield('content')
    </div>

    <footer class="w3-container w3-center w3-opacity w3-margin-bottom">
        <h5>Pronađi nas</h5>
        <div class="w3-xlarge w3-padding-16">
            <i class="fa fa-facebook-official w3-hover-opacity"></i>
            <i class="fa fa-instagram w3-hover-opacity"></i>
            <i class="fa fa-snapchat w3-hover-opacity"></i>
            <i class="fa fa-pinterest-p w3-hover-opacity"></i>
            <i class="fa fa-twitter w3-hover-opacity"></i>
            <i class="fa fa-linkedin w3-hover-opacity"></i>
        </div>
        <p class="w3-small">UCABAK0822IT • Powered by
            <a href="https://www.w3schools.com/w3css/default.asp" target="_blank" class="w3-hover-text-green">w3.css</a>
        </p>
    </footer>

    <script>
    function openLink(evt, linkName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("myLink");
        for (i = 0; i < x.length; i++) { x[i].style.display = "none"; }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
        }
        document.getElementById(linkName).style.display = "block";
        evt.currentTarget.className += " w3-red";
    }
    document.addEventListener('DOMContentLoaded', function () {
        var first = document.getElementsByClassName("tablink")[0];
        if (first) first.click();
    });
    </script>

    @stack('scripts')
</body>
</html>
