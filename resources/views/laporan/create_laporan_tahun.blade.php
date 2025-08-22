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
                    <div class="mb-3">
                        @foreach ($laporan as $lap)
                            @php
                                // Cek apakah laporan ini sudah ada di laporan_tahun untuk tahun yang dipilih
                                $isChecked = $laporanTahun->contains(function ($lt) use ($lap, $tahun) {
                                    return $lt->laporan_id == $lap->id && $lt->tahun == $tahun;
                                });
                            @endphp
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="laporan_id[]"
                                    value="{{ $lap->id }}" id="laporan-{{ $lap->id }}"
                                    {{ $isChecked ? 'checked disabled' : '' }}>
                                <label class="form-check-label" for="laporan-{{ $lap->id }}">
                                    {{ $lap->nama_laporan }}
                                    ({{ optional($lap->jenis_laporan)->nama_jenis ?? 'Tanpa Jenis' }})
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>
