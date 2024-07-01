@extends('layout.main')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Data Pengguna Sistem</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">History Revisi Kontrak</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">History Revisi Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-hovered table-sm table-bordered">
                            <tr>
                                <td>Nomor SP</td>
                                <td>:</td>
                                <td>{{ $RVkontrak->detail_number }}</td>
                            </tr>
                            <tr>
                                <td>Perihal Kontrak</td>
                                <td>:</td>
                                <td>{{ $RVkontrak->perihal }}</td>
                            </tr>
                            <tr>
                                <td>Riwayat Revisi</td>
                                <td>:</td>
                                <td>
                                    <ul>
                                        @foreach ($RVkontrak->historyRevisi as $h)
                                            <li><b>Note Revisi : </b> {{ $h->revisi }} <br>
                                                <b>Oleh   : </b> <span class="badge badge-info">{{ $h->user->name }}</span> <br> 
                                                <b>Posisi : </b> <span class="badge badge-warning">{{ $h->user->roles->first()->name }}</span><br>
                                                <b>Waktu : </b> {{ tanggal_indonesia($h->created_at,'Y') }}
                                                <hr>
                                            </li>
                                        @endforeach
                                        
                                    </ul>
                                    
                                </td>
                            </tr>
                           </table>
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