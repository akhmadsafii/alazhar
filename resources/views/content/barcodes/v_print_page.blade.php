<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export to pdf</title>
</head>

<style type="text/css">
    body {
        font-family: Arial, sans-serif;
        position: static !important;
        padding: 0;
        margin: 0;
    }

    .container-main {
        padding: 0;
    }

    .tg {
        border-collapse: collapse;
        border-spacing: 0;
        border-color: black;
        border-style: solid;
        border-width: 1px;
    }

    .tg td {
        border-color: transparent;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 10px;
        overflow: hidden;
        padding: 10px 5px;
        word-break: normal;
    }

    .tg th {
        border-color: transparent;
        border-style: solid;
        border-width: 1px;
        font-family: Arial, sans-serif;
        font-size: 10px;
        font-weight: normal;
        overflow: hidden;
        padding: 10px 5px;
        word-break: normal;
    }

    .tg .tg-baqh {
        text-align: center;
        vertical-align: top
    }

    .tg .tg-mums {
        background-color: #ffffff;
        border-color: #000000;
        font-weight: bold;
        text-align: center;
        vertical-align: top
    }

    .tg .tg-jbyd {
        background-color: #ffffff;
        border-color: #000000;
        text-align: center;
        vertical-align: top
    }

    .tg .tg-0lax {
        text-align: left;
        vertical-align: top;
        width: 150px;
    }

    .tg .tg-0lax-lag {
        text-align: right;
        vertical-align: top;
        width: 100px;
    }

    .container-main {
        width: 100%;
        display: block;
    }

    .container {
        margin: 10px;
    }

    .tabel {
        width: 45%;
        margin: 10px;
        border: 1px solid black;
        display: inline-block;
    }

    .head {
        width: 100%;
        display: block;
    }

    .title-barang {
        text-align: center;
        padding: 10px 0;
        font-size: 16px;
        padding-bottom: 0px;
    }

    .body {
        width: 100%;
        display: block;
        margin-top: 10px;
    }

    .body-tabel {
        width: 42%;
        padding: 10px;
        display: inline-block;
    }

    .kode {
        font-size: 10px;
        margin: 5px 0;
        text-align: center;
    }

    .barcode {
        display: inline-block;
        margin-left: 3%;
    }

    .row {
        width: 100%;
        display: block;
        padding: 0 5px;
    }

    .col-title {
        width: 40%;
        display: inline-block;
        font-size: 10px
    }

    .col-desc {
        width: 55%;
        display: inline-block;
        font-size: 10px
    }

    table {
        width: 45%;
        margin: 10px 0;
    }

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    <section class="container-main">
        @php
            $no = 0;
        @endphp
        {{-- {{ dd($stuff->items) }} --}}
        @foreach ($stuff->items as $data)
            {{-- {{ dd($data) }} --}}
            <!-- <table> -->
            <div class="tabel">
                <div class="head">
                    <div class="title-barang">
                        <div class="barcode">
                            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($data['name'], 'C39')}}" alt="barcode" />
                            {{-- {!! DNS1D::getBarcodeHTML('$data['code']', 'C128', 2.4, 24) !!} --}}
                        </div>
                    </div>
                    <p class="kode">{{ $data['name'] }}</p>
                    <div class="title-barang"><strong>{{ $stuff['name'] }}</strong></div>
                </div>
                <div class="body">
                    <div class="body-tabel">
                        <div class="row">
                            <div class="col-title">Diperbarui </div>
                            <div class="col-desc">: {{ DateHelper::getMonthYear($data['updated_date']) }}</div>
                        </div>
                        <div class="row">
                            <div class="col-title">Kategori </div>
                            <div class="col-desc">: {{ $stuff->categories->name }}</div>
                        </div>
                    </div>
                    <div class="body-tabel">
                        <div class="row">
                            <div class="col-title">Lokasi :</div>
                            <div class="col-desc"> {{ $data->locations != null ? $data->locations->name : '-' }}</div>
                        </div>
                        <div class="row">
                            <div class="col-title"></div>
                            <div class="col-desc"></div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                ++$no;
            @endphp
            @if ($no % 2 == 0)
                <br>
                @if ($no % 10 == 0)
                    <div class="page-break"></div>
                @endif
            @endif
        @endforeach
    </section>

</body>

<script type="text/javascript"></script>

</html>
