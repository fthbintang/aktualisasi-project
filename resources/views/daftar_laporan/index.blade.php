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
                                                    <a href="{{ route('daftar_laporan.edit_jenis_laporan', $jenis->id) }}"
                                                        class="btn btn-sm btn-warning">Edit Jenis</a>
                                                    <form
                                                        action="{{ route('daftar_laporan.destroy_jenis_laporan', $jenis->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger btn-delete-jenis-laporan">
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
                                                        <a href="{{ route('daftar_laporan.edit_laporan', $laporan->id) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <form
                                                            action="{{ route('daftar_laporan.destroy_laporan', $laporan->id) }}"
                                                            method="POST" class="d-inline form-delete">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-delete-laporan">
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

    {{-- DELETE LAPORAN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-laporan');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

    {{-- DELETE JENIS LAPORAN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete-jenis-laporan');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Jika jenis laporan dihapus, semua laporan di dalamnya juga akan terhapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-layout>
