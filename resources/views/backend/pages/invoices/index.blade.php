@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    {{-- <div class="container">
        <h2>Invoices List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Tenant</th>
                    <th>Month</th>
                    <th>Total ($)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->room->number }}</td>
                        <td>{{ $invoice->tenant->name ?? '-' }}</td>
                        <td>{{ $invoice->month }}</td>
                        <td>${{ $invoice->total_amount }}</td>
                        <td>{{ ucfirst($invoice->status) }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-success btn-sm">Download
                                PDF</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $invoices->links() }}
    </div> --}}
    <div>
        <div
            class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">
            <div class="text-base leading-5 text-gray-1100 font-semibold mb-6 dark:text-gray-dark-1100">invoices</div>
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border text-center"
                            style="background: gold; padding-bottom: 0px;" rowspan="3">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">ល.រ</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border text-center"
                            style="background: gold; padding-bottom: 0px;" rowspan="3">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span
                                    class="text-xs font-semibold text-black-500 dark:text-gray-black-500">ឈ្មោះអ្នកជួល</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border text-center"
                            style="background: gold; padding-bottom: 0px;" rowspan="3">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">លេខបន្ទប់</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border text-center"
                            style="background: gold; padding-bottom: 0px;" rowspan="3">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span
                                    class="text-xs font-semibold text-black-500 dark:text-gray-black-500">ថ្លៃបន្ទប់</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral  dark:border-dark-neutral-border text-center"
                            style="background: red; padding-bottom: 0px;" colspan="4">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span
                                    class="text-xs font-semibold text-gray-1100 dark:text-gray-dark-1100">ថ្លៃអគ្គិសនី</span>
                            </div>
                        </th>
                        <th class="border-b border-neutral  dark:border-dark-neutral-border text-center"
                            style="background: blue; padding-bottom: 0px;" colspan="4">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-gray-1100 dark:text-gray-dark-1100">ថ្លៃទឹក</span>
                            </div>
                        </th>
                        <th class=" border-neutral  dark:border-dark-neutral-border text-center"
                            style="background: gold; padding-bottom: 0px;" colspan="2">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">ប្រាក់ត្រូវបង់
                                </span>
                            </div>
                        </th>
                        {{-- <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border text-center"
                            style="background: gold; padding-bottom: 0px;" rowspan="3">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">Actions</span>
                            </div>
                        </th> --}}
                        {{-- <th class="border-b border-neutral dark:border-dark-neutral-border"></th> --}}
                    </tr>
                    <tr>
                        <th class="border-b border-neutral dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    លេខគីឡូថ្មី
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    លេខគីឡូចាស់
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    ចំនួនគីឡូ
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral  dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    ថ្លៃប្រើ
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    លេខគីឡូថ្មី
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    លេខគីឡូចាស់
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    ចំនួនគីឡូ
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral  dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    ថ្លៃប្រើ
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral  dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    ប្រាក់រៀល
                                </span>
                            </div>
                        </th>
                        <th class="border-b border-neutral  dark:border-dark-neutral-border" style="background: gold;">
                            <div class="flex items-center justify-center gap-x-[10px]">
                                <span class="text-xs font-semibold text-black-500 dark:text-gray-black-500">
                                    ប្រាក់ដុល្លា
                                </span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $loop->iteration + ($invoices->currentPage() - 1) * $invoices->perPage() }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->tenant->name ?? '-' }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->room->number ?? '-' }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ number_format($invoice->rent_cost) }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->electric_new }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->electric_old }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->electric_used }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ number_format($invoice->electric_amount) }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->water_new }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->water_old }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ $invoice->water_used }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ number_format($invoice->water_amount) }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ number_format($invoice->total_riel) }}
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border text-center">
                                {{ number_format($invoice->total_usd, 2) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="text-center py-4">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $invoices->withQueryString()->links('vendor.pagination.back.custom') }}
    </div>
@endsection
