<x-layout title="Dashboard">
    <div class="row">
        <!-- Total Laporan Bulan Ini -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="mb-0 text-uppercase font-weight-bold" style="font-size: 0.75rem;">Total
                                    Laporan
                                    Bulan Ini</p>
                                <h5 class="font-weight-bolder">
                                    34 Laporan
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                <i class="ni ni-single-copy-04 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kosong / Placeholder -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <div class="numbers">
                                    <p class="mb-0 text-uppercase font-weight-bold" style="font-size: 0.60rem;">Minutasi
                                        Permohonan Bulan Ini
                                    </p>
                                    <h5 class="font-weight-bolder">
                                        5 Permohonan
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div
                                class="icon icon-shape bg-gradient-secondary shadow-secondary text-center rounded-circle">
                                <i class="ni ni-chart-bar-32 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Putusan Dikirim -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="mb-0 text-uppercase font-weight-bold" style="font-size: 0.75rem;">Minutasi
                                    Perkara Gugatan
                                    Bulan Ini
                                </p>
                                <h5 class="font-weight-bolder">
                                    5 Perkara
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                <i class="ni ni-send text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Minutasi Bulan Ini -->
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="mb-0 text-uppercase font-weight-bold" style="font-size: 0.75rem;">Minutasi
                                    Perkara Pidana Bulan
                                    Ini</p>
                                <h5 class="font-weight-bolder">
                                    2 Perkara
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                <i class="ni ni-archive-2 text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card z-index-2 h-100">
                <div class="card-header pb-0 pt-3 bg-transparent">
                    <h6 class="text-capitalize">Statistik laporan yang Dibuat</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-arrow-up text-success"></i>
                        <span class="font-weight-bold">Selama 12 Bulan Terakhir</span>
                    </p>
                </div>
                <div class="card-body p-3">
                    <div class="chart">
                        <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card card-carousel overflow-hidden h-100 p-0">
                <div id="carouselExampleCaptions" class="carousel slide h-100" data-bs-ride="carousel">
                    <div class="carousel-inner border-radius-lg h-100">
                        <div class="carousel-item h-100 active"
                            style="background-image: url('/assets/img/carousel-pn_kaimana.png'); background-size: cover;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-camera-compact text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-white mb-1">Pengadilan Negeri Kaimana</h5>
                                <p>Mewujudkan peradilan yang agung melalui pelayanan yang cepat, transparan, dan
                                    profesional.</p>
                            </div>
                        </div>
                        <div class="carousel-item h-100"
                            style="background-image: url('/assets/img/carousel-pn_kaimana-2.png'); background-size: cover;">
                            <div class="carousel-caption d-none d-md-block bottom-0 text-start start-0 ms-5">
                                <div class="icon icon-shape icon-sm bg-white text-center border-radius-md mb-3">
                                    <i class="ni ni-trophy text-dark opacity-10"></i>
                                </div>
                                <h5 class="text-white mb-1">Pelayanan Prima bagi Masyarakat</h5>
                                <p>Kami berkomitmen memberikan layanan hukum yang berkualitas, profesional, dan
                                    berintegritas tinggi.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev w-5 me-3" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next w-5 me-3" type="button"
                        data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row mt-4">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Rekap Pelaporan Online (Aplikasi)</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Nama Laporan
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jan
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Feb
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Mar
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Apr
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Mei
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jun
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jul
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Agu
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Sep
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Okt
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Nov
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Des
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Perkara</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Mediasi</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Diversi</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Sidang Keliling</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Delegasi</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Prodeo (Pembebasan Biaya)</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Biaya (Keuangan Perkara)</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Restorative Justice (RJ)</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Posbakum</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Pengaduan</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Rekap Pelaporan Offline</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Nama Laporan
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jan
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Feb
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Mar
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Apr
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Mei
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jun
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jul
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Agu
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Sep
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Okt
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Nov
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Des
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Survei Harian</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan EIS</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Statistik Perkara</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Keadaan Perkara (Pid & Perd)
                                            </td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan SKM</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan SPAK</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Upaya Hukum</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Tahunan (Laptah LKJIIP)</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Statistik Perkara</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h6>Rekap Pelaporan Lain-Lain</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="text-center">
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Nama Laporan
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jan
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Feb
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Mar
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Apr
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Mei
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jun
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Jul
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Agu
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Sep
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Okt
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Nov
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">
                                                Des
                                            </th>
                                        </tr>
                                    </thead>

                                    <tbody class="text-center">
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Posbakum</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Monev Akurasi Data SIPP</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan SPPT (data)</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Data Direktori Putusan
                                            </td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Monev PTSP</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan BHP (Harta Peninggalan)</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                        <tr>
                                            <td class="text-sm font-weight-bold">Laporan Rekapitulasi Gratifikasi</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-danger text-white">–</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-success text-white">✔</td>
                                            <td class="bg-danger text-white">–</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

</x-layout>

<script>
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Laporan",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [14, 16, 12, 14, 12, 12, 17, 13, 18],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
</script>
