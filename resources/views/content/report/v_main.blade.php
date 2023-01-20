<!DOCTYPE html>
<html>

<head>
    <title>Laporan {{ session('title') }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h4>Laporan {{ session('title') }}</h4>
        <h5>{{ $school && $school['name'] != null ? $school['name'] : '' }}</h5>
    </center>
    @yield('content')



</body>

</html>
