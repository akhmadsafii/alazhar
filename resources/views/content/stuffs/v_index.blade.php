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
                            <button class="btn btn-success m-btn m-btn--custom m-btn--icon m-btn--air my-2"
                                onclick="addImport()" type="button">
                                <span>
                                    <i class="la la-file-text-o"></i>
                                </span></button>
                        </div>
                        <select name="" id="group-status" class="form-control my-2">
                            <option value="" selected disabled>-- Filter berdasarkan jenis --</option>
                            <option value="filter sarana">Sarana</option>
                            <option value="filter prasarana">Prasarana</option>
                        </select>
                        <div class="input-group-prepend">
                            <button class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air my-2"
                                onclick="filterData()" type="button">
                                <i class="fas fa-sort-alpha-down"></i>
                            </button>
                        </div>
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
                                    <th>Jenis Barang</th>
                                    <th>Kategori Barang</th>
                                    <th>Jumlah</th>
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
                            <input type="hidden" name="id" id="id_stuff">
                            <div class="form-group">
                                <label>Nama Barang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control m-input" required id="name" name="name"
                                    placeholder="Nama Barang">
                            </div>
                            <div class="form-group d-none" id="display-source">
                                <label>Sumber Dana <span class="text-danger">*</span></label>
                                <select class="form-control m-input" required id="id_source" name="id_source">
                                    <option value="" disabled selected>-- Pilih Sumber Dana --</option>
                                    @foreach ($sources as $source)
                                        <option value="{{ $source['id'] }}">{{ $source['code'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Barang <span class="text-danger">*</span></label>
                                        <select class="form-control m-input" required id="id_type" name="id_type">
                                            <option value="" disabled selected>-- Pilih Jenis --</option>
                                            @foreach ($type as $typ)
                                                <option value="{{ $typ['id'] }}">{{ $typ['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kategori Barang <span class="text-danger">*</span></label>
                                        <select class="form-control m-input" id="id_category" required disabled
                                            name="id_category">
                                            <option value="" disabled selected>-- Pilih Kategori --</option>
                                        </select>
                                        <span class="m-form__help text-danger d-none" id="caption-text">Harap pilih jenis yang
                                            lain</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Satuan <span class="text-danger">*</span></label>
                                        <select class="form-control m-input" required id="id_unit" name="id_unit">
                                            <option value="" disabled selected>-- Pilih Satuan --</option>
                                            @foreach ($unit as $unt)
                                                <option value="{{ $unt['id'] }}">{{ $unt['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select class="form-control m-input" id="id_supplier" name="id_supplier">
                                            <option value="" disabled selected>-- Pilih Supplier --</option>
                                            @foreach ($supplier as $spl)
                                                <option value="{{ $spl['id'] }}">{{ $spl['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah Barang <span class="text-danger">*</span></label>
                                        <input type="text" name="amount" id="amount"
                                            onkeypress="return onlyNumber(event)" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tarif Barang</label>
                                        <input type="text" name="price" id="price" class="form-control ribuan">
                                    </div>
                                </div>
                            </div>
                            <label class="m-checkbox m-checkbox--bold mb-0 d-none" id="status_bhp">
                                <input type="checkbox" name="bhp" id="bhp"> Tandai sebagai barang habis pakai
                                <span></span>
                            </label>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                            <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formFilter">
                        <div class="modal-header">
                            <h5 class="modal-title">Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Kategori Barang</label>
                                <select class="form-control m-input" id="category_filter" name="category_filter">
                                    <option value="" disabled selected>-- Pilih Kategori --</option>
                                    @foreach ($category as $ct)
                                        <option value="{{ $ct['id'] }}">{{ $ct['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tipe</label>
                                <select class="form-control m-input" id="type_filter" name="type_filter">
                                    <option value="" disabled selected>-- Pilih Tipe --</option>
                                    @foreach ($type as $tp)
                                        <option value="{{ $tp['id'] }}">{{ $tp['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
                                <select class="form-control m-input" id="unit_filter" name="unit_filter">
                                    <option value="" disabled selected>-- Pilih Satuan --</option>
                                    @foreach ($unit as $un)
                                        <option value="{{ $un['id'] }}">{{ $un['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Supplier</label>
                                <select class="form-control m-input" id="supplier_filter" name="supplier_filter">
                                    <option value="" disabled selected>-- Pilih Supplier --</option>
                                    @foreach ($supplier as $sp)
                                        <option value="{{ $sp['id'] }}">{{ $sp['name'] }}</option>
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
                                        <label class="col-lg-4 col-form-label">Jenis:</label>
                                        <div class="col-lg-8">
                                            <p class="alert m-alert mb-0" id="output_type"></p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row py-0">
                                        <label class="col-lg-4 col-form-label">Satuan:</label>
                                        <div class="col-lg-8">
                                            <p class="alert m-alert mb-0" id="output_unit"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group m-form__group row pb-0">
                                        <label class="col-lg-4 col-form-label">Kategori:</label>
                                        <div class="col-lg-8">
                                            <p class="alert m-alert mb-0" id="output_category"></p>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row py-0">
                                        <label class="col-lg-4 col-form-label">Harga:</label>
                                        <div class="col-lg-8">
                                            <p class="alert m-alert mb-0" id="output_price"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-striped- table-bordered table-hover table-checkable item-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tanggal</th>
                                                <th>Pengaju</th>
                                                <th>Jumlah</th>
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
        <script src="{{ asset('asset/plugins/onlyNumber.js') }}"></script>
        <script src="{{ asset('asset/plugins/ribuan.js') }}"></script>
        @include('package.datatable.datatable_js')
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
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'types.name',
                            name: 'types.name',
                        },
                        {
                            data: 'categories.name',
                            name: 'categories.name',
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            className: 'text-center'
                        },
                        {
                            data: 'status_bhp',
                            name: 'status_bhp',
                            className: 'text-center'
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
                    console.log('tes');
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

                $('select[name="id_type"]').on('change', function() {
                    var id = $(this).val();
                    if (id) {
                        $.ajax({
                            url: "{{ route('category.by_type') }}",
                            data: {
                                id
                            },
                            success: function(data) {
                                if (!$.trim(data)) {
                                    $('#id_category').html(
                                        '<option value="">-- Tidak ada kategori --</option>');
                                    $('#caption-text').removeClass('d-none');
                                    $('#id_category').attr('disabled', true);
                                } else {
                                    $('#caption-text').addClass('d-none');
                                    var option =
                                        '<option selected disabled>-- Pilih Kategori --</option>';
                                    data.forEach(function(row) {
                                        option += '<option value="' + row.id + '">' + row
                                            .name +
                                            '</option>';

                                    })
                                    $('#id_category').removeAttr('disabled');
                                }


                                $('#id_category').html(option)
                            }
                        });
                    }
                })
            });

            function addData() {
                $('#id_type').val("");
                $('#status_bhp').removeClass('d-none');
                $('#id_source').attr('required', true);
                $('#id_category').html('<option value="">-- Pilih kategori --</option>');
                $('#id_category').attr('disabled', true);
                $('#display-source').removeClass('d-none');
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
                    url: "{{ route('stuff.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('.modal-title').html("Edit {{ session('title') }}");
                        $('#id_stuff').val(data.id);
                        $('#name').val(data.name);
                        $('#id_type').val(data.id_type).trigger('change');
                        // $('#id_category').val(data.id_category).trigger('change');
                        $('#id_supplier').val(data.id_supplier).trigger('change');
                        $('#id_unit').val(data.id_unit).trigger('change');
                        $('#amount').val(data.amount);
                        $('#id_source').removeAttr('required');
                        let price;
                        if (data.price) {
                            price = rubahRibuan(data.price);
                        }
                        $('#price').val(price);
                        if (data.status_bhp == 1) {
                            $('#bhp').prop('checked', true);
                        }
                        $('#status_bhp').addClass('d-none');
                        $('#display-source').addClass('d-none');
                        edit_category(data.id_type, data.id_category);
                        $('#modalForm').modal('show');
                    }
                });
            }

            function detailData(id) {
                $.ajax({
                    url: "{{ route('stuff.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('#modal-title-detail').html("Penggunaan " + data.name);
                        $('#output_unit').html(data.units.name);
                        if(data.price){
                            $('#output_price').html(rubahRibuan(data.price));
                        }else{
                            $('#output_price').html('-');
                        }
                        $('#output_category').html(data.categories.name);
                        $('#output_type').html(data.types.name);
                        $('#modalDetail').modal('show');
                        reload_datatable(id);
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('stuff.delete') }}",
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

            function filterData() {
                $('#formFilter').trigger("reset");
                $('#modalFilter').modal('show');
            }

            function edit_category(id_type, id) {
                $.ajax({
                    url: "{{ route('category.type_category-by_select') }}",
                    data: {
                        id_type, id
                    },
                    success: function(category) {
                        $('#id_category').html(category);
                        $('#id_category').removeAttr('disabled');
                    }
                });
                return false;
            }

            function reload_datatable(id_stuff) {
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
                        url: "{{ route('consumable.data_stuff') }}",
                        data: function(d) {
                            d.id_stuff = id_stuff;
                        }
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'request_date',
                        name: 'request_date',
                        className: 'align-middle'
                    }, {
                        data: 'users.name',
                        name: 'users.name',
                        className: 'align-middle',
                        defaultContent: '-'
                    }, {
                        data: 'amount',
                        name: 'amount',
                        className: 'align-middle text-center',
                        defaultContent: '-'
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
