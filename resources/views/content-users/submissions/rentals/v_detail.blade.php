@extends('content-users.submissions.v_main')
@section('content_submission')
    @push('styles')
        @include('package.datatable.datatable_css')
    @endpush
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
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table table-striped- table-bordered table-hover table-checkable datatable">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox">
                                                <input type="checkbox" id="check-all">&nbsp;
                                                <span></span>
                                            </label>
                                        </div>
                                    </th>
                                    <th>Nama Item</th>
                                    <th>Kondisi</th>
                                    <th>Lokasi</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                        <button type="button" id="btn-rental" class="btn btn-brand float-right">Pinjam</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('modals')
        <div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formSubmit">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Pinjam</label>
                                        <div class="input-group date">
                                            <input type="text" name="rental_date" id="rental_date"
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
                                        <label>Tanggal Kembali</label>
                                        <div class="input-group date">
                                            <input type="text" name="return_date" id="return_date"
                                                class="form-control m-input m_datetimepicker_3" readonly
                                                value="{{ now() }}" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i
                                                        class="la la-calendar-check-o glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                            </div>
                            <input type="hidden" name="id_stuff" value="{{ $stuff['id'] }}" id="id_stuff">

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endpush

    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.datetimepicker.datetimepicker_js')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    paging: false,
                    length: false,
                    ordering: false,
                    info: false,
                    ajax: "",
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,
                            className: 'align-middle'
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'condition',
                            name: 'condition',
                            className: 'text-center align-middle'
                        },
                        {
                            data: 'location',
                            name: 'location',
                            className: 'align-middle'
                        },
                    ]
                });

                $("#check-all").click(function(e) {
                    let table = $(e.target).closest('table');
                    $('td input:checkbox', table).prop('checked', this.checked);
                });
                var id_items;
                $("#btn-rental").click(function(e) {
                    // console.log('btn rental');
                    id_items = [];
                    $("input:checkbox[class=check_items]:checked").each(function() {
                        id_items.push($(this).val());
                    });
                    console.log(id_items);
                    if (id_items) {
                        $('#modal-title').html("Tambah {{ session('title') }}");
                        $('#modalForm').modal('show');
                    }
                });

                $('#formSubmit').on('submit', function(event) {
                    event.preventDefault();
                    $("#btnSubmit").addClass('m-loader m-loader--light m-loader--right');
                    $("#btnSubmit").attr("disabled", true);
                    var formData = $(this).serializeArray();
                    formData.push({
                        name: "id_item",
                        value: id_items
                    });
                    console.log(formData);
                    $.ajax({
                        url: "{{ route('user.submission.rental.save_user') }}",
                        method: "POST",
                        data: formData,
                        dataType: "json",
                        success: function(data) {
                            $('#formSubmit').trigger("reset");
                            $('#modalForm').modal('hide');
                            $('.datatable').dataTable().fnDraw(false);
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $("#btnSubmit").attr("disabled", false);
                            toastr.success(data.message, "Berhasil");
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "GAGAL");
                            console.log(data);
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $("#btnSubmit").attr("disabled", false);
                        }
                    });
                });

            })
        </script>
    @endpush
@endsection
