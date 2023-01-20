<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kategori Barang</title>
</head>
<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">id</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">id_type</td>
                <td style="text-align: center; font-size:10px">type</td>
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
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">ID Kategori</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Nama</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">ID Jenis</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Jenis</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Tipe</td>
            </thead>
        </table>
        <tbody>
            @foreach ($categories as $ctg)
            <tr>
                <td style="font-size:10px; text-align: center;">{{ $ctg->id }}</td>
                <td style="font-size:10px; text-align: center;">{{ $ctg->name }}</td>
                <td style="font-size:10px; text-align: center;">{{ $ctg->id_type }}</td>
                <td style="font-size:10px; text-align: center;">{{ $ctg->type }}</td>
                <td style="font-size:10px; text-align: center;">{{ $ctg->group }}</td>
            </tr>
            @endforeach
        </tbody>
    </div>
</body>
</html>
