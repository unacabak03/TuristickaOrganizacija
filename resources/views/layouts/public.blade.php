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
                <form method="POST" action="{{ route('logout') }}" class="w3-bar-item" style="display:inline;">
                    @csrf
                    <button type="submit" class="w3-button w3-red">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" 
                class="w3-bar-item w3-button w3-hover-red w3-text-grey" 
                style="height: 66px;">
                    <i class="fa fa-sign-in"></i> Login
                </a>
                <a href="{{ route('register') }}" 
                class="w3-bar-item w3-button w3-hover-red w3-text-grey" 
                style="height: 66px;">
                    <i class="fa fa-user-plus"></i> Register
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
        @if (trim($__env->yieldContent('content')))
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
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

    <script>
    function openLink(evt, linkName) {
        var x = document.getElementsByClassName("myLink");
        for (var i = 0; i < x.length; i++) { x[i].style.display = "none"; }
        var tablinks = document.getElementsByClassName("tablink");
        for (var j = 0; j < tablinks.length; j++) {
        tablinks[j].className = tablinks[j].className.replace(" w3-red", "").replace(" active", "");
        }
        var active = document.getElementById(linkName);
        if (active) active.style.display = "block";
        if (evt && evt.currentTarget) evt.currentTarget.className += " active";
    }

    function initSearchTabs() {
        var btns = document.getElementsByClassName('tablink');
        var panels = document.getElementsByClassName('myLink');
        if (!btns.length || !panels.length) return;

        for (var i=0;i<panels.length;i++) panels[i].style.display = 'none';
        for (var j=0;j<btns.length;j++) btns[j].classList.remove('active');

        var type = new URLSearchParams(window.location.search).get('type');
        var map = { 'date':'DateTab', 'category':'CategoryTab', 'trip':'TripTab' };
        var targetId = map[type] || 'DateTab';

        var active = document.getElementById(targetId);
        if (active) active.style.display = 'block';

        var matchBtn = Array.prototype.find.call(btns, function(b){ return b.dataset.tab === targetId; });
        if (matchBtn) matchBtn.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', initSearchTabs);

    window.addEventListener('livewire:navigated', initSearchTabs);
    </script>

    @stack('scripts')
</body>
</html>
