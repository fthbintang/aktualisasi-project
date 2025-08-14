<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('daftar_laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>Edit Jenis Laporan</h6>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="nama_jenis" class="form-label">
                        <b>Nama Jenis</b><span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_jenis" id="nama_jenis" class="form-control"
                        value="{{ old('nama_jenis', $jenis->nama_jenis) }}" required>
                </div>
                <button type="submit" class="btn btn-primary float-end">Update</button>
            </form>
        </div>
    </div>
</x-layout>
