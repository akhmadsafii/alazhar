<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export to pdf</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        padding: 10px 0;
        margin: 20px 0;
    }

    .item {
        border: 1px solid black;
        width: 500px;
        display: inline-block;
        padding: 5px;
        text-align: center;
        margin: 2px 0
    }

    .kode {
        margin: 0
    }

    .name {
        margin: 2px
    }
</style>

<body>
    <div class="container">
        <div class="item">
            <div class="barcode">
                {{-- @php
            $link = route('detail-item', ['item' => $data['code']]);
        @endphp --}}
                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('tes', 'QRCODE', 3, 33) }}"
                    style="width: 450px; height: 450px" alt="barcode" />

                <hr>
                <p class="kode">KODE</p>
                {{-- <h3 class="name">{{ strtoupper($stuff['name']) }}</h3> --}}
                <h3 class="name">NAMA BARANF</h3>
            </div>
        </div>
    </div>

</body>

</html>
