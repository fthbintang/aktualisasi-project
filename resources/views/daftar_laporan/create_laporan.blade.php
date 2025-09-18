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

                {{-- Periode Upload --}}
                <div class="form-group mb-3">
                    <label for="periode_upload" class="form-label">
                        <b>Periode Upload</b>
                    </label>
                    <select name="periode_upload" id="periode_upload"
                        class="form-select @error('periode_upload') is-invalid @enderror">
                        <option value="">-- Pilih Periode --</option>
                        <option value="Bulanan" {{ old('periode_upload') == 'Bulanan' ? 'selected' : '' }}>Bulanan
                        </option>
                        <option value="Triwulan" {{ old('periode_upload') == 'Triwulan' ? 'selected' : '' }}>Triwulan
                        </option>
                        <option value="Semester" {{ old('periode_upload') == 'Semester' ? 'selected' : '' }}>Semester
                        </option>
                        <option value="Tahunan" {{ old('periode_upload') == 'Tahunan' ? 'selected' : '' }}>Tahunan
                        </option>
                    </select>
                    @error('periode_upload')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Bulan Wajib Upload --}}
                <div class="form-group mb-3">
                    <label class="form-label">
                        <b>Bulan Wajib Upload</b><span class="text-danger">*</span>
                    </label>
                    <div class="row">
                        @php
                            $bulanList = [
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ];
                            $oldBulan = old('bulan_wajib', []);

                            // Bagi menjadi grup isi 3 bulan
                            $bulanChunks = array_chunk($bulanList, 3, true);
                        @endphp

                        @foreach ($bulanChunks as $chunk)
                            <div class="col-md-3 col-6">
                                @foreach ($chunk as $num => $nama)
                                    <div class="form-check">
                                        <input class="form-check-input bulan-checkbox" type="checkbox"
                                            name="bulan_wajib[]" value="{{ $num }}"
                                            id="bulan_{{ $num }}"
                                            {{ in_array($num, $oldBulan) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bulan_{{ $num }}">
                                            {{ $nama }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    @error('bulan_wajib')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary float-end">Tambah Laporan</button>
            </form>
        </div>
    </div>
</x-layout>

{{-- Script untuk auto-check bulan --}}
<script>
    document.getElementById('periode_upload').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.bulan-checkbox');
        checkboxes.forEach(cb => cb.checked = false); // reset dulu

        let selected = this.value;
        let bulanToCheck = [];

        if (selected === "Bulanan") {
            bulanToCheck = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        } else if (selected === "Triwulan") {
            bulanToCheck = [3, 6, 9, 12];
        } else if (selected === "Semester") {
            bulanToCheck = [6, 12];
        } else if (selected === "Tahunan") {
            bulanToCheck = [12];
        }

        bulanToCheck.forEach(num => {
            let cb = document.getElementById('bulan_' + num);
            if (cb) cb.checked = true;
        });
    });
</script>
