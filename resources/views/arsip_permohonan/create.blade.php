<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('arsip_permohonan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- No Berkas Terstruktur -->
                <div class="form-group mb-3">
                    <label class="form-label">
                        <b>No Berkas</b><span class="text-danger">*</span>
                    </label>
                    <div class="row g-2">
                        <!-- Nomor Urut -->
                        <div class="col-3">
                            <input type="number" name="no_urut" id="no_urut"
                                class="form-control @error('no_urut') is-invalid @enderror" placeholder="No"
                                value="{{ old('no_urut') }}" required>
                            @error('no_urut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div class="col-3">
                            <input type="number" name="tahun_berkas" id="tahun_berkas"
                                class="form-control @error('tahun_berkas') is-invalid @enderror" placeholder="Tahun"
                                value="{{ old('tahun_berkas', date('Y')) }}" required>
                            @error('tahun_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Format -->
                        <div class="col-6">
                            <input type="text" id="no_berkas_preview" class="form-control" name="no_berkas" disabled
                                value="{{ old('no_berkas_preview', '') }}">
                        </div>
                    </div>
                </div>

                <!-- Bulan -->
                <div class="mb-3">
                    <label for="bulan" class="form-label">
                        <b>Bulan</b><span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('bulan') is-invalid @enderror" id="bulan" name="bulan"
                        required>
                        <option value="" disabled {{ old('bulan') ? '' : 'selected' }}>Pilih Bulan</option>
                        @php
                            $bulanIndo = [
                                'Januari',
                                'Februari',
                                'Maret',
                                'April',
                                'Mei',
                                'Juni',
                                'Juli',
                                'Agustus',
                                'September',
                                'Oktober',
                                'November',
                                'Desember',
                            ];
                        @endphp
                        @foreach ($bulanIndo as $b)
                            <option value="{{ $b }}" {{ old('bulan') == $b ? 'selected' : '' }}>
                                {{ $b }}</option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Cover -->
                <div class="mb-3">
                    <label for="foto_cover" class="form-label">
                        <b>Foto Cover</b><span class="text-danger">*</span>
                    </label>
                    <input type="file" name="foto_cover" id="foto_cover"
                        class="form-control @error('foto_cover') is-invalid @enderror" required>
                    @error('foto_cover')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Foto Checklist -->
                <div class="mb-3">
                    <label for="foto_checklist" class="form-label">
                        <b>Foto Checklist</b><span class="text-danger">*</span>
                    </label>
                    <input type="file" name="foto_checklist" id="foto_checklist"
                        class="form-control @error('foto_checklist') is-invalid @enderror" required>
                    @error('foto_checklist')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-end">Tambah Arsip</button>
            </form>
        </div>
    </div>

    <script>
        function updateNoBerkasPreview() {
            const nomor = document.getElementById('no_urut').value || '';
            const tahun = document.getElementById('tahun_berkas').value || '';
            const preview = nomor && tahun ? `${nomor}.Pdt.G.${tahun}.PN Kmn` : '';
            document.getElementById('no_berkas_preview').value = preview;
        }

        document.getElementById('no_urut').addEventListener('input', updateNoBerkasPreview);
        document.getElementById('tahun_berkas').addEventListener('input', updateNoBerkasPreview);
        updateNoBerkasPreview();
    </script>
</x-layout>
