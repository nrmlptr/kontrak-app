<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            counter-reset: page;
            padding-top: 120px;
            margin: 0;
            position: relative;
        }

        .nomornya::before {
            content: counter(page); /* Menampilkan nomor halaman */
        }

        @page {
            margin: 2cm;
            counter-increment: page; /* Menambah nomor halaman */
        }

        #header {
            position: fixed;
            /* box-sizing: border-box; */
            /* padding: 10px; */
            top: 0;
            left: 0;
            width: calc(100% - 4cm);
            background-color: white;
            z-index: 1;
            /* margin-bottom: 50px; */
            font-family: sans-serif !important;
            font-size: 10pt !important;
        }

        table{
            border-collapse: collapse;
            width: 100%;
        }
        table tr td{
            padding: 5px;
            margin: 5px;
            /* width: auto; */
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

        #content *{
            font-family: sans-serif !important;
            font-size: 10pt !important;
        }
    </style>
</head>
<body>

<div id="header">
    <table class="table-header" style="border-collapse: collapse; width: 100%;" border="1">
        <tbody>
            <tr>
                <td style="width: 18%; "><b>LAMPIRAN I</b></td>
                <td style="width: 2%; " border="0"><b>:</b></td>
                <td style=""><b>DOKUMEN-DOKUMEN PENGADAAN</b></td>
                <td style=""><b>Halaman: <span class="nomornya"></span> / <span class="total-pages"></span></b></td>
            </tr>
            <tr>
                <td style="width: 13%; " rowspan="2"><b>PERIHAL</b></td>
                <td rowspan="2" style="width: 2%; border: none; "><b> : </b></td>
                <td rowspan="2" style="width: 53%; "><b>{{ strtoupper($data->perihal) }}</b></td>
                <td style="width: 30%; "><b>Nomor : {{ $data->detail_number }}</b></td>
            </tr>
            <tr>
                <td style=""><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
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
    <p>
        Dalam melaksanakan jual beli barang, PIHAK KEDUA harus mengikuti syarat-syarat pelaksanaan umum yang mengikat sebagai berikut :
    </p>
    <ol>
        @foreach ($showdtlampiran1 as $l)
            <li style="padding-bottom: 10px; page-break-inside: avoid">
                {{ $l['perihal'] }}
                <br>
                <table style="width: 100%;">
                    @if($l['nomor_surat'] !== null)
                        <tr>
                            <td style="width: 5%;">Nomor</td>
                            <td style="width: 95%;">: {{ $l['nomor_surat'] }}</td>
                        </tr>
                    @endif
                    <tr style="padding-top: -25px;">
                        <td style="width: 5%;">Tanggal</td>
                        <td style="width: 95%;">: {{ tanggal_indonesia($l['tanggal_surat']) }}</td>
                    </tr>
                </table>
            </li>
        @endforeach
    </ol>

    <table style="width: 100%;
            border-collapse: collapse;
           margin-top: -5px;
           page-break-after: auto;
           page-break-inside: avoid;
           text-align: center;">
        <tr>
            <th style="width: 50%;text-align: center; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">PIHAK KEDUA,</th>
            <th style="width: 50%;text-align: center; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">PIHAK KESATU,</th>
        </tr>
        <tr>
            <th style="width: 50%;text-align: center; font-size: 14px;">{{ $data->integrates[0]->vendor_name }}</th>
            <th style="width: 50%;text-align: center; font-size: 14px;"><b>PERUM PERCETAKAN UANG RI</b></th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <div style="padding-top: 120px; text-align: center; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
                    <div style=""><b><u>{{$pihak2name}}</u></b></div>
                    <div style="margin-top: 5px"><b>{{$pihak2jabatan}}</b></div>
                </div>
            </td>
            <td style="vertical-align: top; width: 80%;">
                <div style="padding-top: 120px; text-align: center; font-size: 10pt; font-family: Arial, Helvetica, sans-serif;">
                    <div style=""><b><u>{{$pihak1name}}</u></b></div>
                    <div style="margin-top: 5px;"><b>{!! str_replace('Fasilitas Umum', '<br>Fasilitas Umum', $pihak1jabatan) !!}</b></div>
                </div>
            </td>
        </tr>
    </table>

</div>
</body>
</html>
