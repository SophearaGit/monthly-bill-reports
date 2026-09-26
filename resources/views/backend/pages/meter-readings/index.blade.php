@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
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
            class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">
            <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100 mb-6">
                Monthly Meter Readings
            </div>
            <form method="POST" action="{{ route('meter_readings.store') }}" id="meterReadinsForm">
                @csrf
                <input type="hidden" name="month" value="{{ $month }}">
                <table class="w-full min-w-[900px]">
                    <tbody>
                        <tr class="border-b border-neutral dark:border-dark-neutral-border pb-[15px]">
                            <th class="font-normal text-normal text-gray-400 text-left pb-[17px] dark:text-gray-dark-400">
                                Room</th>
                            <th class="font-normal text-normal text-gray-400 text-left pb-[17px] dark:text-gray-dark-400">
                                Water Reading (m³)</th>
                            <th class="font-normal text-normal text-gray-400 text-left pb-[17px] dark:text-gray-dark-400">
                                Electric Reading (kWh)</th>
                        </tr>
                        @forelse ($rooms as $room)
                            <tr
                                class="border-b text-normal text-gray-1100 border-neutral dark:border-dark-neutral-border dark:text-gray-dark-1100">
                                <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                    <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100 mb-1">
                                        {{ $room->number }}</p>
                                    <p class="text-desc text-gray-400 dark:text-gray-dark-400">
                                        {{ $room->tenant->name ?? 'N/A' }}</p>
                                    @if ($room->water_meter_no || $room->electric_meter_no)
                                        <p class="text-desc text-gray-400 dark:text-gray-dark-400">
                                            Meter W: {{ $room->water_meter_no ?? '—' }} / E:
                                            {{ $room->electric_meter_no ?? '—' }}
                                        </p>
                                    @endif
                                </td>
                                <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                    <input
                                        class="input bg-transparent text-sm leading-4 font-semibold text-gray-1100 h-fit min-h-fit border border-neutral dark:border-dark-neutral-border rounded-lg py-2 px-[13px] focus:outline-none dark:text-gray-dark-400 placeholder:text-inherit"
                                        type="number" step="0.01" name="readings[{{ $room->id }}][water]"
                                        value="{{ $room->meterReadings->first()->water_reading ?? '' }}" required>
                                    <input type="hidden" name="readings[{{ $room->id }}][room_id]"
                                        value="{{ $room->id }}">
                                </td>
                                <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                    <input
                                        class="input bg-transparent text-sm leading-4 font-semibold text-gray-1100 h-fit min-h-fit border border-neutral dark:border-dark-neutral-border rounded-lg py-2 px-[13px] focus:outline-none dark:text-gray-dark-400 placeholder:text-inherit"
                                        type="number" step="0.01" name="readings[{{ $room->id }}][electric]"
                                        value="{{ $room->meterReadings->first()->electric_reading ?? '' }}" required>
                                    <input type="hidden" name="readings[{{ $room->id }}][room_id]"
                                        value="{{ $room->id }}">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3"
                                    class="py-[26px] text-center text-sm text-gray-400 dark:text-gray-dark-400">
                                    No rooms yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection
