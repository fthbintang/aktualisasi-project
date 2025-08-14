<x-layout :breadcrumbs="$breadcrumbs">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Laporan</h5>

                        {{-- Filter Tahun + Upload Button --}}
                        <div class="d-flex align-items-center gap-2">
                            {{-- Filter Tahun --}}
                            <form id="filterForm" method="GET" action="#" class="d-flex align-items-center mb-2">
                                <label for="tahun" class="form-label fw-bold mb-0 me-2">Tahun</label>
                                <select name="tahun" id="tahun" class="form-select"
                                    style="width: 150px; height: 38px;" onchange="this.form.submit()">
                                    @php
                                        $currentYear = date('Y');
                                    @endphp
                                    @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                                        <option value="{{ $year }}"
                                            {{ request('tahun') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </form>

                            {{-- Button Upload Laporan --}}
                            <a href="#" class="btn btn-primary mt-2">
                                Upload Laporan
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        {{-- Tabel Laporan (dengan pemisah per Jenis Laporan) --}}
                        @if (!empty($dataLaporan) && count($dataLaporan) > 0)
                            @php
                                // Kelompokkan data laporan berdasarkan jenis_laporan_id
                                $grouped = collect($dataLaporan)->groupBy('jenis_laporan_id');
                                $colspan = 1 + 12; // 1 kolom "Nama Laporan" + 12 bulan
                            @endphp

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nama Laporan</th>
                                            @foreach (range(1, 12) as $month)
                                                <th class="text-center">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($grouped as $jenisId => $laporanGroup)
                                            {{-- Baris pemisah: judul jenis laporan --}}
                                            <tr class="table-active">
                                                <th colspan="{{ $colspan }}" class="text-start">
                                                    {{ optional($jenisLaporan->firstWhere('id', $jenisId))->nama_jenis ?? 'Tanpa Jenis' }}
                                                </th>
                                            </tr>

                                            {{-- Baris laporan di bawah jenis terkait --}}
                                            @foreach ($laporanGroup as $laporan)
                                                <tr>
                                                    <td>{{ $laporan->nama_laporan }}</td>
                                                    @foreach (range(1, 12) as $month)
                                                        @php
                                                            // Asumsi: relasi upload_laporan sudah di-eager load dan difilter tahun di controller
                                                            $uploaded = $laporan->upload_laporan->firstWhere(
                                                                'bulan',
                                                                $month,
                                                            );
                                                        @endphp
                                                        @if ($uploaded)
                                                            <td class="text-center bg-success text-white">✔</td>
                                                        @else
                                                            <td class="text-center bg-danger text-white">–</td>
                                                        @endif
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mt-4">
                                Silakan pilih tahun dan jenis laporan untuk melihat data.
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
