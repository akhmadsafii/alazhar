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
                        <select name="" id="" class="form-control my-2">
                            <option value="" selected disabled>-- Filter berdasarkan jenis --</option>
                            <option value="sarana">Sarana</option>
                            <option value="prasarana">Prasarana</option>
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
                                    <th>Jenis</th>
                                    <th>Kategori</th>
                                    <th>Jumlah</th>
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
        <div class="modal fade" id="modalPrint" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formSubmit" action="" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Filter</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_stuff">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah QR horizontal</label>
                                        <input type="text" class="form-control" name="amount_horizontal" id="amount_horizontal">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jumlah QR vertical</label>
                                        <input type="text" class="form-control" name="amount_vertical" id="amount_vertical">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Total gambar per halaman</label>
                                <input type="text" class="form-control" name="total_per_page">
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
    @endpush
    @push('scripts')
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
                            data: 'total_items',
                            name: 'total_items',
                            className: 'text-center align-middle'
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
            });

            function printData(id)
            {
                $('#formSubmit').trigger("reset");
                $('#id_stuff').val(id);
                $('.modal-title').html("Opsi Cetak QR CODE");
                $('#modalPrint').modal('show');
            }
        </script>
    @endpush
@endsection
