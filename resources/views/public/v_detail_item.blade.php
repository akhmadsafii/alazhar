<!DOCTYPE html>
<html lang="en">

<!-- begin::Head -->

<head>
    @include('layout.user.head')
    <style>
        @media (min-width: 1025px){
            .m-page .m-page__container {
                padding: 30px !important;
            }
        }
    </style>
</head>

<body class="m-page--wide m-header--fixed m-header--fixed-mobile m-footer--push m-aside--offcanvas-default">
    <div class="m-grid m-grid--hor m-grid--root m-page">
        <div
            class="m-grid__item m-grid__item--fluid  m-grid m-grid--ver-desktop m-grid--desktop 	m-container m-container--responsive m-container--xxl m-page__container m-body">
            <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">
                <div class="m-portlet__body">
                    <div class="m-widget27 m-portlet-fit--sides">
                        <div class="m-widget27__pic">
                            <img src="../../assets/app/media/img//bg/bg-4.jpg" alt="">
                            <h3 class="m-widget27__title m--font-light text-center">
                                <span style="font-size: 1.0em">Selamat kamu berhasil memindai Barang</span>
                            </h3>
                            <div class="m-widget27__btn">
                                @php
                                    $link = route('detail-item', ['item' => $item['code']]);
                                @endphp
                                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$link", 'QRCODE') }}"
                                    alt="barcode" class="btn bg-white p-2" style="width: 150px; height: 150px" />
                            </div>
                        </div>
                        <div class="m-widget27__container" style="margin-top: 5rem !important">

                            <!-- begin::Nav pills -->
                            <ul class="m-widget27__nav-items nav nav-pills nav-fill" role="tablist">
                                <li class="m-widget27__nav-item nav-item">
                                    <a class="nav-link active" data-toggle="pill"
                                        href="#m_personal_income_quater_1">Detail Item</a>
                                </li>
                                <li class="m-widget27__nav-item nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#m_personal_income_quater_2">Riwayat
                                        Peminjaman</a>
                                </li>
                            </ul>
                            <div class="m-widget27__tab tab-content m-widget27--no-padding">
                                <div id="m_personal_income_quater_1" class="tab-pane active">
                                    <div class="m-widget12">
                                        <div class="m-widget12__item">
                                            <span class="m-widget12__text1">Nama
                                                Barang<br><span>{{ strtoupper($item->stuffs->name) }}</span></span>
                                            <span
                                                class="m-widget12__text2">Kode<br><span>{{ $item['code'] }}</span></span>
                                        </div>
                                        <div class="m-widget12__item">
                                            <span class="m-widget12__text1">Kategori
                                                Barang<br><span>{{ $item->stuffs->categories->name }}</span></span>
                                            <span class="m-widget12__text2">Sumber
                                                Dana<br><span>{{ $item->sources->name }}</span></span>
                                        </div>
                                        <div class="m-widget12__item">
                                            <span
                                                class="m-widget12__text1">Kondisi<br><span>{{ $item['condition'] == 'broken' ? 'Rusak' : 'Bagus' }}</span></span>
                                            <span
                                                class="m-widget12__text2">Lokasi<br><span>{{ $item->locations->name }}</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="m_personal_income_quater_2" class="tab-pane fade">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Peminjam</th>
                                                    <th>Tanggal Pinjam</th>
                                                    <th>Tanggal Kembali</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($rentals->isEmpty())
                                                    <tr>
                                                        <td colspan="3" class="text-center">Tidak tersedia</td>
                                                    </tr>
                                                @else
                                                    @foreach ($rentals as $rt)
                                                        <tr>
                                                            <td>{{ $rt->users->name }}</td>
                                                            <td>{{ DateHelper::getTanggal($rt['rental_date']) }}</td>
                                                            <td>{{ DateHelper::getTanggal($rt['returned_date']) }}</td>
                                                        </tr>  
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layout.user.foot')
</body>

</html>
