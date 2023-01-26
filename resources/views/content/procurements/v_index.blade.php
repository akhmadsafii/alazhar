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
                                    $title = 'Pengajuan Pengadaan';
                                    break;
                                case 'approved':
                                    $title = 'Pengadaan Diterima';
                                    break;
                                case 'rejected':
                                    $title = 'Pengadaan Ditolak';
                                    break;
                                default:
                                    $title = 'Semua Pengadaan';
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
                            <a class="dropdown-item" href="{{ route('procurement.home', ['status' => 'submission']) }}"><i
                                    class="la la-plus"></i> Pengajuan Pengadaan</a>
                            <a class="dropdown-item" href="{{ route('procurement.home', ['status' => 'approved']) }}"><i
                                    class="la la-check-circle"></i> Pengadaan Diterima</a>
                            <a class="dropdown-item" href="{{ route('procurement.home', ['status' => 'rejected']) }}"><i
                                    class="la la-close"></i> Pengadaan Ditolak</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                                href="{{ route('procurement.home', ['status' => 'all-procurement']) }}"><i
                                    class="la la-copy"></i> Semua Pengadaan</a>
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
                            <button class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air my-2" type="button">
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
                                    <th>Prioritas / Status</th>
                                    <th>Nama</th>
                                    <th>Barang</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Total</th>
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
                            <input type="hidden" name="id" id="id_procurement">
                            <div class="form-group">
                                <label>Nama Pengusul</label>
                                <select name="id_user" id="id_user" class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true" required>
                                    <option></option>
                                    @foreach ($user as $us)
                                        <option value="{{ $us['id'] }}">{{ $us['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Pengadaan</label>
                                <input type="text" name="name" id="name" required class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Barang</label>
                                <select name="id_stuff" id="id_stuff" required class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true">
                                    <option value="">-- Pilih Barang --</option>
                                    @foreach ($stuff as $stf)
                                        <option value="{{ $stf['id'] }}">{{ $stf['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Prioritas</label>
                                <select name="priority" required id="priority" class="form-control">
                                    <option value="">-- Level Prioritas --</option>
                                    <option value="normal">Normal</option>
                                    <option value="urgent">Mendesak</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Barang</label>
                                        <input type="text" required class="form-control" onkeypress="return onlyNumber(event)"
                                            name="amount" id="amount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga Satuan</label>
                                        <input type="text" required class="form-control ribuan" name="unit_price" id="unit_price">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Pengadaan</label>
                                <input type="text" readonly name="date_of_filing" id="date_of_filing"
                                    value="{{ date('Y/m/d', strtotime(now())) }}" class="form-control m_datetimepicker_6">
                            </div>
                            <div class="form-group">
                                <label>Keterangan</label>
                                <textarea name="description" id="description" rows="3" class="form-control"></textarea>
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
        <div class="modal fade" id="modalDetail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Informasi Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="display-detail"></div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
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
                            data: 'priority',
                            name: 'priority',
                            className: 'align-middle text-center'
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'name_stuff',
                            name: 'name_stuff',
                            className: 'align-middle'
                        },
                        {
                            data: 'date_of_filing',
                            name: 'date_of_filing',
                            className: 'align-middle'
                        },

                        {
                            data: 'total_price',
                            name: 'total_price',
                            className: 'align-middle text-right'
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
                    // console.log(this.value);
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
                $('#id_procurement').val("");
                $(".m_selectpicker").val('default').selectpicker("refresh");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
            }

            function detailData(id) {
                $.ajax({
                    url: "{{ route('procurement.detail') }}",
                    data: {
                        id
                    },
                    success: function(procurement) {
                        let detail = `<div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label>Nama Pengusul :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.users.name}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Barang :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.stuffs.name}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Harga Per Unit:</label>
                                        <p class="form-control-static font-weight-bold">${procurement.format_unit_price}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Harga Total:</label>
                                        <p class="form-control-static font-weight-bold">${procurement.format_total_price}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Keterangan :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.description}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Kode Item :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.code_handle}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group m-form__group">
                                        <label>Nama Pengadaan :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.name}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Prioritas :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.priority}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Jumlah Barang :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.amount}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Tanggal Pengajuan :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.format_date_of_filing}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Target Tanggal Diterima :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.format_date_received}</p>
                                    </div>
                                    <div class="form-group m-form__group">
                                        <label>Status :</label>
                                        <p class="form-control-static font-weight-bold">${procurement.code_status}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        if (procurement.status == 2) {
                            detail += `<div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">kembali</button>
                            <div class="btnAction">
                                <a href="javascript:void(0)" class="btn btn-danger" onclick="updateStatus(${procurement.id}, 3, this)">Tolak</a>
                                <button type="submit" class="btn btn-success"  onclick="updateStatus(${procurement.id}, 1, this)">Terima</button>
                            </div>
                        </div>`;
                        }
                        $('#display-detail').html(detail);
                        $('#modalDetail').modal('show');
                    }
                });
            }


            function editData(id) {
                $.ajax({
                    url: "{{ route('procurement.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('.modal-title').html("Edit {{ session('title') }}");
                        $('#id_procurement').val(data.id);
                        $('#code').val(data.code);
                        $('#name').val(data.name);
                        $('#priority').val(data.priority);
                        $('#amount').val(data.amount);
                        $('#unit_price').val(rubahRibuan(data.unit_price));
                        $('#id_stuff').val(data.id_stuff).trigger('change');
                        $('#id_user').val(data.id_user).trigger('change');
                        $('#date_received').val(data.date_received);
                        $('#description').val(data.description);
                        $('#modalForm').modal('show');
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('procurement.delete') }}",
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

            function updateStatus(id, status, evt) {
                $(evt).addClass('m-loader m-loader--light m-loader--right');
                $(evt).attr("disabled", true);
                $.ajax({
                    url: "{{ route('procurement.update_status') }}",
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
        </script>
    @endpush
@endsection
