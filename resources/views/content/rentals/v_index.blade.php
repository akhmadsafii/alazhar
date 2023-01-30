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
                                    $title = 'Pengajuan Peminjaman';
                                    break;
                                case 'approved':
                                    $title = 'Peminjaman Diterima';
                                    break;
                                case 'rejected':
                                    $title = 'Peminjaman Ditolak';
                                    break;
                                case 'finished':
                                    $title = 'Peminjaman Selesai';
                                    break;
                                default:
                                    $title = 'Semua Peminjaman';
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
                            <a class="dropdown-item" href="{{ route('rental.home', ['status' => 'submission']) }}"><i
                                    class="la la-plus"></i> Pengajuan Peminjaman</a>
                            <a class="dropdown-item" href="{{ route('rental.home', ['status' => 'approved']) }}"><i
                                    class="la la-check-circle"></i> Peminjaman Diterima</a>
                            <a class="dropdown-item" href="{{ route('rental.home', ['status' => 'rejected']) }}"><i
                                    class="la la-close"></i> Peminjaman Ditolak</a>
                            <a class="dropdown-item" href="{{ route('rental.home', ['status' => 'finished']) }}"><i
                                    class="la la-align-justify"></i> Peminjaman Selesai</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('rental.home', ['status' => 'all-rentals']) }}"><i
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
                        </div>
                        <select name="" id="group-status" class="form-control my-2">
                            <option value="" selected disabled>-- Filter berdasarkan jenis --</option>
                            <option value="sarana">Sarana</option>
                            <option value="prasarana">Prasarana</option>
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
                                    <th>Barang</th>
                                    <th>Kode</th>
                                    <th>Peminjam</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Keterangan</th>
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
                            <div class="form-group">
                                <label>Peminjam</label>
                                <select name="id_user" id="id_user" required
                                    class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                    <option></option>
                                    @foreach ($user as $us)
                                        <option value="{{ $us['id'] }}">{{ $us['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barang</label>
                                        <select name="id_stuff" id="id_stuff" class="form-control">
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
                                        <select name="id_location" id="id_location" class="form-control">
                                            <option value="" selected disabled>-- Pilih Lokasi --</option>
                                            @foreach ($location as $loc)
                                                <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="table-responsive"> --}}
                            <table class="table table-hover datatable-item">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="m-checkbox-list">
                                                <label class="m-checkbox mb-0">
                                                    <input type="checkbox" id="select-all" class="check_items">&nbsp;
                                                    <span></span>
                                                </label>
                                            </div>
                                        </th>
                                        <th>Item</th>
                                        <th>Lokasi</th>
                                        <th>Kondisi</th>
                                    </tr>
                                </thead>
                            </table>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Sewa</label>
                                        <input type="text" class="form-control m_datetimepicker_3" id="rental_date"
                                            name="rental_date" value="{{ now() }}" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Kembali</label>
                                        <input type="text" class="form-control m_datetimepicker_3" id="return_date"
                                            name="return_date" value="{{ now() }}" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1">Diterima</option>
                                    <option value="3">Ditolak</option>
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

        <div class="modal fade" id="modalEditForm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formEditSubmit">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_rental">
                            <div class="form-group">
                                <label>Peminjam</label>
                                <select name="id_user" id="e_id_user" class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true">
                                    <option></option>
                                    @foreach ($user as $us)
                                        <option value="{{ $us['id'] }}">{{ $us['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barang</label>
                                        <select name="id_stuff" id="e_id_stuff"
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
                                        <label>Item</label>
                                        <select name="id_item" id="e_id_item"
                                            class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                            <option value="" selected disabled>-- Pilih Item --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Sewa</label>
                                        <input type="text" class="form-control m_datetimepicker_3" id="e_rental_date"
                                            name="rental_date" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Kembali</label>
                                        <input type="text" class="form-control m_datetimepicker_3" id="e_return_date"
                                            name="return_date" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="description" id="e_description" rows="3" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="e_status" class="form-control">
                                    <option value="1">Diterima</option>
                                    <option value="3">Ditolak</option>
                                </select>
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
                        <div class="row" id="content-confirm"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalConfirm" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <div class="form-group m-form__group text-center">
                                    <input type="hidden" name="id" id="c_id_rental">
                                    <label for="exampleInputEmail1">Tanggal Pengembalian</label>
                                    <div class="input-group date">
                                        <input type="text" name="returned_date" id="returned_date"
                                            class="form-control m-input m_datetimepicker_3" readonly
                                            value="{{ now() }}" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i
                                                    class="la la-calendar-check-o glyphicon-th"></i></span>
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
        </div>
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
        @include('package.datetimepicker.datetimepicker_js')
        @include('component.formSubmit')
        <script>
            var table;
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#id_stuff').change(function() {
                    reloadDatatableItem($(this).val(), $('#id_location').val());
                });


                $('#id_location').change(function() {
                    reloadDatatableItem($('#id_stuff').val(), $(this).val());
                });


                var table = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "",
                        data: function(d) {
                            d.group = $('#group-status').val()
                        }
                    },
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
                            data: 'name_stuff',
                            name: 'name_stuff',
                        },
                        {
                            data: 'name_item',
                            name: 'name_item',
                            className: 'align-middle'
                        },
                        {
                            data: 'name_user',
                            name: 'name_user',
                            className: 'align-middle'
                        },
                        {
                            data: 'rental_date',
                            name: 'rental_date',
                            className: 'align-middle'
                        },
                        {
                            data: 'return_date',
                            name: 'return_date',
                            className: 'align-middle'
                        },
                        {
                            data: 'description',
                            name: 'description',
                            className: 'align-middle'
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

                $("#select-all").click(function(e) {
                    var table = $(e.target).closest('table');
                    $('td input:checkbox', table).prop('checked', this.checked);
                });

                $('#group-status').on('change', function() {
                    table.draw();
                });

                $('#e_id_stuff').on('change', function(e) {
                    let id_stuff = this.value;
                    if (id_stuff) {
                        $.ajax({
                            url: "{{ route('item.by_stuff') }}",
                            data: {
                                id_stuff
                            },
                            success: function(item) {
                                if (!$.trim(item)) {
                                    $('#e_id_item').html(
                                        '<option value="">--- No Item Found ---</option>');
                                } else {
                                    var s = '';
                                    item.forEach(function(it) {
                                        s += '<option value="' + it.id + '">' + it
                                            .name +
                                            '</option>';

                                    })
                                    $('#e_id_item').removeAttr('disabled');
                                }


                                $('#e_id_item').html(s).selectpicker('refresh');
                            }
                        });
                    }
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
                    } else {
                        alert('anda belum memilih item yang akan dipinjam');
                    }
                });
            });


            formSubmit('#formEditSubmit', '#btnUpdate', '{{ route('rental.update') }}', '#modalEditForm');
            formSubmit('#formConfirm', '#btnConfirm', '{{ route('rental.confirm-returned_date') }}', '#modalConfirm');

            function addData() {
                $('#id_type').val("");
                $(".m_selectpicker").val('default').selectpicker("refresh");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
                $('#display-item').addClass('d-none');
                reloadDatatableItem();
            }

            function detailData(id) {
                $.ajax({
                    url: "{{ route('rental.detail_complete') }}",
                    data: {
                        id
                    },
                    success: function(rental) {
                        $('.modal-title').html("Informasi {{ session('title') }}");
                        let information =
                            `<div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Peminjam :</label>
                                    <p class="form-control-static">${rental.users.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Nama Barang :</label>
                                    <p class="form-control-static">${rental.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Tanggal Sewa :</label>
                                    <p class="form-control-static">${rental.e_rental_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Tanggal Kembali :</label>
                                    <p class="form-control-static">${rental.e_return_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Status Peminjaman :</label>
                                    <p class="form-control-static">${rental.status_rental}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Tanggal Dikembalikan :</label>
                                    <p class="form-control-static">${rental.e_returned_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group m-form__group">
                                    <label>Keterangan :</label>
                                    <p class="form-control-static">${rental.description}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>`;
                        if (rental.status == 2) {
                            information += ` <div class="action">
                                        <button type="button" onclick="changeStatus(${rental.id}, 3)"
                                            class="btn btn-danger">Tolak</button>

                                        <button type="button" onclick="changeStatus(${rental.id}, 1)"
                                            class="btn btn-success">Terima</button>
                                    </div>`;
                        }
                        information += `</div></div>`;
                        $('#content-confirm').html(information);
                        $('#modalDetail').modal('show');
                    }
                });
            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('rental.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('.modal-title').html("Edit {{ session('title') }}");
                        $('#id_rental').val(data.id);
                        $('#e_rental_date').val(data.rental_date);
                        $('#e_return_date').val(data.return_date);
                        $('#e_description').val(data.description);
                        $('#e_status').val(data.status);
                        $('#e_id_stuff').val(data.id_stuff).selectpicker('refresh');
                        $('#e_id_user').val(data.id_user).selectpicker('refresh');
                        reloadItem(data.id_stuff, data.id_item);
                        $('#modalEditForm').modal('show');
                    }
                });
            }

            function changeStatus(id, status) {
                if (confirm("Apa kamu yakin mengupdate status peminjaman?") == true) {
                    $.ajax({
                        url: "{{ route('rental.update_status') }}",
                        data: {
                            id,
                            status
                        },
                        success: function(res) {
                            $('.datatable').dataTable().fnDraw(false);
                            toastr.success(res.message, "Success");
                            $('#modalDetail').modal('hide');
                        },
                        error: function(data) {
                            const res = data.responseJSON;
                            toastr.error(res.message, "GAGAL");
                        }
                    })
                }
            }

            function confirmBack(id) {
                $('#c_id_rental').val(id);
                $('#modalConfirm').modal('show');
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('rental.delete') }}",
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

            // function loadItem(id_stuff, id_location) {

            //     var notempty = id_stuff && id_location;
            //     if (notempty) {
            //         $('#display-item').removeClass('d-none');
            //         $.ajax({
            //             url: "{{ route('item.location_item') }}",
            //             data: {
            //                 id_stuff,
            //                 id_location
            //             },
            //             success: function(data) {
            //                 let script_item = '';
            //                 if (data.length > 0) {
            //                     data.forEach(function(item) {
            //                         script_item += `<div class="col-md-4">
    //                                     <div class="m-checkbox-list">
    //                                         <label class="m-checkbox m-checkbox--success">
    //                                             <input type="checkbox" name="item[` + item.id + `]"> ` + item
            //                             .name + `
    //                                             <span></span>
    //                                         </label>
    //                                     </div>
    //                                 </div>`;
            //                     });
            //                 } else {
            //                     script_item += `<div class="col-md-12">
    //                                     <h5 class="text-center text-danger">Data Item saat ini tidak tersedia</h5>
    //                                 </div>`;
            //                 }
            //                 $('#list-item').html(script_item);
            //             },
            //             error: function(data) {
            //                 const res = data.responseJSON;
            //                 toastr.error(res.message, "GAGAL");
            //             }
            //         })
            //     }
            // }

            function reloadDatatableItem(id_stuff = null, id_location = null) {
                console.log(id_stuff, id_location);
                var table = $('.datatable-item').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    bDestroy: true,
                    bFilter: false,
                    bInfo: false,
                    lengthChange: false,
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
                            data: 'code',
                            name: 'code',
                            className: 'text-capitalize align-middle'
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
        </script>
    @endpush
@endsection
