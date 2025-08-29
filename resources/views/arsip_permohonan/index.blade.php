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
                                            File</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($arsip_permohonan as $row)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $row->no_berkas }}</td>
                                            <td class="text-center">{{ $row->bulan }}</td>

                                            <!-- File -->
                                            <td class="text-center">
                                                @if ($row->arsip_permohonan_path)
                                                    @php
                                                        $ext = pathinfo(
                                                            $row->arsip_permohonan_path,
                                                            PATHINFO_EXTENSION,
                                                        );
                                                        $isImage = in_array(strtolower($ext), [
                                                            'jpg',
                                                            'jpeg',
                                                            'png',
                                                            'gif',
                                                        ]);
                                                    @endphp

                                                    @if ($isImage)
                                                        <img src="{{ asset('storage/' . $row->arsip_permohonan_path) }}"
                                                            alt="File" class="img-thumbnail"
                                                            style="width:50px; cursor:pointer;"
                                                            onclick="previewFile('{{ asset('storage/' . $row->arsip_permohonan_path) }}')">
                                                    @else
                                                        <a href="{{ asset('storage/' . $row->arsip_permohonan_path) }}"
                                                            target="_blank">
                                                            {{ basename($row->arsip_permohonan_path) }}
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <a href="{{ route('arsip_permohonan.edit', $row->id) }}"
                                                    class="text-warning font-weight-bold text-xs">Edit</a>
                                                |
                                                <form action="{{ route('arsip_permohonan.destroy', $row->id) }}"
                                                    method="POST" class="d-inline form-delete">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        class="btn btn-link p-0 m-0 text-danger text-xs btn-delete">Hapus</button>
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

    <!-- Modal Preview -->
    <div class="modal fade" id="filePreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0 text-center">
                    <img src="" id="previewFileSrc" class="img-fluid" alt="Preview File">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE & PREVIEW --}}
    <script>
        // Hapus
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

        // Preview gambar
        function previewFile(src) {
            document.getElementById('previewFileSrc').src = src;
            const myModal = new bootstrap.Modal(document.getElementById('filePreviewModal'));
            myModal.show();
        }
    </script>
</x-layout>
