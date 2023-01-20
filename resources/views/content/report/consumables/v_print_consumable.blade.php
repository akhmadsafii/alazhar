@extends('content.report.v_main')
@section('content')
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Barang</th>
                <th>Pengaju</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consumable as $key => $cns)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ DateHelper::getHoursMinute($cns['request_date']) }}</td>
                    <td>{{ $cns->stuffs->name }}</td>
                    <td>{{ $cns->users->name }}</td>
                    <td>{{ $cns->amount }}</td>
                    <td><span
                            class="m-badge  m-badge--{{ StatusHelper::consumables($cns['status'])['class'] }} m-badge--wide">{{ StatusHelper::consumables($cns['status'])['message'] }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Data not found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
