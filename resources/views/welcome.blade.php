@php
    $bookings = \App\Models\Booking::where('tour_id', 1)->where('tour_type', 1)->whereIn('status', [1,2])->where('use_date', request()->query('date', date('Y-m-d')))->get();
    $data = [];
    $classes = ['blue', 'red'];
    foreach ($bookings as $booking){
        if($booking->location){
            $data[] = [
                'lat' => $booking->location->latitude,
                'lng' => $booking->location->longitude,
                'name' => $booking->name,
                'class' => $classes[array_rand($classes)]
            ];
        }
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/@goongmaps/goong-js@1.0.9/dist/goong-js.css' rel='stylesheet'/>

    <!-- Styles -->
    <style>
        /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */
        html {
            line-height: 1.15;
            -webkit-text-size-adjust: 100%
        }

        body {
            margin: 0
        }

        a {
            background-color: transparent
        }

        [hidden] {
            display: none
        }

        html {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, Noto Sans, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
            line-height: 1.5
        }

        *, :after, :before {
            box-sizing: border-box;
            border: 0 solid #e2e8f0
        }

        a {
            color: inherit;
            text-decoration: inherit
        }

        svg, video {
            display: block;
            vertical-align: middle
        }

        video {
            max-width: 100%;
            height: auto
        }

        .bg-white {
            --bg-opacity: 1;
            background-color: #fff;
            background-color: rgba(255, 255, 255, var(--bg-opacity))
        }

        .bg-gray-100 {
            --bg-opacity: 1;
            background-color: #f7fafc;
            background-color: rgba(247, 250, 252, var(--bg-opacity))
        }

        .border-gray-200 {
            --border-opacity: 1;
            border-color: #edf2f7;
            border-color: rgba(237, 242, 247, var(--border-opacity))
        }

        .border-t {
            border-top-width: 1px
        }

        .flex {
            display: flex
        }

        .grid {
            display: grid
        }

        .hidden {
            display: none
        }

        .items-center {
            align-items: center
        }

        .justify-center {
            justify-content: center
        }

        .font-semibold {
            font-weight: 600
        }

        .h-5 {
            height: 1.25rem
        }

        .h-8 {
            height: 2rem
        }

        .h-16 {
            height: 4rem
        }

        .text-sm {
            font-size: .875rem
        }

        .text-lg {
            font-size: 1.125rem
        }

        .leading-7 {
            line-height: 1.75rem
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto
        }

        .ml-1 {
            margin-left: .25rem
        }

        .mt-2 {
            margin-top: .5rem
        }

        .mr-2 {
            margin-right: .5rem
        }

        .ml-2 {
            margin-left: .5rem
        }

        .mt-4 {
            margin-top: 1rem
        }

        .ml-4 {
            margin-left: 1rem
        }

        .mt-8 {
            margin-top: 2rem
        }

        .ml-12 {
            margin-left: 3rem
        }

        .-mt-px {
            margin-top: -1px
        }

        .max-w-6xl {
            max-width: 72rem
        }

        .min-h-screen {
            min-height: 100vh
        }

        .overflow-hidden {
            overflow: hidden
        }

        .p-6 {
            padding: 1.5rem
        }

        .py-4 {
            padding-top: 1rem;
            padding-bottom: 1rem
        }

        .px-6 {
            padding-left: 1.5rem;
            padding-right: 1.5rem
        }

        .pt-8 {
            padding-top: 2rem
        }

        .fixed {
            position: fixed
        }

        .relative {
            position: relative
        }

        .top-0 {
            top: 0
        }

        .right-0 {
            right: 0
        }

        .shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06)
        }

        .text-center {
            text-align: center
        }

        .text-gray-200 {
            --text-opacity: 1;
            color: #edf2f7;
            color: rgba(237, 242, 247, var(--text-opacity))
        }

        .text-gray-300 {
            --text-opacity: 1;
            color: #e2e8f0;
            color: rgba(226, 232, 240, var(--text-opacity))
        }

        .text-gray-400 {
            --text-opacity: 1;
            color: #cbd5e0;
            color: rgba(203, 213, 224, var(--text-opacity))
        }

        .text-gray-500 {
            --text-opacity: 1;
            color: #a0aec0;
            color: rgba(160, 174, 192, var(--text-opacity))
        }

        .text-gray-600 {
            --text-opacity: 1;
            color: #718096;
            color: rgba(113, 128, 150, var(--text-opacity))
        }

        .text-gray-700 {
            --text-opacity: 1;
            color: #4a5568;
            color: rgba(74, 85, 104, var(--text-opacity))
        }

        .text-gray-900 {
            --text-opacity: 1;
            color: #1a202c;
            color: rgba(26, 32, 44, var(--text-opacity))
        }

        .underline {
            text-decoration: underline
        }

        .antialiased {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale
        }

        .w-5 {
            width: 1.25rem
        }

        .w-8 {
            width: 2rem
        }

        .w-auto {
            width: auto
        }

        .grid-cols-1 {
            grid-template-columns:repeat(1, minmax(0, 1fr))
        }

        @media (min-width: 640px) {
            .sm\:rounded-lg {
                border-radius: .5rem
            }

            .sm\:block {
                display: block
            }

            .sm\:items-center {
                align-items: center
            }

            .sm\:justify-start {
                justify-content: flex-start
            }

            .sm\:justify-between {
                justify-content: space-between
            }

            .sm\:h-20 {
                height: 5rem
            }

            .sm\:ml-0 {
                margin-left: 0
            }

            .sm\:px-6 {
                padding-left: 1.5rem;
                padding-right: 1.5rem
            }

            .sm\:pt-0 {
                padding-top: 0
            }

            .sm\:text-left {
                text-align: left
            }

            .sm\:text-right {
                text-align: right
            }
        }

        @media (min-width: 768px) {
            .md\:border-t-0 {
                border-top-width: 0
            }

            .md\:border-l {
                border-left-width: 1px
            }

            .md\:grid-cols-2 {
                grid-template-columns:repeat(2, minmax(0, 1fr))
            }
        }

        @media (min-width: 1024px) {
            .lg\:px-8 {
                padding-left: 2rem;
                padding-right: 2rem
            }
        }

        @media (prefers-color-scheme: dark) {
            .dark\:bg-gray-800 {
                --bg-opacity: 1;
                background-color: #2d3748;
                background-color: rgba(45, 55, 72, var(--bg-opacity))
            }

            .dark\:bg-gray-900 {
                --bg-opacity: 1;
                background-color: #1a202c;
                background-color: rgba(26, 32, 44, var(--bg-opacity))
            }

            .dark\:border-gray-700 {
                --border-opacity: 1;
                border-color: #4a5568;
                border-color: rgba(74, 85, 104, var(--border-opacity))
            }

            .dark\:text-white {
                --text-opacity: 1;
                color: #fff;
                color: rgba(255, 255, 255, var(--text-opacity))
            }

            .dark\:text-gray-400 {
                --text-opacity: 1;
                color: #cbd5e0;
                color: rgba(203, 213, 224, var(--text-opacity))
            }

            .dark\:text-gray-500 {
                --tw-text-opacity: 1;
                color: #6b7280;
                color: rgba(107, 114, 128, var(--tw-text-opacity))
            }
        }
    </style>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        @media screen and (max-width: 767px) {
            #map{
                width: 100%;
                height: calc(100vh - 48px) !important;
            }

            #main{
                flex-direction: column !important;
            }
        }
    </style>
