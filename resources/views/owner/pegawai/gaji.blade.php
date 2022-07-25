@extends('admin.layouts.app')

@section('title', 'Dashboard Data Gaji Pegawai')

@section('content')

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Gaji Pegawai</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Gaji Pegawai</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="tablePegawai">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Pelanggaran</th>
                            <th>Lembur</th>
                            <th>Status</th>
                            <th>Jumlah Anak</th>
                            <th>Total gaji</th>
                            <th>Slip Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pegawai as $item)
                        @php
                            $thr = 1 * $item->gapok;
                            $tunjangan = $item->tunjangan_makan + $item->tunjangan_makmur + $item->tunjangan_transport + ($item->lembur * $item->tunjangan_lembur) + $item->tunjangan_menikah + ($item->jumlah_anak * $item->tunjangan_anak);

                            $gaji = $item->gapok + $tunjangan + $item->bonus_omzet + $thr - $item->pelanggaran;
                        @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_pegawai }}</td>
                                <td>{{ $item->nama_jabatan }}</td>
                                <td>{{ $item->pelanggaran }}</td>
                                <td>{{ $item->lembur }}</td>
                                <td>{{ $item->nama_golongan }}</td>
                                <td>{{ $item->jumlah_anak }}</td>
                                <td>{{ number_format($gaji) }}</td>
                                <td>
                                    <button class="btn btn-success">Slip Gaji</button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#tablePegawai').DataTable();
        });
    </script>

    <script>
        $('.delete').click(function() {
            var pegawaiId = $(this).attr('data-id');
            swal({
                    title: "Apakah kamu yakin ?",
                    text: "Apa kamu yakin ingin menghapus data ini",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location = "/pegawai/delete/" + pegawaiId + ""
                        swal("Data berhasil dihapus", {
                            icon: "success",
                        });
                    } else {
                        swal("Data tidak jadi dihapus");
                    }
                });
        });
    </script>
@endpush
