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
                            <span class="m-nav__link-text">Data Master</span>
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
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ session('title') }}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air my-2"
                                onclick="addData()" type="button">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air my-2" type="button"
                                onclick="addImport()">
                                <span>
                                    <i class="la la-file-text-o"></i>
                                </span></button>
                        </div>
                        <select name="" id="group-status" class="form-control my-2">
                            <option value="" selected disabled>-- Filter berdasarkan jenis --</option>
                            <option value="filter sarana">Sarana</option>
                            <option value="filter prasarana">Prasarana</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table table-striped- table-bordered table-hover table-checkable datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Kode</th>
                                    <th>Kondisi</th>
                                    <th>Lokasi</th>
                                    <th></th>
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
                            <div class="row">
                                <div class="col-md-6 display-stuff">
                                    <div class="form-group">
                                        <label>Pilih Barang</label>
                                        <select name="id_stuff" id="id_stuff"
                                            class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                            <option value="" selected disabled>-- Pilih Barang --</option>
                                            @foreach ($stuff as $st)
                                                <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kode Item</label>
                                        <input type="text" class="form-control m-input" id="name" name="name"
                                            placeholder="Kategori Barang">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <select name="id_location" id="id_location"
                                            class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                            <option value="" selected disabled>-- Pilih Lokasi --</option>
                                            @foreach ($location as $loc)
                                                <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kondisi</label>
                                        <select name="condition" id="condition" class="form-control">
                                            <option value="" selected disabled>-- Pilih Kondisi --</option>
                                            <option value="broken">Rusak</option>
                                            <option value="good">Bagus</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 display-stuff">
                                    <div class="form-group">
                                        <label>Jumlah</label>
                                        <input type="text" name="amount" id="amount" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Diterima</label>
                                        <input type="date" name="received_date" id="received_date" class="form-control">
                                    </div>
                                </div>
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
        @include('component.modal_import')
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
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
                            data: 'stuffs.name',
                            name: 'stuffs.name',
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'condition',
                            name: 'condition',
                        },
                        {
                            data: 'location',
                            name: 'location',
                        },
                        {
                            data: 'action',
                            name: 'action',
                        },
                        {
                            data: 'filter',
                            name: 'filter',
                            visible: false,
                        },


                    ]
                });

                $('#group-status').on('change', function() {
                    table.search(this.value).draw();
                });

                $('#formSubmit').on('submit', function(event) {
                    event.preventDefault();
                    $("#btnSubmit").addClass('m-loader m-loader--light m-loader--right');
                    $("#btnSubmit").attr("disabled", true);
                    $.ajax({
                        url: "",
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
                $('.display-stuff').removeClass("d-none");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
            }

            function addImport() {
                $('#title-import').html("Import {{ session('title') }}");
                $('#modal_import').modal('show');
            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('item.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('#modal-title').html("Edit {{ session('title') }}");
                        $('.display-stuff').addClass("d-none");
                        $('#id_item').val(data.id);
                        $('#id_location').val(data.id_location);
                        $('#id_location').selectpicker('refresh')
                        $('#id_location').trigger('change');
                        $('#name').val(data.name);
                        $('#condition').val(data.condition).trigger('change');
                        $('#received_date').val(data.updated_date);
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
                        $('#modal-title-detail').html("Riwayat Peminjaman " + data.stuffs.name + " " + data.name);
                        $('#output_code').html(data.name);
                        $('#output_location').html(data.locations.name);
                        $('#output_category').html(data.stuffs.categories.name);
                        $('#output_type').val(data.stuffs.types.name);
                        $('#modalDetail').modal('show');
                        reload_datatable(id);
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('item.delete') }}",
                        data: {
                            id
                        },
                        success: function(data) {
                            $('.datatable').dataTable().fnDraw(false);
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "GAGAL");
                        }
                    })
                }
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
        </script>
    @endpush
@endsection
