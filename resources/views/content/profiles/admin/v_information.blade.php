@extends('content.profiles.admin.v_main')
@section('content_profile')
    <form class="m-form">
        <div class="m-form__section m-form__section--first">
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-9">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Nama :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('admin')->user()->name }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Telepon :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('admin')->user()->phone }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Email :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">{{ Auth::guard('admin')->user()->email }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-3 col-form-label">Login terakhir :</label>
                            <div class="col-lg-6">
                                <p class="form-control-static my-2">
                                    {{ DateHelper::getHoursMinute(Auth::guard('admin')->user()->last_login) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img src="{{ Auth::guard('admin')->user()->file == 'user.png' ? 'https://via.placeholder.com/150' : UploadHelper::show_image(Auth::guard('admin')->user()->file) }}" class="w-100" alt="">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
