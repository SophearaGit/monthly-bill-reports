<header
    class="flex items-center justify-end flex-wrap bg-neutral-bg p-5 gap-5 md:py-6 md:pl-[25px] md:pr-[38px] dark:bg-dark-neutral-bg">
    <div class="dropdown dropdown-end">
        <label class="cursor-pointer dropdown-label" tabindex="0"><img
                src="/backend/assets/images/avatar-layouts-5.png" alt="user avatar">
        </label>
        <ul class="dropdown-content" tabindex="0">
            <div class="profile-menu">
                <div class="profile-menu-arrow"></div>
                <a class="profile-menu-item" href="{{ route('profile.edit') }}">
                    <i class="profile-menu-icon"><img src="/backend/assets/images/icons/icon-user.svg" alt="icon"></i>
                    <span>Profile</span>
                </a>
                <a class="profile-menu-item" href="{{ route('dashboard') }}">
                    <i class="profile-menu-icon"><img src="/backend/assets/images/icons/icon-favorite-chart.svg" alt="icon"></i>
                    <span>Dashboard</span>
                </a>
                <div class="profile-menu-divider"></div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <a class="profile-menu-item" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="profile-menu-icon"><img src="/backend/assets/images/icons/icon-logout.svg" alt="icon"></i>
                        <span>Log out</span>
                    </a>
                </form>
            </div>
        </ul>
    </div>
</header>

<style>
    /* Plain CSS on purpose: tailwind.min.css here is a static, pre-purged
       build, so the daisyUI-ish .menu/.rounded-box utility classes it
       relied on could inflate unpredictably. This header renders on
       every page, so its custom classes live here once. */
    .profile-menu {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 200px;
        margin-top: 25px;
        padding: 16px;
        background: var(--neutral-bg, #fff);
        border-radius: 16px;
        box-shadow: 0 40px 120px 0 rgba(0, 0, 0, .122);
    }

    @media (min-width: 768px) {
        .profile-menu {
            margin-top: 40px;
        }
    }

    .dark .profile-menu {
        background: #1B1B29;
    }

    .profile-menu-arrow {
        position: absolute;
        top: -7px;
        right: 18px;
        width: 14px;
        height: 7px;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 7px solid var(--neutral-bg, #fff);
    }

    .dark .profile-menu-arrow {
        border-bottom-color: #1B1B29;
    }

    .profile-menu-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-radius: 8px;
        font-size: 14px;
        color: #8083A3;
        cursor: pointer;
        text-decoration: none;
    }

    .profile-menu-item:hover {
        color: #171725;
        background-color: rgba(128, 131, 163, .08);
    }

    .dark .profile-menu-item:hover {
        color: #E0E0E0;
        background-color: rgba(255, 255, 255, .06);
    }

    .profile-menu-icon {
        width: 16px;
        height: 16px;
        display: grid;
        place-items: center;
        flex-shrink: 0;
    }

    .profile-menu-divider {
        width: 100%;
        height: 1px;
        background: rgba(128, 131, 163, .2);
        margin: 6px 0;
    }

    .dark .profile-menu-divider {
        background: rgba(255, 255, 255, .08);
    }
</style>
