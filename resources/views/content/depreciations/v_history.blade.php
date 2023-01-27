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
            <div class="m-subheader">
                <div class="m-form__section m-form__section--first">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="m-portlet__head-text text-center"> {{ strtoupper($item['code']) }}</h3>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">Barang :</label>
                                <div class="col-lg-9">
                                    <p class="col-form-label">{{ $item->stuffs->name }}</p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-3 col-form-label">Kategori :</label>
                                <div class="col-lg-9">
                                    <p class="col-form-label">{{ $item->stuffs->categories->name }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group row">
                                <label class="col-lg-4 col-form-label">Tipe :</label>
                                <div class="col-lg-8">
                                    <p class="col-form-label">{{ $item->stuffs->units->name }}</p>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <label class="col-lg-4 col-form-label">Harga Saat ini :</label>
                                <div class="col-lg-8">
                                    <p class="col-form-label">{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{ session('title') }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Harga Awal</th>
                                    <th>Penyusutan</th>
                                    <th>Harga Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($depreciation as $key => $dp)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ DateHelper::getTanggal($dp['date']) }}</td>
                                        <td>{{ number_format($dp['initial_price'], 0, ',', '.') }}</td>
                                        <td>{{ number_format($dp['price'], 0, ',', '.') }}</td>
                                        <td>{{ number_format($dp['final_price'], 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Data tidak tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
@endsection
