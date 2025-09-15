<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('arsip_pidana.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('arsip_pidana.update', $arsip_pidana->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @php
                    // Contoh no_berkas: "1.Pid.LL.2025.PN Kmn"
                    $parts = explode('.', $arsip_pidana->no_berkas);
                    $noUrut = $parts[0] ?? '';
                    $jenisPerkara = isset($parts[1], $parts[2]) ? $parts[1] . '.' . $parts[2] : '';
                    $tahunBerkas = $parts[3] ?? date('Y');
                @endphp


                <!-- Jenis Perkara -->
                <div class="mb-3">
                    <label for="jenis_perkara" class="form-label">
                        <b>Jenis Perkara</b><span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('jenis_perkara') is-invalid @enderror" id="jenis_perkara"
                        name="jenis_perkara" required>
                        <option value="" disabled>Pilih Jenis Perkara</option>
                        <option value="Pid.Sus"
                            {{ old('jenis_perkara', $jenisPerkara) == 'Pid.Sus' ? 'selected' : '' }}>Pidana Khusus
                        </option>
                        <option value="Pid.Sus-Anak"
                            {{ old('jenis_perkara', $jenisPerkara) == 'Pid.Sus-Anak' ? 'selected' : '' }}>Pidana Khusus
                            Anak</option>
                        <option value="Pid.B" {{ old('jenis_perkara', $jenisPerkara) == 'Pid.B' ? 'selected' : '' }}>
                            Pidana Biasa</option>
                        <option value="Pid.C" {{ old('jenis_perkara', $jenisPerkara) == 'Pid.C' ? 'selected' : '' }}>
                            Pidana Cepat</option>
                        <option value="Pid.LL" {{ old('jenis_perkara', $jenisPerkara) == 'Pid.LL' ? 'selected' : '' }}>
                            Pidana Lalu Lintas</option>
                        <option value="Pid.Pra"
                            {{ old('jenis_perkara', $jenisPerkara) == 'Pid.Pra' ? 'selected' : '' }}>Pidana Pra
                            Peradilan</option>
                    </select>
                    @error('jenis_perkara')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- No Berkas Terstruktur -->
                <div class="form-group mb-3">
                    <label class="form-label">
                        <b>No Berkas</b><span class="text-danger">*</span>
                    </label>
                    <div class="row g-2">
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
                                value="{{ old('no_berkas', $arsip_pidana->no_berkas) }}">
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
                                {{ old('bulan', $arsip_pidana->bulan) == $b ? 'selected' : '' }}>
                                {{ $b }}
                            </option>
                        @endforeach
                    </select>
                    @error('bulan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- File Arsip Pidana -->
                <div class="mb-3">
                    <label for="arsip_pidana" class="form-label">
                        <b>File Arsip</b> <small class="text-muted">(Kosongkan jika tidak ingin mengganti)</small>
                    </label>
                    <input type="file" name="arsip_pidana" id="arsip_pidana"
                        class="form-control @error('arsip_pidana') is-invalid @enderror">
                    @error('arsip_pidana')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if ($arsip_pidana->arsip_pidana_path)
                        <small class="text-muted">File saat ini:
                            <a href="{{ asset('storage/' . $arsip_pidana->arsip_pidana_path) }}" target="_blank">
                                {{ basename($arsip_pidana->arsip_pidana_path) }}
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
            const jenis = document.getElementById('jenis_perkara').value || '';
            const tahun = document.getElementById('tahun_berkas').value || '';
            const preview = nomor && jenis && tahun ? `${nomor}/${jenis}/${tahun}/PN Kmn` : '';
            document.getElementById('no_berkas_preview').value = preview;
            document.getElementById('no_berkas_hidden').value = preview;
        }

        document.getElementById('no_urut').addEventListener('input', updateNoBerkasPreview);
        document.getElementById('tahun_berkas').addEventListener('input', updateNoBerkasPreview);
        document.getElementById('jenis_perkara').addEventListener('change', updateNoBerkasPreview);

        // Inisialisasi preview saat halaman load
        updateNoBerkasPreview();
    </script>
</x-layout>
