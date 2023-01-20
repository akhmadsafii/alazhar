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
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="#" class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air">
                                <span>
                                    <i class="la la-file-text-o"></i>
                                    <span>Import</span>
                                </span>
                            </a>
                        </li>
                        <li class="m-portlet__nav-item"></li>
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
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Pengaju</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
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
                            <input type="hidden" name="id" id="id_consumable">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Nama Pengaju</label>
                                    <select name="id_user" id="id_user" class="form-control m-bootstrap-select m_selectpicker"
                                        data-live-search="true">
                                        <option value="">-- Pilih User --</option>
                                        @foreach ($user as $us)
                                            <option value="{{ $us['id'] }}">{{ $us['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label>Nama Barang</label>
                                <select name="id_stuff" id="id_stuff" class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true" onchange="getStuff(this)">
                                    <option value="" selected disabled>-- Pilih Barang --</option>
                                    @foreach ($stuff as $st)
                                        <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Barang</label>
                                <input type="text" class="form-control m-input number" id="amount"
                                    onkeypress="return onlyNumber(event)" name="amount">
                                <small class="text-danger notice-stock">Maksimal Stock adalah 50</small>
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="text" class="form-control m-input m_datetimepicker_3"
                                    value="{{ now() }}" id="request_date" name="request_date" readonly>
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
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Informasi Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="display-detail">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Nama Barang:</label>
                                        <p class="form-control-static">email@example.com</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Jumlah Barang:</label>
                                        <p class="form-control-static">email@example.com</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Tanggal:</label>
                                        <p class="form-control-static">email@example.com</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Nama Pengaju:</label>
                                        <p class="form-control-static">email@example.com</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">kembali</button>
                            <div class="btnAction">
                                <button type="button" class="btn btn-danger">Tolak</button>
                                <button type="submit" class="btn btn-success">Terima</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
        @include('package.datetimepicker.datetimepicker_js')
        <script src="{{ asset('asset/plugins/onlyNumber.js') }}"></script>
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
                            data: 'request_date',
                            name: 'request_date',
                        },
                        {
                            data: 'stuffs.name',
                            name: 'stuffs.name',
                        },
                        {
                            data: 'users.name',
                            name: 'users.name',
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                        },
                        {
                            data: 'status',
                            name: 'status',
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
                $('#id_consumable').val("");
                $(".m_selectpicker").val('default').selectpicker("refresh");
                $('.notice-stock').html('');
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
            }

            // function editData(id) {
            //     $.ajax({
            //         url: "{{ route('consumable.detail') }}",
            //         data: {
            //             id
            //         },
            //         success: function(data) {
            //             $('#modal-title').html("Edit {{ session('title') }}");
            //             $('#id_consumable').val(data.id);
            //             $('#id_user').val(data.id_user).selectpicker('refresh').trigger('change');
            //             $('#id_stuff').val(data.id_stuff).selectpicker('refresh').trigger('change');
            //             $('#amount').val(data.amount);
            //             $('#request_date').val(data.request_date);
            //             $('#modalForm').modal('show');
            //         }
            //     });
            // }

            function detailData(id) {
                $.ajax({
                    url: "{{ route('consumable.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        let detail = `<div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Nama Barang:</label>
                                        <p class="form-control-static">${data.stuffs.name}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Jumlah Barang:</label>
                                        <p class="form-control-static">${data.amount}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Tanggal:</label>
                                        <p class="form-control-static">${data.date}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group">
                                        <label>Nama Pengaju:</label>
                                        <p class="form-control-static">${data.users.name}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        if (data.status == 2) {
                            detail += `<div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">kembali</button>
                            <div class="btnAction">
                                <a href="javascript:void(0)" class="btn btn-danger" onclick="updateStatus(${data.id}, 3, this)">Tolak</a>
                                <button type="submit" class="btn btn-success"  onclick="updateStatus(${data.id}, 1, this)">Terima</button>
                            </div>
                        </div>`;
                        }
                        $('#display-detail').html(detail);
                        $('#modalDetail').modal('show');
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('consumable.delete') }}",
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
                    url: "{{ route('consumable.update_status') }}",
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

            function getStuff(stuff) {
                let id = stuff.value;
                $.ajax({
                    url: "{{ route('stuff.detail') }}",
                    data: {
                        id
                    },
                    success: function(stuff) {
                        $('.notice-stock').html('Maksimal stok adalah ' + stuff.amount);
                        $(".number").prop('min', 1);
                        $(".number").prop('max', stuff.amount);
                    }
                });
                return false;
            }
        </script>
    @endpush
@endsection
