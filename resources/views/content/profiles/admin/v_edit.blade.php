@extends('content.profiles.admin.v_main')
@section('content_profile')
    <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('profile.update') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('response'))
                        <div class="alert alert-{{ Session::get('response')['class'] }} alert-dismissible fade show   m-alert m-alert--air mx-3"
                            role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            {{ Session::get('response')['message'] }}
                        </div>
                    @endif

                </div>
                <div class="col-md-12">
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Nama</label>
                        <div class="col-7">
                            <input class="form-control m-input" type="text" name="name"
                                value="{{ Auth::guard('admin')->user()->name }}">
                                <input type="hidden" name="id" value="{{ Auth::guard('admin')->user()->id }}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Telepon</label>
                        <div class="col-7">
                            <input class="form-control m-input" type="text" name="phone"
                                value="{{ Auth::guard('admin')->user()->phone }}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Email</label>
                        <div class="col-7">
                            <input class="form-control m-input" type="email" name="email"
                                value="{{ Auth::guard('admin')->user()->email }}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Gambar Profil</label>
                        <div class="col-7">
                            <input type="file" name="file" id="file" class="form-control-file"
                                onchange="readURL(this);">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label"></label>
                        <div class="col-3">
                            <img id="modal-preview" src="{{ Auth::guard('admin')->user()->file == 'user.png' ? 'https://via.placeholder.com/150' : UploadHelper::show_image(Auth::guard('admin')->user()->file) }}" alt="Preview" class="w-100">
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-7">
                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save
                            changes</button>&nbsp;&nbsp;
                        <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            function readURL(input, id) {
                id = id || '#modal-preview';
                if (input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $(id).attr('src', e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
    @endpush
@endsection
