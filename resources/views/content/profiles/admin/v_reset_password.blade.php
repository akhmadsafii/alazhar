@extends('content.profiles.admin.v_main')
@section('content_profile')
    <form class="m-form m-form--fit m-form--label-align-right" id="formSubmit">
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-2 col-form-label">Password Lama</label>
                <div class="col-7">
                    <input class="form-control m-input" type="password" name="password" id="password">
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-2 col-form-label">Password Baru</label>
                <div class="col-7">
                    <input class="form-control m-input" type="password" name="current_password" id="current_password">
                </div>
            </div>
            <div class="form-group m-form__group row">
                <label for="example-text-input" class="col-2 col-form-label">Konfirmasi Password</label>
                <div class="col-7">
                    <input class="form-control m-input" type="password" name="confirm_password" id="confirm_password">
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <div class="row">
                    <div class="col-2">
                    </div>
                    <div class="col-7">
                        <button type="submit" id="btnUpdate" class="btn btn-accent m-btn m-btn--air m-btn--custom">Save
                            changes</button>&nbsp;&nbsp;
                        <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        @include('component.formSubmit')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#formSubmit').on('submit', function(event) {
                    event.preventDefault();
                    $('#btnUpdate').addClass('m-loader m-loader--light m-loader--right');
                    $('#btnUpdate').attr("disabled", true);
                    $.ajax({
                        url: "{{ route('profile.update_password') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(data) {
                            if (data.status == true) {
                                $('#formSubmit').trigger("reset");
                                toastr.success(data.message, "Berhasil");
                            } else {
                                toastr.error(data.message, "Gagal");
                            }
                            $('#btnUpdate').removeClass('m-loader m-loader--light m-loader--right');
                            $('#btnUpdate').attr("disabled", false);
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "GAGAL");
                            $('#btnUpdate').removeClass('m-loader m-loader--light m-loader--right');
                            $('#btnUpdate').attr("disabled", false);
                        }
                    });
                });
            })

            // formSubmit('#formEditSubmit', '#btnUpdate', '{{ route('exterminate.update') }}',
            //     '#modalEditForm');
        </script>
    @endpush
@endsection
