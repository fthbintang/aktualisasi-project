<x-layout :breadcrumbs="$breadcrumbs">
    <div class="container-fluid py-4">

        {{-- Form Filter Tahun --}}
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <form id="filterForm" method="GET" action="#" class="d-flex align-items-center gap-3">
                    <label for="tahun" class="form-label fw-bold mb-0">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select" style="width: 150px;"
                        onchange="this.form.submit()">
                        @php $currentYear = date('Y'); @endphp
                        @for ($year = $currentYear; $year >= $currentYear - 5; $year--)
                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                </form>

                {{-- Tombol tambah laporan --}}
                <a href="{{ route('laporan_tahun.create', ['tahun' => $tahun]) }}" class="btn btn-primary">
                    Tambah Laporan Tahun Ini
                </a>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        @php
            $bulanIndo = [
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
        @endphp

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Daftar Laporan</h5>
            </div>
            <div class="card-body">
                @if ($laporanGrouped->count() > 0)
                    @php $colspan = 2 + 12; @endphp
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead>
                                <tr>
                                    <th>Nama Laporan</th>
                                    @foreach (range(1, 12) as $month)
                                        <th class="text-center">{{ $bulanIndo[$month] }}</th>
                                    @endforeach
                                    <th class="text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporanGrouped as $jenisId => $laporanGroup)
                                    <tr class="table-active">
                                        <th colspan="{{ $colspan + 1 }}">
                                            {{ optional($jenisLaporan->firstWhere('id', $jenisId))->nama_jenis ?? 'Tanpa Jenis' }}
                                        </th>
                                    </tr>
                                    @foreach ($laporanGroup as $lt)
                                        @php
                                            $laporan = $lt->laporan;

                                            // Ambil bulan wajib dari field JSON/relasi (diasumsikan tersimpan di laporan->bulan_wajib)
                                            // Kalau masih string, ubah jadi array
                                            $bulanWajib = is_array($laporan->bulan_wajib)
                                                ? $laporan->bulan_wajib
                                                : json_decode($laporan->bulan_wajib, true) ?? [];

                                            $warna = 'bg-secondary-subtle'; // warna abu-abu
                                        @endphp
                                        <tr id="row-laporan-{{ $laporan->id }}">
                                            <td>
                                                {{ $laporan->nama_laporan }}
                                                @if ($laporan->periode_upload)
                                                    <br><small
                                                        class="text-muted">({{ ucfirst($laporan->periode_upload) }})</small>
                                                @endif
                                            </td>

                                            {{-- Kolom Bulan --}}
                                            @foreach (range(1, 12) as $month)
                                                @php
                                                    $uploaded = $lt->upload_laporan->firstWhere('bulan', $month);
                                                    $isWajib = in_array($month, $bulanWajib);
                                                @endphp
                                                <td class="text-center {{ $isWajib ? $warna : '' }}">
                                                    @if ($uploaded)
                                                        <!-- Ikon centang -->
                                                        <span class="bg-success text-white px-2 py-1 rounded"
                                                            style="cursor:pointer;" data-bs-toggle="modal"
                                                            data-bs-target="#modalLaporan-{{ $laporan->id }}-{{ $month }}">
                                                            ✔
                                                        </span>

                                                        <!-- Modal sama seperti sebelumnya -->
                                                        <div class="modal fade"
                                                            id="modalLaporan-{{ $laporan->id }}-{{ $month }}"
                                                            tabindex="-1"
                                                            aria-labelledby="modalLabel-{{ $laporan->id }}-{{ $month }}"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="modalLabel-{{ $laporan->id }}-{{ $month }}">
                                                                            Aksi Laporan Bulan {{ $bulanIndo[$month] }}
                                                                        </h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Tutup"></button>
                                                                    </div>
                                                                    <div class="modal-body text-center">
                                                                        @if ($uploaded)
                                                                            <a href="{{ asset('storage/' . $uploaded->laporan_path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-primary w-100 mb-2">
                                                                                Preview Laporan
                                                                            </a>
                                                                        @endif

                                                                        <form
                                                                            action="{{ route('upload_laporan.update', $uploaded->id) }}"
                                                                            method="POST" enctype="multipart/form-data"
                                                                            class="w-100 mb-2">
                                                                            @csrf
                                                                            @method('PUT')
                                                                            <input type="file" name="file_laporan"
                                                                                style="display:none"
                                                                                onchange="this.form.submit()"
                                                                                id="file-edit-{{ $laporan->id }}-{{ $month }}">
                                                                            <button type="button"
                                                                                class="btn btn-warning w-100"
                                                                                onclick="document.getElementById('file-edit-{{ $laporan->id }}-{{ $month }}').click()">
                                                                                Edit Unggahan
                                                                            </button>
                                                                        </form>

                                                                        <form
                                                                            action="{{ route('upload_laporan.delete', $uploaded->id) }}"
                                                                            method="POST" class="w-100 form-delete">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="button"
                                                                                class="btn btn-danger w-100 btn-delete">
                                                                                Hapus Unggahan
                                                                            </button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        @if ($isWajib)
                                                            <!-- Jika bulan wajib tapi belum ada upload -->
                                                            <form action="{{ route('upload_laporan.store') }}"
                                                                method="POST" enctype="multipart/form-data"
                                                                class="preserve-anchor d-inline"
                                                                data-anchor="row-laporan-{{ $laporan->id }}">
                                                                @csrf
                                                                <input type="hidden" name="bulan"
                                                                    value="{{ $month }}">
                                                                <input type="hidden" name="laporan_tahun_id"
                                                                    value="{{ $lt->id }}">
                                                                <input type="file" name="file_laporan"
                                                                    style="display:none" onchange="this.form.submit()"
                                                                    id="file-upload-{{ $laporan->id }}-{{ $month }}">
                                                                <button type="button"
                                                                    class="btn btn-sm btn-primary rounded-circle shadow-sm"
                                                                    style="width:32px; height:32px; padding:0;"
                                                                    title="Upload Laporan"
                                                                    onclick="document.getElementById('file-upload-{{ $laporan->id }}-{{ $month }}').click()">
                                                                    <i class="bi bi-upload fs-5"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endforeach

                                            {{-- Kolom Hapus --}}
                                            <td class="text-center">
                                                <form
                                                    action="{{ route('laporan_tahun.destroy', [$laporan->id, $tahun]) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">Tidak ada laporan.</div>
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

    {{-- SCRIPT DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-layout>
