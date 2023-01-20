@extends('content-users.histories.v_main')
@section('content_history')
    @push('styles')
        @include('package.datatable.datatable_css')
    @endpush
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Riwayat {{ session('title') }}
                        </h3>
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
                                    <th>Tanggal Pengadaan</th>
                                    <th>Jumlah</th>
                                    <th>Harga Satuan</th>
                                    <th>Harga Total</th>
                                    <th>Prioritas</th>
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
                            data: 'date_of_filing',
                            name: 'date_of_filing',
                            className: 'align-middle'
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            className: 'align-middle'
                        },
                        {
                            data: 'unit_price',
                            name: 'unit_price',
                            className: 'align-middle'
                        },
                        {
                            data: 'total_price',
                            name: 'total_price',
                            className: 'align-middle'
                        },
                        {
                            data: 'priority',
                            name: 'priority',
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
                    ]
                });

            })

            function detailData(id) {
                $.ajax({
                    url: "{{ route('user.history.procurement_detail') }}",
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
                        $('#display-detail').html(detail);
                        $('#modalDetail').modal('show');
                    }
                });
            }
        </script>
    @endpush
@endsection
