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
                                <div class="pagebreak">
                                    <div style="height: 50px; text-align: right">
                                        <p style="padding-right: 10px">Lembar ke - 2 -</p>

                                        <div class="page2">
                                            <!-- PASAL 1 -->
                                        
                                            <!-- Isi Pasal -->
                                            <div>
                                                <h4 style="text-align: center">PASAL1<br>DEFINISI-DEFINISI</h4>
                                                <table style="width: 100%">
                                                    <tbody style="vertical-align: top">
                                                        <tr>
                                                            <td style="vertical-align: top; width: 3%">a. </td>
                                                            <td style="width: 97%"><b>Perjanjian</b> adalah Perjanjian ini yang dibuat dan ditandatangani antara Para Pihak, termasuk seluruh lampirannya dan setiap perubahan-perubahannya.</td>
                                                        </tr>
                                                        <td style="line-height: 1px">&nbsp;</td>
                                                        <tr>
                                                            <td>b. </td>
                                                            <td><b>Barang</b> adalah Pengadaan barang yang harus diadakan dan dipasok oleh PIHAK KEDUA.</td>
                                                        </tr>
                                                        <td style="line-height: 1px">&nbsp;</td>
                                                        <tr>
                                                            <td>c. </td>
                                                            <td><b>Spesifikasi Teknis</b> adalah Spesifikasi Teknis barang yang telah disepakati bersama oleh para pihak sebagaimana dimaksud dalam Lampiran III Perjanjian ini.</td>
                                                        </tr>
                                                        <td style="line-height: 1px">&nbsp;</td>
                                                        <tr>
                                                            <td>d. </td>
                                                            <td><b>Bulan dan Hari</b> adalah bulan dan hari terkait yang tercantum dalam kalender Masehi.</td>
                                                        </tr>
                                                        <td style="line-height: 1px">&nbsp;</td>
                                                        <tr>
                                                            <td>e. </td>
                                                            <td><b>Tanggal Berlakunya Perjanjian</b> adalah tanggal dimana semua ketentuan yang terdapat pada Pasal 23 terpenuhi.</td>
                                                        </tr>
                                                        <td style="line-height: 1px">&nbsp;</td>
                                                        <tr>
                                                            <td>f. </td>
                                                            <td><b>Surat Penerimaan Barang (SPB) </b> adalah pernyataan tertulis bertanggal dan diterbitkan oleh PIHAK KESATU yang menyatakan bahwa barang telah diserahkan
                                                                dan diterima oleh PIHAK KESATU sesuai dengan Perjanjian.</td>
                                                        </tr>
                                                        <td style="line-height: 1px">&nbsp;</td>
                                                        <tr>
                                                            <td>g. </td>
                                                            <td><b>Jaminan Mutu</b> adalah kewajiban PIHAK KEDUA untuk menjaga kualitas barang selama masa tertentu sebagaimana diatur dalam Perjanjian ini.</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                    
                                        </div>
                                
                                    </div>
                                </div>
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