<!DOCTYPE html>
<html class="scroll-smooth overflow-x-hidden" lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('pageTitle')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <link rel="icon" href="{{ asset('/backend/assets/images/icons/icon-favicon.png') }}" type="image/png"
        sizes="256x256">
    <link rel="stylesheet" href="{{ asset('/backend/assets/styles/tailwind.min.css?v=5.0') }}">
    <link rel="stylesheet" href="{{ asset('/backend/assets/styles/style.min.css?v=5.0') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script>
        try {
            if (localStorage.getItem('color-theme') === 'dark' ||
                (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        } catch (e) {}
    </script>
    @yield('stylesheets')
</head>

<body class="w-screen relative overflow-x-hidden min-h-screen bg-gray-100 scrollbar-hide dark:bg-[#000]">
    <header
        class="flex items-center justify-between bg-neutral-bg p-5 md:py-6 md:px-[38px] dark:bg-dark-neutral-bg border-b border-neutral dark:border-dark-neutral-border">
        <div class="flex items-center gap-3">
            <img src="{{ asset('/backend/assets/images/icons/icon-logo.png') }}" alt="Anita Rent logo" style="height:40px;width:auto;">
            <span class="text-gray-1100 dark:text-gray-dark-1100 font-semibold">Tenant Portal</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-gray-500 dark:text-gray-dark-500 hidden sm:inline">
                {{ auth('tenant')->user()->name }}
            </span>
            <form method="POST" action="{{ route('tenant.logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-[7px] text-sm text-gray-500 hover:text-color-brands dark:text-gray-dark-500">
                    <img src="{{ asset('/backend/assets/images/icons/icon-logout.svg') }}" alt="icon" class="w-4 h-4">
                    Log out
                </button>
            </form>
        </div>
    </header>
    <main class="max-w-[1000px] mx-auto px-[23px] py-[32px]">
        @yield('content')
    </main>
</body>

</html>
