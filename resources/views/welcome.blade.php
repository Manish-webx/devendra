<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Satta King Live Results & Fast Chart</title>
    <meta name="description"
        content="Get the fastest Satta King live results and daily updated charts for all top locations.">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .satta-table th,
        .satta-table td {
            border: 1px solid #000;
            text-align: center;
            padding: 4px;
        }

        .satta-table th {
            background-color: #F4A460;
            color: red;
            font-weight: bold;
            font-size: 14px;
        }

        .satta-table td {
            font-size: 20px;
            font-weight: bold;
            background-color: #fff;
        }

        .satta-table td.date-col {
            background-color: #cec4eb;
            font-size: 16px;
            width: 50px;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">

    <!-- Header -->
    <div class="bg-black text-yellow-500 text-center py-4 shadow-lg border-b-4 border-yellow-600">
        <h1 class="text-2xl md:text-3xl font-extrabold uppercase tracking-wide">
            Satta King Fast Result
        </h1>
        <div class="mt-2 text-white flex justify-center gap-4">
            <a href="/" class="hover:text-yellow-400 font-bold">HOME</a>
        </div>
    </div>

    <div class="max-w-6xl mx-auto p-4 sm:p-6 lg:p-8">

        <!-- Banners -->
        <div class="mb-6 flex flex-col gap-1 w-full">
            <div class="bg-black text-center py-2 px-2 text-sm sm:text-base md:text-lg font-bold shadow"
                style="color: #dca644;">
                Satta King 2026 – Fast Result, Delhi Satta King, Disawar & Black Satta King 786
            </div>
            <div class="text-white text-center py-2 shadow"
                style="background-color: #1162af; border: 2px solid #00cc00;">
                <div class="font-semibold uppercase tracking-wide" style="font-size: 12px;">SATTAKINGDELHIDS.COM DELHI
                    SATTA KING</div>
                <div class="text-lg sm:text-2xl font-bold mt-1 tracking-wider uppercase">SATTAKINGDELHIDS.COM</div>
            </div>
        </div>

        <!-- Live Results Grid -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8 border border-gray-200">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 uppercase border-b-2 border-red-500 inline-block pb-1">
                    Live Results Today - {{ \Carbon\Carbon::now()->format('d M Y') }}
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($locations as $location)
                    <div
                        class="border-2 border-gray-300 rounded-lg p-3 text-center bg-gray-50 hover:bg-gray-100 transition-colors shadow-sm">
                        <div class="font-bold text-sm text-gray-700 uppercase mb-2">{{ $location->name }}</div>
                        <div class="text-xs text-gray-500 mb-1">({{ $location->result_time }})</div>
                        @php
                            $todayNumber = isset($todayResults[$location->id]) ? $todayResults[$location->id]->lucky_number : 'WAIT';
                        @endphp
                        <div
                            class="text-3xl font-extrabold {{ $todayNumber === 'WAIT' ? 'text-red-500' : 'text-green-600' }}">
                            {{ $todayNumber }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Month Selection -->
        <div class="text-center mb-6">
            <form method="GET" action="{{ route('home') }}"
                class="inline-flex items-center gap-2 bg-white p-3 rounded shadow">
                <select name="month" class="border-gray-300 rounded font-bold" onchange="this.form.submit()">
                    @for($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 10)) }}
                        </option>
                    @endfor
                </select>
                <select name="year" class="border-gray-300 rounded font-bold" onchange="this.form.submit()">
                    @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <noscript><button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Go</button></noscript>
            </form>
        </div>

        <!-- Monthly Chart -->
        <div
            class="bg-black text-yellow-500 text-center py-2 font-bold text-xl uppercase rounded-t-lg border-2 border-black">
            {{ date('F', mktime(0, 0, 0, $month, 10)) }} {{ $year }} - SATTA KING CHART
        </div>

        @foreach($locations->chunk(5) as $chunk)
            <div class="overflow-x-auto bg-white border-2 border-t-0 border-black shadow-lg mb-6">
                <table class="w-full satta-table">
                    <thead>
                        <tr>
                            <th class="date-col">DATE</th>
                            @foreach($chunk as $location)
                                <th>{{ strtoupper($location->name) }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $today = \Carbon\Carbon::today();
                        @endphp
                        @for($day = 1; $day <= $daysInMonth; $day++)
                            @php
                                $rowDate = \Carbon\Carbon::create($year, $month, $day)->startOfDay();
                            @endphp
                            @if($rowDate->gt($today))
                                @continue
                            @endif
                            <tr>
                                <td class="date-col">{{ $day }}</td>
                                @foreach($chunk as $location)
                                    <td>
                                        {{ $monthlyResults[$day][$location->id] ?? '' }}
                                    </td>
                                @endforeach
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        @endforeach

        @if(!empty($bottomText))
            <div class="bg-white rounded-lg shadow-md p-6 mb-8 border border-gray-200 mt-8">
                <div class="prose max-w-none text-slate-700 text-sm sm:text-base leading-relaxed">
                    {!! $bottomText !!}
                </div>
            </div>
        @endif

        <div class="mt-12 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Satta King Results. All rights reserved.
        </div>
    </div>

</body>

</html>