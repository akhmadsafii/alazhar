<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Barang</title>
</head>

<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">id</td>
                <td style="text-align: center; font-size:10px">code</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">unit</td>
                <td style="text-align: center; font-size:10px">type</td>
                <td style="text-align: center; font-size:10px">group</td>
                <td style="text-align: center; font-size:10px">category</td>
                <td style="text-align: center; font-size:10px">supplier</td>
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
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">ID Barang</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Kode</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Nama</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Satuan</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Jenis</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Tipe</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Kategori</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Suplayer</td>
            </thead>
        </table>
        <tbody>
            @foreach ($stuffs as $stf)
                <tr>
                    <td style="font-size:10px; text-align: center;">{{ $stf->id }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->code }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->name }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->unit }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->type }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->group }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->category }}</td>
                    <td style="font-size:10px; text-align: center;">{{ $stf->supplier }}</td>
                </tr>
            @endforeach
        </tbody>
    </div>
</body>

</html>
