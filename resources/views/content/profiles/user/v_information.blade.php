@extends('content.profiles.user.v_main')
@section('content_profile')
    <form class="m-form">
        <div class="m-form__section m-form__section--first">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Nama :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('user')->user()->name }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Telepon :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('user')->user()->phone }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Email :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('user')->user()->email }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Role :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('user')->user()->role }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Jenis Kelamin :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">
                                    {{ Auth::guard('user')->user()->gender == 'male' ? 'Laki - laki' : 'Perempuan' }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Tempat, Tanggal lahir :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">
                                    {{ Auth::guard('user')->user()->place_of_birth .", ". DateHelper::getTanggal(Auth::guard('user')->user()->date_of_birth) }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Agama :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('user')->user()->religion }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Alamat :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('user')->user()->address }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Login terakhir :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">
                                    {{ DateHelper::getHoursMinute(Auth::guard('user')->user()->last_login) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ Auth::guard('user')->user()->file == 'user.png' ? 'https://via.placeholder.com/150' : UploadHelper::show_image(Auth::guard('user')->user()->file) }}"
                            class="w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
