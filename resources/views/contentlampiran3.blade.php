<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            counter-reset: page;
            padding-top: 130px;
            margin: 0;
            position: relative;
        }

        .nomornya::before {
            content: counter(page); /* Menampilkan nomor halaman */
        }

        @page {
            counter-increment: page; /* Menambah nomor halaman */
        }

        #header {
            position: fixed;
            box-sizing: border-box;
            padding: 10px;
            top: 0;
            left: 0;
            width: 100%;
            background-color: white;
            z-index: 1;
            margin-bottom: 50px;
        }

        table {
            border-collapse: collapse;
            width: auto;
        }
        table tr td {
            padding: 5px;
            margin: 5px;
            width: auto;
        }
        .text-center {
            text-align: center;
        }
        .table-header p {
            font-size: 12px;
            margin: 0;
        }

        .total-pages::after {
            content: "{{ $totalPages }}"
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>

@php
    $lampiran3 = $data->lampiran3;
@endphp
<div id="header">
    @if ($lampiran3[0]->jenis_spesifikasi == '2')
        <table class="table-header" style="border-collapse: collapse; width: 100%;" border="1">
            <tbody>
                <tr>
                    <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN III</b></td>
                    <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                    <td style="font-size: 14px;"><b>SPESIFIKASI TEKNIS</b></td>
                    <td style="font-size: 14px;"><b>Halaman: <span class="nomornya"></span> / <span class="total-pages" data-total-pages="0"></span></b></td>
                </tr>
                <tr>
                    <td style="width: 13%; font-size: 14px;" rowspan="2"><b>PERIHAL</b></td>
                    <td rowspan="2" style="width: 2%; border: none; font-size: 14px;"><b> : </b></td>
                    <td rowspan="2" style="width: 60%; font-size: 14px;"><b>{{ strtoupper($data->perihal) }}</b></td>
                    <td style="width: 30%; font-size: 14px;"><b>Nomor : {{ $data->detail_number }}</b></td>
                </tr>
                <tr>
                    <td style="font-size: 14px;"><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                </tr>
            </tbody>
        </table>
        <div><br></div>
        <div style="text-align: center;"><b>SPESIFIKASI TEKNIS</b></div>
        <div><br></div>
        @foreach ($lampiran3 as $l)
            <div style="text-align: center;"><b>{{ $l->jenis_barang }}</b></div>
            <div class="mt-4"></div>
        @endforeach
    @endif
</div>

@php
    $lampiran3 = $data->lampiran3;
@endphp
<div id="content">
    @if ($lampiran3[0]->jenis_spesifikasi == '2')
        <div><br></div>
        @foreach ($lampiran3 as $l)
            <div style="text-align: center;"><b>{{ $l->jenis_barang }}</b></div>
            <div class="mt-4"></div>
        @endforeach
        @foreach($lampiran3 as $l)
            @if($l->gambarnon !== null)
                <div style="display: grid; place-items: center;">
                    <img src="{{ storage_path("app/".$l->gambarnon) }}" style="display: block; margin: 20px auto; max-width: 100%; max-height: auto;">
                </div>
            @endif
        @endforeach
        <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; text-align: left;">
            <thead style="background-color: #f2f2f2;">
                <tr>
                    <th style="padding: 8px; border: 1px solid #ddd;">No</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">No. SPPB</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Kode Barang</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Jenis Barang</th>
                    <th style="padding: 8px; border: 1px solid #ddd;">Spesifikasi Teknis</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lampiran3 as $l)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->no_sppb }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->kode_barang }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->jenis_barang }}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">{!! nl2br(e($l->spesifikasi_teknis)) !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <div><br></div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 100px;">
        <tr>
            <th style="width: 50%; text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
            <th style="width: 50%; text-align: center; font-size: 14px;">PIHAK KESATU,</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <div style="padding-top: 150px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak2name }}</b></div>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div style="padding-top: 150px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak1name }}</b></div>
                </div>
            </td>
        </tr>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contentHeight = document.getElementById('content').scrollHeight;
        const headerHeight = document.getElementById('header').scrollHeight;
        const totalHeight = contentHeight + headerHeight;
        const totalPages = Math.ceil(totalHeight / window.innerHeight);

        document.querySelectorAll('.total-pages').forEach(function(el) {
            el.setAttribute('data-total-pages', totalPages);
        });
    });
</script>
</body>
</html>
