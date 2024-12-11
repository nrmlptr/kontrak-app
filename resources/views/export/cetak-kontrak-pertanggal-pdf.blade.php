<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Kontrak - PDF</title>
    <link rel="stylesheet" href="style.css"> <!-- Tambahkan file CSS eksternal -->
    <style>
        .data-table {
            width: 95%;
            margin: 0 auto;
            border-collapse: collapse;
        }

        .data-table th,
        .data-table td {
            background-color: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            width: auto;
            /* white-space: nowrap; */
            overflow-wrap: break-word; /* or word-wrap: break-word; */
        }

         /* Untuk logo */
        .logo {
            text-align: left; /* Logo diletakkan di sebelah kiri */
            margin-bottom: 20px; /* Atur jarak antara logo dan teks */
        }

        .logo img {
            width: 200px; /* Sesuaikan lebar logo sesuai kebutuhan */
        }

        /* Untuk teks */
        .header-text {
            text-align: center;
        }

        .content {
            margin-bottom: 20px; /* Atur jarak antara konten dan footer */
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Logo Peruri di sebelah kiri -->
        <div class="logo">
            <img src="{{ asset('lte/dist/img/logoperurinew.png') }}" alt="Peruri Logo">
        </div>

        <!-- Teks "Data Kontrak - Department Pengadaan" -->
        <h2 class="header-text"><b>Data Kontrak</b></h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Kontrak</th>
                    <th>Tanggal Kontrak</th>
                    <th>Nomor SOP</th>
                    <th>Tanggal SOP</th>
                    <th>Nama Vendor</th>
                    <th>Perihal</th>
                    <th>Pembuat</th>
                    <th>Unit Kerja</th>
                    <th>Jenis Kontrak</th>
                    <th>Status Jaminan</th>
                    <th>Total Harga (Incl PPN)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exportPertanggal as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->detail_number }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->date_kontrak)) }}</td>
                        <td>{{ $d->nomor_sop }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tanggal_sop)) }}</td>
                        <td>{{ $d->nm_vendor }}</td>
                        <td>{{ $d->perihal }}</td>
                        <td>{{ $d->pembuat }}</td>
                        <td>@if($d->unit_kerja == '41A10')
                                Investasi
                            @elseif($d->unit_kerja == '41A20')
                                Jasa Barum
                            @elseif($d->unit_kerja == '41A30')
                                Lokal
                            @else
                                Import
                            @endif
                        </td>
                        <td>
                            @if($d->jenis_kontrak == '1')
                                Lumpsum
                            @else
                                Harga Satuan
                            @endif
                        </td>
                         <td>
                            @if($d->status_jaminan == '1')
                                Jaminan
                            @else
                                Tanpa Jaminan
                            @endif
                        </td>
                        <td>{{ @formatRupiah($d->total_keseluruhan) }}</td>
                        <td>
                            @if($d->status == 'draft')
                                <span class="badge badge-warning">draft</span>
                            @elseif($d->status == 'konsep')
                                <span class="badge badge-info">Konsep</span>
                            @elseif($d->status == 'reviewkasek')
                                <span class="badge badge-info">Review Kasek</span>
                            @elseif($d->status == 'revisikasek')
                                <span class="badge badge-danger">Revisi by Kasek</span>
                            @elseif($d->status == 'editedkasek')
                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                            @elseif($d->status == 'approvedkasek')
                                <span class="badge badge-success">Disetujui Kasek</span>
                            @elseif($d->status == 'reviewkadept')
                                <span class="badge badge-info">Review Kadept</span>
                            @elseif($d->status == 'revisikadept')
                                <span class="badge badge-danger">Revisi by Kadept</span>
                            @elseif($d->status == 'editedkadept')
                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                            @elseif($d->status == 'approvedkadept')
                                <span class="badge badge-success">Disetujui Kadept</span>
                            @elseif($d->status == 'reviewkadiv')
                                <span class="badge badge-info">Review Kadiv</span>
                            @elseif($d->status == 'revisikadiv')
                                <span class="badge badge-danger">Revisi by Kadiv</span>
                            @elseif($d->status == 'editedkadiv')
                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                            @else
                                <span class="badge badge-success">Disetujui Kadiv (NET)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    {{-- <footer class="main-footer">
       <strong>&copy;{{ date('Y')}} Dept.Pengadaan - PERURI. All rights reserved.</strong>
    </footer>    --}}

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>
