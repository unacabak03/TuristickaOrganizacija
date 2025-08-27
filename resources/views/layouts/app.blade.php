<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                    </div>
                </header>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>

        <script defer>
            (function () {
            let chart;

            function destroyIfExists(canvas) {
                if (!window.Chart) return;
                const existing = window.Chart.getChart(canvas);
                if (existing) existing.destroy();
            }

            function initReservationsChart() {
                const el = document.getElementById('reservationsByStatusChart');
                if (!el || typeof window.Chart === 'undefined') return;

                const labels = JSON.parse(el.dataset.labels || '[]');
                const counts = JSON.parse(el.dataset.counts || '[]');

                destroyIfExists(el);

                chart = new window.Chart(el, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                    data: counts,
                    backgroundColor: ['#93c5fd', '#86efac', '#fda4af'],
                    hoverBackgroundColor: ['#60a5fa', '#4ade80', '#fb7185'],
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                    legend: { position: 'bottom' },
                    tooltip: {
                        callbacks: {
                        label: (ctx) => {
                            const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            const val = ctx.parsed;
                            const pct = total ? ((val / total) * 100).toFixed(1) : 0;
                            return `${ctx.label}: ${val} (${pct}%)`;
                        }
                        }
                    }
                    }
                }
                });
            }

            window.addEventListener('DOMContentLoaded', initReservationsChart);
            document.addEventListener('livewire:navigated', initReservationsChart);
            })();
        </script>
    </body>
</html>
