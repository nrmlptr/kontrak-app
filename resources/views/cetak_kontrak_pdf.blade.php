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
}
table tr td{
    padding: 5px;
    margin: 5px;
}
.text-center{
    text-align: center;
}
</style>

<div id="dokumen">
            <div class="content">
                <div style="text-align: center">
                    <h4 style="font-weight: normal">PERJANJIAN</h4>
                    <h4 style="font-weight: normal">antara</h4>
                    <h4 style="font-weight: bold">PERUM PERCETAKAN UANG RI</h4>
                    <h4 style="font-weight: normal">dengan</h4>
                    <h4 style="font-weight: bold">
                    {{ @$data->integrates[0]->vendor_name }}
                    </h4>
                    <h4 style="font-weight: normal">tentang</h4>
                    <h4 style="font-weight: bold">{{ $data->perihal }}</h4>
                    <h4 style="font-weight: normal">Nomor: {{ $data->detail_number }}</h4>
                </div>


                <table style="width: 100%">
                    <tbody>
                        <tr>
                            <td style="width: 3%">&nbsp;</td>
                            <td style="width: 22%">&nbsp;</td>
                            <td style="width: 75%">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="3">Perjanjian ini dibuat pada hari Senin tanggal Tujuh bulan Agustus tahun Duaribuduapuluhempat di Kantor Perum Percetakan Uang Republik Indonesia, Jalan Palatehan No. 4, Kebayoran Baru,
                                Jakarta Selatan 12160 Indonesia oleh dan antara Pihak-Pihak:</td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td style="vertical-align: top;text-align: left" colspan="2"><b>{{ $pihak1name }},</b></td>
                            <td>
                                @if ($data->peruritext)
                                            {!! @$data->peruritext !!}
                                    @else
                                        {!! @$pihak1data->peruri_akta !!}
                                    @endif
                            </td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td style="vertical-align: top;text-align: left" colspan="2"><b>{{ $pihak2name }},</b></td>
                            <td> {!! @$pihak2data->akta !!}
                            </td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td colspan="3">
                                Para Pihak secara sendiri-sendiri disebut <b>"Pihak"</b> dan secara bersama-sama disebut juga <b>"Para Pihak"</b>
                            </td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td colspan="3">
                                <b>Para Pihak Menerangkan</b>
                            </td>
                        </tr>
                        @php
                            $lampiran2=$data->lampiran2;
                        @endphp
                        <tr>
                            <td style="vertical-align: top">a. </td>
                            <td colspan="2">Bahwa PIHAK KESATU bermaksud melaksanakan {{ $lampiran2->perihal }} sebagaimana diatur dalam Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">b. </td>
                            <td colspan="2">Bahwa PIHAK KEDUA telah ditunjuk untuk melaksanakan {{ $lampiran2->perihal }} sebagaimana dimaksud dalam Perjanjian ini.</td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">c. </td>
                            <td colspan="2">Dokumen-dokumen pengadaan terkait pelaksanaan pengadaan ini sesuai dengan Lampiran I Perjanjian ini dan merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</td>
                        </tr>
                        <td><br></td>
                        <tr>
                            <td colspan="3">Berdasarkan pertimbangan-pertimbangan tersebut di atas, Para Pihak sepakat untuk mengikatkan diri satu sama lain dalam Perjanjian ini berdasarkan ketentuan-ketentuan dan persyaratan sebagai berikut:</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>
        
            <div class="content">
                <div style="height: 100px; text-align: left;">
                    <div style="padding-right: 10px;float: right;">
                        <p style="text-align: center;    margin-bottom: -15px !important;">Lembar ke - 2 -</p>
                        <p style="text-align: left;">
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
                <div style="clear: both;"></div>
                <!-- Isi Pasal -->
            
                @foreach ($data->pasal as $p)
            
                    <div class="boxpasal">
                        <h4 style="text-align: center">{{ $p->nama_pasal }}
                            <br>{{ $p->keterangan_pasal }}
                        </h4>
                        {!! $p->isi_pasal !!}
                    </div>
                    <div style="margin-bottom: 40px;"></div>
            
            
                    {{-- table ttd diakhir loop --}}
                    @if ($loop->last)
                        <p>Demikian Perjanjian ini dibuat dalam 2 (dua) rangkap ASLI masing-masing sama bunyi dan bermeterai cukup serta mempunyai kekuatan hukum yang sama setelah ditandatangani dan dibubuhi cap perusahaan kedua belah pihak.</p>
                        <table style="width: 100%;
                                border-collapse: collapse;
                                margin-top: 20px;">
                            <tr>
                                <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                                <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">
                                    <div style="padding-top: 50px; text-align: center;">
                                        <div style="">{{ $pihak2name }}</div>
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div style="padding-top: 50px; text-align: center;">
                                        <div style="">{{ $pihak1name }}</div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    @endif
                @endforeach
                {{-- end loop pasal --}}
            </div>

            {{-- disini butuh page break ke halaman selanjutnya --}}
            <div class="page-break"></div>


            {{-- lampiran 1 --}}
            @php
                $lampiran1=$data->lampiran1;
                $dtlampiran1=json_decode($lampiran1->data_json,true);
            @endphp
            <div class="content">
                <table border="1">
                    <tbody>
                        <tr>
                            <td><b>LAMPIRAN I : DOKUMEN-DOKUMEN PENGADAAN</b></td>
                            <td><b>Halaman : 1 / 1</b></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                            <td><b>Nomor : {{ $data->detail_number }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center;"><b>DOKUMEN-DOKUMEN PENGADAAN</b></div>
                <p>
                    Dalam melaksanakan jual beli barang, PIHAK KEDUA harus mengikuti syarat-syarat pelaksanaan
                        umum yang mengikat sebagai berikut :
                </p>
                <ol>
                    @foreach ($dtlampiran1 as $l)
                    
                        <li>
                            {{ $l['perihal'] }}
                            <br>
                            Nomor : {{ $l['nomor_surat'] }}
                            <br>
                            Tanggal : {{ tanggal_indonesia($l['tanggal_surat']) }}
                        </li>
                    @endforeach
                </ol>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
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
                <table border="1">
                    <tbody>
                        <tr>
                            <td><b>LAMPIRAN II : LINGKUP PERJANJIAN </b></td>
                            <td><b>Halaman : 1 / 1</b></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                            <td><b>Nomor : {{ $data->detail_number }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center;"><b>LINGKUP PERJANJIAN</b></div>
                <ol>
                <li>
                        PIHAK KEDUA dengan ini berjanji dan mengikatkan diri untuk Jual {{  $lampiran2->perihal }}, yang kemudian dalam Perjanjian ini akan disebut dengan “barang” kepada PIHAK KESATU, demikian juga PIHAK KESATU dengan ini telah setuju dan mengikatkan diri untuk membeli barang tersebut dari PIHAK KEDUA, yang pelaksanaannya akan dituangkan di dalam Surat Order Pembelian (SOP) Nomor : {{  $lampiran2->nomor_sop }} tanggal {{ tanggal_indonesia($lampiran2->tanggal_sop) }}.
                </li>
                <li>
                        Lingkup Perjanjian sebagaimana dimaksud Pasal 3 Perjanjian ini merupakan bagian yang tidak terpisahkan dari Perjanjian ini.
                </li>
                </ol>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
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
                    <table border="1">
                        <tbody>
                            <tr>
                                <td><b>LAMPIRAN III : SPESIFIKASI TEKNIS  </b></td>
                                <td><b>Halaman : 1 / 1</b></td>
                            </tr>
                            <tr>
                                <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                                <td><b>Nomor : {{ $data->detail_number }}</b></td>
                            </tr>
                            <tr>
                                <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                            </tr>
                        </tbody>
                    </table>
                    <div style="text-align: center;"><b>SPESIFIKASI TEKNIS</b></div>
                    
                    @foreach ($lampiran3 as $l) 
                        <div style="text-align: center;"><b>{{ $l->jenis_barang }}</b></div>
                    @endforeach
                    <table border="1" cellpadding="3" cellspacing="1">
                        <thead>
                            <tr>
                                <th>No </th>
                                <th>No SPBB</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Spesifikasi Teknis</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lampiran3 as $l)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $l->no_sppb }}</td>
                                <td>{{ $l->kode_barang }}</td>
                                <td>{{ $l->jenis_barang }}</td>
                                <td>{{ $l->spesifikasi_teknis }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @foreach ($lampiran3 as $l)
                        <table border="1">
                            <tbody>
                                <tr>
                                    <td><b>LAMPIRAN III : SPESIFIKASI TEKNIS  </b></td>
                                    <td><b>Halaman : {{ $loop->iteration }} / {{ $lampiran3->count() }}</b></td>
                                </tr>
                                <tr>
                                    <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                                    <td><b>Nomor : {{ $data->detail_number }}</b></td>
                                </tr>
                                <tr>
                                    <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <img src="{{ storage_path("app/".$l->gambar) }}" style="margin-top:20px;margin-bottom:20px; max-width: 100%; max-height: auto;">
                        @if (!$loop->last)
                            <div class="page-break"></div>
                        @endif
                    @endforeach
                @endif
                
                
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
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
                <table border="1">
                    <tbody>
                        <tr>
                            <td><b>LAMPIRAN IV : JADWAL PENYERAHAN BARANG  </b></td>
                            <td><b>Halaman : 1 / 1</b></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                            <td><b>Nomor : {{ $data->detail_number }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center;"><b>JADWAL PENYERAHAN BARANG</b></div>
                <ol>
                    @if ($lampiran4->count()>1)
                        <li>
                            PIHAK KEDUA sanggup dan berjanji untuk melaksanakan penyerahan barang sebagaimana
                            dimaksud Pasal 5 Perjanjian ini sesuai jadwal yang tercantum dalam Surat Order Pembelian
                            (SOP) Nomor : {{ $lampiran4[0]->nomor_sop }} tanggal {{ tanggal_indonesia($lampiran4[0]->tanggal_sop) }} yang diterbitkan oleh PIHAK
                            KESATU yaitu sebagai berikut :
                            <br>
                            <table border="1" cellpadding="3" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th>No </th>
                                        <th>No SPPB</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Tanggal Penyerahan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lampiran4 as $l)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $l->no_sppb }}</td>
                                            <td>{{ $l->kode_barang }}</td>
                                            <td>{{ $l->nama_barang }}</td>
                                            <td>{{ $l->jadwal_penyerahan_barang }}</td>
                                        </tr>
                                    @endforeach   
                                </tbody>
                            </table>
                        </li>
                    @else
                        <li>
                            PIHAK KEDUA sanggup dan berjanji untuk melaksanakan penyerahan barang sebagaimana
                            dimaksud Pasal 5 Perjanjian ini sesuai jadwal yang tercantum dalam Surat Order Pembelian (SOP)
                            Nomor : {{ @$lampiran4[0]->nomor_sop }} tanggal {{ tanggal_indonesia(@$lampiran4[0]->tanggal_sop) }} yang diterbitkan oleh PIHAK KESATU yaitu secara bertahap sampai dengan tanggal {{ @$lampiran4[0]->jadwal_penyerahan_barang }}. 
                            
                        </li>
                    @endif
                
                <li>
                        Penyerahan barang dilakukan langsung ke gudang {{ @$lampiran4[0]->lokasi }} PIHAK KESATU di Karawang.
                </li>
                <li>
                        Terhadap setiap Barang yang diserahkan oleh PIHAK KEDUA dan telah dinyatakan baik sesuai dengan hasil pemeriksaan maka PIHAK KESATU akan menyatakan menerima dengan membuat Surat Penerimaan Barang (SPB).
                </li>
                </ol>
                
                
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
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
                <table border="1">
                    <tbody>
                        <tr>
                            <td><b>LAMPIRAN V : HARGA BARANG   </b></td>
                            <td><b>Halaman : 1 / 1</b></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                            <td><b>Nomor : {{ $data->detail_number }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center;"><b>HARGA BARANG </b></div>
                <ol>
                    @if ($lampiran5->count()>1)
                        <li>
                            Harga satuan barang :
                            <br>
                            <table border="1" cellpadding="3" cellspacing="1">
                                <thead>
                                    <tr>
                                        <th>No </th>
                                        <th>No SPPB</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Harga Satuan / Liter (Excl. PPN)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total=0;
                                    @endphp
                                    @foreach ($lampiran5 as $l)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $l->no_sppb }}</td>
                                            <td>{{ $l->kode_barang }}</td>
                                            <td>{{ $l->nama_barang }}</td>
                                            <td>{{ formatRupiah($l->harga_awal) }}</td>

                                        </tr>
                                        @php
                                        $totalHarga=$l->harga_awal*$l->qty;
                                            $total+=$totalHarga;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            dengan total harga keseluruhan sebesar {{ @formatRupiah($data->total_keseluruhan) }} ({{ terbilang($data->total_keseluruhan) }} rupiah)  sudah termasuk Pajak Pertambahan Nilai (PPN).
                        </li>
                    @else
                        <li>
                            Harga satuan barang {{ formatRupiah(@$lampiran5[0]->harga_awal) }} per lembar dengan total harga keseluruhan sebesar {{ @formatRupiah($data->total_keseluruhan) }} ({{ terbilang($data->total_keseluruhan) }} rupiah) sudah termasuk Pajak Pertambahan Nilai (PPN).
                        </li>
                    @endif
                
                <li>
                        Harga barang dimaksud butir (1) Lampiran V ini adalah franko gudang {{ @$lampiran5[0]->lokasi }} PIHAK KESATU Karawang.
                </li>
                <li>
                        Harga dimaksud pada butir (1) Lampiran V ini terdiri dari komponen-komponen harga satuan yang merupakan harga tetap dan tidak berubah oleh sebab apapun sampai dengan selesainya pelaksanaan jual beli dimaksud Pasal 12 Perjanjian ini.                        
                </li>
                </ol>
                
                
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
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
                <table border="1">
                    <tbody>
                        <tr>
                            <td><b>LAMPIRAN VI : PEMBAYARAN </b></td>
                            <td><b>Halaman : 1 / 1</b></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                            <td><b>Nomor : {{ $data->detail_number }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <span style="text-align: center;"><b>PEMBAYARAN</b></span>
                <ol>
                    <li>
                        Pembayaran dari PIHAK KESATU kepada PIHAK KEDUA dilakukan setelah barang diserahkan seluruhnya oleh PIHAK KEDUA kepada PIHAK KESATU yang dinyatakan dengan dibuatkannya Surat Penerimaan Barang (SPB) oleh PIHAK KESATU, yang mana Surat Penerimaan Barang (SPB) tersebut kemudian akan melengkapi perangkat (dokumen) penagihan seperti dimaksud butir (3) Lampiran VI ini .
                    </li>
                    <li>
                        Apabila ada denda terhadap PIHAK KEDUA di dalam melaksanakan jual beli dimaksud Pasal 15 Perjanjian ini, maka denda tersebut oleh PIHAK KESATU dapat langsung dibebankan pada saat pembayaran oleh PIHAK KESATU kepada PIHAK KEDUA dilakukan.
                    </li>
                    <li>
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
                            <li>Kuitansi yang bermeterai cukup.</li>
                            <li>Faktur Pajak.</li>
                            <li>Invoice</li>
                            @if ($data->jenis_kontrak=='1')
                                <li>Copy Jaminan Pelaksanaan dan Surat keabsahan Jaminan (Jaminan Pelaksanaan) yang telah distempel "Verified Dep. Pengadaan Perum Peruri".
                                </li>
                            @endif
                            <li>Copy Surat Order Pembelian Nomor : {{ @$lampiran6->nomor_sop }} tanggal {{ tanggal_indonesia($data->tanggal_sop) }}.</li>
                            <li>Copy Perjanjian Nomor : {{ $data->detail_number }} tanggal {{ tanggal_indonesia($data->date_kontrak) }}.
                            </li>
                            <li>Surat Bukti Penyerahan Barang/Delivery Order (DO)</li>
                            <li>Copy Surat Penerimaan Barang (SPB).</li>
                        </ol>
                    </li>
                </ol>
                <p style="text-align: center;">Pembayaran ini merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</p>
                <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;">
                    <tr>
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
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
                <table border="1">
                    <tbody>
                        <tr>
                            <td><b>LAMPIRAN VII : ALAMAT SURAT MENYURAT  </b></td>
                            <td><b>Halaman : 1 / 1</b></td>
                        </tr>
                        <tr>
                            <td rowspan="2"><b>PERIHAL : {{ strtoupper($data->perihal) }}</b></td>
                            <td><b>Nomor : {{ $data->detail_number }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
                        </tr>
                    </tbody>
                </table>
                <div style="text-align: center;"><b>ALAMAT SURAT MENYURAT </b></div>
                <div style="padding: 20px;">
                    <table style="width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;padding:10px;">
                        <tr>
                            <td><b>PIHAK KESATU</b>
                                <br>
                                {!! $lampiran7->alamat_peruri !!}
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
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
                        <th style="width: 50%;text-align: center;">PIHAK KEDUA,</th>
                        <th style="width: 50%;text-align: center;">PIHAK KESATU,</th>
                    </tr>
                    <tr>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak2name }}</div>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <div style="padding-top: 50px; text-align: center;">
                                <div style="">{{ $pihak1name }}</div>
                            </div>
                        </td>
                    </tr>
                </table>
                
            </div>
            {{-- end lampiran 7 --}}

        </div>
        {{-- end dokumen --}}

</body>
</html>