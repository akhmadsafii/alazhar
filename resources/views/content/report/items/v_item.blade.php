@extends('layout.main')
@section('content')
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
                            <span class="m-nav__link-text">Laporan</span>
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
            <div>
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                    m-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                        class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                        <i class="la la-plus m--hide"></i>
                        <i class="la la-ellipsis-h"></i>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__section m-nav__section--first m--hide">
                                            <span class="m-nav__section-text">Quick Actions</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon far fa-file-pdf"></i>
                                                <span class="m-nav__link-text">Print PDF</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon fas fa-chart-bar"></i>
                                                <span class="m-nav__link-text">Mode Chart</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-portlet">
                    <div class="m-portlet__body m-portlet__body--no-padding">
                        <div class="m-invoice-2">
                            <div class="m-invoice__wrapper">
                                <div class="m-invoice__head">
                                    <div class="m-invoice__container m-invoice__container--centered">
                                        <div class="m-invoice__logo py-5">
                                            <a href="#">
                                                <h1 class="text-uppercase text-center">Laporan {{ session('title') }}</h1>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if (!empty($item))
                                    @foreach ($item as $it)
                                        <div class="m-invoice__body m-invoice__body--centered my-5">
                                            <div class="d-flex justify-content-between">
                                                <h3>Jenis : {{ $it['type'] }}</h3>
                                                <h4>Tipe : {{ $it['group'] }}</h3>
                                            </div>
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th class="text-left">Nama</th>
                                                            <th class="text-left">Kode</th>
                                                            <th class="text-left">Kategori</th>
                                                            <th class="text-left">Kondisi</th>
                                                            <th class="text-left">Lokasi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($it['categories'])
                                                            @foreach ($it['categories'] as $key => $s)
                                                                <tr>
                                                                    <td class="text-center">{{ ++$key }}</td>
                                                                    <td class="text-left">{{ $s->stuffs->name }}</td>
                                                                    <td class="text-left">{{ $s['name'] }}</td>
                                                                    <td class="text-left">{{ $s->categories ? $s->categories->name : '-' }}</td>
                                                                    <td class="text-left">{{ $s['condition'] }}</td>
                                                                    <td class="text-left">
                                                                        {{ $s->locations ? $s->locations->name : '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        @else
                                                            <tr>
                                                                <td colspan="6" class="text-center m--font-danger">Data
                                                                    saat ini tidak tersedia</td>
                                                            </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="m-invoice__footer">
                                    {{-- <div class="m-invoice__table  m-invoice__table--centered table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>BANK</th>
                                                    <th>ACC.NO.</th>
                                                    <th>DUE DATE</th>
                                                    <th>TOTAL AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>BARCLAYS UK</td>
                                                    <td>12345678909</td>
                                                    <td>Jan 07, 2018</td>
                                                    <td class="m--font-danger">20,600.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> --}}
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
