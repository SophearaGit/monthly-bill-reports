@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div>
        <div
            class="border p-6 bg-neutral-bg rounded-2xl border-neutral pb-0 overflow-x-scroll scrollbar-hide dark:bg-dark-neutral-bg dark:border-dark-neutral-border mb-[52px] xl:overflow-x-hidden">
            <div class="text-base leading-5 text-gray-1100 font-semibold mb-6 dark:text-gray-dark-1100">Tenents</div>
            <table class="w-full min-w-[900px]">
                <tbody>
                    <tr class="border-b border-neutral dark:border-dark-neutral-border pb-[15px]">
                        <th class="border-b border-neutral pb-[17px] dark:border-dark-neutral-border">
                            <div class="flex items-center gap-x-[10px]"><span
                                    class="text-xs font-semibold text-gray-500 dark:text-gray-dark-500">ID</span><img
                                    src="/backend/assets/images/icons/icon-arrow-up-down.svg" alt="arrow up down icon">
                            </div>
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Name
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Phone
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-left pb-[15px] dark:text-gray-dark-400">Room
                        </th>
                        <th class="font-normal text-normal text-gray-400 text-center pb-[15px] dark:text-gray-dark-400">
                            Actions</th>
                    </tr>
                    @forelse ($tenants as $tenant)
                        <tr
                            class="border-b text-normal text-gray-1100 border-neutral dark:border-dark-neutral-border dark:text-gray-dark-1100">
                            <td class="border-b border-neutral py-[26px] dark:border-dark-neutral-border">
                                <p class="text-sm leading-4 text-gray-1100 font-semibold dark:text-gray-dark-1100">
                                    {{ $tenant->id }}
                                </p>
                            </td>
                            <td class="py-[25px]">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full overflow-hidden"><img
                                            src="/backend/assets/images/seller-avatar-1.png" alt="user avatar"></div>
                                    <p class="text-normal text-gray-1100 dark:text-gray-dark-1100">{{ $tenant->name }}</p>
                                </div>
                            </td>
                            <td><span>{{ $tenant->phone }}</span></td>
                            <td><span>{{ $tenant->room->number }}</span></td>
                            <td>
                                <div class="dropdown dropdown-end w-full">
                                    <label class="cursor-pointer dropdown-label flex items-center justify-between p-3"
                                        tabindex="0"><img class="mx-auto cursor-pointer"
                                            src="/backend/assets/images/icons/icon-more.svg" alt="more icon">
                                    </label>
                                    <ul class="dropdown-content" tabindex="0">
                                        <div
                                            class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                            <div
                                                class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                            </div>
                                            <li class="text-normal mb-[7px]"><a
                                                    class="flex items-center bg-transparent p-0 gap-[7px] show-detail"
                                                    href="#"> <span
                                                        class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">View
                                                        details</span></a>
                                            </li>
                                            <li class="text-normal mb-[7px]"><a
                                                    class="flex items-center bg-transparent p-0 gap-[7px]" href="#">
                                                    <span
                                                        class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Send
                                                        message</span></a>
                                            </li>
                                            <li class="text-normal mb-[7px]"><a
                                                    class="flex items-center bg-transparent p-0 gap-[7px]" href="#">
                                                    <span
                                                        class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Contact</span></a>
                                            </li>
                                            <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                            </div>
                                            <li class="text-normal mb-[7px]"><a
                                                    class="flex items-center bg-transparent p-0 gap-[7px]" href="#remove">
                                                    <span class="text-red text-[11px] leading-4">Delete</span></a>
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $tenants->withQueryString()->links('vendor.pagination.back.custom') }}
    </div>
@endsection
