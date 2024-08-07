<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            counter-reset: page;
            padding-top: 150px;
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

        table{
            border-collapse: collapse;
            width: auto;
        }
        table tr td{
            padding: 5px;
            margin: 5px;
            width: auto;
        }
        .text-center{
            text-align: center;
        }
        .table-header p {
            font-size: 12px;
            margin: 0
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

<div id="header">
    <table class="table-header" style="border-collapse: collapse; width: 100%;" border="1">
        <tbody>
            <tr>
                <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN I</b></td>
                <td style="width: 2%; font-size: 14px;" border="0"><b>:</b></td>
                <td style="font-size: 14px;"><b>DOKUMEN-DOKUMEN PENGADAAN</b></td>
                <td style="font-size: 14px;"><b>Halaman: <span class="nomornya"></span> / <span class="total-pages"></span></b></td>
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
    <div style="text-align: center;"><b>DOKUMEN-DOKUMEN PENGADAAN</b></div>

</div>

@php
    $lampiran1 = $data->lampiran1;
    $dtlampiran1 = json_decode($lampiran1->data_json, true);
@endphp
<div id="content">
    <div><br></div>
    <p>
        Dalam melaksanakan jual beli barang, PIHAK KEDUA harus mengikuti syarat-syarat pelaksanaan umum yang mengikat sebagai berikut :
    </p>
    <ol>
        @foreach ($showdtlampiran1 as $l)
            <li>
                {{ $l['perihal'] }}
                <br>
                Nomor : {{ $l['nomor_surat'] }}
                <br>
                Tanggal : {{ tanggal_indonesia($l['tanggal_surat']) }}
            </li>
        @endforeach
    </ol>
    <table style="width: 100%; border-collapse: collapse; margin-top: 50px;">
        <tr>
            <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
            <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <div style="padding-top: 65px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak2name }}</b></div>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div style="padding-top: 65px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak1name }}</b></div>
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
