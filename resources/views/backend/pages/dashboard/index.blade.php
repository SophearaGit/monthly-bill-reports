@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <style>
        .dash-trend-grid {
            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            column-gap: 16px;
        }

        .dash-bar-track {
            height: 140px;
        }

        .dash-row-border {
            border-bottom-width: 1px;
        }

        .dash-table-min {
            min-width: 560px;
        }

        .dash-invoices-col {
            grid-column: span 1 / span 1;
        }

        @media (min-width: 1280px) {
            .dash-invoices-col {
                grid-column: span 2 / span 2;
            }
        }

        .dash-mt-1 {
            margin-top: 4px;
        }

        .dash-icon-white {
            filter: brightness(0) invert(1);
        }

        .quick-action-tile {
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }

        .quick-action-tile:hover {
            transform: translateY(-2px);
            border-color: var(--color-brands);
            box-shadow: 0 6px 16px rgba(115, 100, 219, .16);
        }
    </style>
    <div>
        <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
            <p class="text-desc text-gray-500 dark:text-gray-dark-500">
                Overview for
                <span class="font-semibold text-gray-1100 dark:text-gray-dark-1100">{{ $currentMonthLabel }}</span>
            </p>
            <form method="GET" action="{{ route('dashboard') }}"
                class="flex items-center gap-2 rounded-lg border border-neutral dark:border-dark-neutral-border px-3 py-2">
                <img src="/backend/assets/images/icons/icon-calendar-1.svg" alt="" class="w-4 h-4">
                <input type="month" name="month" value="{{ $selectedMonth }}"
                    class="bg-transparent text-sm text-gray-1100 dark:text-gray-dark-1100 focus:outline-none"
                    onchange="this.form.submit()">
            </form>
        </div>

        {{-- ── Quick actions ── --}}
        <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Quick Actions</p>
        <div class="flex items-center flex-wrap gap-3 mb-5">
            <a href="{{ route('rooms.index', ['open' => 'add-room']) }}"
                class="quick-action-tile flex items-center gap-3 rounded-xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg pl-3 pr-5 py-[10px]">
                <div class="w-9 h-9 shrink-0 rounded-lg grid place-items-center bg-green">
                    <img class="filter-white w-[18px] h-[18px]" src="/backend/assets/images/icons/icon-products.svg"
                        alt="">
                </div>
                <span class="text-sm font-semibold text-gray-1100 dark:text-gray-dark-1100 whitespace-nowrap">Add
                    Room</span>
            </a>
            <a href="{{ route('tenents.index', ['open' => 'add-tenant']) }}"
                class="quick-action-tile flex items-center gap-3 rounded-xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg pl-3 pr-5 py-[10px]">
                <div class="w-9 h-9 shrink-0 rounded-lg grid place-items-center bg-blue">
                    <img class="filter-white w-[18px] h-[18px]" src="/backend/assets/images/icons/icon-crm.svg" alt="">
                </div>
                <span class="text-sm font-semibold text-gray-1100 dark:text-gray-dark-1100 whitespace-nowrap">Add
                    Tenant</span>
            </a>
            <a href="{{ route('meter_readings.index') }}"
                class="quick-action-tile flex items-center gap-3 rounded-xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg pl-3 pr-5 py-[10px]">
                <div class="w-9 h-9 shrink-0 rounded-lg grid place-items-center bg-violet">
                    <img class="filter-white w-[18px] h-[18px]" src="/backend/assets/images/icons/icon-analytics.svg"
                        alt="">
                </div>
                <span class="text-sm font-semibold text-gray-1100 dark:text-gray-dark-1100 whitespace-nowrap">Record
                    Readings</span>
            </a>
            <a href="{{ route('invoices.index') }}"
                class="quick-action-tile flex items-center gap-3 rounded-xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg pl-3 pr-5 py-[10px]">
                <div class="w-9 h-9 shrink-0 rounded-lg grid place-items-center bg-red">
                    <img class="filter-white w-[18px] h-[18px]" src="/backend/assets/images/icons/icon-wallet.svg"
                        alt="">
                </div>
                <span class="text-sm font-semibold text-gray-1100 dark:text-gray-dark-1100 whitespace-nowrap">View
                    Invoices</span>
            </a>
        </div>

        {{-- ── Stat cards ── --}}
        <div class="grid grid-cols-1 gap-4 mb-5 lg:grid-cols-2 xl:grid-cols-4">
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Monthly Revenue</p>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-green"><img
                                class="dash-icon-white" src="/backend/assets/images/icons/icon-bar-chart.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">
                            ${{ number_format($monthlyRevenue, 2) }}</p>
                    </div>
                    <div class="flex items-center gap-[7px]">
                        <img src="/backend/assets/images/icons/icon-export-{{ $revenueChange >= 0 ? 'green' : 'red' }}.svg"
                            alt="">
                        <span
                            class="{{ $revenueChange >= 0 ? 'text-green' : 'text-red' }} text-subtitle font-medium">{{ number_format(abs($revenueChange), 1) }}%</span>
                    </div>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">vs last month
                </p>
            </div>

            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Collected</p>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-blue"><img
                                class="dash-icon-white" src="/backend/assets/images/icons/icon-money.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">
                            ${{ number_format($collected, 2) }}</p>
                    </div>
                    <span class="text-desc text-gray-400 dark:text-gray-dark-400">{{ $paidCount }} paid</span>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">of
                    ${{ number_format($monthlyRevenue, 2) }} billed</p>
            </div>

            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Outstanding</p>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-red"><img
                                class="dash-icon-white" src="/backend/assets/images/icons/icon-wallet.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">
                            ${{ number_format($outstanding, 2) }}</p>
                    </div>
                    <span class="text-desc text-red font-semibold">{{ $unpaidCount }} unpaid</span>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">needs
                    collecting</p>
            </div>

            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Occupancy</p>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-violet"><img
                                class="dash-icon-white" src="/backend/assets/images/icons/icon-home-hashtag.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">
                            {{ $occupancyRate }}%</p>
                    </div>
                    <span class="text-desc text-gray-400 dark:text-gray-dark-400">{{ $rentedRooms }}/{{ $totalRooms }}
                        rooms</span>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">
                    {{ $totalTenants }} tenants total</p>
            </div>
        </div>

        {{-- ── Trend + status row ── --}}
        <div class="grid grid-cols-1 gap-4 mb-5 lg:grid-cols-3">
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg flex-1 p-5">
                <div
                    class="flex items-center justify-between pb-3 border-neutral dash-row-border mb-4 dark:border-dark-neutral-border">
                    <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">Revenue
                        Trend</p>
                </div>
                <div class="dash-trend-grid">
                    @foreach ($trendLabels as $i => $label)
                        @php
                            $val = $trendRevenue[$i];
                            $heightPct = $maxTrendRevenue > 0 ? max(4, round($val / $maxTrendRevenue * 100)) : 4;
                            $isCurrent = $i === $trendLabels->count() - 1;
                        @endphp
                        <div class="flex flex-col-reverse gap-y-[10px]">
                            <p
                                class="text-xs {{ $isCurrent ? 'text-color-brands font-semibold' : 'text-gray-400 dark:text-gray-dark-400' }}">
                                {{ $label }}</p>
                            <div class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border dash-bar-track"
                                title="${{ number_format($val, 2) }}">
                                <div class="w-full block {{ $isCurrent ? 'bg-color-brands' : 'bg-blue' }} absolute bottom-0 rounded-[10px]"
                                    style="height: {{ $heightPct }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg flex-1 p-5">
                <div
                    class="flex items-center justify-between pb-3 border-neutral dash-row-border mb-4 dark:border-dark-neutral-border">
                    <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">Room
                        Status</p>
                </div>
                <div class="max-w-[160px] mx-auto">
                    <canvas class="max-h-[160px]" width="400" height="400" id="roomStatusChart"></canvas>
                </div>
                <div class="flex items-center justify-between mt-4 text-xs flex-wrap gap-y-2">
                    <div class="flex items-center gap-x-2"><span class="w-2 h-2 rounded-full bg-red inline-block"></span>
                        <span class="text-gray-500 dark:text-gray-dark-500">Rented ({{ $rentedRooms }})</span>
                    </div>
                    <div class="flex items-center gap-x-2"><span
                            class="w-2 h-2 rounded-full bg-yellow inline-block"></span>
                        <span class="text-gray-500 dark:text-gray-dark-500">Booked ({{ $bookedRooms }})</span>
                    </div>
                    <div class="flex items-center gap-x-2"><span
                            class="w-2 h-2 rounded-full bg-green inline-block"></span>
                        <span class="text-gray-500 dark:text-gray-dark-500">Available ({{ $availableRooms }})</span>
                    </div>
                </div>
            </div>

            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg flex-1 p-5">
                <div
                    class="flex items-center justify-between pb-3 border-neutral dash-row-border mb-4 dark:border-dark-neutral-border">
                    <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">Outstanding
                        Trend</p>
                </div>
                <div>
                    <canvas class="max-h-[160px]" width="400" height="400" id="outstandingTrendChart"></canvas>
                </div>
                <p class="text-desc text-gray-500 mt-3 dark:text-gray-dark-500">
                    ${{ number_format($outstanding, 2) }} currently outstanding across {{ $unpaidCount }}
                    invoice{{ $unpaidCount === 1 ? '' : 's' }}.
                </p>
            </div>
        </div>

        {{-- ── Usage row ── --}}
        <div class="grid grid-cols-1 gap-4 mb-5 lg:grid-cols-2">
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Water Usage ({{ $currentMonthLabel }})
                </p>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-blue"><img
                                class="dash-icon-white" src="/backend/assets/images/icons/icon-economy.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">
                            {{ number_format($waterUsedTotal) }} m&sup3;</p>
                    </div>
                    <span class="text-desc text-gray-400 dark:text-gray-dark-400">${{ number_format($waterCostTotal, 2) }}</span>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">billed this
                    month</p>
            </div>

            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <p class="text-desc text-gray-500 dark:text-gray-dark-500 mb-3">Electric Usage
                    ({{ $currentMonthLabel }})</p>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-violet"><img
                                class="dash-icon-white" src="/backend/assets/images/icons/icon-flash.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">
                            {{ number_format($electricUsedTotal) }} kWh</p>
                    </div>
                    <span
                        class="text-desc text-gray-400 dark:text-gray-dark-400">${{ number_format($electricCostTotal, 2) }}</span>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">billed this
                    month</p>
            </div>
        </div>

        {{-- ── Invoices row ── --}}
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-3">
            <div
                class="dash-invoices-col border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border xl:overflow-x-hidden">
                <div class="flex items-center justify-between mb-6">
                    <p class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100">Recent
                        Invoices</p>
                    <a href="{{ route('invoices.index') }}"
                        class="text-desc text-color-brands font-semibold hover:opacity-75">View all</a>
                </div>
                <table class="w-full dash-table-min">
                    <tbody>
                        <tr>
                            <th class="dash-row-border border-neutral pb-[17px] dark:border-dark-neutral-border text-left">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Room</span>
                            </th>
                            <th class="dash-row-border border-neutral pb-[17px] dark:border-dark-neutral-border text-left">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Tenant</span>
                            </th>
                            <th class="dash-row-border border-neutral pb-[17px] dark:border-dark-neutral-border text-left">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Month</span>
                            </th>
                            <th class="dash-row-border border-neutral pb-[17px] dark:border-dark-neutral-border text-right">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Amount</span>
                            </th>
                            <th class="dash-row-border border-neutral pb-[17px] dark:border-dark-neutral-border text-left">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Status</span>
                            </th>
                        </tr>
                        @forelse ($recentInvoices as $inv)
                            <tr>
                                <td class="dash-row-border border-neutral py-5 dark:border-dark-neutral-border">
                                    <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                        #{{ $inv->room->number ?? '—' }}</p>
                                </td>
                                <td class="dash-row-border border-neutral py-5 dark:border-dark-neutral-border">
                                    <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500">
                                        {{ $inv->tenant->name ?? 'N/A' }}</p>
                                </td>
                                <td class="dash-row-border border-neutral py-5 dark:border-dark-neutral-border">
                                    <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500">
                                        {{ \Carbon\Carbon::parse($inv->month . '-01')->format('M Y') }}</p>
                                </td>
                                <td class="dash-row-border border-neutral py-5 dark:border-dark-neutral-border text-right">
                                    <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                        ${{ number_format($inv->total_amount, 2) }}</p>
                                </td>
                                <td class="dash-row-border border-neutral py-5 dark:border-dark-neutral-border">
                                    @if ($inv->status === 'paid')
                                        <span class="inline-flex items-center rounded-full text-xs font-semibold px-2 py-1"
                                            style="background-color: rgba(80,209,178,.15); color: #50D1B2;">Paid</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full text-xs font-semibold px-2 py-1"
                                            style="background-color: rgba(226,55,56,.12); color: #E23738;">Unpaid</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 dark:text-gray-dark-400 text-sm">
                                    No invoices yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div
                class="border p-6 bg-neutral-bg rounded-2xl border-neutral dark:bg-dark-neutral-bg dark:border-dark-neutral-border">
                <p class="text-base leading-5 text-gray-1100 font-semibold mb-6 dark:text-gray-dark-1100">Top
                    Outstanding</p>
                <div class="flex flex-col gap-5">
                    @forelse ($topOutstanding as $inv)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    Room #{{ $inv->room->number ?? '—' }}</p>
                                <p class="text-xs text-gray-400 dark:text-gray-dark-400 dash-mt-1">
                                    {{ $inv->tenant->name ?? 'N/A' }}</p>
                            </div>
                            <p class="text-sm font-bold text-red">${{ number_format($inv->total_amount, 2) }}</p>
                        </div>
                    @empty
                        <p class="text-desc text-gray-400 dark:text-gray-dark-400">All caught up — no outstanding
                            invoices this month.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var roomStatusCtx = document.getElementById('roomStatusChart');
            if (roomStatusCtx && window.Chart) {
                new Chart(roomStatusCtx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Rented', 'Booked', 'Available'],
                        datasets: [{
                            data: [{{ $rentedRooms }}, {{ $bookedRooms }}, {{ $availableRooms }}],
                            backgroundColor: ['#E23738', '#F5A623', '#50D1B2'],
                            borderWidth: 0,
                        }],
                    },
                    options: {
                        responsive: true,
                        cutout: '70%',
                        plugins: { legend: { display: false }, tooltip: { enabled: true } },
                    },
                });
            }

            var outstandingCtx = document.getElementById('outstandingTrendChart');
            if (outstandingCtx && window.Chart) {
                new Chart(outstandingCtx, {
                    type: 'line',
                    data: {
                        labels: {!! $trendLabels->values()->toJson() !!},
                        datasets: [{
                            label: 'Outstanding',
                            data: {!! $trendOutstanding->values()->toJson() !!},
                            borderColor: '#E23738',
                            backgroundColor: '#E23738',
                            pointRadius: 0,
                            tension: 0.4,
                        }],
                    },
                    options: {
                        responsive: true,
                        scales: { x: { display: false }, y: { display: false } },
                        plugins: { legend: { display: false } },
                    },
                });
            }
        });
    </script>
@endsection
