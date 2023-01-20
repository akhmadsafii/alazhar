<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suplayer</title>
</head>

<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">id</td>
                <td style="text-align: center; font-size:10px">name</td>
                <td style="text-align: center; font-size:10px">phone</td>
                <td style="text-align: center; font-size:10px">address</td>
                <td style="text-align: center; font-size:10px">description</td>
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
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">ID Suplayer</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Nama</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Telepon</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Keterangan</td>
            </thead>
        </table>
        <tbody>
            @foreach ($supplier as $splyr)
            <tr>
                <td style="font-size:10px; text-align: center;">{{ $splyr->id }}</td>
                <td style="font-size:10px; text-align: center;">{{ $splyr->name }}</td>
                <td style="font-size:10px; text-align: center;">{{ $splyr->phone}}</td>
                <td style="font-size:10px; text-align: center;">{{ $splyr->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </div>
</body>

</html>
