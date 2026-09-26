@extends('backend.layouts.auth-layout')
@section('pageTitle', 'Admin Forgot Password')
@section('content')
    <h3 class="font-bold text-2xl text-gray-1100 capitalize mb-[5px] dark:text-gray-dark-1100">Forgot password?</h3>
    <p class="text-sm text-gray-500 mb-[30px] dark:text-gray-dark-500">
        Enter your email and we'll send you a link to reset it.
    </p>

    @if (session('status'))
        <div class="mb-[20px] text-sm font-medium text-green text-left">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.password.email') }}" class="text-left">
        @csrf

        <label for="email">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Email</p>
        </label>
        <div class="form-control mb-[8px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="email" placeholder="you@example.com" name="email" id="email" value="{{ old('email') }}"
                    required autofocus>
                <button type="button" class="btn-square flex items-center justify-center bg-transparent" tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-sms.svg') }}" alt="email icon">
                </button>
            </div>
        </div>
        @error('email')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <button type="submit"
            class="btn auth-submit-btn normal-case h-fit min-h-fit transition-all duration-300 border-4 w-full border-neutral-bg mb-[20px] py-[14px] dark:border-dark-neutral-bg">
            Send Password Reset Link
        </button>

        <p class="text-sm text-gray-1100 dark:text-gray-dark-1100">
            <a class="text-color-brands" href="{{ route('admin.login') }}">Back to sign in</a>
        </p>
    </form>
@endsection
