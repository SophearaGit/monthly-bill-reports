<h2 class="capitalize text-gray-1100 font-bold text-[28px] leading-[35px] dark:text-gray-dark-1100 mb-[13px]">
    @if (Route::is('dashboard'))
        Dashboard
    @elseif (Route::is('rooms.*'))
        Rooms
    @elseif (Route::is('tenents.*'))
        Tenents
    @elseif (Route::is('meter_readings.index'))
        Meter Readings
    @endif
</h2>
<div class="flex items-center text-xs text-gray-500 gap-x-[11px] mb-[37px]">
    <div class="flex items-center gap-x-1"><img src="/backend/assets/images/icons/icon-home-2.svg" alt="home icon"><a
            class="capitalize" href="{{ route('dashboard') }}">home</a></div><img
        src="/backend/assets/images/icons/icon-arrow-right.svg" alt="arrow right icon"><span
        class="capitalize text-color-brands">
        @if (Route::is('dashboard'))
            Dashboard
        @elseif (Route::is('rooms.*'))
            Rooms
        @elseif (Route::is('tenents.*'))
            Tenents
        @elseif (Route::is('meter_readings.index'))
            Meter Readings
        @endif
    </span>
</div>
