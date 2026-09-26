@extends('backend.layouts.auth-layout')
@section('pageTitle', 'Admin Sign In')
@section('content')
    <h3 class="font-bold text-2xl text-gray-1100 capitalize mb-[5px] dark:text-gray-dark-1100">Admin sign in</h3>
    <p class="text-sm text-gray-500 mb-[30px] dark:text-gray-dark-500">Sign in to manage your rooms and reports.</p>

    @if (session('status'))
        <div class="mb-[20px] text-sm font-medium text-green text-left">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login') }}" class="text-left">
        @csrf

        <label for="email">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Email</p>
        </label>
        <div class="form-control mb-[8px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="email" placeholder="you@example.com" name="email" id="email" value="{{ old('email') }}"
                    required autofocus autocomplete="username">
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
                    autocomplete="current-password">
                <button type="button" class="btn-square border-white flex items-center justify-center bg-transparent"
                    tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-eye.svg') }}" alt="eye icon">
                </button>
            </div>
        </div>
        @error('password')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <div class="flex items-center justify-between mb-[20px]">
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-color-brands focus:ring-color-brands" name="remember">
                <span class="text-xs text-gray-500 dark:text-gray-dark-500">Remember me</span>
            </label>
            <a class="text-xs text-[#8083A3] hover:text-color-brands" href="{{ route('admin.password.request') }}">
                Forgot password?
            </a>
        </div>

        <button type="submit"
            class="btn auth-submit-btn normal-case h-fit min-h-fit transition-all duration-300 border-4 w-full border-neutral-bg mb-[20px] py-[14px] dark:border-dark-neutral-bg">
            Login
        </button>

        <p class="text-sm text-gray-1100 dark:text-gray-dark-1100">Need an admin account?
            <a class="text-color-brands" href="{{ route('admin.register') }}">Sign up</a>
        </p>
    </form>
@endsection
