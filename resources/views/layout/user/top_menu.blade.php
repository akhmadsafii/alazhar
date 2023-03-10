<div class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
    <div class="m-stack m-stack--ver m-stack--desktop">

        <!-- begin::Horizontal Menu -->
        <div class="m-stack__item m-stack__item--middle m-stack__item--fluid">
            <button class="m-aside-header-menu-mobile-close  m-aside-header-menu-mobile-close--skin-light "
                id="m_aside_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
            <div id="m_header_menu"
                class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-dark m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-light m-aside-header-menu-mobile--submenu-skin-light ">
                <ul class="m-menu__nav  m-menu__nav--submenu-arrow ">
                    <li class="m-menu__item  {{ Route::is('user.dashboard') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a
                            href="{{ route('user.dashboard') }}" class="m-menu__link "><span
                                class="m-menu__item-here"></span><span class="m-menu__link-text">Dashboard</span></a>
                    </li>
                    <li class="m-menu__item {{ Route::is('user.submission.*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a
                            href="{{ route('user.submission.rental.list') }}"
                            class="m-menu__link "><span class="m-menu__item-here"></span><span
                                class="m-menu__link-text">Pengajuan</span></a></li>
                    <li class="m-menu__item {{ Route::is('user.history.*') ? 'm-menu__item--active' : '' }}" aria-haspopup="true"><a href="{{ route('user.history.rental') }}" class="m-menu__link "><span
                                class="m-menu__item-here"></span><span class="m-menu__link-text">Riwayat</span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
