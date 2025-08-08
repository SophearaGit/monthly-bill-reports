@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    {{-- <div class="container">
        <h2>Monthly Meter Readings</h2>

        <form method="GET" action="{{ route('meter_readings.index') }}" class="mb-4">
            <label for="month">Select Month:</label>
            <input type="month" name="month" id="month" value="{{ $month }}" />
            <button class="btn btn-primary">Load</button>
        </form>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('meter_readings.store') }}">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Water Reading (m³)</th>
                        <th>Electric Reading (kWh)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rooms as $room)
                        <tr>
                            <td>{{ $room->number }}</td>
                            <td>
                                <input type="number" step="0.01" name="readings[{{ $room->id }}][water]"
                                    value="{{ $room->meterReadings->first()->water_reading ?? '' }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="readings[{{ $room->id }}][electric]"
                                    value="{{ $room->meterReadings->first()->electric_reading ?? '' }}" required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button class="btn btn-success" type="submit">Save & Generate Invoices</button>
        </form>
    </div> --}}

    <div>

        <div
            class="border bg-neutral-bg border-neutral dark:bg-dark-neutral-bg dark:border-dark-neutral-border rounded-2xl search-input-shadow flex items-center justify-between flex-col py-[18px] pl-[28px] pr-[19px] mb-[38px] gap-[10px] sm:flex-row">
            <form method="GET" action="{{ route('meter_readings.index') }}">
                <div class="flex items-center"><img src="/backend/assets/images/icons/icon-search-normal.svg"
                        alt="seacrh icon">
                    <input
                        class="input w-full bg-transparent outline-none h-5 text-gray-400 text-sm leading-4 focus:!outline-none placeholder:text-gray-400 dark:placeholder:text-gray-dark-400 pl-[11px]"
                        type="month" name="month" id="month" value="{{ $month }}" placeholder="Search media"
                        onchange="this.form.submit()">
                </div>
            </form>
            <button
                class="btn text-sm h-fit min-h-fit capitalize leading-4 border-0 px-6 bg-color-brands rounded-lg py-[11.5px] hover:bg-color-brands"
                onclick="document.getElementById('meterReadinsForm').submit();">Save</button>
        </div>


        <div
            class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg overflow-x-scroll scrollbar-hide p-[25px] pb-[30px] mb-[45px]">
            <div class="flex items-center justify-between mb-4">
                <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">Monthly Meter
                    Readings</p>
            </div>
            <div class="w-full bg-neutral h-[1px] dark:bg-dark-neutral-border mb-[32px]"></div>
            <form method="POST" action="{{ route('meter_readings.store') }}" id="meterReadinsForm">
                @csrf
                <input type="hidden" name="month" value="{{ $month }}">
                <table class="w-full border-separate min-w-[900px] border-spacing-y-[15px]">
                    <thead>
                        <tr class="dark:border-dark-neutral-border pb-[15px] pl-[30px]">
                            <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                                Room</th>
                            <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                                Water Reading (m³)</th>
                            <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                                Electric Reading (kWh)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $room)
                            <tr
                                class="text-normal text-gray-500 dark:border-dark-neutral-border dark:text-gray-dark-1100 mb-[15px]">
                                <td
                                    class="border border-neutral py-4 border-r-0 border-l-0 dark:border-dark-neutral-border">
                                    <div>
                                        <p
                                            class="text-normal font-semibold text-gray-1100 mb-[4px] dark:text-gray-dark-1100">
                                            {{ $room->number }}</p>
                                        <p class="text-desc text-gray-400 dark:text-gray-dark-400">{{ $room->tenant->name }}
                                        </p>
                                    </div>
                                </td>
                                <td class="border border-neutral border-r-0 border-l-0 dark:border-dark-neutral-border">
                                    <div>
                                        <input
                                            class="input bg-transparent text-sm leading-4 font-semibold  text-gray-1100  h-fit min-h-fit py-4 focus:outline-none pl-[13px] dark:text-gray-dark-400 placeholder:text-inherit"
                                            type="number" step="0.01" name="readings[{{ $room->id }}][water]"
                                            value="{{ $room->meterReadings->first()->water_reading ?? '' }}" required>

                                        <input type="hidden" name="readings[{{ $room->id }}][room_id]"
                                            value="{{ $room->id }}">
                                    </div>
                                </td>
                                <td class="border border-neutral border-r-0 border-l-0 dark:border-dark-neutral-border">
                                    <div>
                                        <input
                                            class="input bg-transparent text-sm leading-4 font-semibold  text-gray-1100  h-fit min-h-fit py-4 focus:outline-none pl-[13px] dark:text-gray-dark-400 placeholder:text-inherit"
                                            type="number" step="0.01" name="readings[{{ $room->id }}][electric]"
                                            value="{{ $room->meterReadings->first()->electric_reading ?? '' }}" required>
                                        <input type="hidden" name="readings[{{ $room->id }}][room_id]"
                                            value="{{ $room->id }}">
                                    </div>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection
