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
                                    <th>Nama User</th>
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
                            <input type="hidden" name="id" id="id_admin">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" class="form-control m-input" id="name" name="name"
                                    placeholder="Nama Admin">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control m-input" id="email" name="email"
                                    placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Telepon</label>
                                <input type="text" class="form-control m-input" id="phone" name="phone"
                                    placeholder="Telepon">
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control m-input" id="password" name="password"
                                            placeholder="Password">
                                        <span class="m-form__help d-none" id="notice_password">Harap kosongi, jika tidak ingin
                                            mengubah passwords.</span>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" name="file" class="form-control-file"
                                            onchange="readURL(this);">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview" class="w-100">
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
                    <div class="m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
                        <div class="m-portlet__body" id="detail-profile">
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
                        "print", "copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5",
                    ],
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'align-middle'
                    }, {
                        data: 'name',
                        name: 'name',
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center align-middle'
                    }, ]
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
                $('#id_admin').val("");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                $('#modalForm').modal('show');
                $('#notice_password').addClass('d-none');
            }

            function detailData(id) {
                $.ajax({
                    url: "{{ route('admin.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        // $('#id_admin').val(data.id);
                        $('#detail-profile').html(`
                            <div class="m-widget27 m-portlet-fit--sides">
                                <div class="m-widget27__pic">
                                    <img src="{{ asset('asset/img/bg-4.jpg') }}" alt=""
                                        style="height: 150px !important">
                                    <h3 class="m-widget27__title m--font-light text-center text-capitalize">
                                        <span style="font-size: 1.5rem !important">${data.name}</span>
                                    </h3>
                                    <div class="m-widget27__btn">
                                        <img src="${data.show_file}" alt=""
                                            class="btn m--img-rounded" style="border-radius: 50% !important">
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
                                        <div id="information" class="tab-pane active table-responsive">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                        <label>Nama :</label>
                                                        <p class="form-control-static font-weight-bold">${data.name}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                        <label>Telepon :</label>
                                                        <p class="form-control-static font-weight-bold">${data.phone}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                        <label>Email :</label>
                                                        <p class="form-control-static font-weight-bold">${data.email}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="access_data" class="tab-pane fade">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                        <label>IP Adress :</label>
                                                        <p class="form-control-static font-weight-bold">${data.last_ip}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                        <label>Password Reset :</label>
                                                        <p class="form-control-static font-weight-bold">${data.reset_password}</p>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group m-form__group">
                                                        <label>Login Terakhir :</label>
                                                        <p class="form-control-static font-weight-bold">${data.last_login}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `);
                        $('#modalDetail').modal('show');
                    }
                });



                $('#modalDetail').modal('show');

            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('admin.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('.modal-title').html("Edit {{ session('title') }}");
                        $('#id_admin').val(data.id);
                        $('#name').val(data.name);
                        $('#email').val(data.email);
                        $('#notice_password').removeClass('d-none');
                        $('#phone').val(data.phone);
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
