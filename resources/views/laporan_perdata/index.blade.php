<x-layout :breadcrumbs="$breadcrumbs">
    <div class="page-heading ms-3">
        <h3 class="text-white">Upload Laporan Perdata Bulanan</h3>
        <p class="text-white">Pilih bulan & tahun, lalu upload laporan perdata yang akan dikirim ke hukum.</p>
    </div>


    <div class="page-content">
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
                            class="form-control @error('nama_laporan') is-invalid @enderror"
                            placeholder="Nama Laporan..." value="{{ old('nama_laporan') }}" required>
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
                                <th style="width: 15%">Aksi</th>
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
                                    <td>{{ $detail->catatan ?? '-' }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="#" method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin hapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada laporan untuk bulan ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
