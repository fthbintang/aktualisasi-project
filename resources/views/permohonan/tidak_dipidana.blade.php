<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Tidak Pernah Dipidana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f6f9ff;
            min-height: 100vh;
        }

        .form-card {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 15px;
            padding: 30px 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            color: #004aad;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .btn-primary {
            background-color: #004aad;
            border-color: #004aad;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .btn-primary:hover {
            background-color: #003c8a;
        }

        .required::after {
            content: " *";
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-card">
            <h2 class="text-center mb-4">Form Permohonan<br>Tidak Pernah Dipidana</h2>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif


            <form action="{{ route('permohonan.tidak_dipidana.store') }}" method="POST">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label for="nama" class="form-label required">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror" placeholder="Masukkan nama lengkap"
                        value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tempat dan Tanggal Lahir --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tempat_lahir" class="form-label required">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            placeholder="Masukkan tempat lahir" value="{{ old('tempat_lahir') }}" required>
                        @error('tempat_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir') }}" required>
                        @error('tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Jenis Kelamin --}}
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Pekerjaan --}}
                <div class="mb-3">
                    <label for="pekerjaan" class="form-label required">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan"
                        class="form-control @error('pekerjaan') is-invalid @enderror" placeholder="Masukkan pekerjaan"
                        value="{{ old('pekerjaan') }}" required>
                    @error('pekerjaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Sesuai Identitas --}}
                <div class="mb-3">
                    <label for="alamat_sesuai_identitas" class="form-label required">Alamat Sesuai Identitas</label>
                    <textarea name="alamat_sesuai_identitas" id="alamat_sesuai_identitas"
                        class="form-control @error('alamat_sesuai_identitas') is-invalid @enderror" rows="3"
                        placeholder="Masukkan alamat sesuai KTP" required>{{ old('alamat_sesuai_identitas') }}</textarea>
                    @error('alamat_sesuai_identitas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat Domisili --}}
                <div class="mb-3">
                    <label for="alamat_domisili" class="form-label required">Alamat Domisili</label>
                    <textarea name="alamat_domisili" id="alamat_domisili"
                        class="form-control @error('alamat_domisili') is-invalid @enderror" rows="3"
                        placeholder="Masukkan alamat tempat tinggal saat ini" required>{{ old('alamat_domisili') }}</textarea>
                    @error('alamat_domisili')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keperluan --}}
                <div class="mb-4">
                    <label for="keperluan" class="form-label required">
                        Keperluan
                    </label>
                    <input type="text" name="keperluan" id="keperluan"
                        class="form-control @error('keperluan') is-invalid @enderror"
                        placeholder="Contoh: Pembuatan SKCK, Lamaran CPNS, atau Pembuatan Paspor"
                        value="{{ old('keperluan') }}" required>
                    <small class="form-text text-muted">
                        Tuliskan keperluan secara spesifik tanpa menuliskan frasa
                        <i>“Melengkapi Persyaratan”</i> karena sudah otomatis ada di surat.
                    </small>
                    @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Submit --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Kirim Permohonan</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('permohonan.index') }}" class="text-decoration-none">← Kembali ke Pilihan
                    Permohonan</a>
            </div>
        </div>
    </div>
</body>

</html>
