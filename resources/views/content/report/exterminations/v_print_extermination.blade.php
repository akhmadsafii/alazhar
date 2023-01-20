@extends('content.report.v_main')
@section('content')
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pemusnahan</th>
                <th>Nama Barang</th>
                <th>Kode Item</th>
                <th>Jenis</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($extermination as $key => $ex)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ DateHelper::getHoursMinute($ex['extermination_date']) }}</td>
                    <td>{{ $ex->stuffs->name }}</td>
                    <td>{{ $ex->items->name }}</td>
                    <td>{{ $ex->stuffs->types->name }}</td>
                    <td>{{ $ex->stuffs->categories->name }}</td>
                    <td>{{ $ex->description }}</td>
                    <td class="text-center">
                        <span
                            class="m-badge  m-badge--{{ StatusHelper::exterminate($ex['status'])['class'] }} m-badge--wide">{{ StatusHelper::exterminate($ex['status'])['message'] }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data not found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
