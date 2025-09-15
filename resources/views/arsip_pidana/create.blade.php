<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('arsip_gugatan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
    <div class="card">
        <div class="card-header pb-0">
            <h6>{{ end($breadcrumbs) }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('arsip_pidana.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Jenis Perkara -->
                <div class="mb-3">
                    <label for="jenis_perkara" class="form-label">
                        <b>Jenis Perkara</b><span class="text-danger">*</span>
                    </label>
                    <select class="form-select @error('jenis_perkara') is-invalid @enderror" id="jenis_perkara"
                        name="jenis_perkara" required>
                        <option value="" disabled selected>Pilih Jenis Perkara</option>
                        <option value="Pid.Sus">Pidana Khusus</option>
                        <option value="Pid.Sus-Anak">Pidana Khusus Anak</option>
                        <option value="Pid.B">Pidana Biasa</option>
                        <option value="Pid.C">Pidana Cepat</option>
                        <option value="Pid.LL">Pidana Lalu Lintas</option>
                        <option value="Pid.Pra">Pidana Pra Peradilan</option>
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
                                class="form-control @error('no_urut') is-invalid @enderror" placeholder="No"
                                value="{{ old('no_urut') }}" disabled required>
                            @error('no_urut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tahun -->
                        <div class="col-3">
                            <input type="number" name="tahun_berkas" id="tahun_berkas"
                                class="form-control @error('tahun_berkas') is-invalid @enderror" placeholder="Tahun"
                                value="{{ old('tahun_berkas', date('Y')) }}" disabled required>
                            @error('tahun_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Preview Format -->
                        <div class="col-6">
                            <input type="text" id="no_berkas_preview" class="form-control" disabled>
                            <!-- Hidden input untuk dikirim ke server -->
                            <input type="hidden" name="no_berkas" id="no_berkas_hidden" value="{{ old('no_berkas') }}">
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

                <!-- File Arsip Pidana -->
                <div class="mb-3">
                    <label for="arsip_pidana" class="form-label">
                        <b>File Arsip</b><span class="text-danger">*</span>
                    </label>
                    <input type="file" name="arsip_pidana" id="arsip_pidana"
                        class="form-control @error('arsip_pidana') is-invalid @enderror" required>
                    @error('arsip_pidana')
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
            const jenis = document.getElementById('jenis_perkara').value || '';

            let preview = '';
            if (nomor && tahun && jenis) {
                preview = `${nomor}/${jenis}/${tahun}/PN Kmn`;
            }

            document.getElementById('no_berkas_preview').value = preview;
            document.getElementById('no_berkas_hidden').value = preview;
        }

        // Enable input ketika jenis perkara dipilih
        document.getElementById('jenis_perkara').addEventListener('change', function() {
            document.getElementById('no_urut').disabled = false;
            document.getElementById('tahun_berkas').disabled = false;
            updateNoBerkasPreview();
        });

        document.getElementById('no_urut').addEventListener('input', updateNoBerkasPreview);
        document.getElementById('tahun_berkas').addEventListener('input', updateNoBerkasPreview);
    </script>
</x-layout>
