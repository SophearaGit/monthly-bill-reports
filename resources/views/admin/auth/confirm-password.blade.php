@extends('backend.layouts.auth-layout')
@section('pageTitle', 'Confirm Password')
@section('content')
    <h3 class="font-bold text-2xl text-gray-1100 capitalize mb-[5px] dark:text-gray-dark-1100">Confirm password</h3>
    <p class="text-sm text-gray-500 mb-[30px] dark:text-gray-dark-500">
        This is a secure area. Please confirm your password before continuing.
    </p>

    <form method="POST" action="{{ route('admin.password.confirm') }}" class="text-left">
        @csrf

        <label for="password">
            <p class="text-left text-sm mb-2 text-gray-1100 dark:text-gray-dark-1100">Password</p>
        </label>
        <div class="form-control mb-[8px]">
            <div class="input-group border rounded-lg border-[#E8EDF2] auth-input dark:border-[#313442]">
                <input class="input flex-1 bg-transparent text-gray-1100 focus:outline-none dark:text-gray-dark-100"
                    type="password" placeholder="Password" name="password" id="password" required
                    autofocus autocomplete="current-password">
                <button type="button" class="btn-square border-white flex items-center justify-center bg-transparent"
                    tabindex="-1">
                    <img src="{{ asset('/backend/assets/images/icons/icon-eye.svg') }}" alt="eye icon">
                </button>
            </div>
        </div>
        @error('password')
            <p class="text-red text-xs mb-[12px] text-left">{{ $message }}</p>
        @enderror

        <button type="submit"
            class="btn auth-submit-btn normal-case h-fit min-h-fit transition-all duration-300 border-4 w-full border-neutral-bg mb-[20px] py-[14px] dark:border-dark-neutral-bg">
            Confirm
        </button>
    </form>
@endsection
