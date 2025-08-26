<x-layout :breadcrumbs="$breadcrumbs">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-sm-8">
                                <h6>Data {{ end($breadcrumbs) }}</h6>
                            </div>
                            <div class="col-sm-4 d-flex justify-content-end">
                                <a href="{{ route('arsip_permohonan.create') }}" class="btn btn-success">Tambah Data</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            No</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            No Berkas</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Bulan</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Foto Cover</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Foto Checklist</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($arsip_permohonan as $row)
                                        <tr>
                                            <td>
                                                <div class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $row->no_berkas }}</p>
                                            </td>
                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0">{{ $row->bulan }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $row->foto_cover }}
                                                </p>
                                            </td>
                                            <td>
                                                <p class="text-center text-xs font-weight-bold mb-0">
                                                    {{ $row->foto_checklist }}
                                                </p>
                                            </td>
                                            <td class="text-center text-xs font-weight-bold mb-0">
                                                <a href="#" class="text-warning font-weight-bold text-xs">
                                                    Edit
                                                </a>
                                                |
                                                <form action="#" method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-link p-0 m-0 text-danger text-xs btn-delete">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
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
