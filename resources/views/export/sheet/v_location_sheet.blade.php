<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ruang</title>
</head>
<body>
    <div class="table-responsive">
        <table class="table table-bordered border-primary">
            <thead class="thead-dark">
                <td style="text-align: center; font-size:10px">id</td>
                <td style="text-align: center; font-size:10px">name</td>
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
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px">ID</td>
                <td style="text-align: center; background-color:#7dd8ff; font-size:10px;">Nama</td>
            </thead>
        </table>
        <tbody>
            @foreach ($locations as $loc)
            <tr>
                <td style="font-size:10px; text-align: center;">{{ $loc->id }}</td>
                <td style="font-size:10px; text-align: center;">{{ $loc->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </div>
</body>
</html>
