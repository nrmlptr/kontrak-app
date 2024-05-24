<!DOCTYPE html>
<html>
    <head>
        <title>Download Kontrak {{ $data->detail_number }}</title>
    </head>
    <body>
        <style type="text/css">
            .content {
                overflow: auto;
                display: flex;
                flex-direction: column;
            }
            .page {
                break-inside: avoid;
            }
            .page-break {
            page-break-after: always;
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
        </style>


        {{-- start document  --}}
        <div id="dokumen">
            <div class="content">
                <div style="text-align: center">
                    <h5 style="font-weight: normal; margin: 5px 0;">PERJANJIAN</h5>
                    <h5 style="font-weight: normal; margin: 5px 0;">antara</h5>
                    <h5 style="font-weight: bold; margin: 5px 0;">PERUM PERCETAKAN UANG RI</h5>
                    <h5 style="font-weight: normal; margin: 5px 0;">dengan</h5>
                    <h5 style="font-weight: bold; margin: 5px 0;">{{ @$data->integrates[0]->vendor_name }}</h5>
                    <h5 style="font-weight: normal; margin: 5px 0;">tentang</h5>
                    <h5 style="font-weight: bold; margin: 5px 0;">{{ $data->perihal }}</h5>
                    <h5 style="font-weight: normal; margin: 5px 0;">Nomor: {{ $data->detail_number }}</h5>
                </div>


                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 3%">&nbsp;</td>
                            <td style="width: 22%">&nbsp;</td>
                            <td style="width: 75%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3"style="text-align: justify; font-size: 14px;"" >Perjanjian ini dibuat pada hari {{ $tanggal_tertulis }} di Kantor Perum Percetakan Uang Republik Indonesia, Jalan Palatehan No. 4, Kebayoran Baru, Jakarta Selatan 12160 Indonesia oleh dan antara Pihak-Pihak:</td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td style="vertical-align: top;text-align: left; font-size: 14px;"" colspan="2"><b>{{ $pihak1name }},</b></td>
                            <td style="text-align: justify; font-size: 14px;"">
                                @if ($data->peruritext)
                                        {!! @$data->peruritext !!}
                                    @else
                                        {!! @$pihak1data->peruri_akta !!}
                                    @endif
                            </td>
                        </tr>
                        {{-- <td><br></td> --}}
                        <tr>
                            <td style="vertical-align: top;text-align: left; font-size: 14px;"" colspan="2"><b>{{ $pihak2name }},</b></td>
                            <td style="text-align: justify; font-size: 14px;""> {!! @$pihak2data->akta !!}</td>
                        </tr>
                        {{-- <td><br></td> --}}
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 14px;"">
                                Para Pihak secara sendiri-sendiri disebut <b>"Pihak"</b> dan secara bersama-sama disebut juga <b>"Para Pihak"</b>
                            </td>
                        </tr>
                        {{-- <td><br></td> --}}
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 14px;"">
                                <b>Para Pihak Menerangkan</b>
                            </td>
                        </tr>
                        @php
                            $lampiran2=$data->lampiran2;
                        @endphp
                        <tr>
                            <td style="vertical-align: top">a. </td>
                            <td colspan="2" style="text-align: justify; font-size: 14px;"">Bahwa PIHAK KESATU bermaksud melaksanakan {{ $lampiran2->perihal }} sebagaimana diatur dalam Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">b. </td>
                            <td colspan="2" style="text-align: justify; font-size: 14px;"">Bahwa PIHAK KEDUA telah ditunjuk untuk melaksanakan {{ $lampiran2->perihal }} sebagaimana dimaksud dalam Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">c. </td>
                            <td colspan="2" style="text-align: justify; font-size: 14px;">Dokumen-dokumen pengadaan terkait pelaksanaan pengadaan ini sesuai dengan Lampiran I Perjanjian ini dan merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</td>
                        </tr>
                        {{-- <td><br></td> --}}
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 14px;">Berdasarkan pertimbangan-pertimbangan tersebut di atas, Para Pihak sepakat untuk mengikatkan diri satu sama lain dalam Perjanjian ini berdasarkan ketentuan-ketentuan dan persyaratan sebagai berikut:</td>
                        </tr>
                    </tbody>
                </table>
            </div>
           

        </div>
        {{-- end document --}}

    </body>
</html>