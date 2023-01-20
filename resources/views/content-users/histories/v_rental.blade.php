@extends('content-users.histories.v_main')
@section('content_history')
    @push('styles')
        @include('package.datatable.datatable_css')
    @endpush
    <!-- END: Subheader -->
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
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th>
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
                    <div class="modal-body">
                        <div class="row" id="content-confirm">
                        </div>
                    </div>
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
                    url: "{{ route('user.history.rental_detail') }}",
                    data: {
                        id
                    },
                    success: function(rental) {
                        $('.modal-title').html("Informasi {{ session('title') }}");
                        let information =
                            `<div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Peminjam :</label>
                                    <p class="form-control-static">${rental.users.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Nama Barang :</label>
                                    <p class="form-control-static">${rental.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Tanggal Sewa :</label>
                                    <p class="form-control-static">${rental.e_rental_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Tanggal Kembali :</label>
                                    <p class="form-control-static">${rental.e_return_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Status Peminjaman :</label>
                                    <p class="form-control-static">${rental.status_rental}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Tanggal Dikembalikan :</label>
                                    <p class="form-control-static">${rental.e_returned_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group m-form__group">
                                    <label class="font-weight-bold">Keterangan :</label>
                                    <p class="form-control-static">${rental.description}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>`;
                        information += `</div></div>`;
                        $('#content-confirm').html(information);
                        $('#modalDetail').modal('show');
                    }
                });
            }
        </script>
    @endpush
@endsection
