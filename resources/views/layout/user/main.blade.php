<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>

    @include('layout.user.head')
</head>

<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <header id="m_header" class="m-grid__item m-header " m-minimize="minimize" m-minimize-offset="200"
            m-minimize-mobile-offset="200">
            <div class="m-header__top">
                <div
                    class="m-container m-container--responsive m-container--xxl m-container--full-height m-page__container">
                    <div class="m-stack m-stack--ver m-stack--desktop">
                        <div class="m-stack__item m-brand" style="width: 500px">
                            <div class="m-stack m-stack--ver m-stack--general m-stack--inline">
                                <div class="m-stack__item m-stack__item--middle m-brand__logo">
                                    <a href="{{ route('user.dashboard') }}" class="m-brand__logo-wrapper d-flex">
                                        <img alt=""
                                            src="{{ $school && $school['file'] != null ? UploadHelper::show_image($school['file']) : '' }}"
                                            height="60" />
                                        <h1 class="my-auto mx-2">
                                            {{ $school && $school['name'] != null ? $school['name'] : '' }}</h1>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
                            <div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
                                <div class="m-stack__item m-topbar__nav-wrapper">
                                    <ul class="m-topbar__nav m-nav m-nav--inline">
                                        <li class="m-nav__item m-topbar__user-profile m-topbar__user-profile--img  m-dropdown m-dropdown--medium m-dropdown--arrow m-dropdown--header-bg-fill m-dropdown--align-right m-dropdown--mobile-full-width m-dropdown--skin-light"
                                            m-dropdown-toggle="click">
                                            <a href="#" class="m-nav__link m-dropdown__toggle">
                                                <span class="m-topbar__welcome">Hello,&nbsp;</span>
                                                <span
                                                    class="m-topbar__username">{{ Auth::guard('user')->user()->name }}</span>
                                                <span class="m-topbar__userpic">
                                                    <img src="{{ Auth::guard('user')->user()->file == 'user.png' ? asset('asset/img/user.png') : UploadHelper::show_image(Auth::guard('user')->user()->file) }}"
                                                        class="m--img-rounded m--marginless m--img-centered"
                                                        alt="" />
                                                </span>
                                            </a>
                                            <div class="m-dropdown__wrapper">
                                                <span
                                                    class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                                                <div class="m-dropdown__inner">
                                                    <div class="m-dropdown__header m--align-center"
                                                        style="background: url(assets/app/media/img/misc/user_profile_bg.jpg); background-size: cover;">
                                                        <div class="m-card-user m-card-user--skin-dark">
                                                            <div class="m-card-user__pic">
                                                                <img src="{{ Auth::guard('user')->user()->file == 'user.png' ? asset('asset/img/user.png') : UploadHelper::show_image(Auth::guard('user')->user()->file) }}"
                                                                    class="m--img-rounded m--marginless"
                                                                    alt="" />
                                                            </div>
                                                            <div class="m-card-user__details">
                                                                <span
                                                                    class="m-card-user__name m--font-weight-500">{{ Auth::guard('user')->user()->name }}</span>
                                                                <a href=""
                                                                    class="m-card-user__email m--font-weight-300 m-link">{{ Auth::guard('user')->user()->email }}</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="m-dropdown__body">
                                                        <div class="m-dropdown__content">
                                                            <ul class="m-nav m-nav--skin-light">
                                                                <li class="m-nav__section m--hide">
                                                                    <span class="m-nav__section-text">Section</span>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="{{ route('user.profile.user', ['information' => 'detail']) }}"
                                                                        class="m-nav__link">
                                                                        <i
                                                                            class="m-nav__link-icon flaticon-profile-1"></i>
                                                                        <span class="m-nav__link-title">
                                                                            <span class="m-nav__link-wrap">
                                                                                <span class="m-nav__link-text">My
                                                                                    Profile</span>
                                                                                <span class="m-nav__link-badge"><span
                                                                                        class="m-badge m-badge--success">2</span></span>
                                                                            </span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li class="m-nav__item">
                                                                    <a href="{{ route('auth.logout') }}"
                                                                        class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--label-brand m-btn--bolder">Logout</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- end::Topbar -->
                    </div>
                </div>
            </div>
            <div class="m-header__bottom">
                @include('layout.user.top_menu')
            </div>
        </header>
        <div
            class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop 	m-container m-container--responsive m-container--xxl m-page__container m-body">
            @yield('content')
        </div>

        <!-- end::Body -->

        <!-- begin::Footer -->
        <footer class="m-grid__item m-footer ">
            @include('layout.user.footer')
        </footer>
    </div>
    <div id="m_scroll_top" class="m-scroll-top">
        <i class="la la-arrow-up"></i>
    </div>
    @stack('modals')
    @include('layout.user.foot')
</body>

</html>
