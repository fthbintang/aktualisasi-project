<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('daftar_laporan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>Edit Laporan</h6>
        </div>
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="jenis_laporan_id" class="form-label">
                        <b>Jenis Laporan</b><span class="text-danger">*</span>
                    </label>
                    <select name="jenis_laporan_id" id="jenis_laporan_id" class="form-select" required>
                        @foreach ($jenisLaporan as $jenis)
                            <option value="{{ $jenis->id }}"
                                {{ $laporan->jenis_laporan_id == $jenis->id ? 'selected' : '' }}>
                                {{ $jenis->nama_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="nama_laporan" class="form-label">
                        <b>Nama Laporan</b><span class="text-danger">*</span>
                    </label>
                    <input type="text" name="nama_laporan" id="nama_laporan" class="form-control"
                        value="{{ old('nama_laporan', $laporan->nama_laporan) }}" required>
                </div>

                <button type="submit" class="btn btn-primary float-end">Update</button>
            </form>
        </div>
    </div>
</x-layout>
