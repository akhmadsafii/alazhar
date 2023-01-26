@extends('layout.main')
@section('content')
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">Akun</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">User</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">{{ session('title') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="row d-flex justify-content-center">
            <div class="col-md-8">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    {{ session('title') }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <form class="m-form m-form--fit m-form--label-align-right" id="formSubmit">
                        <div class="m-portlet__body">
                            <input type="hidden" name="id" value="{{ $_GET['action'] == 'edit' ? $user['id'] : '' }}">
                            <div class="form-group m-form__group">
                                <label>Email</label>
                                <input type="email" class="form-control m-input m-input--square" name="email"
                                    id="email" value="{{ $_GET['action'] == 'edit' ? $user['email'] : '' }}">
                            </div>
                            <div class="form-group m-form__group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control m-input m-input--square" name="password"
                                    id="password" placeholder="Password">
                                <span class="m-form__help {{ $_GET['action'] == 'create' ? 'd-none' : '' }}">Harap kosongi,
                                    jika tidak ingin
                                    mengubah passwords.</span>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Nama</label>
                                <input type="text" class="form-control m-input m-input--square" name="name"
                                    id="name" value="{{ $_GET['action'] == 'edit' ? $user['name'] : '' }}">
                            </div>
                            <div class="form-group m-form__group">
                                <label>Telepon</label>
                                <input type="text" class="form-control m-input m-input--square" name="phone"
                                    id="phone" value="{{ $_GET['action'] == 'edit' ? $user['phone'] : '' }}">
                            </div>
                            <div class="form-group m-form__group">
                                <label>Posisi</label>
                                <select name="position" id="position" class="form-control m-input m-input--square">
                                    <option value="" selected disabled>-- Pilih Posisi --</option>
                                    <option value="student" {{ $_GET['action'] == 'edit' && $user['position'] == 'student' ? 'selected' : '' }}>Siswa</option>
                                    <option value="teacher" {{ $_GET['action'] == 'edit' && $user['position'] == 'teacher' ? 'selected' : '' }}>Guru</option>
                                    <option value="staff" {{ $_GET['action'] == 'edit' && $user['position'] == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="other" {{ $_GET['action'] == 'edit' && $user['position'] == 'other' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Jenis Kelamin</label>
                                <div class="m-radio-inline">
                                    <label class="m-radio">
                                        <input type="radio" name="gender" value="male"
                                            {{ $_GET['action'] == 'edit' && $user['gender'] == 'male' ? 'checked' : '' }}>
                                        Laki - laki
                                        <span></span>
                                    </label>
                                    <label class="m-radio">
                                        <input type="radio" name="gender" value="female"
                                            {{ $_GET['action'] == 'edit' && $user['gender'] == 'female' ? 'checked' : '' }}>
                                        Perempuan
                                        <span></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" class="form-control m-input m-input--square"
                                            name="place_of_birth" id="place_of_birth">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" class="form-control m-input m-input--square"
                                            name="date_of_birth" id="date_of_birth">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group">
                                <label>Agama</label>
                                <select name="religion" id="religion" class="form-control">
                                    <option value="" selected disabled>-- Pilih Agama --</option>
                                    <option value="islam">Islam</option>
                                    <option value="protestan">Protestan</option>
                                    <option value="katholik">Katholik</option>
                                    <option value="hindu">Hindu</option>
                                    <option value="buddha">Buddha</option>
                                    <option value="khonghucu">Khonghucu</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group m-form__group">
                                        <label>Alamat</label>
                                        <textarea name="address" id="address" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Gambar</label>
                                        <input type="file" name="file" class="form-control-file"
                                            onchange="readURL(this);">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group m-form__group">
                                        <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview"
                                            class="w-100">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions">
                                <button type="submit" id="btnSubmit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('user.home') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#formSubmit').on('submit', function(event) {
                    event.preventDefault();
                    $("#btnSubmit").addClass('m-loader m-loader--light m-loader--right');
                    $("#btnSubmit").attr("disabled", true);
                    let formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('user.store') }}",
                        method: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            window.location.href = "{{ route('user.home') }}";
                            toastr.success(data.message, "Berhasil");
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "Gagal");
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $("#btnSubmit").attr("disabled", false);
                        }
                    });
                });
            });

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
