@extends('layout.user.main')
@section('content')
    @push('styles')
        @include('package.datatable.datatable_css')
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    @endpush
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
        <div class="m-content">
            <div class="row">
                <div class="col-md-7">
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <div class="d-flex">
                                <div>
                                    <h3 class="m-subheader__title m-subheader__title--separator">Selamat Datang di sarana dan
                                        prasarana</h3>
                                    <p>Kamu berhasil meminjam 6 item barang dan mengajukan pengadaan 3 Barang pada bulan
                                        ini. lihat selengkapnya untuk riwayat peminjaman dan pengadaan</p><button
                                        class="btn btn-primary">Selengkapnya <i class="fas fa-arrow-right"></i></button>
                                </div><img src="{{ asset('asset/img/user-sarpras.png') }}" alt="" height="150">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="m-portlet">
                                <div class="m-portlet__body p-3">
                                    <div class="d-flex">
                                        <div class="icon my-auto m-2 alert alert-danger"><i
                                                class="icon fas fa-suitcase fa-3x"></i></div>
                                        <div class="info">
                                            <h5 class="my-1">Total Peminjaman</h5>
                                            <h3>{{ $statistic['rentals'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="m-portlet">
                                <div class="m-portlet__body p-3">
                                    <div class="d-flex">
                                        <div class="icon my-auto m-2 alert alert-danger"><i
                                                class="icon fas fa-suitcase fa-3x"></i></div>
                                        <div class="info">
                                            <h5 class="my-1">Total Pengadaan</h5>
                                            <h3>{{ $statistic['procurement'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="m-portlet">
                                <div class="m-portlet__body p-3">
                                    <div class="d-flex">
                                        <div class="icon my-auto m-2 alert alert-danger"><i
                                                class="icon fas fa-suitcase fa-3x"></i></div>
                                        <div class="info">
                                            <h5 class="my-1">Barang Sudah Kembali</h5>
                                            <h3>{{ $statistic['item_back'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="m-portlet">
                                <div class="m-portlet__body p-3">
                                    <div class="d-flex">
                                        <div class="icon my-auto m-2 alert alert-danger"><i
                                                class="icon fas fa-suitcase fa-3x"></i></div>
                                        <div class="info">
                                            <h5 class="my-1">Barang belum kembali</h5>
                                            <h3>{{ $statistic['item_not_back'] }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="m-portlet">
                        <div class="m-portlet__body">
                            <h5>Statistik Jumlah Pinjam Sarana dan Prasarana</h5>
                            <p>Data jumlah peminjaman sarana dan prasarana tahun {{ date('Y') }}</p>
                            <div id="myfirstchart" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <h3 class="m-portlet__head-text">
                                        Daftar pinjaman mendekati batas waktu
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
                    ajax: "{{ route('user.rental_day') }}",
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
                    url: "{{ route('user.statistic') }}",
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
