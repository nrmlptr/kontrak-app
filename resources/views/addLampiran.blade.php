@extends('layout.main')
@section('content')
<style>
    #accordion .btn {
        border-radius: 2em;
        background-color: #4aacf7;
        border-color: #f7fafa
    }

    input {
        border-radius: 1em;
    }

    .label-collapse {
        font-size: 11pt;
        font-family: 'Segoe UI';

    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Tambah Data Pengguna Sistem</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add Lampiran</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- left column -->
                <div class="col-lg-12 d-flex align-items-strech">
                    <!-- general form elements -->
                    <div class="card card-primary w-100">
                        <div class="card-header">
                            <h3 class="card-title">Input Data Lampiran</h3>
                        </div>
                        <br>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row col-12">
                                <div id="accordion">

                                    <!-- Lampiran 1 -->
                                    <div class="card" id="lampiran1">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran1">Lampiran 1</a>
                                                <span class="label-collapse">DOKUMEN-DOKUMEN PENGADAAN</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 1 -->
                                        <div id="collapseLampiran1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                            <div class="card-body">
                                                @include('component/form_lampiran1')
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran 2 -->
                                    <div class="card" id="lampiran2">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingTwo">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran2">Lampiran 2</a>
                                                <span class="label-collapse">LINGKUP PEKERJAAN</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 2 -->
                                        <div id="collapseLampiran2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                            <div class="card-body">
                                                @include('component/form_lampiran2')
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran 3 -->
                                    <div class="card" id="lampiran3">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran3">Lampiran 3</a>
                                                <span class="label-collapse">SPESIFIKASI TEKNIS</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 3 -->
                                        <div id="collapseLampiran3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                            <div class="card-body">
                                                <!-- isi includean dari kontrak/komponen/inputlampiran3 -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran 4 -->
                                    <div class="card" id="lampiran4">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingFour">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran4">Lampiran 4</a>
                                                <span class="label-collapse">JADWAL PENYERAHAN BARANG</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 4 -->
                                        <div id="collapseLampiran4" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                            <div class="card-body">
                                                <!-- isi includean dari kontrak/komponen/inputlampiran4 -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran 5 -->
                                    <div class="card" id="lampiran5">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingFive">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran5">Lampiran 5</a>
                                                <span class="label-collapse">HARGA BARANG</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 5 -->
                                        <div id="collapseLampiran5" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                            <div class="card-body">
                                                <!-- isi includean dari kontrak/komponen/inputlampiran5, ['data' => 'Tes'] -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran 6 -->
                                    <div class="card" id="lampiran6">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingSix">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran6">Lampiran 6</a>
                                                <span class="label-collapse">PEMBAYARAN</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 6 -->
                                        <div id="collapseLampiran6" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                            <div class="card-body">
                                                <!-- isi includean dari kontrak/komponen/inputlampiran6 -->
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Lampiran 7 -->
                                    <div class="card" id="lampiran7">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingSeven">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran7">Lampiran 7</a>
                                                <span class="label-collapse">ALAMAT SURAT MENYURAT</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN LAMPIRAN 7 -->
                                        <div id="collapseLampiran7" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
                                            <div class="card-body">
                                                @include('component/form_lampiran7')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <!-- <button type="button" class="btn btn-primary" onclick="submit_data()">Submit</button> -->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection