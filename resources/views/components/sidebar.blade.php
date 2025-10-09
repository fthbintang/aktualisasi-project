<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html "
            target="_blank">
            <img src="/assets/img/logos/pn_kaimana.png" width="20px" height="20px" class="navbar-brand-img h-100"
                alt="main_logo">
            <span class="ms-1 font-weight-bold">SIKAHU | PN Kaimana</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">
    {{-- <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main"> --}}
    <ul class="navbar-nav">

        <x-sidebar-link href="{{ route('dashboard') }}" icon="ni ni-tv-2" label="Dashboard" />

        @can('Admin')
            <x-sidebar-link href="{{ route('pengguna.index') }}" icon="ni ni-single-02" label="Pengguna" />
        @endcan

        @canany(['Admin', 'Staff Kepaniteraan Hukum'])
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Laporan Kepaniteraan Hukum
                </h6>
            </li>
            <x-sidebar-link href="{{ route('daftar_laporan.index') }}" icon="ni ni-books" label="Daftar Laporan" />
            <x-sidebar-link href="{{ route('laporan.index') }}" icon="ni ni-single-copy-04" label="Upload Laporan" />
        @elseif(!auth()->user()->can('Staff Kepaniteraan Pidana') && !auth()->user()->can('Staff Kepaniteraan Perdata'))
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Laporan Kepaniteraan Hukum
                </h6>
            </li>
            <x-sidebar-link href="{{ route('laporan.index') }}" icon="ni ni-single-copy-04" label="Laporan Hukum" />
        @endcanany

        @canany(['Admin', 'Staff Kepaniteraan Perdata'])
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Laporan Kepaniteraan Perdata
                </h6>
            </li>
            <x-sidebar-link href="{{ route('laporan_perdata.index') }}" icon="ni ni-single-copy-04"
                label="Upload Laporan" />
        @elseif(!auth()->user()->can('Staff Kepaniteraan Pidana'))
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Laporan Kepaniteraan Perdata
                </h6>
            </li>
            <x-sidebar-link href="{{ route('laporan_perdata.index') }}" icon="ni ni-single-copy-04"
                label="Laporan Perdata" />
        @endcanany

        @canany(['Admin', 'Staff Kepaniteraan Pidana'])
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Laporan Kepaniteraan Pidana
                </h6>
            </li>
            <x-sidebar-link href="{{ route('laporan_pidana.index') }}" icon="ni ni-single-copy-04" label="Upload Laporan" />
        @elseif(!auth()->user()->can('Staff Kepaniteraan Perdata'))
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Laporan Kepaniteraan Pidana
                </h6>
            </li>
            <x-sidebar-link href="{{ route('laporan_pidana.index') }}" icon="ni ni-single-copy-04" label="Laporan Pidana" />
        @endcan

        {{-- <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan Kepaniteraan Pidana</h6>
        </li>
        @can('Kepaniteraan Pidana')
            <x-sidebar-link href="{{ route('laporan_pidana.index') }}" icon="ni ni-single-copy-04" label="Upload Laporan" />
        @else
            <x-sidebar-link href="{{ route('laporan_pidana.index') }}" icon="ni ni-single-copy-04"
                label="Laporan Pidana" />
        @endcan --}}

        {{-- <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Arsip Berkas</h6>
        </li>
        <x-sidebar-link href="#" icon="ni ni-world-2" label="Daftar Register Arsip" />
        <x-sidebar-link href="#" icon="ni ni-world-2" label="Daftar Register Peminjaman" /> --}}

        <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Minutasi Perkara</h6>
        </li>
        <x-sidebar-link href="{{ route('arsip_permohonan.index') }}" icon="ni ni-app" label="Permohonan" />
        <x-sidebar-link href="{{ route('arsip_gugatan.index') }}" icon="ni ni-collection" label="Gugatan" />
        <x-sidebar-link href="{{ route('arsip_pidana.index') }}" icon="ni ni-world-2" label="Pidana" />

        {{-- <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Surat Permohonan (PTSP)</h6>
        </li>
        <x-sidebar-link href="#" icon="ni ni-app" label="Kuasa Isidentil" />
        <x-sidebar-link href="#" icon="ni ni-collection" label="Tidak Dicabut Hak Pilih" />
        <x-sidebar-link href="{{ route('permohonan_tidak_dipidana.dashboard_index') }}" icon="ni ni-world-2"
            label="Tidak Dipidana" />
        <x-sidebar-link href="#" icon="ni ni-world-2" label="Tidak Waarmeking" /> --}}
    </ul>
    {{-- </div> --}}
</aside>
