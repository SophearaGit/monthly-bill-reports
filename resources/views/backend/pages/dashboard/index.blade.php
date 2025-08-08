@extends('backend.layouts.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page Title Here')
@section('content')
    <div>
        <div class="grid grid-cols-1 gap-6 mb-[26px] lg:grid-cols-2 xl:grid-cols-4">
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-desc text-gray-500 dark:text-gray-dark-500">Total sells</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove">
                                        <span class="text-red text-[11px] leading-4">Remove widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-green"><img
                                src="/backend/assets/images/icons/icon-bag-happy.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">$126.500
                        </p>
                    </div>
                    <div class="flex items-center gap-[7px]"><img src="/backend/assets/images/icons/icon-export-green.svg"
                            alt=""><span class="text-green text-subtitle font-medium">34.7%</span></div>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">Compared
                    to Jan 2022</p>
            </div>
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-desc text-gray-500 dark:text-gray-dark-500">Orders value</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#">
                                        <span class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove">
                                        <span class="text-red text-[11px] leading-4">Remove widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-blue"><img
                                src="/backend/assets/images/icons/icon-bag-happy.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">$136.800
                        </p>
                    </div>
                    <div class="flex items-center gap-[7px]"><img src="/backend/assets/images/icons/icon-export-green.svg"
                            alt=""><span class="text-green text-subtitle font-medium">22.8%</span></div>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">
                    Compared to Jan 2022</p>
            </div>
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-desc text-gray-500 dark:text-gray-dark-500">Daily orders</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove"> <span class="text-red text-[11px] leading-4">Remove
                                            widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-violet"><img
                                src="/backend/assets/images/icons/icon-bag-happy.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">$25.200
                        </p>
                    </div>
                    <div class="flex items-center gap-[7px]"><img src="/backend/assets/images/icons/icon-export-green.svg"
                            alt=""><span class="text-green text-subtitle font-medium">17.8%</span></div>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">
                    Compared to Jan 2022</p>
            </div>
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg py-4 flex-1 px-[19px]">
                <div class="flex items-center justify-between mb-4">
                    <p class="text-desc text-gray-500 dark:text-gray-dark-500">Total sells</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove"> <span class="text-red text-[11px] leading-4">Remove
                                            widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-[2px]">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg grid place-items-center bg-pink"><img
                                src="/backend/assets/images/icons/icon-bag-happy.svg" alt=""></div>
                        <p class="text-btn-label font-bold text-gray-1100 dark:text-gray-dark-1100">$12.125
                        </p>
                    </div>
                    <div class="flex items-center gap-[7px]"><img src="/backend/assets/images/icons/icon-export-green.svg"
                            alt=""><span class="text-green text-subtitle font-medium">23.9%</span></div>
                </div>
                <p class="text-right text-gray-400 dark:text-gray-dark-400 text-[11px] leading-[16px]">
                    Compared to Jan 2022</p>
            </div>
        </div>


        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg flex-1 p-[25px]">
                <div
                    class="flex items-center justify-between pb-3 border-neutral border-b mb-5 dark:border-dark-neutral-border">
                    <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">
                        Market Overview</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove"> <span class="text-red text-[11px] leading-4">Remove
                                            widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-x-[27.45px]">
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-gray-400 dark:text-gray-dark-400">Mon</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-gray-400 dark:text-gray-dark-400">Tue</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-gray-400 dark:text-gray-dark-400">Wed</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-gray-400 dark:text-gray-dark-400">Thu</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-gray-400 dark:text-gray-dark-400">Fri</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-red dark:text-red">Sat</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col-reverse gap-y-[10px]">
                        <p class="text-xs text-red dark:text-red">Sun</p>
                        <div
                            class="relative bg-neutral rounded-[10px] dark:bg-dark-neutral-border h-[198px] max-w-[21.12px]">
                            <div class="w-full block bg-color-brands absolute bottom-0 rounded-[10px] h-[50%]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg flex-1 p-[25px]">
                <div
                    class="flex items-center justify-between pb-3 border-neutral border-b mb-5 dark:border-dark-neutral-border">
                    <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">
                        Visits by Source</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove"> <span class="text-red text-[11px] leading-4">Remove
                                            widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div>
                    <div>
                        <canvas class="max-h-[240px] lg:max-h-[123px] xl:max-h-[200px]" width="400" height="400"
                            id="visitChart"></canvas>
                    </div>
                </div>
                <p class="text-desc text-gray-500 mt-3 dark:text-gray-dark-500">Lorem ipsum dolor sit amet,
                    consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
            </div>
            <div
                class="rounded-2xl border border-neutral bg-neutral-bg dark:border-dark-neutral-border dark:bg-dark-neutral-bg flex-1 p-[25px]">
                <div
                    class="flex items-center justify-between pb-3 border-neutral border-b mb-5 dark:border-dark-neutral-border">
                    <p class="text-subtitle-semibold font-semibold text-gray-1100 dark:text-gray-dark-1100">
                        Total Revenue</p>
                    <div class="dropdown dropdown-end ml-auto translate-x-4 z-10">
                        <label class="cursor-pointer dropdown-label flex items-center justify-between py-2 px-4"
                            tabindex="0"><img class="cursor-pointer" src="/backend/assets/images/icons/icon-toggle.svg"
                                alt="toggle icon">
                        </label>
                        <ul class="dropdown-content" tabindex="0">
                            <div
                                class="relative menu rounded-box dropdown-shadow min-w-[126px] bg-neutral-bg mt-[10px] pt-[14px] pb-[7px] px-4 border border-neutral-border  dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                                <div
                                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-transparent right-[18px]">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Sales
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Export
                                            report</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Profit
                                            manage</span></a>
                                </li>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#"> <span
                                            class="text-gray-500 text-[11px] leading-4 hover:text-gray-700">Revenue
                                            report</span></a>
                                </li>
                                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border">
                                </div>
                                <li class="text-normal mb-[7px]"><a class="flex items-center bg-transparent p-0 gap-[7px]"
                                        href="#remove"> <span class="text-red text-[11px] leading-4">Remove
                                            widget</span></a>
                                </li>
                            </div>
                        </ul>
                    </div>
                </div>
                <div>
                    <div>
                        <canvas class="max-h-[240px] lg:max-h-[123px] xl:max-h-[200px]" width="400" height="400"
                            id="revenueChart"></canvas>
                    </div>
                </div>
                <p class="text-desc text-gray-500 mt-3 dark:text-gray-dark-500">Lorem ipsum dolor sit amet,
                    consectetur adipiscing elit, sed do eiusmod tempor incididunt.</p>
            </div>
        </div>
    </div>
@endsection
