@extends('layout.main')
@section('content')
    <style>
         @page {
            size: A4;
            margin: 1cm;
        }
        
        @media print {
            @page {
                margin: 0.3in 1in 0.3in 1in !important
            }
        }
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

    </style>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"></div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('rKontrak') }}">Back</a></li>
                            <li class="breadcrumb-item active">Detail Kontrak</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <div class="col-12">
                        @if(Auth::user()->permission=='kasek' || Auth::user()->permission=='kadept' || Auth::user()->permission=='kadiv')
                            @if($data->status !== 'approvedkadiv')
                                <a href="{{ route('createRevisi', ['id' => $data->id]) }}" class="btn btn-sm btn-warning mr-1 mb-3"><i class="fas fa-pen"></i> Revisi Kontrak</a>
                                <a href="{{ route('setujuiKontrak',$data->id) }}" id="setujuiKontrak" class="btn btn-sm btn-success mr-1 mb-3"><i class="fas fa-thumbs-up"></i> Submit Kontrak</a>
                            @endif
                        @endif
                        <a href="{{ route('cetakKontrak',$data->id) }}" target="_blank"  class="btn btn-sm btn-secondary mr-1 mb-3"><i class="nav-icon fas fa-print"></i></i> Cetak Kontrak</a>
                        {{-- TOMBOL UNTUK TAMPILKAN REVISI KETIKA KASEK CEK HASIL UPDATE AN, TAKUT LUPA PESAN REVISINYA APA JADI DIBUATIN TAMPILAN REVISI INI --}}
                        <a class="btn btn-sm btn-primary mr-1 mb-3" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-file-contract"></i>
                            Tampilkan Revisi
                        </a>
                        <div class="collapse" id="collapseExample">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Pesan Revisi</h3>
                                </div>
                                <div class="card-body">
                                    <table style="width: auto;">
                                        <tr>
                                            <td>Pemberi Revisi</td>
                                            <td></td>
                                            <td>:</td>
                                            <td colspan="2"><b> {{ $revisi->user->name }}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Posisi</td>
                                            <td></td>
                                            <td>:</td>
                                            <td colspan="2"><b>{{ $revisi->user->permission }}</b></td>
                                        </tr>
                                        <tr>
                                            <td>Detail</td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <hr color="black;">
                                                <div class="callout callout-info">
                                                    <h6>No Kontrak : </h6>
                                                    <h6><b>{{ $revisi->kontrak->detail_number }}</b></h6>
                                                    <h6>Perihal : </h6>
                                                    <h6><b>{{ $revisi->kontrak->perihal }}</b></h6>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Isi Revisi </td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <hr color="black;">
                                                <div class="callout callout-info">
                                                <h5><b>{{ $revisi->revisi }}</b></h5>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card"></div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Detail Kontrak</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div id="dokumen">
                                    <div class="content">
                                        <div style="text-align: center">
                                            <h4 style="font-weight: normal">PERJANJIAN</h4>
                                            <h4 style="font-weight: normal">antara</h4>
                                            <h4 style="font-weight: bold">PERUM PERCETAKAN UANG RI</h4>
                                            <h4 style="font-weight: normal">dengan</h4>
                                            <h4 style="font-weight: bold">{{ @$data->integrates[0]->vendor_name }}</h4>
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
                                                    <td colspan="3" style="text-align: justify;">Perjanjian ini dibuat pada hari {{ $tanggal_tertulis }} di Kantor Perum Percetakan Uang Republik Indonesia, Jalan Palatehan No. 4, Kebayoran Baru, Jakarta Selatan 12160 Indonesia oleh dan antara Pihak-Pihak:</td>
                                                </tr>
                                                <td><br></td>
                                                <tr>
                                                    <td style="vertical-align: top;text-align: left" colspan="2"><b>{{ @$pihak1name }},</b></td>
                                                    <td style="text-align: justify;">
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
                                                    <td style="text-align: justify;">
                                                        @if ($data->vendortext)
                                                            {!! @$data->vendortext !!}
                                                        @else
                                                            {!! @$pihak2data->akta !!}
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                <td><br></td>
                                                <tr>
                                                    <td colspan="3" style="text-align: justify;">
                                                        Para Pihak secara sendiri-sendiri disebut <b>"Pihak"</b> dan secara bersama-sama disebut juga <b>"Para Pihak"</b>
                                                    </td>
                                                </tr>
                                                <td><br></td>
                                                <tr>
                                                    <td colspan="3" style="text-align: justify;">
                                                        <b>Para Pihak Menerangkan</b>
                                                    </td>
                                                </tr>
                                                @php
                                                    $lampiran2=$data->lampiran2;
                                                @endphp
                                                <tr>
                                                    <td style="vertical-align: top">a. </td>
                                                    <td colspan="2" style="text-align: justify;">Bahwa PIHAK KESATU bermaksud melaksanakan {{ $lampiran2->perihal }} sebagaimana diatur dalam Perjanjian ini.</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: top">b. </td>
                                                    <td colspan="2" style="text-align: justify;">Bahwa PIHAK KEDUA telah ditunjuk untuk melaksanakan {{ $lampiran2->perihal }} sebagaimana dimaksud dalam Perjanjian ini.</td>
                                                </tr>
                                                <tr>
                                                    <td style="vertical-align: top">c. </td>
                                                    <td colspan="2" style="text-align: justify;">Dokumen-dokumen pengadaan terkait pelaksanaan pengadaan ini sesuai dengan Lampiran I Perjanjian ini dan merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</td>
                                                </tr>
                                                <td><br></td>
                                                <tr>
                                                    <td colspan="3" style="text-align: justify;">Berdasarkan pertimbangan-pertimbangan tersebut di atas, Para Pihak sepakat untuk mengikatkan diri satu sama lain dalam Perjanjian ini berdasarkan ketentuan-ketentuan dan persyaratan sebagai berikut:</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                 
                                    {{-- disini butuh page break ke halaman selanjutnya --}}
                                    <div class="page-break"></div>
                                
                                   {{-- KONTEN TENTANG PASAL --}}
                                    <div class="content">
                                        
                                        {{-- <div style="height: 100px; text-align: left;">
                                            <div style="padding-right: 10px;float: right;">
                                                <p style="text-align: center; margin-bottom: -15px !important;">Lembar ke - 2 -</p>
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
                                        <div style="clear: both;"></div> --}}
                                    
                                        
                                        <!-- Isi Pasal -->
                                        @foreach ($data->pasal as $p)
                                            <div class="boxpasal" style="text-align: justify; page-break-inside: avoid;">
                                                {{-- <div style="height: 100px; text-align: left;">
                                                    <div style="padding-right: 10px; float: right;">
                                                        <p style="text-align: center; margin-bottom: -15px !important;">Lembar ke - {{ $loop->iteration }} -</p>
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
                                                </div> --}}
                                                <h4 style="text-align: center">{{ $p->nama_pasal }}
                                                    <br>{{ $p->keterangan_pasal }}
                                                </h4>
                                                {!! $p->isi_pasal !!}
                                            </div>
                                            <div style="margin-bottom: 40px;"></div>            
                                    
                                            {{-- table ttd diakhir loop --}}
                                            @if ($loop->last)
                                                <p style="text-align: justify;">Demikian Perjanjian ini dibuat dalam 2 (dua) rangkap ASLI masing-masing sama bunyi dan bermeterai cukup serta mempunyai kekuatan hukum yang sama setelah ditandatangani dan dibubuhi cap perusahaan kedua belah pihak.</p>
                                                <div><br></div>
                                                <div><br></div>
                                                <div><br></div>
                                                <table style="width: 100%;
                                                        border-collapse: collapse;
                                                        margin-top: 20px;">
                                                    <tr>
                                                        <th style="width: 50%;text-align: center; ">PIHAK KEDUA,</th>
                                                        <th style="width: 50%;text-align: center; ">PIHAK KESATU,</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="vertical-align: top;">
                                                            <div style="padding-top: 50px; text-align: center;">
                                                                <div style=""><b>{{ $pihak2name }}</b></div>
                                                            </div>
                                                        </td>
                                                        <td style="vertical-align: top;">
                                                            <div style="padding-top: 50px; text-align: center;">
                                                                <div style=""><b>{{ $pihak1name }}</b></div>
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
                                        <span style="text-align: center;"><b>DOKUMEN-DOKUMEN PENGADAAN</b></span>
                                        <p>
                                            Dalam melaksanakan jual beli barang, PIHAK KEDUA harus mengikuti syarat-syarat pelaksanaan umum yang mengikat sebagai berikut :
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
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
                                        <span style="text-align: center;"><b>LINGKUP PERJANJIAN</b></span>
                                        <ol>
                                            <li style="text-align: justify;">
                                                PIHAK KEDUA dengan ini berjanji dan mengikatkan diri untuk Jual {{  $lampiran2->perihal }}, yang kemudian dalam Perjanjian ini akan disebut dengan “barang” kepada PIHAK KESATU, demikian juga PIHAK KESATU dengan ini telah setuju dan mengikatkan diri untuk membeli barang tersebut dari PIHAK KEDUA, yang pelaksanaannya akan dituangkan di dalam Surat Order Pembelian (SOP) Nomor : {{  $lampiran2->nomor_sop }} tanggal {{ tanggal_indonesia($lampiran2->tanggal_sop) }}.
                                            </li>
                                            <li style="text-align: justify;">
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
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
                                            <div><br></div>
                                            <div style="text-align: center;"><b>SPESIFIKASI TEKNIS</b></div>
                                            {{-- <div><br></div> --}}
                                            @foreach ($lampiran3 as $l) 
                                                <div style="text-align: center;"><b>{{ $l->jenis_barang }}</b></div>
                                                <div class="mt-4"></div>
                                            @endforeach
                                            @foreach($lampiran3 as $l)
                                                @if($l->gambarnon !== null)
                                                    <div style="display: grid; place-items: center;">
                                                        <img src="{{ Storage::url($l->gambarnon) }}" alt="{{ Storage::url($l->gambarnon) }}" style="margin-top: 20px; margin-bottom: 20px; max-width: auto; height: auto;">
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
                                                <img src="{{ Storage::url($l->gambar) }}" alt="{{ Storage::url($l->gambar) }}" style="margin-top:20px;margin-bottom:20px; max-width: auto%; max-height: auto;">
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
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
                                        <span style="text-align: center;"><b>JADWAL PENYERAHAN BARANG</b></span>
                                        <ol>
                                            @if ($lampiran4->count()>1)
                                                <li>
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
                                                <li style="text-align: justify;">
                                                    PIHAK KEDUA sanggup dan berjanji untuk melaksanakan penyerahan barang sebagaimana
                                                    dimaksud Pasal 5 Perjanjian ini sesuai jadwal yang tercantum dalam Surat Order Pembelian (SOP)
                                                    Nomor : {{ @$lampiran4[0]->nomor_sop }} tanggal {{ tanggal_indonesia(@$lampiran4[0]->tanggal_sop) }} yang diterbitkan oleh PIHAK KESATU yaitu {{ @$lampiran4[0]->jadwal_penyerahan_barang }}. 
                                                    
                                                </li>
                                            @endif
                                        
                                            <li style="text-align: justify;">
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
                                            <li style="text-align: justify;">
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
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
                                        <div><br></div>
                                        <div style="text-align: center;"><b>HARGA BARANG </b></div>
                                        <div><br></div>
                                        <ol>
                                            @if ($lampiran5->count()>1)
                                                <li>
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
                                                <li style="text-align: justify;">
                                                    Harga satuan barang {{ formatRupiah(@$lampiran5[0]->harga_awal) }} per lembar dengan total harga keseluruhan sebesar {{ @formatRupiah($data->total_keseluruhan) }} ({{ terbilang($data->total_keseluruhan) }} Rupiah) sudah termasuk Pajak Pertambahan Nilai (PPN).
                                                </li>
                                            @endif
                                        
                                            <li style="text-align: justify;">
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
                                            <li style="text-align: justify;">
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
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
                                        <div><br></div>
                                        <div style="text-align: center;"><b>PEMBAYARAN</b></div>
                                        <div><br></div>
                                        <ol>
                                            <li style="text-align: justify;">
                                                Pembayaran dari PIHAK KESATU kepada PIHAK KEDUA dilakukan setelah barang diserahkan seluruhnya oleh PIHAK KEDUA kepada PIHAK KESATU yang dinyatakan dengan dibuatkannya Surat Penerimaan Barang (SPB) oleh PIHAK KESATU, yang mana Surat Penerimaan Barang (SPB) tersebut kemudian akan melengkapi perangkat (dokumen) penagihan seperti dimaksud butir (3) Lampiran VI ini .
                                            </li>
                                            <li style="text-align: justify;">
                                                Apabila ada denda terhadap PIHAK KEDUA di dalam melaksanakan jual beli dimaksud Pasal 15 Perjanjian ini, maka denda tersebut oleh PIHAK KESATU dapat langsung dibebankan pada saat pembayaran oleh PIHAK KESATU kepada PIHAK KEDUA dilakukan.
                                            </li>
                                            <li style="text-align: justify;">
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
                                                    <li style="text-align: justify;">Kuitansi yang bermeterai cukup.</li>
                                                    <li style="text-align: justify;">Faktur Pajak.</li>
                                                    <li style="text-align: justify;">Invoice.</li>
                                                    @if ($data->jenis_kontrak=='1')
                                                        <li style="text-align: justify;">Copy Jaminan Pelaksanaan dan Surat keabsahan Jaminan (Jaminan Pelaksanaan) yang telah distempel "Verified Dep. Pengadaan Perum Peruri".
                                                        </li>
                                                    @endif
                                                    <li style="text-align: justify;">Copy Surat Order Pembelian Nomor : {{ @$lampiran6->nomor_sop }} tanggal {{ tanggal_indonesia($data->tanggal_sop) }}.</li>
                                                    <li style="text-align: justify;">Copy Perjanjian Nomor : {{ $data->detail_number }} tanggal {{ tanggal_indonesia($data->date_kontrak) }}.
                                                    </li>
                                                    <li style="text-align: justify;">Surat Bukti Penyerahan Barang/Delivery Order (DO).</li>
                                                    <li style="text-align: justify;">Copy Surat Penerimaan Barang (SPB).</li>
                                                </ol>
                                            </li>
                                            <p style="text-align: justify; ">Pembayaran ini merupakan bagian yang tidak terpisahkan dari Perjanjian ini.</p>
                                        </ol>
                                        <div><br></div>
                                        <div><br></div>
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
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
                                        <div><br></div>
                                        <div style="text-align: center;"><b>ALAMAT SURAT MENYURAT </b></div>
                                        <div><br></div>
                                        <div style="padding: 20px;">
                                            <table style="width: 100%;
                                                border-collapse: collapse;
                                                margin-top: 20px;padding:10px;">
                                                <tr>
                                                    <td style="text-align: justify;"><b>PIHAK KESATU</b>
                                                        <br>
                                                        {!! $lampiran7->alamat_peruri !!}
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="text-align: justify;">
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
                                                        <div style=""><b>{{ $pihak2name }}</b></div>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: top;">
                                                    <div style="padding-top: 50px; text-align: center;">
                                                        <div style=""><b>{{ $pihak1name }}</b></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        
                                    </div>
                                    {{-- end lampiran 7 --}}
                                </div>
                                {{-- end dokumen --}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection


@push('scripts')
    <script type="text/javascript">
        // import Swal from 'sweetalert2';

        $(document).on('click', '#setujuiKontrak', function(e) {
            e.preventDefault();
            let href = $(this).attr('href');
            console.log(href);
            Swal.fire({
                title: "Apakah Anda yakin akan submit draft Kontrak Pengadaan?",
                // text: "Anda tidak akan dapat mengembalikan ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                 cancelButtonText: "Tidak",
                confirmButtonText: "Ya, Submit!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "POST",
                        url: href,
                        data: {},
                        success: function(result) {
                            console.log(result.message);
                            if (result.redirect) {
                                window.location.href = result.redirect; // Mengarahkan ke halaman review
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
