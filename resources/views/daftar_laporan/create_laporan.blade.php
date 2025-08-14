<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('daftar_laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>

        <div class="card-body">
            <form action="{{ route('daftar_laporan.store_laporan') }}" method="POST">
                @csrf

                {{-- Pilih Jenis Laporan --}}
                <div class="form-group mb-3">
                    <label for="jenis_laporan_id" class="form-label">
                        <b>Jenis Laporan</b><span class="text-danger">*</span>
                    </label>
                    <select name="jenis_laporan_id" id="jenis_laporan_id"
                        class="form-select @error('jenis_laporan_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Laporan --</option>
                        @foreach ($jenisLaporan as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ old('jenis_laporan_id') == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                    @error('jenis_laporan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nama Laporan --}}
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

                <button type="submit" class="btn btn-primary float-end">Tambah Laporan</button>
            </form>
        </div>
    </div>
</x-layout>