</head>
<body class="antialiased">
<div
    class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0" id="main">
    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
        </div>
    @endif


    <div id='map' style='width: 100%; height: 100vh;'></div>
    <script>
        goongjs.accessToken = 'ECtkx4dsZc4RnkZfLC0zmZurYFB3NthMNmbFTrcl';
        var map = new goongjs.Map({
            container: 'map',
            style: 'https://tiles.goong.io/assets/goong_map_web.json', // stylesheet location
            center: [103.966850, 10.200809], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });

        var bookings = @json($data);
        var markers = [];
        var bounds = new goongjs.LngLatBounds();
        var places = {
            'type': 'FeatureCollection',
            'features': bookings.map(function (booking) {
                return {
                    'type': 'Feature',
                    'properties': {
                        'description': booking.name,
                        'icon': booking.class == 'blue' ? 'custom-marker' : 'custom-marker-red'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [booking.lng, booking.lat]
                    }
                }
            })
        };
        map.on('load', function () {
            map.loadImage(
                'http://maps.google.com/mapfiles/ms/icons/blue.png',
                function (error, image) {
                    if (error) throw error;
                    map.addImage('custom-marker', image);

                    map.loadImage('http://maps.google.com/mapfiles/ms/icons/red.png', function (err, image) {
                        map.addImage('custom-marker-red', image);
                    })

                    // Add a GeoJSON source containing place coordinates and information.
                    map.addSource('places', {
                        'type': 'geojson',
                        'data': places
                    });

                    map.addLayer({
                        'id': 'places',
                        'type': 'symbol',
                        'source': 'places',
                        'layout': {
                            'icon-image': '{icon}',
                            'icon-allow-overlap': true
                        }
                    });
                    bookings.forEach(function (booking) {
                        if(booking && booking.lat && booking.lng){
                            // var marker = new goongjs.Marker()
                            //     .setLngLat([booking.lng, booking.lat])
                            //     .addTo(map);
                            bounds.extend(new goongjs.LngLat(booking.lng, booking.lat));

                            // var popup = new goongjs.Popup({ offset: 25 }).setText(
                            //     'The President Ho Chi Minh Mausoleum is a mausoleum which serves as the resting place of Vietnamese Revolutionary leader & President Ho Chi Minh in Hanoi, Vietnam'
                            // );
                            // marker.setPopup(popup).addTo(map);
                        }
                    })
                    map.fitBounds(bounds, 60);

                    // When a click event occurs on a feature in the places layer, open a popup at the
                    // location of the feature, with description HTML from its properties.
                    map.on('click', 'places', function (e) {
                        var coordinates = e.features[0].geometry.coordinates.slice();
                        var description = e.features[0].properties.description;

                        map.flyTo({
                            center: e.features[0].geometry.coordinates
                        });
                        // Ensure that if the map is zoomed out such that multiple
                        // copies of the feature are visible, the popup appears
                        // over the copy being pointed to.
                        while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                        }

                        new goongjs.Popup()
                            .setLngLat(coordinates)
                            .setHTML(description)
                            .addTo(map);
                    });


                    // Change the cursor to a pointer when the mouse is over the places layer.
                    map.on('mouseenter', 'places', function () {
                        map.getCanvas().style.cursor = 'pointer';
                    });

                    // Change it back to a pointer when it leaves.
                    map.on('mouseleave', 'places', function () {
                        map.getCanvas().style.cursor = '';
                    });
                })
        });
    </script>

    <div class="search-form">
        <form action="/">
            <div class="form-control">
                <label>Ngày</label>
                <input type="date" name="date" value="{{date('Y-m-d')}}"/>
            </div>
            <button>Chọn</button>
        </form>
    </div>
</div>
</body>
</html>
