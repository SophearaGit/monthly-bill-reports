@extends('backend.layouts.auth-layout')
@section('pageTitle', 'Admin Sign Up')
@section('content')
    <h3 class="font-bold text-2xl text-gray-1100 capitalize mb-[5px] dark:text-gray-dark-1100">Create an admin account
    </h3>
    <p class="text-sm text-gray-500 mb-[30px] dark:text-gray-dark-500">Let's get you set up.</p>

    <form method="POST" action="{{ route('admin.register') }}" class="text-left">
        @csrf

        <label for="name">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Full Name</p>
        </label>
        <div class="form-control mb-[8px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="text" placeholder="Your name" name="name" id="name" value="{{ old('name') }}" required
                    autofocus autocomplete="name">
                <button type="button" class="btn-square flex items-center justify-center bg-transparent" tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-user.svg') }}" alt="user icon">
                </button>
            </div>
        </div>
        @error('name')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <label for="email">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Email</p>
        </label>
        <div class="form-control mb-[8px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="email" placeholder="you@example.com" name="email" id="email" value="{{ old('email') }}"
                    required autocomplete="username">
                <button type="button" class="btn-square flex items-center justify-center bg-transparent" tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-sms.svg') }}" alt="email icon">
                </button>
            </div>
        </div>
        @error('email')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <label for="password">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Password</p>
        </label>
        <div class="form-control mb-[8px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="password" placeholder="Password" name="password" id="password" required
                    autocomplete="new-password">
                <button type="button" class="btn-square border-white flex items-center justify-center bg-transparent"
                    tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-eye.svg') }}" alt="eye icon">
                </button>
            </div>
        </div>
        @error('password')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <label for="password_confirmation">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Confirm Password</p>
        </label>
        <div class="form-control mb-[20px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="password" placeholder="Confirm password" name="password_confirmation"
                    id="password_confirmation" required autocomplete="new-password">
                <button type="button" class="btn-square border-white flex items-center justify-center bg-transparent"
                    tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-eye.svg') }}" alt="eye icon">
                </button>
            </div>
        </div>
        @error('password_confirmation')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <button type="submit"
            class="btn auth-submit-btn normal-case h-fit min-h-fit transition-all duration-300 border-4 w-full border-neutral-bg mb-[20px] py-[14px] dark:border-dark-neutral-bg">
            Register
        </button>

        <p class="text-sm text-gray-1100 dark:text-gray-dark-1100">Already have an admin account?
            <a class="text-color-brands" href="{{ route('admin.login') }}">Sign in</a>
        </p>
    </form>
@endsection
