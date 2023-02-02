@extends('content-users.submissions.v_main')
@section('content_submission')
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__head border-0">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ session('title') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-5 col-form-label font-weight-bold">Nama :</label>
                            <div class="col-lg-7">
                                <p class="form-control-static my-2">{{ $stuff['name'] }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-5 col-form-label font-weight-bold">Jenis :</label>
                            <div class="col-lg-7">
                                <p class="form-control-static my-2">{{ $stuff->types->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-5 col-form-label font-weight-bold">Kategori :</label>
                            <div class="col-lg-7">
                                <p class="form-control-static my-2">{{ $stuff->categories->name }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-5 col-form-label font-weight-bold">Jumlah :</label>
                            <div class="col-lg-7">
                                <p class="form-control-static my-2">{{ $stuff['amount'] }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group m-form__group row">
                            <label class="col-lg-5 col-form-label font-weight-bold">Kode :</label>
                            <div class="col-lg-7">
                                <p class="form-control-static my-2">{{ $stuff['code'] }}</p>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                            <label class="col-lg-5 col-form-label font-weight-bold">Tarif :</label>
                            <div class="col-lg-7">
                                <p class="form-control-static my-2">
                                    {{ str_replace(',', '.', number_format($stuff['price'])) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="m-portlet__head border-0">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Form Pengadaan
                        </h3>
                    </div>
                </div>
            </div>
            <form id="formSubmit">
                <div class="m-portlet__body pt-0">
                    <div class="form-group">
                        <label>Judul Pengadaan</label>
                        <input type="text" name="name" required id="name" class="form-control">
                        <input type="hidden" name="id_stuff" id="id_stuff" value="{{ $stuff['id'] }}">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal Pengajuan</label>
                                <div class="input-group date">
                                    <input type="text" name="date_of_filing" id="date_of_filing"
                                        class="form-control m-input m_datetimepicker_3" readonly
                                        value="{{ now() }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i
                                                class="la la-calendar-check-o glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Prioritas</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option value="" selected disabled>Pilih Prioritas</option>
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Mendesak</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" name="amount" id="amount" class="form-control" onkeypress="return onlyNumber(event)">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Harga Satuan</label>
                                <input type="text" name="unit_price" id="unit_price" class="form-control ribuan">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                    </div>
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions p-3">
                        <button type="submit" id="btnSubmit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        @include('package.datetimepicker.datetimepicker_js')
        <script src="{{ asset('asset/plugins/onlyNumber.js') }}"></script>
        <script src="{{ asset('asset/plugins/ribuan.js') }}"></script>
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
                    $.ajax({
                        url: "{{ route('user.submission.procurement.save_user') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(data) {
                            toastr.success(data.message, "Berhasil");
                            $('#formSubmit').trigger("reset");
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $("#btnSubmit").attr("disabled", false);
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "GAGAL");
                            // console.log(data);
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $("#btnSubmit").attr("disabled", false);
                        }
                    });
                });

            })
        </script>
    @endpush
@endsection
