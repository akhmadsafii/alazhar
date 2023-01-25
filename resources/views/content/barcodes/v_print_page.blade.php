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
        padding: 10px 0;
        margin: 20px 0;
    }

    .container {
        margin: 10px;
    }

    .item {
        border: 1px solid black;
        width: 29%;
        /* position: relative; */
        display: inline-block;
        padding: 5px;
        text-align: center
    }

    .kode {
        margin: 0
    }

    .name {
        margin: 2px
    }

    .spacing {
        margin: 2px 0px
    }

    .page-break {
        page-break-after: always;
    }
</style>

<body>
    <div class="container">
        @php
            $no = 0;
        @endphp
        @foreach ($stuff->items as $data)
            <div class="item">
                <div class="barcode">
                    @php
                        $link = route('detail-item', ['item' => $data['code']]);
                    @endphp
                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG("$link", 'QRCODE') }}" alt="barcode"
                        style="width: 150px; height: 150px" />
                    <hr>
                    <p class="kode">{{ $data['code'] }}</p>
                    <h3 class="name">{{ strtoupper($stuff['name']) }}</h3>
                </div>
            </div>
            @php
                ++$no;
            @endphp
            @if ($no % 3 == 0)
                <div class="spacing"></div>
                @if ($no % 12 == 0)
                    <div class="page-break"></div>
                @endif
            @endif
        @endforeach

    </div>

</body>

</html>
