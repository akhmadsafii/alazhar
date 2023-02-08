<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jenis Barang</title>
</head>
<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">code</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">group</td>
            </thead>
        </table>
        <tbody>
        </tbody>
    </div>
    <br />
    <br />
    <br />
    <br />
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">Kode Jenis</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Nama</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Tipe</td>
            </thead>
        </table>
        <tbody>
            @foreach ($type as $tp)
            <tr>
                <td style="font-size:10px; text-align: center;">{{ $tp['code'] }}</td>
                <td style="font-size:10px; text-align: center;">{{ $tp['name'] }}</td>
                <td style="font-size:10px; text-align: center;">{{ $tp['group'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </div>
</body>
</html>
