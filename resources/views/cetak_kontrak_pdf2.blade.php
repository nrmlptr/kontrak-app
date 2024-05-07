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
            /* Style untuk tanda tangan */
            .signature-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
            }

            .signature-table td {
                border: 1px solid #000;
                padding: 10px;
            }

            .signature-table td.name {
                font-weight: bold;
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
                        <td><br></td>
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
                        <td><br></td>
                        <tr>
                            <td colspan="3" style="text-align: justify; font-size: 14px;">Berdasarkan pertimbangan-pertimbangan tersebut di atas, Para Pihak sepakat untuk mengikatkan diri satu sama lain dalam Perjanjian ini berdasarkan ketentuan-ketentuan dan persyaratan sebagai berikut:</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>
        
          
            
                 {{-- KONTEN TENTANG PASAL --}}
                 
                 
                 @foreach ($chunktext as $p)
                 <div class="content">
                     {{-- start tulisan lembar --}}
                     <div style="height: 100px; text-align: left;">
                            <div style="padding-right: 10px; float: right;">
                                <p style="text-align: center; margin-bottom: -15px !important;">Lembar ke - {{ $loop->iteration }} -</p>
                                <p style="text-align: left; font-size: 14px;">
                                    <table>
                                        <tr>
                                            <td>Nomor</td>
                                            <td>:</td>
                                            <td>{{ $data->detail_number }}</td>
                                        </tr>
                                        <tr style="border-bottom: 1px solid black;">
                                            <td>Tanggal</td>
                                            <td>:</td>
                                            <td>{{ tanggal_indonesia($data->date_kontrak) }}</td>
                                        </tr>
                                    </table>
                                </p>
                            </div>
                        </div>
                    {{-- end tulisan lembar --}}
                   {!! $p !!}        
            
                    {{-- table ttd diakhir loop --}}
                    @if ($loop->last)
                        <p style="text-align: justify; font-size: 14px;">Demikian Perjanjian ini dibuat dalam 2 (dua) rangkap ASLI masing-masing sama bunyi dan bermeterai cukup serta mempunyai kekuatan hukum yang sama setelah ditandatangani dan dibubuhi cap perusahaan kedua belah pihak.</p>
                        <div><br></div>
                        <div><br></div>
                        <div><br></div>
                        <table style="width: 100%;
                                border-collapse: collapse;
                                margin-top: 20px;">
                            <tr>
                                <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                                <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                        <div style=""><b>{{ $pihak1name }}</b></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    @endif 
                </div>
                @endforeach
                <!-- Isi Pasal -->
               
                {{-- end loop pasal --}}
          
           

            {{-- PERCOBAAN KESEKIAN  --}}

            


            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 1 --}}
            @php
                $lampiran1=$data->lampiran1;
                $dtlampiran1=json_decode($lampiran1->data_json,true);
            @endphp
            <div class="content">
                <table class="table-header" style="border-collapse: collapse; width: 100%;" border="1">
                    <tbody>
                        <tr>
                            <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN I</b></td>
                            <td style="width: 2%; font-size: 14px;" border="0"><b>:</b></td>
                            <td style="font-size: 14px;"><b>DOKUMEN-DOKUMEN PENGADAAN</b></td>
                            <td style="font-size: 14px;"><b>Halaman : 1 / 1</b></td>
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
                <div style="text-align: center; font-size: 14px;"><b>DOKUMEN-DOKUMEN PENGADAAN</b></div>
                <p style="font-size: 14px;">
                    Dalam melaksanakan jual beli barang, PIHAK KEDUA harus mengikuti syarat-syarat pelaksanaan
                        umum yang mengikat sebagai berikut :
                </p>
                <ol>
                    @foreach ($dtlampiran1 as $l)
                        
                        <li style="font-size: 14px;">
                            {{ $l['perihal'] }}
                            <br>
                            Nomor : {{ $l['nomor_surat'] }}
                            <br>
                            Tanggal : {{ tanggal_indonesia($l['tanggal_surat']) }}
                        </li>
                    @endforeach
                </ol>
                <div><br></div>
                <div><br></div>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>


            
            {{-- end lampiran 1 --}}


            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 2 --}}
            @php
                $lampiran2=$data->lampiran2;
            @endphp
            <div class="content">
                <table style="border-collapse: collapse; width: 100%;" border="1">
                    <tbody>
                        <tr>
                            <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN II</b></td>
                            <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                            <td style="font-size: 14px;"><b>LINGKUP PERJANJIAN</b></td>
                            <td style="font-size: 14px;"><b>Halaman : 1 / 1</b></td>
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
                <div style="text-align: center; font-size: 14px;"><b>LINGKUP PERJANJIAN</b></div>
                <ol>
                    <li style="text-align: justify; font-size: 14px;">
                            PIHAK KEDUA dengan ini berjanji dan mengikatkan diri untuk Jual {{  $lampiran2->perihal }}, yang kemudian dalam Perjanjian ini akan disebut dengan “barang” kepada PIHAK KESATU, demikian juga PIHAK KESATU dengan ini telah setuju dan mengikatkan diri untuk membeli barang tersebut dari PIHAK KEDUA, yang pelaksanaannya akan dituangkan di dalam Surat Order Pembelian (SOP) Nomor : {{  $lampiran2->nomor_sop }} tanggal {{ tanggal_indonesia($lampiran2->tanggal_sop) }}.
                    </li>
                    <li style="text-align: justify; font-size: 14px;">
                            Lingkup Perjanjian sebagaimana dimaksud Pasal 3 Perjanjian ini merupakan bagian yang tidak terpisahkan dari Perjanjian ini.
                    </li>
                </ol>
                <div><br></div>
                <div><br></div>
                <div><br></div>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
                
            </div>
            {{-- end lampiran 2 --}}


            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 3 --}}
            @php
                $lampiran3=$data->lampiran3;
            @endphp
            <div class="content">
                @if ($lampiran3[0]->jenis_spesifikasi=='2')
        
                    {{-- <table style="border-collapse: collapse; width: 100%;" border="1">
                        <tbody>
                            <tr>
                                <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN III</b></td>
                                <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                                <td style="font-size: 14px;"><b>SPESIFIKASI TEKNIS</b></td>
                                <td style="font-size: 14px;"><b>Halaman : 1/1 </b></td>
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
                    <div><br></div> --}}


                   
                    {{-- TEMPAT TAMPILIN GAMBAR NONLAB JIKA ADA --}}
                    @foreach ($lampiran3 as $l) 
                        <table style="border-collapse: collapse; width: 100%;" border="1">
                            <tbody>
                                <tr>
                                    <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN III</b></td>
                                    <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                                    <td style="font-size: 14px;"><b>SPESIFIKASI TEKNIS</b></td>
                                    <td style="font-size: 14px;"><b>Halaman : {{ $loop->iteration  }} / {{ $lampiran3->count() }} </b></td>
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
                        {{-- <div><br></div> --}}
                        <div style="text-align: center;"><b>SPESIFIKASI TEKNIS</b></div>
                        {{-- <div><br></div> --}}
                        @if($l->gambarnon !== null)
                            <div style="display: grid; place-items: center;">
                                <img src="{{ storage_path("app/".$l->gambarnon) }}" style="display: block; margin: 20px auto; max-width: 100%; max-height: auto;">
                            </div>
                        @else
                            <div style="background-color: white;"></div>
                        @endif
                        @if (!$loop->last)
                            <div class="page-break"></div>
                        @endif
                    @endforeach
                    {{-- TEMPAT MANGGIL NAMA BARANGNYA --}}
                    @foreach ($lampiran3 as $l) 
                        <div style="text-align: center;"><b>{{ $l->jenis_barang }}</b></div>
                        {{-- <div><br></div> --}}
                    @endforeach
                    <div><br></div>
                    {{-- TEMPAT TABEL SPESIFIKASINYA --}}
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

                    {{-- <div class="page-break"></div>

                    @foreach($lampiran3 as $key => $l)
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
                        @foreach ($lampiran3 as $l) 
                            <div style="text-align: center;"><b>{{ $l->jenis_barang }}</b></div>
                        @endforeach
                        @foreach ($lampiran3 as $l) 
                            @if($l->gambarnon !== null)
                                <div style="display: grid; place-items: center;">
                                    <img src="{{ storage_path("app/".$l->gambarnon) }}" style="display: block; margin: 20px auto; max-width: 100%; max-height: auto;">
                                </div>
                            @else
                                <div style="width: 100px; height: 100px; background-color: white;"></div>
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
                        @if (!$loop->last)
                            <div class="page-break"></div>
                        @endif
                    @endforeach --}}


                @else

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
                        <img src="{{ storage_path("app/".$l->gambar) }}" style="display: block; margin: 20px auto; max-width: 100%; max-height: auto;">
                        @if (!$loop->last)
                            <div class="page-break"></div>
                        @endif

                    @endforeach

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

                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            {{-- end lampiran 3 --}}


            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 4 --}}
            @php
                $lampiran4=$data->lampiran4;
            @endphp
            <div class="content">
                <table style="border-collapse: collapse; width: 100%;" border="1">
                    <tbody>
                        <tr>
                            <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN IV</b></td>
                            <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                            <td style="font-size: 14px;"><b>JADWAL PENYERAHAN BARANG</b></td>
                            <td style="font-size: 14px;"><b>Halaman : 1 / 1</b></td>
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
                <div style="text-align: center;"><b>JADWAL PENYERAHAN BARANG</b></div>
                <ol>
                    @if ($lampiran4->count()>1)
                        <li style="text-align: justify; font-size: 14px;">
                            PIHAK KEDUA sanggup dan berjanji untuk melaksanakan penyerahan barang sebagaimana
                            dimaksud Pasal 5 Perjanjian ini sesuai jadwal yang tercantum dalam Surat Order Pembelian
                            (SOP) Nomor : {{ $lampiran4[0]->nomor_sop }} tanggal {{ tanggal_indonesia($lampiran4[0]->tanggal_sop) }} yang diterbitkan oleh PIHAK
                            KESATU yaitu sebagai berikut :
                            <div><br></div>
                            <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; text-align: center;">
                                <thead style="background-color: #f2f2f2;">
                                    <tr>
                                        <th style="padding: 8px; border: 1px solid #ddd;">No</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">No SPPB</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">Kode Barang</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">Nama Barang</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">Tanggal Penyerahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lampiran4 as $l)
                                        <tr>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->no_sppb }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->kode_barang }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->nama_barang }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->jadwal_penyerahan_barang }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div><br></div>
                        </li>
                    @else
                        <li style="text-align: justify; font-size: 14px;">
                            PIHAK KEDUA sanggup dan berjanji untuk melaksanakan penyerahan barang sebagaimana
                            dimaksud Pasal 5 Perjanjian ini sesuai jadwal yang tercantum dalam Surat Order Pembelian (SOP)
                            Nomor : {{ @$lampiran4[0]->nomor_sop }} tanggal {{ tanggal_indonesia(@$lampiran4[0]->tanggal_sop) }} yang diterbitkan oleh PIHAK KESATU yaitu secara bertahap sampai dengan tanggal {{ @$lampiran4[0]->jadwal_penyerahan_barang }}. 
                            
                        </li>
                    @endif
                    
                    <li style="text-align: justify; font-size: 14px;">
                            Penyerahan barang dilakukan langsung ke  
                            @if(@$lampiran4[0]->lokasi == 'UGM')
                                Gudang Ugam                                
                            @elseif(@$lampiran4[0]->lokasi == 'UTAS')
                                Gudang Utas
                            @elseif(@$lampiran4[0]->lokasi == 'UMUM')
                                Gudang umum
                            @elseif(@$lampiran4[0]->lokasi == 'TGN')
                                Gudang Tasganu
                            @else
                                Gudang Tengah
                            @endif
                            PIHAK KESATU di Karawang.
                    </li>
                    <li style="text-align: justify; font-size: 14px;">
                            Terhadap setiap Barang yang diserahkan oleh PIHAK KEDUA dan telah dinyatakan baik sesuai dengan hasil pemeriksaan maka PIHAK KESATU akan menyatakan menerima dengan membuat Surat Penerimaan Barang (SPB).
                    </li>
                </ol>
                
                <div><br></div>
                <div><br></div>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>   
            </div>
            {{-- end lampiran 4 --}}


        
            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 5 --}}
            @php
                $lampiran5=$data->lampiran5;
            @endphp
            <div class="content">
                <table style="border-collapse: collapse; width: 100%;" border="1">
                    <tbody>    
                        <tr>
                            <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN V</b></td>
                            <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                            <td style="font-size: 14px;"><b>HARGA BARANG</b></td>
                            <td style="font-size: 14px;"><b>Halaman : 1 / 1</b></td>
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
                <div style="text-align: center;"><b>HARGA BARANG </b></div>
                <ol>
                    @if ($lampiran5->count()>1)
                        <li style="font-size: 14px; text-align: justify; ">
                            Harga satuan barang :
                            <div><br></div>
                            <table style="border-collapse: collapse; width: 100%; border: 1px solid #ddd; text-align: center;">
                                <thead style="background-color: #f2f2f2;">
                                    <tr>
                                        <th style="padding: 8px; border: 1px solid #ddd;">No</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">No SPPB</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">Kode Barang</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">Nama Barang</th>
                                        <th style="padding: 8px; border: 1px solid #ddd;">Harga Satuan / Liter (Excl. PPN)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total=0;
                                    @endphp
                                    @foreach ($lampiran5 as $l)
                                        <tr>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $loop->iteration }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->no_sppb }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->kode_barang }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ $l->nama_barang }}</td>
                                            <td style="padding: 8px; border: 1px solid #ddd;">{{ formatRupiah($l->harga_awal) }}</td>
                                        </tr>
                                        @php
                                            $totalHarga=$l->harga_awal*$l->qty;
                                            $total+=$totalHarga;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div><br></div>
                            dengan total harga keseluruhan sebesar {{ @formatRupiah($data->total_keseluruhan) }} ({{ terbilang($data->total_keseluruhan) }} Rupiah)  sudah termasuk Pajak Pertambahan Nilai (PPN).
                        </li>
                    @else
                        <li style="text-align: justify; font-size: 14px;">
                            Harga satuan barang {{ formatRupiah(@$lampiran5[0]->harga_awal) }} per lembar dengan total harga keseluruhan sebesar {{ @formatRupiah($data->total_keseluruhan) }} ({{ terbilang($data->total_keseluruhan) }} Rupiah) sudah termasuk Pajak Pertambahan Nilai (PPN).
                        </li>
                    @endif
                
                    <li style="text-align: justify; font-size: 14px;">
                        Harga barang dimaksud butir (1) Lampiran V ini adalah franko
                        @if(@$lampiran5[0]->lokasi == 'UGM')
                            Gudang Ugam                                                    
                        @elseif(@$lampiran5[0]->lokasi == 'UTAS')
                            Gudang Utas
                        @elseif(@$lampiran5[0]->lokasi == 'UMUM')
                            Gudang umum
                        @elseif(@$lampiran5[0]->lokasi == 'TGN')
                            Gudang Tasganu
                        @else
                            Gudang Tengah
                        @endif
                        PIHAK KESATU Karawang.
                    </li>
                    <li style="text-align: justify; font-size: 14px;">
                        Harga dimaksud pada butir (1) Lampiran V ini terdiri dari komponen-komponen harga satuan yang merupakan harga tetap dan tidak berubah oleh sebab apapun sampai dengan selesainya pelaksanaan jual beli dimaksud Pasal 12 Perjanjian ini.                        
                    </li>
                </ol>
                
                <div><br></div>
                <div><br></div>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
                
            </div>
            {{-- end lampiran 5 --}}


            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 6 --}}
            @php
                $lampiran6=$data->lampiran6;
            @endphp
            <div class="content">
                <table style="border-collapse: collapse; width: 100%;" border="1">
                    <tbody> 
                        <tr>
                            <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN VI</b></td>
                            <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                            <td style="font-size: 14px;"><b>PEMBAYARAN</b></td>
                            <td style="font-size: 14px;"><b>Halaman : 1 / 1</b></td>
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
                <div style="text-align: center;"><b>PEMBAYARAN</b></div>
                <ol>
                    <li style="text-align: justify; font-size: 14px;">
                        Pembayaran dari PIHAK KESATU kepada PIHAK KEDUA dilakukan setelah barang diserahkan seluruhnya oleh PIHAK KEDUA kepada PIHAK KESATU yang dinyatakan dengan dibuatkannya Surat Penerimaan Barang (SPB) oleh PIHAK KESATU, yang mana Surat Penerimaan Barang (SPB) tersebut kemudian akan melengkapi perangkat (dokumen) penagihan seperti dimaksud butir (3) Lampiran VI ini .
                    </li>
                    <li style="text-align: justify; font-size: 14px;">
                        Apabila ada denda terhadap PIHAK KEDUA di dalam melaksanakan jual beli dimaksud Pasal 15 Perjanjian ini, maka denda tersebut oleh PIHAK KESATU dapat langsung dibebankan pada saat pembayaran oleh PIHAK KESATU kepada PIHAK KEDUA dilakukan.
                    </li>
                    <li  style="text-align: justify; font-size: 14px;">
                        @if (@$lampiran6->jenis_pembayaran=='1')
                            {{-- lansung --}}
                            Pelaksanaan pembayaran oleh PIHAK KESATU kepada PIHAK KEDUA dilakukan {{ $lampiran6->lama_pembayaran }} ({{ terbilang($lampiran6->lama_pembayaran) }})
                            hari kerja setelah perangkat penagihan dinyatakan lengkap diterima oleh PIHAK KESATU yang
                            terdiri antara lain : 
                        @else
                            {{-- bertahap --}}
                            Pelaksanaan pembayaran oleh PIHAK KESATU kepada PIHAK KEDUA di tiap tahapan
                            pengirimannya dilakukan {{ @$lampiran6->lama_pembayaran }} ({{ terbilang(@$lampiran6->lama_pembayaran) }}) hari kerja setelah perangkat penagihan dinyatakan lengkap
                            diterima oleh PIHAK KESATU yang terdiri antara lain :
                        @endif  
                        <ol>
                            <li style="text-align: justify; font-size: 14px;">Kuitansi yang bermeterai cukup.</li>
                            <li style="text-align: justify; font-size: 14px;">Faktur Pajak.</li>
                            <li style="text-align: justify; font-size: 14px;">Invoice.</li>
                            @if ($data->jenis_kontrak=='1')
                                <li style="text-align: justify; font-size: 14px;">Copy Jaminan Pelaksanaan dan Surat keabsahan Jaminan (Jaminan Pelaksanaan) yang telah distempel "Verified Dep. Pengadaan Perum Peruri".
                                </li>
                            @endif
                            <li style="text-align: justify; font-size: 14px;">Copy Surat Order Pembelian Nomor : {{ @$lampiran6->nomor_sop }} tanggal {{ tanggal_indonesia($data->tanggal_sop) }}.</li>
                            <li style="text-align: justify; font-size: 14px;">Copy Perjanjian Nomor : {{ $data->detail_number }} tanggal {{ tanggal_indonesia($data->date_kontrak) }}.
                            </li>
                            <li style="text-align: justify; font-size: 14px;">Surat Bukti Penyerahan Barang/Delivery Order (DO).</li>
                            <li style="text-align: justify; font-size: 14px;">Copy Surat Penerimaan Barang (SPB).</li>
                        </ol>
                    </li>
                    <p style="text-align: justify; font-size: 14px;">Pembayaran ini merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</p>
                </ol>
                <div><br></div>
                <div><br></div>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
                
            </div>
            {{-- end lampiran 6 --}}


            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 7 --}}
            @php
                $lampiran7=$data->lampiran7;
            @endphp
            <div class="content">
                <table style="border-collapse: collapse; width: 100%;" border="1">
                    <tbody>    
                        <tr>
                            <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN VII</b></td>
                            <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                            <td style="font-size: 14px;"><b>ALAMAT SURAT MENYURAT</b></td>
                            <td style="font-size: 14px;"><b>Halaman : 1 / 1</b></td>
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
                <div style="text-align: center;"><b>ALAMAT SURAT MENYURAT </b></div>
                <div style="padding: 20px;">
                    <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;padding:10px;">
                        <tr>
                            <td style="text-align: justify; font-size: 14px;"><b>PIHAK KESATU</b>
                                <br>
                                {!! $lampiran7->alamat_peruri !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <td style="text-align: justify; font-size: 14px;">
                                <br><br>
                                <b>PIHAK KEDUA</b>
                                <br>
                                {!! $lampiran7->alamat_vendor !!}
                            </td>
                        </tr>
                    </table>
                </div>
                
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak2name }}</b></div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center; font-size: 14px;">
                                <div style=""><b>{{ $pihak1name }}</b></div>
                            </div>
                        </td>
                    </tr>
                </table>
                
            </div>
            {{-- end lampiran 7 --}}

        </div>
        {{-- end document --}}

    </body>
</html>