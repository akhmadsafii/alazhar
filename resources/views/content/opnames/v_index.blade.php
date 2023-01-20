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
                                    <th>Jumlah Stock Lama</th>
                                    <th>Jumlah Stock Baru</th>
                                    <th>Total Stock</th>
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
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Pilih Barang</label>
                                    <select name="id_stuff" id="id_stuff" onchange="getStuff(this);"
                                        class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($stuffs as $st)
                                            <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Stock Lama</label>
                                <input type="text" name="amount_now" id="amount_now" class="form-control sum_amount"
                                    onkeypress="return onlyNumber(event)">
                            </div>
                            <div class="form-group">
                                <label>Stock Baru</label>
                                <input type="text" name="plus_amount" id="plus_amount" class="form-control sum_amount"
                                    onkeypress="return onlyNumber(event)">
                            </div>
                            <div class="form-group">
                                <label>Jumlah saat ini</label>
                                <input type="text" name="total" id="total" class="form-control"
                                    onkeypress="return onlyNumber(event)">
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control m-input m_datetimepicker_3" readonly
                                        value="{{ now() }}" name="date_opname" id="date_opname" />
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

        <div class="modal fade" id="modalEditForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formEdit">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-edit-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_opname">
                            <div class="form-group">
                                <div class="form-group">
                                    <label>Pilih Barang</label>
                                    <select name="id_stuff" id="e_id_stuff"
                                        class="form-control m-bootstrap-select m_selectpicker" data-live-search="true">
                                        <option value="">-- Pilih Barang --</option>
                                        @foreach ($stuffs as $st)
                                            <option value="{{ $st['id'] }}">{{ $st['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label>Stock Lama</label>
                                <input type="text" name="amount_now" id="e_amount_now" class="form-control edit_amount"
                                    onkeypress="return onlyNumber(event)" readonly>
                            </div>
                            <div class="form-group">
                                <label>Stock Baru</label>
                                <input type="text" name="plus_amount" id="e_plus_amount" class="form-control edit_amount"
                                    onkeypress="return onlyNumber(event)">
                            </div>
                            <div class="form-group">
                                <label>Jumlah saat ini</label>
                                <input type="text" name="total" id="e_total" class="form-control"
                                    onkeypress="return onlyNumber(event)">
                            </div>
                            <div class="form-group">
                                <label>Tanggal</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control m-input m_datetimepicker_3" readonly
                                        value="{{ now() }}" name="date_opname" id="e_date_opname" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i
                                                class="la la-calendar-check-o glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary" id="btnEditSubmit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        </div> --}}
    @endpush
    @push('scripts')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
        @include('package.datetimepicker.datetimepicker_js')
        <script src="{{ asset('asset/plugins/onlyNumber.js') }}"></script>
        @include('component.formSubmit')
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
                            data: 'date_opname',
                            name: 'date_opname',
                        },
                        {
                            data: 'stuffs.name',
                            name: 'stuffs.name',
                        },
                        {
                            data: 'amount_now',
                            name: 'amount_now',
                        },
                        {
                            data: 'plus_amount',
                            name: 'plus_amount',
                        },
                        {
                            data: 'total',
                            name: 'total',
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

                formSubmit('#formSubmit', '#btnSubmit', '', '#modalForm');
                formSubmit('#formEdit', '#btnEditSubmit', '', '#modalEditForm');

                $("#plus_amount").on("keydown keyup", function() {
                    calculateSum();
                });

                $("#e_plus_amount").on("keydown keyup", function() {
                    editCalculateSum();
                });
            });

            function addData() {
                $('#id_opname').val("");
                $(".m_selectpicker").val('default').selectpicker("refresh");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('opname.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('#modal-edit-title').html("Edit {{ session('title') }}");
                        $('#id_opname').val(data.id);
                        $('#e_amount_now').val(data.amount_now);
                        $('#e_plus_amount').val(data.plus_amount);
                        $('#e_total').val(data.total);
                        $('#e_id_stuff').val(data.id_stuff).selectpicker('refresh').trigger('change');
                        $('#e_date_opname').val(data.date_opname);
                        $('#modalEditForm').modal('show');
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
                        $('#amount_now').val(stuff.amount);
                        $('#amount_now').attr('readonly', true);
                        calculateSum();
                    }
                });
                return false;
            }

            function calculateSum() {
                let sum = 0;
                $(".sum_amount").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });

                $("#total").val(sum);
            }

            function editCalculateSum() {
                let sum = 0;
                $(".edit_amount").each(function() {
                    if (!isNaN(this.value) && this.value.length != 0) {
                        sum += parseFloat(this.value);
                    }
                });

                $("#e_total").val(sum);
            }
        </script>
    @endpush
@endsection
