<x-layout :breadcrumbs="$breadcrumbs">
    <div class="container-fluid py-4">

        {{-- Form Filter Tahun --}}
        <div class="card mb-4">
            <div class="card-body">
                <form id="filterForm" method="GET" action="#" class="d-flex align-items-center gap-3">
                    <label for="tahun" class="form-label fw-bold mb-0">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select" style="width: 150px;"
                        onchange="this.form.submit()">
                        @php
                            $currentYear = date('Y');
                        @endphp
                        @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </form>
            </div>
        </div>

        {{-- Tabel Laporan Visible --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Laporan Aktif</h5>
            </div>
            <div class="card-body">
                @if ($laporanVisible->count() > 0)
                    @php $colspan = 2 + 12; @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Laporan</th>
                                    <th class="text-center">Tampilkan?</th>
                                    @foreach (range(1, 12) as $month)
                                        <th class="text-center">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanVisible as $jenisId => $laporanGroup)
                                    <tr class="table-active">
                                        <th colspan="{{ $colspan }}" class="text-start">
                                            {{ optional($jenisLaporan->firstWhere('id', $jenisId))->nama_jenis ?? 'Tanpa Jenis' }}
                                        </th>
                                    </tr>
                                    @foreach ($laporanGroup as $laporan)
                                        <tr id="row-laporan-{{ $laporan->id }}">
                                            <td>{{ $laporan->nama_laporan }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('laporan.toggle', $laporan->id) }}"
                                                    method="POST" class="preserve-anchor"
                                                    data-anchor="row-laporan-{{ $laporan->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="form-check form-switch d-flex justify-content-center">
                                                        <input class="form-check-input" type="checkbox"
                                                            onchange="this.form.submit()" checked>
                                                    </div>
                                                </form>
                                            </td>

                                            {{-- Kolom Bulan --}}
                                            @foreach (range(1, 12) as $month)
                                                @php $uploaded = $laporan->upload_laporan->firstWhere('bulan', $month); @endphp
                                                <td class="text-center">
                                                    @if ($uploaded)
                                                        <span class="bg-success text-white px-2 py-1 rounded">✔</span>
                                                    @else
                                                        {{-- Tanda merah yang bisa diklik untuk upload --}}
                                                        <form action="#" method="POST"
                                                            enctype="multipart/form-data" class="preserve-anchor"
                                                            data-anchor="row-laporan-{{ $laporan->id }}">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $month }}">
                                                            <input type="file" name="file_laporan"
                                                                style="display:none" onchange="this.form.submit()"
                                                                id="file-upload-{{ $laporan->id }}-{{ $month }}">
                                                            <span class="text-danger fw-bold" style="cursor:pointer;"
                                                                onclick="document.getElementById('file-upload-{{ $laporan->id }}-{{ $month }}').click()">–</span>
                                                        </form>
                                                    @endif
                                                </td>
                                            @endforeach

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Tidak ada laporan aktif.</div>
                @endif
            </div>
        </div>

        {{-- Tabel Laporan Hidden --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Laporan Disembunyikan</h5>
            </div>
            <div class="card-body">
                @if ($laporanHidden->count() > 0)
                    @php $colspan = 2 + 12; @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Laporan</th>
                                    <th class="text-center">Tampilkan Kembali?</th>
                                    @foreach (range(1, 12) as $month)
                                        <th class="text-center">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanHidden as $jenisId => $laporanGroup)
                                    <tr class="table-active">
                                        <th colspan="{{ $colspan }}" class="text-start">
                                            {{ optional($jenisLaporan->firstWhere('id', $jenisId))->nama_jenis ?? 'Tanpa Jenis' }}
                                        </th>
                                    </tr>
                                    @foreach ($laporanGroup as $laporan)
                                        <tr class="table-secondary" id="row-laporan-{{ $laporan->id }}">
                                            <td>{{ $laporan->nama_laporan }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('laporan.toggle', $laporan->id) }}"
                                                    method="POST" class="preserve-anchor"
                                                    data-anchor="row-laporan-{{ $laporan->id }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-success btn-sm">Tampilkan</button>
                                                </form>
                                            </td>

                                            {{-- Kolom Bulan --}}
                                            @foreach (range(1, 12) as $month)
                                                @php $uploaded = $laporan->upload_laporan->firstWhere('bulan', $month); @endphp
                                                <td class="text-center">
                                                    @if ($uploaded)
                                                        <span class="bg-success text-white px-2 py-1 rounded">✔</span>
                                                    @else
                                                        <form action="#" method="POST"
                                                            enctype="multipart/form-data" class="preserve-anchor"
                                                            data-anchor="row-laporan-{{ $laporan->id }}">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $month }}">
                                                            <input type="file" name="file_laporan"
                                                                style="display:none" onchange="this.form.submit()"
                                                                id="file-upload-hidden-{{ $laporan->id }}-{{ $month }}">
                                                            <span class="text-danger fw-bold" style="cursor:pointer;"
                                                                onclick="document.getElementById('file-upload-hidden-{{ $laporan->id }}-{{ $month }}').click()">–</span>
                                                        </form>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Tidak ada laporan disembunyikan.</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Script untuk preserve posisi scroll/anchor --}}
    <script>
        (function() {
            document.addEventListener('submit', function(e) {
                const form = e.target;
                const anchorId = form?.dataset?.anchor;
                if (anchorId) {
                    sessionStorage.setItem('laporan-anchor-id', anchorId);
                } else {
                    sessionStorage.setItem('laporan-scroll-y', String(window.scrollY));
                }
            }, true);

            window.addEventListener('load', function() {
                const anchorId = sessionStorage.getItem('laporan-anchor-id');
                if (anchorId) {
                    const el = document.getElementById(anchorId);
                    if (el) {
                        el.scrollIntoView({
                            behavior: 'auto',
                            block: 'center'
                        });
                    }
                    sessionStorage.removeItem('laporan-anchor-id');
                    return;
                }
                const y = sessionStorage.getItem('laporan-scroll-y');
                if (y !== null) {
                    window.scrollTo(0, parseInt(y, 10));
                    sessionStorage.removeItem('laporan-scroll-y');
                }
            });
        })();
    </script>
</x-layout>
