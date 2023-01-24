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
        width: 30%;
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
        width: 30%;
        padding: 10px;
        display: inline-block;
    }

    .kode {
        font-size: 10px;
        text-align: center;
    }

    .barcode {
        display: inline-block;
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

    .text-center{
        text-align: center;
    }

    /* .page-break {
        page-break-after: always;
    } */
</style>

<body>
    <section class="container-main">
        @php
            $no = 0;
        @endphp
        {{-- {{ dd($stuff->items) }} --}}
        @foreach ($stuff->items as $data)
            <div class="tabel">
                <div class="head">
                    <div class="title-barang">
                        <div class="barcode">
                            @php
                                $link = route('detail-item', ['item' => $data['code']]);
                            @endphp
                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$link", 'QRCODE') }}"
                                alt="barcode" />
                        </div>
                    </div>
                    <p class="kode">{{ $data['code'] }}</p>
                    <div class="text-center" style="margin-bottom: 3px"><strong>{{ strtoupper($stuff['name']) }}</strong></div>
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
