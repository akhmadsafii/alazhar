@extends('content.profiles.user.v_main')
@section('content_profile')
    <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('user.profile.update_user') }}" method="POST"
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
                                value="{{ Auth::guard('user')->user()->name }}">
                            <input type="hidden" name="id" value="{{ Auth::guard('user')->user()->id }}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Telepon</label>
                        <div class="col-7">
                            <input class="form-control m-input" type="text" name="phone"
                                value="{{ Auth::guard('user')->user()->phone }}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Email</label>
                        <div class="col-7">
                            <input class="form-control m-input" type="email" name="email"
                                value="{{ Auth::guard('user')->user()->email }}">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Role</label>
                        <div class="col-7">
                            <select name="role" id="role" class="form-control">
                                <option value="" disabled>-- Pilih Role --</option>
                                <option value="student" {{ Auth::guard('user')->user()->role == 'student' ? 'selected' : '' }}>Murid</option>
                                <option value="teacher" {{ Auth::guard('user')->user()->role == 'teacher' ? 'selected' : '' }}>Guru</option>
                                <option value="staff" {{ Auth::guard('user')->user()->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="other" {{ Auth::guard('user')->user()->role == 'other' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-7">
                            <select name="gender" id="gender" class="form-control">
                                <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                <option value="male" {{ Auth::guard('user')->user()->gender == 'male' ? 'selected' : '' }}>Laki - laki</option>
                                <option value="female" {{ Auth::guard('user')->user()->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Tempat lahir</label>
                        <div class="col-7">
                            <input type="text" name="place_of_birth" id="place_of_birth" value="{{ Auth::guard('user')->user()->place_of_birth }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Tanggal lahir</label>
                        <div class="col-7">
                            <input type="date" name="date_of_birth" id="date_of_birth" value="{{ Auth::guard('user')->user()->date_of_birth }}" class="form-control">
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Agama</label>
                        <div class="col-7">
                            <select name="religion" id="religion" class="form-control">
                                <option value="" disabled>-- Pilih Agama --</option>
                                <option value="islam" {{ Auth::guard('user')->user()->religion == 'islam' ? 'selected' : '' }}>Islam</option>
                                <option value="kristen" {{ Auth::guard('user')->user()->religion == 'kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="hindu" {{ Auth::guard('user')->user()->religion == 'hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="budha" {{ Auth::guard('user')->user()->religion == 'budha' ? 'selected' : '' }}>Budha</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <label for="example-text-input" class="col-2 col-form-label">Alamat</label>
                        <div class="col-7">
                            <textarea name="address" id="address" rows="3" class="form-control">{{ Auth::guard('user')->user()->address }}</textarea>
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
                            <img id="modal-preview"
                                src="{{ Auth::guard('user')->user()->file == 'user.png' ? 'https://via.placeholder.com/150' : UploadHelper::show_image(Auth::guard('user')->user()->file) }}"
                                alt="Preview" class="w-100">
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
