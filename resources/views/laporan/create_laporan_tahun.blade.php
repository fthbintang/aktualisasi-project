{{-- <x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end">
        <a href="{{ route('laporan.index', ['tahun' => $tahun]) }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ end($breadcrumbs) }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan_tahun.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tahun" value="{{ $tahun }}">

                    <div class="row">
                        @foreach ($jenisLaporan as $jenis)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="border rounded p-3 h-100">
                                    <h6 class="fw-bold mb-3">
                                        {{ $jenis->nama_jenis ?? 'Tanpa Jenis' }}
                                    </h6>

                                    @php
                                        $laporanJenis = $laporan->where('jenis_laporan_id', $jenis->id);
                                    @endphp

                                    @forelse ($laporanJenis as $lap)
                                        @php
                                            $isChecked = $laporanTahun->contains(function ($lt) use ($lap, $tahun) {
                                                return $lt->laporan_id == $lap->id && $lt->tahun == $tahun;
                                            });
                                        @endphp

                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="laporan_id[]"
                                                value="{{ $lap->id }}" id="laporan-{{ $lap->id }}"
                                                {{ $isChecked ? 'checked disabled' : '' }}>
                                            <label class="form-check-label" for="laporan-{{ $lap->id }}">
                                                {{ $lap->nama_laporan }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-muted">Tidak ada laporan</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-layout> --}}

<x-layout :breadcrumbs="$breadcrumbs">
    <div class="d-flex justify-content-end">
        <a href="{{ route('laporan.index', ['tahun' => $tahun]) }}" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h5>{{ end($breadcrumbs) }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('laporan_tahun.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tahun" value="{{ $tahun }}">

                    <div class="row">
                        @foreach ($jenisLaporan as $jenis)
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="fw-bold mb-0">
                                            {{ $jenis->nama_jenis ?? 'Tanpa Jenis' }}
                                        </h6>
                                        <div class="form-check m-0">
                                            <input type="checkbox" class="form-check-input pilih-semua"
                                                id="pilih-semua-{{ $jenis->id }}" data-jenis="{{ $jenis->id }}">
                                            <label class="form-check-label small" for="pilih-semua-{{ $jenis->id }}">
                                                Semua
                                            </label>
                                        </div>
                                    </div>

                                    @php
                                        $laporanJenis = $laporan->where('jenis_laporan_id', $jenis->id);
                                    @endphp

                                    @forelse ($laporanJenis as $lap)
                                        @php
                                            $isChecked = $laporanTahun->contains(function ($lt) use ($lap, $tahun) {
                                                return $lt->laporan_id == $lap->id && $lt->tahun == $tahun;
                                            });
                                        @endphp

                                        <div class="form-check mb-2">
                                            <input class="form-check-input laporan-checkbox jenis-{{ $jenis->id }}"
                                                type="checkbox" name="laporan_id[]" value="{{ $lap->id }}"
                                                id="laporan-{{ $lap->id }}"
                                                {{ $isChecked ? 'checked disabled' : '' }}>
                                            <label class="form-check-label" for="laporan-{{ $lap->id }}">
                                                {{ $lap->nama_laporan }}
                                            </label>
                                        </div>
                                    @empty
                                        <p class="text-muted">Tidak ada laporan</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.pilih-semua').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let jenisId = this.getAttribute('data-jenis');
                    let checkboxes = document.querySelectorAll('.jenis-' + jenisId +
                        ':not(:disabled)');
                    checkboxes.forEach(cb => cb.checked = this.checked);
                });
            });
        });
    </script>
</x-layout>
