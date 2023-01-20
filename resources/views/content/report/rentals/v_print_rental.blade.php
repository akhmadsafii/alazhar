@extends('content.report.v_main')
@section('content')
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Sewa</th>
                <th>Nama Barang</th>
                <th>Kode Item</th>
                <th>Penyewa</th>
                <th>Role</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rental as $key => $rt)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ DateHelper::getHoursMinute($rt['rental_date']) }}</td>
                    <td>{{ $rt->stuffs->name }}</td>
                    <td>{{ $rt->items->name }}</td>
                    <td>{{ $rt->users->name }}</td>
                    <td>{{ $rt->users->role }}</td>
                    <td>{{ DateHelper::getHoursMinute($rt['return_date']) }}</td>
                    <td><span
                            class="m-badge  m-badge--{{ StatusHelper::rentals($rt['status'])['class'] }} m-badge--wide">{{ StatusHelper::consumables($rt['status'])['message'] }}</span>
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
