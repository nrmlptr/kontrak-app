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
            width: 100%;
        }
        table tr td {
            padding: 5px;
            margin: 5px;
            /* width: auto; */
        }
        .text-center {
            text-align: center;
        }
        .table-header p {
            font-size: 12px;
            margin: 0;
        }

        @page{
            margin: 2cm;
        }

        #content *{
            font-family: sans-serif !important;
            font-size: 10pt !important;
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
                        <td style="width: 18%; font-size: 14px;"><b>LAMPIRAN III</b></td>
                        <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                        <td style="font-size: 14px;"><b>SPESIFIKASI TEKNIS</b></td>
                        <td style="font-size: 14px;"><b>Halaman : {{ $loop->iteration }} / {{ $lampiran3->count() }}</b></td>
                    </tr>
                    <tr>
                        <td style="width: 13%; font-size: 14px;" rowspan="2"><b>PERIHAL</b></td>
                        <td rowspan="2" style="width: 2%; border: none; font-size: 14px;"><b> : </b></td>
                        <td rowspan="2" style="width: 53%; font-size: 14px;"><b>{{ strtoupper($data->perihal) }}</b></td>
                        <td style="width: 30%; font-size: 14px;"><b>Nomor : {{ $data->detail_number }}</b></td>
                    </tr>
                    <tr>
                        <td style="font-size: 14px;"><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                    </tr>
                </tbody>
            </table>
            <div><br></div>
            {{-- <div style="text-align: center; font-size: 15px;"><b>SPESIFIKASI TEKNIS</b></div> --}}
            <div><br></div>
            <div style="display: flex; justify-content: center; align-items: center;">
                @if($loop->last)
                <img src="{{ storage_path('app/'.$l->gambar) }}" style="display: flex; justify-content: center; align-items: center; margin-left: 110px; max-width: 75%; height: 70%; max-height: 75vh; max-width: 75vw;">
                @else
                <img src="{{ storage_path('app/'.$l->gambar) }}" style="display: flex; justify-content: center; align-items: center; margin-left: 110px; max-width: 75%; height: 80%; max-height: 75vh; max-width: 75vw;">
                @endif
            </div>
            @if (!$loop->last)
                <div class="page-break"></div>
            @else
                <table style="width: 100%;
                border-collapse: collapse;
                margin-top: 35px;">
                    <tr>
                        <th style="width: 50%; text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%; text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">{{ $data->integrates[0]->vendor_name }}</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;"><b>PERUM PERCETAKAN UANG RI</b></th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 115px; text-align: center; font-size: 14px;">
                                <div style=""><b><u>{{ $pihak2name }}</u></b></div>
                                <div style="margin-top: 5px"><b>{{ $pihak2jabatan }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 115px; text-align: center; font-size: 14px;">
                                <div style=""><b><u>{{ $pihak1name }}</u></b></div>
                                <div style="margin-top: 5px"><b>{!! str_replace('Fasilitas Umum', '<br>Fasilitas Umum', $pihak1jabatan) !!}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
            @endif

        @endforeach

    {{-- <div><br></div>

    <table style="width: 100%; border-collapse: collapse; margin-top: 35px;">
        <tr>
            <th style="width: 50%; text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
            <th style="width: 50%; text-align: center; font-size: 14px;">PIHAK KESATU,</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <div style="padding-top: 120px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak2name }}</b></div>
                    <div style="margin-top: 5px"><b><u>{{ $pihak2jabatan }}</u></b></div>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div style="padding-top: 120px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak1name }}</b></div>
                    <div style="margin-top: 5px"><b><u>{{ $pihak1jabatan }}</u></b></div>
                </div>
            </td>
        </tr>
    </table> --}}
</div>
</body>
</html>
