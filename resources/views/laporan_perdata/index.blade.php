<x-layout :breadcrumbs="$breadcrumbs">
    <div class="page-heading ms-3">
        @can('Kepaniteraan Perdata')
            <h3 class="text-white">Upload Laporan Perdata Bulanan</h3>
            <p class="text-white">Pilih bulan & tahun, lalu upload laporan perdata yang akan dikirim ke hukum.</p>
        @else
            <h3 class="text-white">Laporan Perdata Bulanan</h3>
            <p class="text-white">Silakan pilih bulan & tahun untuk melihat laporan perdata yang telah diunggah.</p>
        @endcan
    </div>

    {{-- Filter Bulan & Tahun --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('laporan_perdata.index') }}" class="row g-2">
                <div class="col-md-4">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select">
                        @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}"
                                {{ $b == request('bulan', now()->month) ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control"
                        value="{{ request('tahun', now()->year) }}">
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary w-auto">
                        <i class="bi bi-search"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @can('Kepaniteraan Perdata')
        {{-- Form Upload Laporan Baru --}}
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h5>Tambah Laporan - {{ $bulanNama }} {{ $tahun }}</h5>
            </div>

            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    Laporan yang diunggah pada bulan ini adalah <b>hasil kegiatan bulan sebelumnya</b>.
                    Contoh: upload Februari berisi laporan bulan Januari.
                </div>
                <form action="{{ route('laporan_perdata.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">

                    <div class="form-group mb-3">
                        <label for="nama_laporan" class="form-label">
                            <b>Nama Laporan</b><span class="text-danger">*</span>
                        </label>
                        <input type="text" name="nama_laporan" id="nama_laporan"
                            class="form-control @error('nama_laporan') is-invalid @enderror" placeholder="Nama Laporan..."
                            value="{{ old('nama_laporan') }}" required>
                        @error('nama_laporan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="laporan_perdata_path" class="form-label">
                            <b>Upload File</b><span class="text-danger">*</span>
                        </label>
                        <input type="file" name="laporan_perdata_path" id="laporan_perdata_path"
                            class="form-control @error('laporan_perdata_path') is-invalid @enderror" required>
                        <small class="text-muted">Format: PDF, DOCX, XLSX, dll</small>
                        @error('laporan_perdata_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="catatan" class="form-label"><b>Catatan</b> (opsional)</label>
                        <textarea name="catatan" id="catatan" class="form-control @error('catatan') is-invalid @enderror" rows="2"
                            placeholder="Catatan...">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-upload"></i> Upload Laporan
                    </button>
                </form>

            </div>
        </div>
    @endcan
    <div class="page-content">

        {{-- Daftar Laporan --}}
        <div class="card">
            <div class="card-header pb-0">
                <h5>Daftar Laporan - {{ $bulanNama }} {{ $tahun }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 30%">Nama Laporan</th>
                                <th style="width: 25%">File</th>
                                <th style="width: 25%">Catatan</th>
                                @can('Kepaniteraan Perdata')
                                    <th style="width: 15%">Aksi</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanPerdata->laporan_perdata_detail as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->nama_laporan }}</td>
                                    <td>
                                        @if ($detail->laporan_perdata_path)
                                            <a href="{{ asset('storage/' . $detail->laporan_perdata_path) }}"
                                                target="_blank" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i> Preview
                                            </a>
                                        @else
                                            <span class="badge bg-warning">Belum Ada File</span>
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $detail->catatan ?? '-' }}</td>
                                    @can('Kepaniteraan Perdata')
                                        <td>
                                            {{-- Tombol Edit di dalam tabel --}}
                                            <button type="button" class="btn btn-primary btn-sm btn-edit"
                                                data-id="{{ $detail->id }}" data-nama="{{ $detail->nama_laporan }}"
                                                data-catatan="{{ $detail->catatan }}"
                                                data-file="{{ $detail->laporan_perdata_path }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <!-- Modal Edit Laporan -->
                                            <div class="modal fade" id="editLaporanModal" tabindex="-1"
                                                aria-labelledby="editLaporanLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form id="editForm" method="POST" enctype="multipart/form-data"
                                                            action="{{ route('laporan_perdata.update', $detail->id) }}">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editLaporanLabel">Edit Laporan
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group mb-3">
                                                                    <label for="edit_nama_laporan" class="form-label">Nama
                                                                        Laporan</label>
                                                                    <input type="text" name="edit_nama_laporan"
                                                                        id="edit_nama_laporan" class="form-control"
                                                                        required>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label for="edit_catatan"
                                                                        class="form-label">Catatan</label>
                                                                    <textarea name="edit_catatan" id="edit_catatan" class="form-control" rows="2"></textarea>
                                                                </div>

                                                                <div class="form-group mb-3">
                                                                    <label for="edit_file" class="form-label">Upload File
                                                                        Baru (Opsional)</label>
                                                                    <input type="file" name="laporan_perdata_path"
                                                                        id="edit_file" class="form-control">
                                                                    <small class="text-muted">Kosongkan jika tidak ingin
                                                                        ganti file</small>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <span id="currentFile"></span>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="bi bi-save"></i> Simpan Perubahan
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="{{ route('laporan_perdata.destroy', $detail->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada laporan untuk bulan ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if ($laporanPerdata->laporan_perdata_detail->count() > 0)
                        <div class="mt-3">
                            <a href="{{ route('laporan_perdata.download_all') }}" class="btn btn-success">
                                <i class="bi bi-download"></i> Download Semua Laporan (ZIP)
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Pastikan jQuery & SweetAlert2 sudah di load -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.btn-edit');
            const editModal = new bootstrap.Modal(document.getElementById('editLaporanModal'));
            const editForm = document.getElementById('editForm');

            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const nama = this.dataset.nama;
                    const catatan = this.dataset.catatan;
                    const file = this.dataset.file;

                    // Isi form
                    document.getElementById('edit_nama_laporan').value = nama;
                    document.getElementById('edit_catatan').value = catatan ?? '';
                    document.getElementById('currentFile').innerHTML = file ?
                        `<a href="/storage/${file}" target="_blank" class="badge bg-info">Lihat File Lama</a>` :
                        `<span class="badge bg-warning">Belum ada file</span>`;

                    // Set action form ke route update
                    editForm.action = "{{ url('/dashboard/laporan_perdata/update') }}/" + id;

                    // Tampilkan modal
                    editModal.show();
                });
            });
        });
    </script>

    <script>
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>

</x-layout>
