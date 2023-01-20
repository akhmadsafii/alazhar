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
                            <span class="m-nav__link-text">Akun</span>
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
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
                <div class="m-portlet__head m-portlet__head--fit-">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text m--font-light">
                                Personal Detail
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__pic">
                            <img src="{{ asset('asset/img/bg-4.jpg') }}" alt="">
                            <h3 class="m-widget27__title m--font-light">
                                <span>{{ $user['name'] }}</span>
                            </h3>
                            <div class="m-widget27__btn">
                                <img src="{{ asset('asset/img/user3.jpg') }}" alt="" class="btn m--img-rounded"
                                    style="border-radius: 50% !important">
                            </div>
                        </div>
                        <div class="m-widget27__container">
                            <ul class="m-widget27__nav-items nav nav-pills nav-fill" role="tablist">
                                <li class="m-widget27__nav-item nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#information">Informasi</a>
                                </li>
                                <li class="m-widget27__nav-item nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#access_data">Data Akses</a>
                                </li>
                            </ul>

                            <div class="m-widget27__tab tab-content m-widget27--no-padding">
                                <div id="information" class="tab-pane active">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group m-form__group">
                                                <label>Nama :</label>
                                                <p class="form-control-static">{{ $user['name'] }}</p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>Email :</label>
                                                <p class="form-control-static">{{ $user['email'] }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group m-form__group">
                                                <label>Jenis Kelamin :</label>
                                                <p class="form-control-static">
                                                    {{ $user['gender'] == 'male' ? 'Laki -laki' : 'Perempuan' }}</p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>Alamat :</label>
                                                <p class="form-control-static">{{ $user['address'] }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group m-form__group">
                                                <label>Agama :</label>
                                                <p class="form-control-static">{{ $user['religion'] }}</p>
                                            </div>
                                            <div class="form-group m-form__group">
                                                <label>TTL :</label>
                                                <p class="form-control-static">
                                                    {{ $user['place_of_birth'] . ', ' . DateHelper::getTanggal($user['date_of_birth']) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="access_data" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group m-form__group">
                                                <label>IP Adress :</label>
                                                <p class="form-control-static">{{ $user['last_ip'] ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group m-form__group">
                                                <label>Password Reset :</label>
                                                <p class="form-control-static">
                                                    {{ $user['reset_password'] ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group m-form__group">
                                                <label>Login Terakhir :</label>
                                                <p class="form-control-static">
                                                    {{ DateHelper::getHoursMinute($user['last_login']) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-content">
        <div class="m-portlet">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Riwayat Peminjaman
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
                                    <th>Barang</th>
                                    <th>Kode</th>
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
        </div>
    </div>


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
                    let formData = new FormData(this);
                    $.ajax({
                        url: "",
                        method: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
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
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('user.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('.modal-title').html("Edit {{ session('title') }}");
                        $('#id_type').val(data.id);
                        $('#name').val(data.name);
                        $('#group').val(data.group).trigger('change');
                        $('#modalForm').modal('show');
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('user.delete') }}",
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
        </script>
    @endpush
@endsection
