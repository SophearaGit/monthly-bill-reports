@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div>
        <div
            class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">
            <div class="text-base leading-5 text-gray-1100 font-semibold mb-6 dark:text-gray-dark-1100">Rooms</div>
            <table class="w-full min-w-[900px]">
                <tbody>
                    <tr>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">ID</span><img
                                    src="/backend/assets/images/icons/icon-arrow-up-down.svg" alt="arrow up down icon">
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Number</span><img
                                    src="/backend/assets/images/icons/icon-arrow-up-down.svg" alt="arrow up down icon">
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Type</span><img
                                    src="/backend/assets/images/icons/icon-arrow-up-down.svg" alt="arrow up down icon">
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Price</span><img
                                    src="/backend/assets/images/icons/icon-arrow-up-down.svg" alt="arrow up down icon">
                            </div>
                        </th>
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">Status</span><img
                                    src="/backend/assets/images/icons/icon-arrow-up-down.svg" alt="arrow up down icon">
                            </div>
                        </th>
                        <th class="border-b border-neutral dark:border-dark-neutral-border"></th>
                    </tr>
                    @forelse ($rooms as $room)
                        <tr>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    {{ $room->id }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <div class="flex flex-col gap-y-1 max-w-[250px]">
                                    <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                        {{ $room->number }}</p>
                                </div>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p
                                    class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100 uppercase">
                                    {{ $room->type }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    ${{ $room->rent_price }}
                                </p>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <div class="flex items-center gap-x-2">
                                    @if ($room->status == 'available')
                                        <div class="w-2 h-2 bg-green rounded-full"></div>
                                        <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500 capitalize">active
                                        </p>
                                    @elseif($room->status == 'rented')
                                        <div class="w-2 h-2 bg-red rounded-full"></div>
                                        <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500 capitalize">rented
                                        </p>
                                    @elseif($room->status == 'booked')
                                        <div class="w-2 h-2 bg-yellow rounded-full"></div>
                                        <p class="text-sm leading-4 text-gray-500 dark:text-gray-dark-500 capitalize">booked
                                        </p>
                                    @endif
                                </div>
                            </td>
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border"><img
                                    src="/backend/assets/images/icons/icon-3-dots.svg" alt="3 dots icon"></td>
                        </tr>
                    @empty
                    @endforelse

                </tbody>
            </table>
        </div>
        {{ $rooms->withQueryString()->links('vendor.pagination.back.custom') }}
    </div>
@endsection
