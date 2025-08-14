<x-layout :breadcrumbs="$breadcrumbs">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Laporan</h5>

                        <div class="d-flex gap-2">
                            <a href="{{ route('daftar_laporan.create_jenis_laporan') }}" class="btn btn-primary">
                                + Jenis Laporan
                            </a>
                            <a href="{{ route('daftar_laporan.create_laporan') }}" class="btn btn-success">
                                + Laporan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Tabel Gabungan Jenis Laporan & Laporan --}}
                        @if ($jenisLaporan->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Jenis Laporan</th>
                                            <th>Nama Laporan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jenisLaporan as $jenis)
                                            {{-- Baris jenis laporan --}}
                                            <tr class="table-active">
                                                <th>{{ $jenis->nama_jenis }}</th>
                                                <td></td>
                                                <td class="text-end">
                                                    <a href="#" class="btn btn-sm btn-warning">Edit Jenis</a>
                                                    <form action="#" method="POST" class="d-inline"
                                                        onsubmit="return confirm('Yakin hapus jenis laporan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Hapus Jenis
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            {{-- Baris laporan di bawah jenis terkait --}}
                                            @foreach ($jenis->laporan as $laporan)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $laporan->nama_laporan }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                        <form action="#" method="POST" class="d-inline"
                                                            onsubmit="return confirm('Yakin hapus laporan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Belum ada jenis laporan. Silakan tambah jenis/laporan.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
