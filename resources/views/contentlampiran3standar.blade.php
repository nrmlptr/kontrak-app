<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        .content {
            overflow: auto;
            display: flex;
            flex-direction: column;
        }
        .page-break {
            page-break-after: always;
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
    </style>
</head>
<body>

@php
    $lampiran3 = $data->lampiran3;
@endphp

<div id="content" class="content">
        @foreach ($lampiran3 as $l)
            <table style="border-collapse: collapse; width: 100%;" border="1">
                <tbody>
                    <tr>
                        <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN III</b></td>
                        <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                        <td style="font-size: 14px;"><b>SPESIFIKASI TEKNIS</b></td>
                        <td style="font-size: 14px;"><b>Halaman : {{ $loop->iteration }} / {{ $lampiran3->count() }}</b></td>
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
            <div style="text-align: center; font-size: 15px;"><b>SPESIFIKASI TEKNIS</b></div>
            <div><br></div>
            <div style="display: flex; justify-content: center; align-items: center; margin: 20px auto; max-width: 100%; max-height: auto;">
                <img src="{{ storage_path("app/".$l->gambar) }}" style="max-width: 100%; max-height: auto;">
            </div>
            @if (!$loop->last)
                <div class="page-break"></div>
            @endif

        @endforeach

    <div><br></div>
    <div><br></div>
    <div><br></div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 50px;">
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
</body>
</html>
