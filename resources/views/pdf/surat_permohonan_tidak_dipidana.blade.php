<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Tidak Pernah Dipidana</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 40px;
            font-size: 12pt;
            line-height: 1.6;
        }

        .right-block {
            width: 40%;
            margin-left: auto;
            /* blok kanan tapi teks tetap rata kiri */
        }

        .content {
            margin-top: 30px;
        }

        .section {
            margin-left: 40px;
            /* agar sejajar dari 'Dengan hormat' hingga tabel */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        td {
            padding: 3px 0;
            vertical-align: top;
        }

        td:first-child {
            width: 35%;
        }

        p {
            text-align: justify;
        }

        .indent {
            text-indent: 40px;
            /* anelia di awal paragraf */
        }

        .signature {
            width: 40%;
            margin-left: auto;
            text-align: center;
            margin-top: 60px;
        }

        .signature .name {
            text-decoration: underline;
            margin-top: 60px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="right-block">
        <p>Kaimana, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
        <p>
            Kepada Yth,<br>
            Ketua Pengadilan Negeri Kaimana
        </p>
    </div>

    <div class="content section">
        <p>Dengan hormat,</p>
        <p>Saya yang bertanda tangan di bawah ini:</p>

        <table>
            <tr>
                <td>Nama</td>
                <td>: {{ $data->nama ?? '................' }}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>:
                    {{ $data->tempat_lahir ?? '................' }},
                    @if (!empty($data->tanggal_lahir))
                        {{ \Carbon\Carbon::parse($data->tanggal_lahir)->translatedFormat('d F Y') }}
                    @else
                        ................
                    @endif
                </td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: {{ $data->jenis_kelamin ?? '................' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: {{ $data->pekerjaan ?? '................' }}</td>
            </tr>
            <tr>
                <td>Alamat Sesuai Identitas</td>
                <td>: {{ $data->alamat_sesuai_identitas ?? '................' }}</td>
            </tr>
            <tr>
                <td>Alamat Domisili</td>
                <td>: {{ $data->alamat_domisili ?? '................' }}</td>
            </tr>
        </table>

        <br>

        <p class="indent">
            Dengan ini mohon perkenan Ketua Pengadilan Negeri Kaimana kiranya dapat mengeluarkan surat keterangan
            yang menyatakan bahwa saya hingga saat ini tidak pernah sebagai terpidana berdasarkan Putusan Pengadilan
            yang telah mempunyai kekuatan hukum tetap.
        </p>

        <p class="indent">
            Adapun Surat Keterangan tersebut akan saya pergunakan untuk melengkapi persyaratan administrasi
            untuk Melengkapi Persyaratan {{ $data->keperluan ?? '..............................................' }}.
        </p>

        <p class="indent">
            Demikian permohonan ini disampaikan, atas perhatian dan perkenannya diucapkan terima kasih.
        </p>

        <div class="signature">
            <p>Hormat Pemohon,</p>
            <div class="name">{{ $data->nama ?? '....................' }}</div>
        </div>
    </div>

</body>

</html>
