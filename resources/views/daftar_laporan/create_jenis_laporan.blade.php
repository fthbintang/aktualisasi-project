<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('daftar_laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="nama_jenis" class="form-label">
                        <b>Nama Jenis</b><span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_jenis" id="nama_jenis"
                        class="form-control @error('nama_jenis') is-invalid @enderror" placeholder="Nama Jenis..."
                        value="{{ old('nama_jenis') }}" required>
                    @error('nama_jenis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-end">Tambah Jenis Laporan</button>
            </form>

        </div>
    </div>
</x-layout>
