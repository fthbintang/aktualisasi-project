<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Jenis Permohonan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e8f0ff, #ffffff);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .permohonan-btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 12px;
        }

        h1 {
            font-weight: 700;
            color: #004aad;
        }
    </style>
</head>

<body>
    <div class="container text-center py-5">
        <h1 class="mb-4">Pilih Jenis Permohonan</h1>
        <p class="text-muted mb-5">Silakan pilih jenis surat permohonan yang ingin Anda buat</p>

        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card p-4">
                    <h5 class="mb-3">Surat Kuasa</h5>
                    <a href="#" class="btn btn-primary permohonan-btn w-100">
                        Buat Permohonan
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card p-4">
                    <h5 class="mb-3">Surat Tidak Dicabut Hak Pilih</h5>
                    <a href="#" class="btn btn-primary permohonan-btn w-100">
                        Buat Permohonan
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card p-4">
                    <h5 class="mb-3">Surat Tidak Pernah Dipidana</h5>
                    <a href="{{ route('permohonan.tidak_dipidana') }}" class="btn btn-primary permohonan-btn w-100">
                        Buat Permohonan
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="card p-4">
                    <h5 class="mb-3">Waarmeking</h5>
                    <a href="#" class="btn btn-primary permohonan-btn w-100">
                        Buat Permohonan
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
