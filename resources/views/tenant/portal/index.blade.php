@extends('tenant.layouts.portal-layout')
@section('pageTitle', 'My Room')
@section('content')
    <div class="mb-8">
        <h1 class="text-header-6 font-semibold text-gray-1100 dark:text-gray-dark-1100 mb-1">
            Welcome, {{ $tenant->name }}
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-dark-500">Here's an overview of your room and billing.</p>
    </div>

    {{-- Room summary --}}
    <div
        class="border p-6 bg-neutral-bg rounded-2xl border-neutral dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-8">
        <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100 mb-5">Room Summary</div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-dark-400 mb-1">Room</p>
                <p class="text-normal font-semibold text-gray-1100 dark:text-gray-dark-1100">
                    {{ $tenant->room->number ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-dark-400 mb-1">Floor</p>
                <p class="text-normal font-semibold text-gray-1100 dark:text-gray-dark-1100">
                    {{ $tenant->room->floor->name ?? '—' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-dark-400 mb-1">Monthly Rent</p>
                <p class="text-normal font-semibold text-gray-1100 dark:text-gray-dark-1100">
                    ${{ number_format($tenant->room->rent_price ?? 0, 2) }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 dark:text-gray-dark-400 mb-1">Move-in Date</p>
                <p class="text-normal font-semibold text-gray-1100 dark:text-gray-dark-1100">
                    {{ optional($tenant->move_in_date)->format('d M Y') ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Meter readings --}}
    <div
        class="border p-6 bg-neutral-bg rounded-2xl border-neutral overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-8">
        <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100 mb-5">Meter Readings
        </div>
        <table class="w-full min-w-[500px]">
            <tbody>
                <tr class="border-b border-neutral dark:border-dark-neutral-border">
                    <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                        Month</th>
                    <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                        Water</th>
                    <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                        Electric</th>
                </tr>
                @forelse ($meterReadings as $reading)
                    <tr
                        class="border-b text-normal text-gray-1100 border-neutral dark:border-dark-neutral-border dark:text-gray-dark-1100">
                        <td class="py-[16px]">{{ $reading->month }}</td>
                        <td>{{ $reading->water_reading }}</td>
                        <td>{{ $reading->electric_reading }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-[20px] text-center text-sm text-gray-400 dark:text-gray-dark-400">
                            No meter readings yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Invoices --}}
    <div
        class="border p-6 bg-neutral-bg rounded-2xl border-neutral overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border">
        <div class="text-base leading-5 text-gray-1100 font-semibold dark:text-gray-dark-1100 mb-5">Invoices</div>
        <table class="w-full min-w-[600px]">
            <tbody>
                <tr class="border-b border-neutral dark:border-dark-neutral-border">
                    <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                        Month</th>
                    <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                        Total</th>
                    <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">
                        Status</th>
                </tr>
                @forelse ($invoices as $invoice)
                    <tr
                        class="border-b text-normal text-gray-1100 border-neutral dark:border-dark-neutral-border dark:text-gray-dark-1100">
                        <td class="py-[16px]">{{ $invoice->month }}</td>
                        <td>${{ number_format($invoice->total_amount, 2) }}</td>
                        <td>
                            @if (strtolower($invoice->status ?? '') === 'paid')
                                <span
                                    class="inline-flex items-center rounded-full bg-green/10 text-green text-xs font-semibold px-3 py-1">Paid</span>
                            @else
                                <span
                                    class="inline-flex items-center rounded-full bg-red/10 text-red text-xs font-semibold px-3 py-1">{{ ucfirst($invoice->status ?? 'Unpaid') }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-[20px] text-center text-sm text-gray-400 dark:text-gray-dark-400">
                            No invoices yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
