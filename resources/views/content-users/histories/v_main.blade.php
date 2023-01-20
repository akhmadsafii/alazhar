@extends('layout.user.main')
@section('content')
    <button class="m-aside-left-close m-aside-left-close--skin-light" id="m_aside_left_close_btn"><i
            class="la la-close"></i></button>
    <div id="m_aside_left" class="m-grid__item m-aside-left ">
        <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-light m-aside-menu--submenu-skin-light "
            data-menu-vertical="true" m-menu-scrollable="0" m-menu-dropdown-timeout="500">
            <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
                <li class="m-menu__section m-menu__section--first">
                    <h4 class="m-menu__section-text">Departments</h4>
                    <i class="m-menu__section-icon flaticon-more-v2"></i>
                </li>
                <li class="m-menu__item {{ Route::is('user.history.rental') ? 'm-menu__item--active' : '' }}"
                    aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ route('user.history.rental') }}"
                        class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                            class="m-menu__link-text">Peminjaman Barang</span></a></li>
                <li class="m-menu__item {{ Route::is('user.history.procurement') ? 'm-menu__item--active' : '' }}"
                    aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ route('user.history.procurement') }}"
                        class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                            class="m-menu__link-text">Pengadaan Barang</span></a></li>
                <li class="m-menu__item {{ Route::is('user.history.consumable') ? 'm-menu__item--active' : '' }}"
                    aria-haspopup="true" m-menu-link-redirect="1"><a href="{{ route('user.history.consumable') }}"
                        class="m-menu__link "><i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i><span
                            class="m-menu__link-text">Barang Habis Pakai</span></a></li>
            </ul>
        </div>
    </div>
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        @yield('content_history')
    </div>
@endsection
