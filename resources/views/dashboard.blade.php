<x-layout>
    <div class="page-heading">
        <h3>Dashboard - {{ $bulanSekarang }}</h3>
    </div>

    {{-- Baris 1: Ringkasan Arsip --}}
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>Arsip Permohonan</h5>
                    <h2>{{ $arsip['permohonan'] }}</h2>
                    <small>Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>Arsip Gugatan</h5>
                    <h2>{{ $arsip['gugatan'] }}</h2>
                    <small>Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5>Arsip Pidana</h5>
                    <h2>{{ $arsip['pidana'] }}</h2>
                    <small>Bulan {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Baris 2: Status Upload --}}
    @canany(['Admin', 'Staff Kepaniteraan Hukum'])
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Status Upload Laporan - {{ $bulanSekarang }}</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 70%">Jenis Laporan</th>
                                    <th style="width: 30%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($statusUpload as $laporan => $status)
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', $laporan)) }}</td>
                                        <td>
                                            @if ($status)
                                                <span class="badge bg-success">Lengkap</span>
                                            @else
                                                <span class="badge bg-danger">Belum Lengkap</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Belum ada data laporan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endcanany

    {{-- Baris 3: Grafik --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Arsip Permohonan per Bulan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        <i class="bi bi-info-circle"></i>
                        Grafik ini menampilkan jumlah <b>permohonan</b> yang masuk dan diarsipkan
                        pada setiap bulan, sehingga memudahkan pemantauan tren permohonan dari waktu ke waktu.
                    </p>
                    <canvas id="permohonanChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Arsip Gugatan per Bulan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Grafik ini menampilkan jumlah <b>gugatan</b> yang masuk dan diarsipkan pada setiap bulan, untuk
                        memantau tren perkara gugatan secara berkala.
                    </p>
                    <canvas id="gugatanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Arsip Pidana per Bulan</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">
                        <i class="bi bi-info-circle"></i>
                        Grafik ini menampilkan jumlah <b>pidana</b> yang masuk dan diarsipkan pada setiap bulan, untuk
                        memantau tren perkara pidana secara berkala.
                    </p>
                    <canvas id="pidanaChart"></canvas>
                </div>
            </div>
        </div>

        @canany(['Admin', 'Staff Kepaniteraan Hukum', 'Panitera', 'Ketua PN'])
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Kepatuhan Laporan Kepaniteraan Hukum</h5>
                    </div>
                    <div class="card-body pb-0">
                        <p class="text-muted">
                            <i class="bi bi-info-circle"></i>
                            Kepatuhan di sini menggambarkan sejauh mana laporan yang seharusnya dibuat
                            oleh <b>Kepaniteraan Hukum</b> benar-benar telah dibuat dan diserahkan sesuai ketentuan.
                        </p>
                        <canvas id="kepatuhanChart"></canvas>
                    </div>
                </div>
            </div>
        @endcanany
    </div>

    {{-- ChartJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labelsBulan);

        const kepUploaded = @json($kepUploadedCounts); // jumlah upload tiap bulan
        const kepTotal = @json($kepTotalRequired); // jumlah laporan wajib tiap bulan

        new Chart(document.getElementById('permohonanChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Permohonan',
                    data: @json($grafikPermohonan),
                    borderColor: 'blue',
                    backgroundColor: 'rgba(54,162,235,0.2)',
                    fill: true,
                    tension: 0.3
                }]
            }
        });

        new Chart(document.getElementById('gugatanChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gugatan',
                    data: @json($grafikGugatan),
                    borderColor: 'green',
                    backgroundColor: 'rgba(75,192,192,0.2)',
                    fill: true
                }]
            }
        });

        new Chart(document.getElementById('pidanaChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pidana',
                    data: @json($grafikPidana),
                    borderColor: 'red',
                    backgroundColor: 'rgba(255,99,132,0.2)',
                    fill: true
                }]
            }
        });

        new Chart(document.getElementById('kepatuhanChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Kepatuhan (%)',
                    data: @json($grafikKepatuhan),
                    backgroundColor: 'rgba(153,102,255,0.7)',
                }]
            },
            options: {
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const idx = context.dataIndex;
                                const percent = context.parsed.y;
                                const uploaded = kepUploaded[idx] ?? 0;
                                const total = kepTotal[idx] ?? 0;
                                if (total === 0) {
                                    return 'Tidak ada laporan wajib';
                                }
                                return percent + '% (' + uploaded + '/' + total + ' laporan)';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        min: 0,
                        max: 100
                    }
                }
            }
        });
    </script>

</x-layout>
