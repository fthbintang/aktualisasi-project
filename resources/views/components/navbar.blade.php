@props(['breadcrumbs'])

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
    data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                {{-- Breadcrumb dinamis --}}
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="{{ url('/') }}">Home</a>
                </li>

                @foreach ($breadcrumbs as $breadcrumb)
                    @if ($loop->last)
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">{{ $breadcrumb }}
                        </li>
                    @else
                        <li class="breadcrumb-item text-sm text-white">{{ $breadcrumb }}</li>
                    @endif
                @endforeach
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">{{ end($breadcrumbs) }}</h6>
        </nav>

        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 justify-content-end" id="navbar">
            <ul class="navbar-nav d-flex align-items-center">
                <li class="nav-item d-flex flex-column align-items-start me-3 text-white">
                    <span>Halo, {{ auth()->user()->nama_lengkap }}</span>
                    <small class="text-white-50">{{ auth()->user()->role }}</small>
                </li>

                <!-- LOGOUT -->
                <li class="nav-item d-flex align-items-center">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit"
                            class="nav-link text-white d-flex align-items-center px-3 py-2 rounded bg-gradient-danger shadow-sm border-0">
                            <i class="fa fa-sign-out me-2"></i>
                            <span class="d-none d-sm-inline">Logout</span>
                        </button>
                    </form>
                </li>

                <!-- Toggler hanya muncul di layar kecil -->
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
