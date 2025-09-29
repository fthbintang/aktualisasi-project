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
                            @canany(['Admin', 'Staff Kepaniteraan Hukum'])
                                <div class="col-sm-4 d-flex justify-content-end">
                                    <a href="{{ route('arsip_permohonan.create') }}" class="btn btn-success">Tambah
                                        Data</a>
                                </div>
                            @endcanany
                        </div>
                    </div>
                    <div class="card-body px-3 pt-3 pb-2">
                        <div class="table-responsive">
                            <table id="arsipTable"
                                class="table table-bordered table-striped table-hover align-middle mb-0"
                                style="width:100%">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>No Berkas</th>
                                        <th>Bulan</th>
                                        <th>File</th>
                                        <th>Diupload Oleh</th>
                                        <th>Diperbarui Oleh</th>
                                        @canany(['Admin', 'Staff Kepaniteraan Hukum'])
                                            <th>Aksi</th>
                                        @endcanany
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- jQuery + DataTables (Bootstrap 5 Integration) --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />

    <script>
        $(document).ready(function() {
            $('#arsipTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('arsip_permohonan.data') }}",
                columns: [{
                        data: null,
                        className: "text-center",
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'no_berkas',
                        name: 'no_berkas',
                        className: "text-center"
                    },
                    {
                        data: 'bulan',
                        name: 'bulan',
                        className: "text-center"
                    },
                    {
                        data: 'arsip_permohonan_path',
                        name: 'arsip_permohonan_path',
                        className: "text-center",
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        className: "text-center"
                    },
                    {
                        data: 'updated_by',
                        name: 'updated_by',
                        className: "text-center"
                    },
                    @canany(['Admin', 'Staff Kepaniteraan Hukum'])
                        {
                            data: 'aksi',
                            name: 'aksi',
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        },
                    @endcanany
                ],
                // layout
                dom: '<"row mb-2"<"col-sm-6"l><"col-sm-6 text-end"f>>t<"row mt-2"<"col-sm-6"i><"col-sm-6 text-end"p>>',
                language: {
                    lengthMenu: "_MENU_ data per halaman",
                    search: "Cari:",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    infoPostFix: "",
                    loadingRecords: "Sedang memuat...",
                    zeroRecords: "Data tidak ditemukan",
                    emptyTable: "Tidak ada data tersedia di tabel",
                    paginate: {
                        first: "Pertama",
                        previous: "&laquo;",
                        next: "&raquo;",
                        last: "Terakhir"
                    },
                    aria: {
                        sortAscending: ": aktifkan untuk mengurutkan kolom naik",
                        sortDescending: ": aktifkan untuk mengurutkan kolom turun"
                    },
                    processing: "Sedang memproses..."
                },
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 100],
            });
        });
    </script>

</x-layout>
