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
                font-family: sans-serif;
            }
            .page {
                break-inside: avoid;
            }
            .page-break {
            page-break-after: always;
            }
            .text-center{
                text-align: center;
            }

            td.akta-text > p, span{
                font-size: 10pt !important;
                text-align: justify;
            }

            div {
                margin: 10px;
            }

            .identitas-peruri{
                /* background-color: blueviolet; */
            }

            td{
                /* border: 1px solid red; Debugging aid to see borders */
            }
        </style>


        {{-- start document  --}}
        <div id="dokumen">
            <div class="content">
                <div style="text-align: center">
                    <h5 style="font-weight: normal; margin: 5px 0; font-size: 10pt;">PERJANJIAN</h5>
                    <h5 style="font-weight: normal; margin: 5px 0; font-size: 10pt;">antara</h5>
                    <h5 style="font-weight: bold; margin: 5px 0; font-size: 10pt;">PERUM PERCETAKAN UANG RI</h5>
                    <h5 style="font-weight: normal; margin: 5px 0; font-size: 10pt;">dengan</h5>
                    <h5 style="font-weight: bold; margin: 5px 0; font-size: 10pt;">{{ @$data->integrates[0]->vendor_name }}</h5>
                    <h5 style="font-weight: normal; margin: 5px 0; font-size: 10pt;">tentang</h5>
                    <h5 style="font-weight: bold; margin: 5px 0; font-size: 10pt;">{{ $data->perihal }}</h5>
                    <h5 style="font-weight: normal; margin: 5px 0; font-size: 10pt;">Nomor: {{ $data->detail_number }}</h5>
                </div>

                <table style="width: 100% table-layout: fixed;" >
                    <tbody>
                        {{-- <tr>
                            <td style="width: 3%">&nbsp;</td>
                            <td style="width: 22%">&nbsp;</td>
                            <td style="width: 75%">&nbsp;</td>
                        </tr> --}}
                        <tr>
                            <td colspan="3"style="text-align: justify; font-size: 10pt;">Perjanjian ini dibuat pada hari {{ $tanggal_tertulis }} di Kantor Perum Percetakan Uang Republik Indonesia, Jalan Palatehan No. 4, Kebayoran Baru, Jakarta Selatan 12160 Indonesia oleh dan antara Pihak-Pihak:</td>
                        </tr>
                        <td><br></td>
                        {{-- <tr class="identitas-peruri">
                            <td style="vertical-align: top; text-align: left; font-size: 10pt; width: 20%;" colspan="2"><b>{{ $pihak1name }},</b></td>
                            <td style="vertical-align: top; text-align: justify; font-size: 10pt; width: 80%;" class="akta-text">
                                @if ($data->peruritext)
                                    {!! strip_tags(@$data->peruritext) !!}
                                @else
                                {!! strip_tags(@$pihak1data->peruri_akta) !!}
                                @endif
                            </td>
                        </tr>
                        <tr><br></tr>
                        <tr>
                            <td style="vertical-align: top; text-align: left; font-size: 10pt; width: 20%;" colspan="2"><b>{{ $pihak2name }},</b></td>
                            <td style="vertical-align: top; text-align: justify; font-size: 10pt; width: 80%;" class="akta-text">
                                @if ($data->vendortext)
                                        {!! strip_tags(@$data->vendortext) !!}
                                    @else
                                        {!! strip_tags(@$pihak2data->akta) !!}
                                    @endif
                            </td>
                        </tr> --}}
                        <tr>
                            <td style="vertical-align: top; text-align: left; font-size: 10pt; width: 20%;" colspan="2">
                                <b>{{ $pihak1name }},</b>
                            </td>
                            <td style="vertical-align: top; text-align: justify; width: 80%; font-size: 10pt;" class="akta-text">
                                {!! strip_tags(@$data->peruritext) !!}
                                <div style="text-align: center">
                                    <b>---------------------------------------- PIHAK KESATU -------------------------------------</b>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; text-align: left; font-size: 10pt; width: 20%;" colspan="2">
                                <b>{{ $pihak2name }},</b>
                            </td>
                            <td style="vertical-align: top; text-align: justify; width: 80%; font-size: 10pt;" class="akta-text">
                                {!! strip_tags(@$data->vendortext) !!}
                                <div style="text-align: center;">
                                    <b align="center">---------------------------------------- PIHAK KEDUA -------------------------------------</b>
                                </div>
                            </td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 10pt;">
                                PIHAK KESATU dan PIHAK KEDUA secara sendiri-sendiri disebut <b>"Pihak"</b> dan secara bersama-sama disebut juga <b>"Para Pihak".</b>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 10pt;">
                                <b>Para Pihak Menerangkan:</b>
                            </td>
                        </tr>

                        <tr>
                            <td style="vertical-align: top; font-size: 10pt; width: 2%;">a.</td>
                            <td colspan="2" style="text-align: justify; font-size: 10pt; width: 98%;">Bahwa PIHAK KESATU bermaksud mengadakan Barang <i>(sebagaimana didefinisikan di bawah)</i> sebagaimana diatur dalam Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; font-size: 10pt;">b.</td>
                            <td colspan="2" style="text-align: justify; font-size: 10pt;">Bahwa PIHAK KEDUA telah ditunjuk untuk menyediakan dan memasok Barang sebagaimana dimaksud dalam Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top; font-size: 10pt;">c.</td>
                            <td colspan="2" style="text-align: justify; font-size: 10pt;">Dokumen-dokumen terkait pelaksanaan pengadaan Barang adalah sebagaimana dilampirkan pada Lampiran I Perjanjian ini dan merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 10pt;">Berdasarkan pertimbangan-pertimbangan tersebut di atas, Para Pihak sepakat untuk mengikatkan diri satu sama lain dalam Perjanjian ini berdasarkan ketentuan-ketentuan dan persyaratan sebagai berikut:</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        {{-- end document --}}
    </body>
</html>
