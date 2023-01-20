@extends('layout.main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
        {{-- @include('package.select2.select2_css') --}}
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
                <div class="w-100 m-portlet__head-tools d-flex justify-content-between">
                    <a href="#" class="btn btn-secondary m-btn m-btn--icon m-btn--wide m-btn--md m--margin-right-10">
                        <span>
                            <i class="la la-arrow-left"></i>
                            <span>Back</span>
                        </span>
                    </a>
                    <div class="btn-group">
                        @php
                            switch ($_GET['status']) {
                                case 'submission':
                                    $title = 'Pengajuan Pemusnahan';
                                    break;
                                case 'approved':
                                    $title = 'Pemusnahan Diterima';
                                    break;
                                case 'rejected':
                                    $title = 'Pemusnahan Ditolak';
                                    break;
                                default:
                                    $title = 'Semua Pemusnahan';
                                    break;
                            }
                        @endphp
                        <button type="button" class="btn btn-info  m-btn m-btn--icon m-btn--wide m-btn--md">
                            <span>
                                <i class="la la-check"></i>
                                <span>{{ $title }}</span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-info  dropdown-toggle dropdown-toggle-split m-btn m-btn--md"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('exterminate.home', ['status' => 'submission']) }}"><i
                                    class="la la-plus"></i> Pengajuan Peminjaman</a>
                            <a class="dropdown-item" href="{{ route('exterminate.home', ['status' => 'approved']) }}"><i
                                    class="la la-check-circle"></i> Peminjaman Diterima</a>
                            <a class="dropdown-item" href="{{ route('exterminate.home', ['status' => 'rejected']) }}"><i
                                    class="la la-close"></i> Peminjaman Ditolak</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('exterminate.home', ['status' => 'all-rentals']) }}"><i
                                    class="la la-copy"></i> Semua Peminjaman</a>
                        </div>
                    </div>
                </div>
            </div>
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
                            {{-- <button class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air my-2"
                            type="button">
                            <span>
                                <i class="la la-file-text-o"></i>
                            </span></button> --}}
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
                                    <th>Kode</th>
                                    <th>Barang</th>
                                    <th>Tanggal Tindakan</th>
                                    <th>Tindakan</th>
                                    <th>Status</th>
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
        <div class="modal fade" id="modalForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
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
                                        <label>Barang</label>
                                        <select name="id_stuff" id="id_stuff"
                                            class="form-control  m-bootstrap-select m_selectpicker" data-live-search="true">
                                            <option value="" selected disabled>-- Pilih Barang --</option>
                                            @foreach ($stuff as $st)
                                                <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lokasi</label>
                                        <select name="id_location" id="id_location"
                                            class="form-control  m-bootstrap-select m_selectpicker" data-live-search="true">
                                            <option value="" selected disabled>-- Pilih Lokasi --</option>
                                            @foreach ($location as $loc)
                                                <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table
                                        class="table table-striped- table-bordered table-hover table-checkable datatable-item">
                                        <thead>
                                            <tr>
                                                <th width="20">
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" id="select-all">&nbsp;
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>Kode</th>
                                                <th>Barang</th>
                                                <th>Lokasi</th>
                                                <th>Kondisi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Bukti File</label>
                                        <input type="file" name="file" id="file" class="form-control-file"
                                            accept="image/*" onchange="readURL(this);">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview"
                                        class="w-100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Dimusnahkan</label>
                                <div class="input-group date">
                                    <input type="text" name="extermination_date" id="extermination_date"
                                        class="form-control m-input m_datetimepicker_3" readonly
                                        value="{{ now() }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i
                                                class="la la-calendar-check-o glyphicon-th"></i></span>
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

        <div class="modal fade" id="modalEditForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formEditSubmit">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-edit_title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_exterminate">
                            <div class="form-group">
                                <label>Barang</label>
                                <select name="id_stuff" id="e_id_stuff"
                                    class="form-control m-bootstrap-select m_selectpicker" data-live-search="true"
                                    onchange="getItem(this)">
                                    <option selected disabled>-- Pilih Barang --</option>
                                    @foreach ($stuff as $st)
                                        <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Item</label>
                                <select name="id_item" id="e_id_item" class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true">
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <textarea name="description" id="e_description" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>File</label>
                                        <input type="file" name="file" id="e_file" class="form-control-file"
                                            accept="image/*" onchange="readURLS(this);">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <img id="modal-previews" src="https://via.placeholder.com/150" alt="Preview"
                                        class="w-100">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Dimusnahkan</label>
                                <div class="input-group date">
                                    <input type="text" name="extermination_date" id="e_extermination_date"
                                        class="form-control m-input m_datetimepicker_3" readonly
                                        value="{{ now() }}" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i
                                                class="la la-calendar-check-o glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary" id="btnUpdate">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalDetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Informasi Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="content-confirm">
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Barang :</label>
                                    <p class="form-control-static font-weight-bold">${rental.users.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Kode Item :</label>
                                    <p class="form-control-static font-weight-bold">${rental.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Tanggal Pemusnahan :</label>
                                    <p class="form-control-static font-weight-bold">${rental.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Status :</label>
                                    <p class="form-control-static font-weight-bold">${rental.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <img src="" class="w-100" alt="">
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group m-form__group">
                                    <label>Keterangan :</label>
                                    <p class="form-control-static font-weight-bold">${rental.e_return_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                                    <div class="action">
                                        <button type="button" onclick="changeStatus(${rental.id}, 3)"
                                            class="btn btn-danger">Tolak</button>

                                        <button type="button" onclick="changeStatus(${rental.id}, 1)"
                                            class="btn btn-success">Terima</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="modal fade" id="modalConfirm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formConfirm">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <center>
                                <h5>Konfirmasi Barang Kembali</h5>
                                <i class="m-nav__link-icon flaticon-safe-shield-protection fa-5x text-primary"></i>
                                <div class="form-group m-form__group row">
                                    <input type="hidden" name="id" id="c_id_rental">
                                    <label class="col-form-label col-lg-4 col-sm-12">Tanggal Pengembalian</label>
                                    <div class="col-lg-8 col-sm-12">
                                        <div class="input-group date">
                                            <input type="text" name="returned_date" id="returned_date"
                                                class="form-control m-input m_datetimepicker_3" readonly
                                                placeholder="Select date & time" />
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i
                                                        class="la la-calendar-check-o glyphicon-th"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                            <div class="action">
                                <button type="submit" class="btn btn-success" id="btnConfirm">Konfirmasi</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
        @include('package.datetimepicker.datetimepicker_js')
        @include('component.formImageSubmit')
        <script>
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                // $('#id_stuff').change(function() {
                //     loadItem($(this).val(), $('#id_location').val());
                // });


                // $('#id_location').change(function() {
                //     loadItem($('#id_stuff').val(), $(this).val());
                // });


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
                            data: 'items.name',
                            name: 'items.name',
                        },
                        {
                            data: 'stuff',
                            name: 'stuff',
                            className: 'align-middle'
                        },
                        {
                            data: 'extermination_date',
                            name: 'extermination_date',
                            className: 'align-middle'
                        },
                        {
                            data: 'description',
                            name: 'description',
                            className: 'align-middle'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: 'align-middle'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center align-middle'
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

                $("#select-all").click(function(e) {
                    var table = $(e.target).closest('table');
                    $('td input:checkbox', table).prop('checked', this.checked);
                });

                $('#id_stuff').on('change', function(e) {
                    reloadDatatableItem(this.value, $('#id_location').val())
                });

                $('#id_location').on('change', function(e) {
                    reloadDatatableItem($('#id_stuff').val(), this.value)
                });

                $('body').on('submit', '#formSubmit', function(e) {
                    e.preventDefault();
                    let items = [];
                    $(".check_items:checked").each(function() {
                        items.push($(this).val());
                    });
                    if (items.length > 0) {
                        $.ajax({
                            url: '',
                            type: "POST",
                            data: new FormData(this),
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function() {
                                $('#btnSubmit').addClass(
                                    'm-loader m-loader--light m-loader--right');
                                $('#btnSubmit').attr("disabled", true);
                            },
                            success: function(data) {
                                $('#formSubmit').trigger("reset");
                                $('#modalForm').modal('hide');
                                $('.datatable').dataTable().fnDraw(false);
                                $('#btnSubmit').removeClass(
                                    'm-loader m-loader--light m-loader--right');
                                $('#btnSubmit').attr("disabled", false);
                            },
                            error: function(data) {
                                const res = data.responseJSON;
                                toastr.error(res.message, "GAGAL");
                                $('#btnSubmit').removeClass(
                                    'm-loader m-loader--light m-loader--right');
                                $('#btnSubmit').attr("disabled", false);
                            }
                        });
                    }else{
                        alert('anda belum memilih item yang akan dimusnahkan');
                    }
                });

                formImageSubmit('#formEditSubmit', '#btnUpdate', '{{ route('exterminate.update') }}',
                    '#modalEditForm');


            });

            function addData() {
                $('#id_type').val("");
                $(".m_selectpicker").val('default').selectpicker("refresh");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                reloadItem();
                reloadDatatableItem();
                $('#modalForm').modal('show');
            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('exterminate.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('#modal-edit_title').html("Edit {{ session('title') }}");
                        $('#id_exterminate').val(data.id);
                        $('#e_description').val(data.description);
                        $('#e_extermination_date').val(data.extermination_date);
                        $('#e_id_stuff').val(data.id_stuff).selectpicker('refresh');
                        $('#modal-preview').attr('src', data.show_file);
                        reloadItem(data.id_stuff, data.id_item);
                        $('#modalEditForm').modal('show');
                    }
                });
            }


            function reloadDatatableItem(id_stuff = null, id_location = null) {
                console.log(id_stuff, id_location);
                var table = $('.datatable-item').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    dom: "<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>\n\t\t\t<'row'<'col-sm-12'tr>>\n\t\t\t<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>",
                    buttons: [
                        "print",
                        "copyHtml5",
                        "excelHtml5",
                        "csvHtml5",
                        "pdfHtml5",
                    ],
                    bDestroy: true,
                    ajax: {
                        url: "{{ route('item.datatable_location_stuff') }}",
                        data: function(d) {
                            d.id_stuff = id_stuff;
                            d.id_location = id_location;
                        }
                    },
                    columns: [{
                            data: 'checkbox',
                            name: 'checkbox',
                            orderable: false,
                            searchable: false,
                            className: 'align-middle text-center'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'text-capitalize align-middle'
                        },
                        {
                            data: 'stuffs.name',
                            name: 'stuffs.name',
                            className: 'align-middle'
                        },
                        {
                            data: 'location',
                            name: 'location',
                            className: 'align-middle'
                        },
                        {
                            data: 'condition',
                            name: 'condition',
                            className: 'align-middle text-center'
                        },

                    ]
                });
            }

            function detailData(id) {
                // $('#modalDetail').modal('show');
                $.ajax({
                    url: "{{ route('exterminate.detail_complete') }}",
                    data: {
                        id
                    },
                    success: function(exterminate) {
                        $('.modal-title').html("Informasi {{ session('title') }}");
                        let information =
                            `<div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Barang :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Kode Item :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.items.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Tanggal Pemusnahan :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.extermination_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Status :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.code_status}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <img src="${exterminate.show_file}" class="w-100" alt="">
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group m-form__group">
                                    <label>Keterangan :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.description}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>`;
                        if (exterminate.status == 2) {
                            information += ` <div class="action">
                                        <button type="button" onclick="changeStatus(${exterminate.id}, 3, this)"
                                            class="btn btn-danger">Tolak</button>

                                        <button type="button" onclick="changeStatus(${exterminate.id}, 1, this)"
                                            class="btn btn-success">Terima</button>
                                    </div>`;
                        }
                        information += `</div></div>`;
                        $('#content-confirm').html(information);
                        $('#modalDetail').modal('show');
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('exterminate.delete') }}",
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

            function reloadItem(id_stuff, id_item) {
                $.ajax({
                    url: "{{ route('item.load_item_stuff') }}",
                    data: {
                        id_stuff,
                        id_item
                    },
                    beforeSend: function() {
                        $('#e_id_item').html('<option value="">--- No Item Found ---</option>');
                    },
                    success: function(item) {
                        $('#e_id_item').html(item).selectpicker('refresh');
                        $('#e_id_item').removeAttr('disabled');
                    }
                });
                return false;
            }

            function changeStatus(id, status, evt) {
                $(evt).addClass('m-loader m-loader--light m-loader--right');
                $(evt).attr("disabled", true);
                $.ajax({
                    url: "{{ route('exterminate.update_status') }}",
                    data: {
                        id,
                        status
                    },
                    success: function(data) {
                        $('#modalDetail').modal('hide');
                        $('.datatable').dataTable().fnDraw(false);
                        $(evt).removeClass('m-loader m-loader--light m-loader--right');
                        $(evt).attr("disabled", false);
                        toastr.success(data.message, "Berhasil");
                    },
                    error: function(data) {
                        const res = data.responseJSON;
                        toastr.error(res.message, "GAGAL");
                        $(evt).removeClass('m-loader m-loader--light m-loader--right');
                        $(evt).attr("disabled", false);
                    }
                });
            }

            function getItem(stuff) {
                let id_stuff = stuff.value;
                $.ajax({
                    url: "{{ route('item.by_stuff') }}",
                    data: {
                        id_stuff
                    },
                    beforeSend: function() {
                        $('#e_id_item').html('<option value="">--- No Item Found ---</option>');
                    },
                    success: function(items) {
                        let content_item = '';
                        items.forEach(function(item) {
                            content_item += '<option value="' + item.id + '">' + item.name + '</option>';
                        })
                        $('#e_id_item').html(content_item).selectpicker('refresh');
                    }
                });
                return false;

            }

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

            function readURLS(input, id) {
                id = id || '#modal-previews';
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
