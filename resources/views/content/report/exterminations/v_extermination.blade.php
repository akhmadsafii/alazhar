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
                                            <a href="{{ route('report.extermination', ['download' => 'pdf']) }}"
                                                target="_blank" class="m-nav__link">
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
                    <div class="m-portlet__body m-portlet__body">
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
                                <hr>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal Pemusnahan</th>
                                                <th>Nama Barang</th>
                                                <th>Kode Item</th>
                                                <th>Jenis</th>
                                                <th>Kategori</th>
                                                <th>Keterangan</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($extermination as $key => $ex)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ DateHelper::getHoursMinute($ex['extermination_date']) }}</td>
                                                    <td>{{ $ex->stuffs->name }}</td>
                                                    <td>{{ $ex->items->name }}</td>
                                                    <td>{{ $ex->stuffs->types->name }}</td>
                                                    <td>{{ $ex->stuffs->categories->name }}</td>
                                                    <td>{{ $ex->description }}</td>
                                                    <td class="text-center">
                                                        <span
                                                            class="m-badge  m-badge--{{ StatusHelper::exterminate($ex['status'])['class'] }} m-badge--wide">{{ StatusHelper::exterminate($ex['status'])['message'] }}</span>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">Data not found</td>
                                                </tr>
                                            @endforelse
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
@endsection
