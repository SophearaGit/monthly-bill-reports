@extends('backend.layouts.auth-layout')
@section('pageTitle', 'Anita Rent — Sign In')
@section('content')
    <h3 class="font-bold text-2xl text-gray-1100 capitalize mb-[5px] dark:text-gray-dark-1100">Welcome</h3>
    <p class="text-sm text-gray-500 mb-[30px] dark:text-gray-dark-500">Sign in to continue.</p>

    <div class="flex flex-col gap-3 text-left">
        <a href="{{ route('admin.login') }}"
            class="btn auth-submit-btn normal-case h-fit min-h-fit transition-all duration-300 border-4 w-full border-neutral-bg py-[14px] flex items-center justify-center gap-2 dark:border-dark-neutral-bg">
            <img src="{{ asset('/backend/assets/images/icons/icon-favorite-chart.svg') }}" alt="" class="filter-white">
            Admin Login
        </a>

        <a href="{{ route('tenant.login') }}"
            class="btn normal-case h-fit min-h-fit transition-all duration-300 border w-full py-[14px] flex items-center justify-center gap-2 bg-transparent border-[#E8EDF2] text-gray-1100 hover:bg-gray-100 dark:border-[#313442] dark:text-gray-dark-1100 dark:hover:bg-gray-dark-100">
            <img src="{{ asset('/backend/assets/images/icons/icon-user.svg') }}" alt="">
            Tenant Login
        </a>
    </div>
@endsection
