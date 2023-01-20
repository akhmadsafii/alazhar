@extends('content.report.v_main')
@section('content')
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Pengajuan</th>
                <th>Nama Barang</th>
                <th class="text-center">Jumlah</th>
                <th>Pengaju</th>
                <th>Tanggal Diterima</th>
                <th class="text-center">Status</th>
                <th class="text-right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @forelse($procurement as $key => $pc)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ DateHelper::getHoursMinute($pc['date_of_filing']) }}</td>
                    <td>{{ $pc->stuffs->name }}</td>
                    <td class="text-center">{{ $pc->amount }}</td>
                    <td>{{ $pc->users->name }}</td>
                    <td>{{ DateHelper::getHoursMinute($pc['date_received']) }}</td>

                    <td class="text-center">
                        @php
                            $class = 'primary';
                            if ($pc['status'] == 2) {
                                $class = 'danger';
                            } elseif ($pc['status'] == '1') {
                                $class = 'success';
                            }
                        @endphp
                        <span
                            class="m-badge  m-badge--{{ $class }} m-badge--wide">{{ StatusHelper::procurements($pc['status']) }}</span>
                    </td>
                    <td class="text-right">
                        {{ number_format($pc['total_price'], 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Data not found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
