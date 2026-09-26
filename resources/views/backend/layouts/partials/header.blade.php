<header
    class="flex items-center justify-end flex-wrap bg-neutral-bg p-5 gap-5 md:py-6 md:pl-[25px] md:pr-[38px] dark:bg-dark-neutral-bg">
    <div class="dropdown dropdown-end">
        <label class="cursor-pointer dropdown-label" tabindex="0"><img
                src="/backend/assets/images/avatar-layouts-5.png" alt="user avatar">
        </label>
        <ul class="dropdown-content" tabindex="0">
            <div
                class="relative menu rounded-box dropdown-shadow p-[25px] pb-[10px] bg-neutral-bg mt-[25px] md:mt-[40px] min-w-[237px] dark:text-gray-dark-500 dark:border-dark-neutral-border dark:bg-dark-neutral-bg">
                <div
                    class="border-solid border-b-8 border-x-transparent border-x-8 border-t-0 absolute w-[14px] top-[-7px] border-b-neutral-bg dark:border-b-dark-neutral-bg right-[18px]">
                </div>
                <li
                    class="text-gray-500 hover:text-gray-1100 hover:bg-gray-100 dark:text-gray-dark-500 dark:hover:text-gray-dark-1100 dark:hover:bg-gray-dark-100 rounded-lg group p-[15px] pl-[21px]">
                    <a class="flex items-center bg-transparent p-0 gap-[7px]" href="{{ route('profile.edit') }}"> <i
                            class="w-4 h-4 grid place-items-center"><img
                                class="group-hover:filter-black dark:group-hover:filter-white"
                                src="/backend/assets/images/icons/icon-user.svg"
                                alt="icon"></i><span>Profile</span></a>
                </li>
                <li
                    class="text-gray-500 hover:text-gray-1100 hover:bg-gray-100 dark:text-gray-dark-500 dark:hover:text-gray-dark-1100 dark:hover:bg-gray-dark-100 rounded-lg group p-[15px] pl-[21px]">
                    <a class="flex items-center bg-transparent p-0 gap-[7px]" href="{{ route('dashboard') }}"> <i
                            class="w-4 h-4 grid place-items-center"><img
                                class="group-hover:filter-black dark:group-hover:filter-white"
                                src="/backend/assets/images/icons/icon-favorite-chart.svg"
                                alt="icon"></i><span>Dashboard</span></a>
                </li>
                <div class="w-full bg-neutral h-[1px] my-[7px] dark:bg-dark-neutral-border"></div>
                <li
                    class="text-gray-500 hover:text-gray-1100 hover:bg-gray-100 dark:text-gray-dark-500 dark:hover:text-gray-dark-1100 dark:hover:bg-gray-dark-100 rounded-lg group p-[15px] pl-[21px]">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <a class="flex items-center bg-transparent p-0 gap-[7px] cursor-pointer"
                            onclick="event.preventDefault(); this.closest('form').submit();"> <i
                                class="w-4 h-4 grid place-items-center"><img
                                    class="group-hover:filter-black dark:group-hover:filter-white"
                                    src="/backend/assets/images/icons/icon-logout.svg" alt="icon"></i><span>Log
                                out</span></a>
                    </form>
                </li>
            </div>
        </ul>
    </div>
</header>
