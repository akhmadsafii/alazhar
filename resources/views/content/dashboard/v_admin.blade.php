@extends('layout.main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
        <style>
            div#DataTables_Table_1_filter {
                display: none
            }
        </style>
    @endpush
    <div class="m-content">
        <div class="row">
            <div class="col-lg-4">
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <center>
                            <i class="fas fa-hand-holding fa-3x text-info"></i>
                            <h5 class="my-1">Total Peminjaman Bulan ini</h5>
                            <h3 class="text-info m-0">{{ $statistic['rentals'] }}</h3>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <center>
                            <i class="fas fa-tag fa-3x text-warning"></i>
                            <h5 class="my-1">Total Pengadaan Bulan ini</h5>
                            <h3 class="text-warning m-0">{{ $statistic['procurement'] }}</h3>
                        </center>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <center>
                            <i class="fas fa-trash-alt fa-3x text-success"></i>
                            <h5 class="my-1">Total Pemusnahan Bulan ini</h5>
                            <h3 class="text-success m-0">{{ $statistic['extermination'] }}</h3>
                        </center>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="m-portlet">
                    <div class="m-portlet__body p-3">
                        <div class="d-flex">
                            <div class="icon my-auto m-2 alert alert-danger">
                                <i class="icon fas fa-suitcase fa-3x"></i>
                            </div>
                            <div class="info">
                                <h5 class="my-1">Total Barang</h5>
                                <h3>{{ $statistic['stuff'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="m-portlet">
                    <div class="m-portlet__body p-3">
                        <div class="d-flex">
                            <div class="icon my-auto m-2 alert alert-danger">
                                <i class="icon fa fa-users fa-3x"></i>
                            </div>
                            <div class="info">
                                <h5 class="my-1">Total Item</h5>
                                <h3>{{ $statistic['item'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="m-portlet">
                    <div class="m-portlet__body p-3">
                        <div class="d-flex">
                            <div class="icon my-auto m-2 alert alert-danger">
                                <i class="icon fa fa-users fa-3x"></i>
                            </div>
                            <div class="info">
                                <h5 class="my-1">Item Rusak</h5>
                                <h3>{{ $statistic['broken_item'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="m-portlet">
                    <div class="m-portlet__body p-3">
                        <div class="d-flex">
                            <div class="icon my-auto m-2 alert alert-danger">
                                <i class="icon fa fa-users fa-3x"></i>
                            </div>
                            <div class="info">
                                <h6 class="my-1">Item Belum Kembali</h6>
                                <h3>{{ $statistic['rental_not_back'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="m-portlet">
                    <div class="m-portlet__body">
                        <h5>Statistik Jumlah Sarana dan Prasarana</h5>
                        <p>Data jumlah sarana dan prasarana tahun {{ date('Y') }}</p>
                        <div id="myfirstchart" style="height:300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="m-portlet">
                            <div class="m-portlet__body">
                                <div class="m-widget25">
                                    <div class="m-widget25--progress pt-0 m-0 border-0">
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                {{ $statistic['item_prasarana'] }}%
                                            </span>
                                            <div class="m--space-10"></div>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar m--bg-danger" role="progressbar"
                                                    style="width: {{ $statistic['item_prasarana'] }}%;"
                                                    aria-valuenow="{{ $statistic['item_prasarana'] }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <span class="m-widget25__progress-sub">
                                                Item Prasarana Tersedia
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="m-portlet">
                            <div class="m-portlet__body">
                                <div class="m-widget25">
                                    <div class="m-widget25--progress pt-0 m-0 border-0">
                                        <div class="m-widget25__progress">
                                            <span class="m-widget25__progress-number">
                                                {{ $statistic['item_sarana'] }}%
                                            </span>
                                            <div class="m--space-10"></div>
                                            <div class="progress m-progress--sm">
                                                <div class="progress-bar m--bg-success" role="progressbar"
                                                    style="width: {{ $statistic['item_sarana'] }}%;"
                                                    aria-valuenow="{{ $statistic['item_sarana'] }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                            <span class="m-widget25__progress-sub">
                                                Item Sarana Tersedia
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Daftar Barang Belum Kembali
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    Pengadaan
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <div class="input-group">
                                <select name="" id="filter-status" class="form-control my-2">
                                    <option value="" selected="" disabled="">-- Filter berdasarkan Status
                                        --
                                    </option>
                                    <option value="diterima">Diterima</option>
                                    <option value="pengajuan">Pengajuan</option>
                                    <option value="ditolak">Ditolak</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <table class="table datatable1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th>Prioritas</th>
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script>
            $(function() {

                var table = $('.datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    searching: false,
                    ajax: "{{ route('admin.dashboard-not_back') }}",
                    "drawCallback": function(settings) {
                        $(".datatable thead").remove();
                    },
                    columns: [{
                            data: 'detail',
                            name: 'detail'
                        },
                        {
                            data: 'status',
                            name: 'status',
                            className: 'text-center'
                        },
                    ]
                });

                var table1 = $('.datatable1').DataTable({
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    ordering: false,
                    info: false,
                    ajax: "{{ route('admin.dashboard-last_procurement') }}",
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'align-middle'
                        },
                        {
                            data: 'date_of_filling',
                            name: 'date_of_filling'
                        },
                        {
                            data: 'stuffs.name',
                            name: 'stuffs.name'
                        },
                        {
                            data: 'amount',
                            name: 'amount',
                            className: 'text-center'
                        },
                        {
                            data: 'priority',
                            name: 'priority',
                            className: 'text-center',
                        },
                        {
                            data: 'status',
                            name: 'status',
                            visible: false,
                        },
                    ]
                });

                $('#filter-status').on('change', function() {
                    console.log(this.value);
                    table1.search(this.value).draw();
                });

                var Area_chart = Morris.Area({
                    element: 'myfirstchart',
                    behaveLikeLine: true,
                    parseTime: false,
                    data: [],
                    xkey: 'y',
                    ykeys: ['a', 'b'],
                    labels: ['Prasarana', 'Sarana'],
                    pointFillColors: ['#707f9b'],
                    pointStrokeColors: ['#ffaaab'],
                    lineColors: ['#f26c4f', '#00a651', '#00bff3'],
                    redraw: true
                });

                $.ajax({
                    url: "{{ route('admin.statistic') }}",
                    data: 0,
                    dataType: 'json',
                    success: function(data) {
                        Area_chart.setData(data);
                    }
                });
            })
        </script>
    @endpush
@endsection
