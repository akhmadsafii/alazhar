@extends('layout.main')
@section('content')
    <div class="m-content">
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
            <form id="formSubmit">
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label for="exampleInputEmail1">Nama Sekolah</label>
                                        <input type="hidden" name="id" value="{{ $school ? $school['id'] : '' }}">
                                        <input type="text" name="name" class="form-control m-input" id="name"
                                            value="{{ $school ? $school['name'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label for="exampleInputEmail1">NPSN</label>
                                        <input type="text" name="npsn" class="form-control m-input" id="npsn"
                                            value="{{ $school ? $school['npsn'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group m-form__group">
                                        <label for="exampleInputEmail1">Telepon</label>
                                        <input type="text" name="phone" class="form-control m-input" id="phone"
                                            value="{{ $school ? $school['phone'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group m-form__group">
                                        <label for="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" class="form-control m-input" id="email"
                                            value="{{ $school ? $school['email'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group m-form__group">
                                        <label for="exampleInputEmail1">Website</label>
                                        <input type="text" name="website" class="form-control m-input" id="website"
                                            value="{{ $school ? $school['website'] : '' }}">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">Alamat</label>
                                                <textarea name="address" id="address" rows="3" class="form-control">{{ $school ? $school['address'] : '' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">Logo</label>
                                                <input type="file" name="file" id="file"
                                                    class="form-control-file" onchange="readURL(this);">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group m-form__group">
                                                <label for="exampleInputEmail1">Footer</label>
                                                <input type="text" name="footer" id="footer"
                                                    value="{{ $school ? $school['footer'] : '' }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img id="modal-preview"
                                        src="{{ $school && $school['file'] != null ? UploadHelper::show_image($school['file']) : 'https://via.placeholder.com/150' }}"
                                        alt="Preview" height="150">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions p-4 d-flex justify-content-end">
                        <button type="submit" id="btnSubmit" class="btn btn-primary mx-3">Update</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        {{-- @include('package.datetimepicker.datetimepicker_js') --}}
        {{-- <script src="{{ asset('asset/plugins/onlyNumber.js') }}"></script> --}}
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('body').on('submit', '#formSubmit', function(e) {
                    e.preventDefault();
                    $('#btnSubmit').addClass('m-loader m-loader--light m-loader--right');
                    $('#btnSubmit').attr("disabled", true);
                    var formData = new FormData(this);
                    $.ajax({
                        type: "POST",
                        url: '',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: (data) => {
                            toastr.success(data.message, "Berhasil");
                            window.location.reload();
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "GAGAL");
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $('#btnSubmit').attr("disabled", false);
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
