<!DOCTYPE html>
<html class="scroll-smooth overflow-x-hidden" lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('pageTitle')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0">
    <link rel="icon" href="{{ asset('/backend/assets/images/icons/icon-favicon.svg') }}" type="image/x-icon"
        sizes="16x16">
    <link rel="stylesheet" href="{{ asset('/backend/assets/styles/tailwind.min.css?v=5.0') }}">
    <link rel="stylesheet" href="{{ asset('/backend/assets/styles/style.min.css?v=5.0') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Chivo:wght@400;700;900&family=Noto+Sans:wght@400;500;600;700;800&display=swap">
    <style>
        .auth-input:focus-within {
            border-color: var(--color-brands);
            box-shadow: 0 0 0 3px rgba(115, 100, 219, .12);
        }

        .auth-submit-btn {
            background-color: var(--color-brands);
            color: #fff;
        }

        .auth-submit-btn:hover {
            filter: brightness(0.94);
        }
    </style>
    <script>
        // Apply saved theme before paint to avoid a light/dark flash.
        try {
            if (localStorage.getItem('color-theme') === 'dark' ||
                (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        } catch (e) {}
    </script>
</head>

<body class="w-screen relative overflow-x-hidden min-h-screen bg-gray-100 dark:bg-[#000] flex items-center justify-center p-4">
    <div class="w-full max-w-[440px]">
        <a href="{{ url('/') }}" class="flex justify-center mb-8">
            <img src="{{ asset('/backend/assets/images/icons/icon-logo.svg') }}" alt="logo" class="h-8">
        </a>
        <div class="rounded-2xl bg-white p-10 text-center dark:bg-[#1F2128]">
            @yield('content')
        </div>
    </div>
</body>

</html>
