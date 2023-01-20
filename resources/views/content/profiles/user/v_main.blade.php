@extends('layout.user.main')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="m-portlet m-portlet">
                    <div class="m-portlet__body">
                        <div class="m-card-profile">
                            <div class="m-card-profile__title m--hide">
                                Your Profile
                            </div>
                            <div class="m-card-profile__pic">
                                <div class="m-card-profile__pic-wrapper">
                                    <img src="{{ Auth::guard('user')->user()->file == 'user.png' ? 'https://via.placeholder.com/150' : UploadHelper::show_image(Auth::guard('user')->user()->file) }}" alt="" height="100" />
                                </div>
                            </div>
                            <div class="m-card-profile__details">
                                <span class="m-card-profile__name">{{ Auth::guard('user')->user()->name }}</span>
                                <a href=""
                                    class="m-card-profile__email m-link">{{ Auth::guard('user')->user()->email }}</a>
                            </div>
                        </div>
                        <ul class="m-nav m-nav--hover-bg m-portlet-fit--sides">
                            <li class="m-nav__separator m-nav__separator--fit"></li>
                            <li class="m-nav__section m--hide">
                                <span class="m-nav__section-text">Section</span>
                            </li>
                            <li class="m-nav__item">
                                <a href="{{ route('user.profile.user', ['information' => 'detail']) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-profile-1"></i>
                                    <span class="m-nav__link-title">
                                        <span class="m-nav__link-wrap">
                                            <span class="m-nav__link-text">Profil Saya</span>
                                            <span class="m-nav__link-badge"><span
                                                    class="m-badge m-badge--success">2</span></span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="{{ route('user.profile.user', ['information' => 'edit']) }}" class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-share"></i>
                                    <span class="m-nav__link-text">Edit Informasi saya</span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="{{ route('user.profile.user', ['information' => 'reset-password']) }}"
                                    class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                    <span class="m-nav__link-text">Update Password</span>
                                </a>
                            </li>
                            <li class="m-nav__item">
                                <a href="{{ route('user.profile.user', ['information' => 'close-account']) }}"
                                    class="m-nav__link">
                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                    <span class="m-nav__link-text">Tutup Akun</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-8">
                <div class="m-portlet m-portlet">
                    @yield('content_profile')
                </div>
            </div>
        </div>
    </div>
@endsection
