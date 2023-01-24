@extends('layout.main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
    @endpush
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
                            <span class="m-nav__link-text">Barang</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">Data Barang</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">Daftar Barang</span>
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
        <div class="m-portlet">
            <div class="m-subheader">
                <div class="m-form__section m-form__section--first">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="m-portlet__head-text text-center"> {{ strtoupper($stuff['name']) }}</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">Jenis :</label>
                                <div class="col-lg-9">
                                    <p class="col-form-label">{{ $stuff->types->name }}</p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">Kategori :</label>
                                <div class="col-lg-9">
                                    <p class="col-form-label">{{ $stuff->categories->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">Satuan :</label>
                                <div class="col-lg-9">
                                    <p class="col-form-label">{{ $stuff->units->name }}</p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">Tarif :</label>
                                <div class="col-lg-9">
                                    <p class="col-form-label">{{ number_format($stuff->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="m-portlet__head border-0">
                <div class="m-portlet__head-caption">
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <button onclick="addData()" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-plus"></i>
                                    <span>Tambah</span>
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table table-striped- table-bordered table-hover table-checkable datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Lokasi</th>
                                    <th>Kondisi</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
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
                            <input type="hidden" name="id" id="id_item">
                            <input type="hidden" name="id_stuff" id="id_stuff">
                            <div class="form-group">
                                <label>Lokasi</label>
                                <select name="id_location" id="id_location"
                                    class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                    <option value="" selected disabled>-- Pilih Lokasi --</option>
                                    @foreach ($locations as $loc)
                                        <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="form-group" id="display-amount">
                                    <label>Jumlah Barang</label>
                                    <input type="text" name="amount" id="amount" onkeypress="return onlyNumber(event)" class="form-control">
                                </div>
                            </div>
                            <div class="row display-stuff">
                                <div class="col-md-6">
                                    <label>Kondisi Barang</label>
                                    <select class="form-control m-input" id="condition" name="condition">
                                        <option value="" disabled selected>-- Pilih Kondisi --</option>
                                        <option value="broken">Rusak</option>
                                        <option value="good">Bagus</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <input type="text" readonly name="date_received" id="date_received"
                                            class="form-control m_datetimepicker_6">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Sumber Dana</label>
                                <select class="form-control m-input" id="id_source" name="id_source">
                                    <option value="" disabled selected>-- Pilih Sumber Dana --</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source['id'] }}">{{ $source['code'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form class="m-form m-form--fit m-form--label-align-right" id="formSubmit">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title-detail"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group m-form__group row pb-0">
                                    <label class="col-lg-4 col-form-label">Kode:</label>
                                    <div class="col-lg-8">
                                        <p class="alert m-alert mb-0" id="output_code">email@example.com</p>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row py-0">
                                    <label class="col-lg-4 col-form-label">Lokasi:</label>
                                    <div class="col-lg-8">
                                        <p class="alert m-alert mb-0" id="output_location">email@example.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group row pb-0">
                                    <label class="col-lg-4 col-form-label">Kategori:</label>
                                    <div class="col-lg-8">
                                        <p class="alert m-alert mb-0" id="output_category">email@example.com</p>
                                    </div>
                                </div>
                                <div class="form-group m-form__group row py-0">
                                    <label class="col-lg-4 col-form-label">Jenis:</label>
                                    <div class="col-lg-8">
                                        <p class="alert m-alert mb-0" id="output_type">email@example.com</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-striped- table-bordered table-hover table-checkable item-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Penyewa</th>
                                            <th>Role</th>
                                            <th>Tanggal Sewa</th>
                                            <th>Tanggal Kembali</th>
                                            <th>Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
        <script src="{{ asset('asset/plugins/onlyNumber.js') }}"></script>
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
                    ajax: "",
                    dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        "print",
                        "copyHtml5",
                        "excelHtml5",
                        "csvHtml5",
                        "pdfHtml5",
                    ],
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'align-middle'
                        },
                        {
                            data: 'code',
                            name: 'code',
                        },
                        {
                            data: 'location',
                            name: 'location',
                        },
                        {
                            data: 'condition',
                            name: 'condition',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center align-middle'
                        },
                    ]
                });

                $('#formSubmit').on('submit', function(event) {
                    event.preventDefault();
                    $("#btnSubmit").addClass('m-loader m-loader--light m-loader--right');
                    $("#btnSubmit").attr("disabled", true);
                    $.ajax({
                        url: "{{ route('item.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        dataType: "json",
                        success: function(data) {
                            $('#formSubmit').trigger("reset");
                            $('#modalForm').modal('hide');
                            $('.datatable').dataTable().fnDraw(false);
                            $('#btnSubmit').removeClass('m-loader m-loader--light m-loader--right');
                            $("#btnSubmit").attr("disabled", false);
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
            });

            function addData() {
                $('#id_type').val("");
                $('#id_stuff').val("{{ $stuff->id }}");
                $('#formSubmit').trigger("reset");
                $('#display-amount').removeClass('d-none');
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
            }

            function editData(id) {
                // console.log(id);
                $.ajax({
                    url: "{{ route('item.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        console.log(data);
                        $('.modal-title').html("Edit {{ session('title') }}");
                        $('#id_item').val(data.id);
                        $('#id_stuff').val("{{ $stuff->id }}");
                        $('#display-amount').addClass('d-none');
                        $('#id_location').val(data.id_location).selectpicker('refresh').trigger('change');
                        $('#condition').val(data.condition).trigger('change');
                        $('#id_source').val(data.id_source).trigger('change');
                        $('#date_received').val(data.date_received);
                        $('#modalForm').modal('show');
                    }
                });
            }

            function detailData(id) {
                $.ajax({
                    url: "{{ route('item.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('#modal-title-detail').html("Riwayat Peminjaman " + data.stuffs.name + " " + data.code);
                        $('#output_code').html(data.code);
                        $('#output_location').html(data.location);
                        $('#output_category').html(data.stuffs.categories.name);
                        $('#output_type').val(data.stuffs.types.name);
                        $('#modalDetail').modal('show');
                        reload_datatable(id);
                    }
                });
            }

            function reload_datatable(id_item) {
                var table = $('.item-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    bDestroy: true,
                    dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        "print",
                        "copyHtml5",
                        "excelHtml5",
                        "csvHtml5",
                        "pdfHtml5",
                    ],
                    ajax: {
                        url: "{{ route('rental.data_item') }}",
                        data: function(d) {
                            d.id_item = id_item;
                        }
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'users.name',
                        name: 'users.name',
                        className: 'align-middle'
                    }, {
                        data: 'role',
                        name: 'role',
                        className: 'align-middle',
                        defaultContent: '-'
                    }, {
                        data: 'rental_date',
                        name: 'rental_date',
                        className: 'align-middle'
                    }, {
                        data: 'return_date',
                        name: 'return_date',
                        className: 'align-middle'
                    }, {
                        data: 'description',
                        name: 'description',
                        className: 'align-middle'
                    }, {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle'
                    }, ]
                });
            }

            function filterData() {
                $('#formFilter').trigger("reset");
                $('#modalFilter').modal('show');
            }
        </script>
    @endpush
@endsection
