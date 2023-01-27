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
                                    <th></th>
                                    <th>Tanggal</th>
                                    <th>Kode</th>
                                    <th>Barang</th>
                                    <th>Harga Awal</th>
                                    <th>Penyusutan</th>
                                    <th>Harga Akhir</th>
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
                                <label>Tanggal Penyusutan</label>
                                <input type="text" class="form-control m_datetimepicker_6" readonly
                                    value="{{ date('Y/m/d', strtotime(now())) }}" name="date">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Barang</label>
                                        <select name="id_stuff" id="id_stuff"
                                            class="form-control  m-bootstrap-select m_selectpicker" data-live-search="true">
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
                                        <select name="id_location" id="id_location"
                                            class="form-control  m-bootstrap-select m_selectpicker" data-live-search="true">
                                            <option value="" selected disabled>-- Pilih Lokasi --</option>
                                            @foreach ($location as $loc)
                                                <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <table
                                        class="table table-striped- table-bordered table-hover table-checkable datatable-item">
                                        <thead>
                                            <tr>

                                                <th width="20">
                                                    <div class="m-checkbox-list">
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" id="select-all">&nbsp;
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </th>
                                                <th>Kode</th>
                                                <th>Barang</th>
                                                <th>Lokasi</th>
                                                <th>Kondisi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Nilai Penyusutan</label>
                                <input type="text" class="form-control ribuan" name="price">
                                <span class="m-form__help">Harap diisi dengan harga rupiah.</span>
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
        <div class="modal fade" id="modalEdit" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form class="m-form m-form--fit m-form--label-align-right" id="formUpdate">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-edit_title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Tanggal Penyusutan</label>
                                <input type="text" class="form-control m_datetimepicker_6" name="date" readonly
                                    id="edit_date">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" id="id_depreciation">
                                <label>Item Barang</label>
                                <input type="hidden" name="id_item" id="edit_id_item">
                                <input type="text" class="form-control" readonly id="edit_item">
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga Awal</label>
                                        <input type="text" class="form-control" name="initial_price" readonly
                                            id="edit_initial_price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Harga Penyusutan</label>
                                        <input type="text" class="form-control" name="price" id="edit_price">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Harga Akhir</label>
                                <input type="text" class="form-control" name="final_price" readonly
                                    id="edit_final_price">
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
    @endpush
    @push('scripts')
        @include('component.formSubmit')
        @include('package.datatable.datatable_js')
        @include('package.bootstrap-select.bootstrap-select_js')
        @include('package.datetimepicker.datetimepicker_js')
        <script src="{{ asset('asset/plugins/ribuan.js') }}"></script>
        <script>
            var table;
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                table = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: {
                        url: "",
                        data: function(d) {
                            d.group = $('#group-status').val()
                        }
                    },
                    order: [
                        [1, 'desc']
                    ],

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
                        }, {
                            data: 'id',
                            name: 'id',
                            visible: false,
                        },
                        {
                            data: 'date',
                            name: 'date',
                        },
                        {
                            data: 'code_item',
                            name: 'code_item',
                            className: 'align-middle'
                        },
                        {
                            data: 'name',
                            name: 'name',
                            className: 'align-middle'
                        },
                        {
                            data: 'initial_price',
                            name: 'initial_price',
                            className: 'align-middle text-right'
                        },
                        {
                            data: 'price',
                            name: 'price',
                            className: 'align-middle text-right'
                        },
                        {
                            data: 'final_price',
                            name: 'final_price',
                            className: 'align-middle text-right'
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

                $('#group-status').on('change', function() {
                    table.draw();
                });

                formSubmit('#formUpdate', '#btnUpdate', '{{ route('depreciation.update') }}', '#modalEdit');

                $("#select-all").click(function(e) {
                    var table = $(e.target).closest('table');
                    $('td input:checkbox', table).prop('checked', this.checked);
                });

                $('#id_stuff').on('change', function(e) {
                    reloadDatatableItem(this.value, $('#id_location').val())
                });

                $('#id_location').on('change', function(e) {
                    reloadDatatableItem($('#id_stuff').val(), this.value)
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
                        alert('anda belum memilih item yang akan disusutkan');
                    }
                });

                // $("#edit_price").blur(function() {
                //     var inital_price = removePoint($('#edit_inital_price').val());
                //     var price = removePoint(this.value);
                //     // $('#edit_price').keyup(function(event) {
                //     // var price = removePoint(this.value);
                //     console.log(price);
                // });

                $('#edit_price').on("focusout", function(event) {
                    var price = parseFloat($(this).val().replace('.',''));
                    var inital_price = parseFloat($('#edit_initial_price').val().replace('.',''));
                    let final_price = inital_price - price;
                    $('#edit_final_price').val(rubahRibuan(final_price));
                });


            });

            function addData() {
                $(".m_selectpicker").val('default').selectpicker("refresh");
                $('#formSubmit').trigger("reset");
                $('#modal-title').html("Tambah {{ session('title') }}");
                reloadDatatableItem();
                $('#modalForm').modal('show');
            }

            function editData(id) {
                $.ajax({
                    url: "{{ route('depreciation.detail') }}",
                    data: {
                        id
                    },
                    success: function(data) {
                        $('#modal-edit_title').html("Edit {{ session('title') }}");
                        $('#id_depreciation').val(data.id);
                        $('#edit_id_item').val(data.id_item);
                        $('#edit_item').val(data.items.code);
                        $('#edit_date').val(data.date);
                        $('#edit_initial_price').val(rubahRibuan(data.initial_price));
                        $('#edit_price').val(data.price);
                        $('#edit_final_price').val(rubahRibuan(data.final_price));
                        $('#modalEdit').modal('show');
                    }
                });
            }


            function reloadDatatableItem(id_stuff = null, id_location = null) {
                // console.log(id_stuff, id_location);
                var table = $('.datatable-item').DataTable({
                    processing: true,
                    serverSide: true,
                    info: false,
                    searching: false,
                    lengthChange: false,
                    responsive: true,
                    bDestroy: true,
                    ajax: {
                        url: "{{ route('item.datatable_location_stuff') }}",
                        data: function(d) {
                            d.id_stuff = id_stuff;
                            d.id_location = id_location;
                        }
                    },
                    columns: [{
                            data: 'all_check',
                            name: 'all_check',
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
                            data: 'stuffs.name',
                            name: 'stuffs.name',
                            className: 'align-middle'
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

            function detailData(id) {
                // $('#modalDetail').modal('show');
                $.ajax({
                    url: "{{ route('exterminate.detail_complete') }}",
                    data: {
                        id
                    },
                    success: function(exterminate) {
                        $('.modal-title').html("Informasi {{ session('title') }}");
                        let information =
                            `<div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Barang :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.stuffs.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Kode Item :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.items.name}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Tanggal Pemusnahan :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.extermination_date}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group m-form__group">
                                    <label>Status :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.code_status}</p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <img src="${exterminate.show_file}" class="w-100" alt="">
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group m-form__group">
                                    <label>Keterangan :</label>
                                    <p class="form-control-static font-weight-bold">${exterminate.description}</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>`;
                        if (exterminate.status == 2) {
                            information += ` <div class="action">
                                        <button type="button" onclick="changeStatus(${exterminate.id}, 3, this)"
                                            class="btn btn-danger">Tolak</button>

                                        <button type="button" onclick="changeStatus(${exterminate.id}, 1, this)"
                                            class="btn btn-success">Terima</button>
                                    </div>`;
                        }
                        information += `</div></div>`;
                        $('#content-confirm').html(information);
                        $('#modalDetail').modal('show');
                    }
                });
            }

            function deleteData(id) {
                if (confirm("Apa kamu yakin ingin menghapus data ini?") == true) {
                    $.ajax({
                        url: "{{ route('exterminate.delete') }}",
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

            function changeStatus(id, status, evt) {
                $(evt).addClass('m-loader m-loader--light m-loader--right');
                $(evt).attr("disabled", true);
                $.ajax({
                    url: "{{ route('exterminate.update_status') }}",
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

            function getItem(stuff) {
                let id_stuff = stuff.value;
                $.ajax({
                    url: "{{ route('item.by_stuff') }}",
                    data: {
                        id_stuff
                    },
                    beforeSend: function() {
                        $('#e_id_item').html('<option value="">--- No Item Found ---</option>');
                    },
                    success: function(items) {
                        let content_item = '';
                        items.forEach(function(item) {
                            content_item += '<option value="' + item.id + '">' + item.name + '</option>';
                        })
                        $('#e_id_item').html(content_item).selectpicker('refresh');
                    }
                });
                return false;

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

            function readURLS(input, id) {
                id = id || '#modal-previews';
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
