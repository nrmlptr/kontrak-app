@extends('layout.main')
@section('content')
    <style>
        body {
            position: flex;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11pt;
            text-align: justify;
        }

        /* .main {
        font-size: 10pt
        } */

        .auto-style1 {
            font-weight: bold;
            text-align: left;
            line-height: 30px;
        }

        .head table {
            border: 1px solid black;
            border-collapse: collapse;
            overflow: auto;
            width: 100%;

        }

        .table-ttd {
            text-align: center
        }

        .lampiran {
            width: 20%;
            border-bottom: 1px solid black;
        }

        .double-dot {
            width: 2%;
            border-bottom: 1px solid black;
        }

        .fill-lampiran {
            width: 40%;
            border-bottom: 1px solid black;
            border-right: 1px solid black;
        }

        .halaman {
            width: 13%;
            border-bottom: 1px solid black
        }

        .fill-halaman {
            border-bottom: 1px solid black;
            width: 35%
        }

        .fill-perihal {
            border-right: 1px solid black;
        }

        .nomor {
            border-bottom: 1px solid black
        }

        .fill-nomor {
            border-bottom: 1px solid black
        }

        .page2 {
            font-size: 10.2pt
        }

        .page3 {
            font-size: 10.2pt
        }

        .page4 {
            font-size: 10.2pt
        }

        .page5 {
            font-size: 10.2pt
        }

        .page6 {
            font-size: 10.2pt
        }

        .page7 {
            font-size: 10.2pt
        }

        .page8 {
            font-size: 10.2pt
        }

        .page9 {
            font-size: 10.2pt
        }

        @page {
            size: A4;
        }

        @media print {
            .pagebreak {
                page-break-before: always;
            }

            /* page-break-after works, as well */
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('rKontrak') }}">Home</a></li>
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
                        <a href="{{ route('createRevisi', ['id' => $data->id]) }}" class="btn btn-sm btn-warning mr-1 mb-3"><i class="fas fa-pen"></i> Revisi Kontrak</a>

                        <a href="" class="btn btn-sm btn-success mr-1 mb-3"><i class="fas fa-thumbs-up"></i> Setujui Kontrak</a>
                        @endif
                        <a href="" class="btn btn-sm btn-secondary mr-1 mb-3"><i class="nav-icon fas fa-print"></i></i> Cetak Kontrak</a>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Detail Kontrak</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                    
                                <div class="main">
                                    <div style="text-align: center">
                                        <h4 style="font-weight: normal">PERJANJIAN</h4>
                                        <h4 style="font-weight: normal">antara</h4>
                                        <h4 style="font-weight: bold">PERUM PERCETAKAN UANG RI</h4>
                                        <h4 style="font-weight: normal">dengan</h4>
                                        <h4 style="font-weight: bold">PT TES</h4>
                                        <h4 style="font-weight: normal">tentang</h4>
                                        <h4 style="font-weight: bold"></h4>
                                        <h4 style="font-weight: normal">Nomor: </h4>
                                    </div>
                                </div>
                                <div>
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
                                                <td style="vertical-align: top;text-align: left" colspan="2"><b>Rezi Syahputra,</b></td>
                                                <td>yang dalam hal ini jabatannya selaku POH Kepala Divisi Pengadaan dan Fasilitas Umum sesuai Nota Dinas Direktorat SDM, Teknologi dan Informasi Nomor : 21/Dir. SDM & TI/VIII/2023 tanggal 01 Agustus 2023
                                                    Tentang Penunjukan POH Kepala Divisi Pengadaan dan Fasilitas Umum, dari dan oleh karena itu bertindak untuk dan atas nama Perum Percetakan Uang RI yang didirikan untuk terakhir kalinya berdasarkan Peraturan Pemerintah RI
                                                    NomorL 6 Tahun 2019 tanggal 19 Februari 2019 tentang Perusahaan Umum (Perum) Percetakan Uang Republik Indonesia, yang berkedudukan hukum di Jalan Palatehan No. 4, Kebayoran Baru, Jakarta Selatan 12160,
                                                    yang selanjutnya dalam perbuatan hukum ini disebut sebagai: </td>
                                            </tr>
                                            <td><br></td>
                                            <tr>
                                                <td style="vertical-align: top;text-align: left" colspan="2"><b>Eric Italiano,</b></td>
                                                <td>yang dalam hal ini jabatannya selaku Technical Director untuk dan atas nama PT. Sicpa Peruri Securink yang anggaran dasarnya telah mendapat pengesahan dari Menteri Hukum dan HAM Nomor: c-12289 HT.01.01TH.2003
                                                    dan diumumkan dalam Tambahan Berita Negara RI tertanggal 22 Agustus 2003 Nomor: 67, Tambahan Nomor 7310/2003 dengan Akta tertanggal 19 Februari 2003 Nomor: 4 yang dibuat dihadapan TH. Siti Sri Amiretno Diah Wasisti
                                                    Bagiono SH, Notaris di Jakarta dan telah diubah untuk terakhir kalinya dengan Akta Nomor: 25 tanggal 12 November 2021 yang dibuat dihadapan RA Mahyasari Arizza Notonagoro.SH, M.Kn., Notaris di Jakarta,
                                                    yang berkedudukan hukum di Desa Parung Mulya, Kecamatan Ciampel, Kabupaten Karawang, Jawa Barat, untuk selanjutnya dalam perbuatan hukum ini disebut sebagai: </td>
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
                                            <tr>
                                                <td style="vertical-align: top">a. </td>
                                                <td colspan="2">Bahwa PIHAK KESATU bermaksud melaksanakan Jual Beli 4.000 Kg Cleaning Compound Type TI-4240 sebagaimana diatur dalam Perjanjian ini.</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top">b. </td>
                                                <td colspan="2">Bahwa PIHAK KEDUA telah ditunjuk untuk melaksanakan Jual Beli 4.000 Kg Cleaning Compound Type TI-4240 sebagaimana dimaksud dalam Perjanjian ini.</td>
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
                                <!-- BAGIAN PAGE2 -->
                                <div class="pagebreak"></div>
                                
                                
                                <div class="page">
                                    <!-- PASAL 1 -->
                                    <div style="height: 100px; text-align: left;float: right;">
                                        <div style="padding-right: 10px">
                                            <p style="text-align: center;    margin-bottom: -15px !important;">Lembar ke - 2 -</p>
                                            <p style="text-align: left;">
                                                <table>
                                                    <tr>
                                                        <td>Nomor</td>
                                                        <td>:</td>
                                                        <td>SP-30/I/2024</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid black;">
                                                        <td>Tanggal</td>
                                                        <td>:</td>
                                                        <td>10 Januari 2024</td>
                                                    </tr>

                                                </table>
                                                </p>
                                        </div>
                                        
                                    </div>
                                    <div style="clear: both;"></div>
                                    <!-- Isi Pasal -->
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($data->pasal as $p)
                                     @if ($no > 0 && $no <= 6)
                                        <div class="boxpasal">
                                            <h4 style="text-align: center">{{ $p->nama_pasal }}
                                                <br>{{ $p->keterangan_pasal }}
                                            </h4>
                                            {!! $p->isi_pasal !!}
                                        </div>
                                        <div style="margin-bottom: 40px;"></div>
                                    @endif
                                    
                                    @php
                                        $no++;
                                    @endphp
                                    @endforeach
                                    {{-- end loop pasal --}}
                                </div>
                                {{-- end page 2 --}}
                            
                                


                                 <div class="pagebreak"></div>



                                {{-- page 3 --}}
                                 <div class="page">
                                    <div style="height: 100px; text-align: left;float: right;">
                                        <div style="padding-right: 10px">
                                            <p style="text-align: center;    margin-bottom: -15px !important;">Lembar ke - 3 -</p>
                                            <p style="text-align: left;">
                                                <table>
                                                    <tr>
                                                        <td>Nomor</td>
                                                        <td>:</td>
                                                        <td>SP-30/I/2024</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid black;">
                                                        <td>Tanggal</td>
                                                        <td>:</td>
                                                        <td>10 Januari 2024</td>
                                                    </tr>

                                                </table>
                                                </p>
                                        </div>
                                        
                                    </div>
                                    <div style="clear: both;"></div>
                                    <!-- Isi Pasal -->
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($data->pasal as $p)
                                    @if ($no > 6 && $no <= 9)
                                        <div class="boxpasal">
                                            <h4 style="text-align: center">{{ $p->nama_pasal }}
                                                <br>{{ $p->keterangan_pasal }}
                                            </h4>
                                            {!! $p->isi_pasal !!}
                                        </div>
                                        <div style="margin-bottom: 40px;"></div>
                                    @endif
                                    
                                    @php
                                        $no++;
                                    @endphp
                                    @endforeach
                                    {{-- end loop pasal --}}
                                </div>
                                {{-- end page 3 --}}

                                <div class="pagebreak"></div>



                                {{-- page 4 --}}
                                 <div class="page">
                                    <div style="height: 100px; text-align: left;float: right;">
                                        <div style="padding-right: 10px">
                                            <p style="text-align: center;    margin-bottom: -15px !important;">Lembar ke - 4 -</p>
                                            <p style="text-align: left;">
                                                <table>
                                                    <tr>
                                                        <td>Nomor</td>
                                                        <td>:</td>
                                                        <td>SP-30/I/2024</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid black;">
                                                        <td>Tanggal</td>
                                                        <td>:</td>
                                                        <td>10 Januari 2024</td>
                                                    </tr>

                                                </table>
                                                </p>
                                        </div>
                                        
                                    </div>
                                    <div style="clear: both;"></div>
                                    <!-- Isi Pasal -->
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($data->pasal as $p)
                                    @if ($no > 9 && $no <= 12)
                                        <div class="boxpasal">
                                            <h4 style="text-align: center">{{ $p->nama_pasal }}
                                                <br>{{ $p->keterangan_pasal }}
                                            </h4>
                                            {!! $p->isi_pasal !!}
                                        </div>
                                        <div style="margin-bottom: 40px;"></div>
                                    @endif
                                    
                                    @php
                                        $no++;
                                    @endphp
                                    @endforeach
                                    {{-- end loop pasal --}}
                                </div>
                                {{-- end page 4 --}}

                            <div class="pagebreak"></div>

                                {{-- page 5 --}}
                                 <div class="page">
                                    <div style="height: 100px; text-align: left;float: right;">
                                        <div style="padding-right: 10px">
                                            <p style="text-align: center;    margin-bottom: -15px !important;">Lembar ke - 5 -</p>
                                            <p style="text-align: left;">
                                                <table>
                                                    <tr>
                                                        <td>Nomor</td>
                                                        <td>:</td>
                                                        <td>SP-30/I/2024</td>
                                                    </tr>
                                                    <tr style="border-bottom: 1px solid black;">
                                                        <td>Tanggal</td>
                                                        <td>:</td>
                                                        <td>10 Januari 2024</td>
                                                    </tr>

                                                </table>
                                                </p>
                                        </div>
                                        
                                    </div>
                                    <div style="clear: both;"></div>
                                    <!-- Isi Pasal -->
                                    @php
                                        $no=1;
                                    @endphp
                                    @foreach ($data->pasal as $p)
                                    @if ($no > 12 && $no <= 15)
                                        <div class="boxpasal">
                                            <h4 style="text-align: center">{{ $p->nama_pasal }}
                                                <br>{{ $p->keterangan_pasal }}
                                            </h4>
                                            {!! $p->isi_pasal !!}
                                        </div>
                                        <div style="margin-bottom: 40px;"></div>
                                    @endif
                                    
                                    @php
                                        $no++;
                                    @endphp
                                    @endforeach
                                    {{-- end loop pasal --}}
                                </div>
                                {{-- end page 5 --}}







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