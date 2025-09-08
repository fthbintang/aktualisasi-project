<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('arsip_gugatan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('arsip_gugatan.update', $arsip_gugatan->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- No Berkas Terstruktur -->
                <div class="form-group mb-3">
                    <label class="form-label">
                        <b>No Berkas</b><span class="text-danger">*</span>
                    </label>
                    <div class="row g-2">
                        @php
                            // pecah no_berkas: "123.Pdt.G.2024.PN Kmn"
                            $parts = explode('.', $arsip_gugatan->no_berkas);
                            $noUrut = $parts[0] ?? '';
                            $tahunBerkas = $parts[3] ?? date('Y');
                        @endphp

                        <!-- Nomor Urut -->
                        <div class="col-3">
                            <input type="number" name="no_urut" id="no_urut"
                                class="form-control @error('no_urut') is-invalid @enderror"
                                value="{{ old('no_urut', $noUrut) }}" required>
                            @error('no_urut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div class="col-3">
                            <input type="number" name="tahun_berkas" id="tahun_berkas"
                                class="form-control @error('tahun_berkas') is-invalid @enderror"
                                value="{{ old('tahun_berkas', $tahunBerkas) }}" required>
                            @error('tahun_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Format -->
                        <div class="col-6">
                            <input type="text" id="no_berkas_preview" class="form-control" disabled>
                            <input type="hidden" name="no_berkas" id="no_berkas_hidden"
                                value="{{ old('no_berkas', $arsip_gugatan->no_berkas) }}">
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
                        <option value="" disabled>Pilih Bulan</option>
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
                            <option value="{{ $b }}"
                                {{ old('bulan', $arsip_gugatan->bulan) == $b ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- File Arsip Gugatan -->
                <div class="mb-3">
                    <label for="arsip_gugatan" class="form-label">
                        <b>File Arsip</b> <small class="text-muted">(Kosongkan jika tidak ingin mengganti)</small>
                    </label>
                    <input type="file" name="arsip_gugatan" id="arsip_gugatan"
                        class="form-control @error('arsip_gugatan') is-invalid @enderror">
                    @error('arsip_gugatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($arsip_gugatan->arsip_gugatan_path)
                        <small class="text-muted">File saat ini:
                            <a href="{{ asset('storage/' . $arsip_gugatan->arsip_gugatan_path) }}" target="_blank">
                                {{ basename($arsip_gugatan->arsip_gugatan_path) }}
                            </a>
                        </small>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary float-end">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        function updateNoBerkasPreview() {
            const nomor = document.getElementById('no_urut').value || '';
            const tahun = document.getElementById('tahun_berkas').value || '';
            const preview = nomor && tahun ? `${nomor}.Pdt.G.${tahun}.PN Kmn` : '';
            document.getElementById('no_berkas_preview').value = preview;
            document.getElementById('no_berkas_hidden').value = preview;
        }

        document.getElementById('no_urut').addEventListener('input', updateNoBerkasPreview);
        document.getElementById('tahun_berkas').addEventListener('input', updateNoBerkasPreview);

        // Inisialisasi preview saat halaman load
        updateNoBerkasPreview();
    </script>
</x-layout>
