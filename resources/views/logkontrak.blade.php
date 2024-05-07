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
                        <li class="breadcrumb-item active">Log Kontrak</li>
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
                            <h3 class="card-title">Log Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                           <div class="table-responsive">
                            <table class="table table-hovered table-sm table-bordered">
                            <tr>
                                <td><b>Number</b></td>
                                <td>:</td>
                                <td>{{ $kontrak->detail_number }}</td>
                            </tr>
                            <tr>
                                <td><b>Perihal</b></td>
                                <td>:</td>
                                <td>{{ $kontrak->perihal }}</td>
                            </tr>
                            <tr>
                                <td><b>Log Status</b></td>
                                <td>:</td>
                                <td>
                                    <ul>
                                        @foreach ($kontrak->logs as $l)
                                            <li>{{ $l->status }} - {{ $l->user->name }}@({{ tanggal_indonesia($l->created_at,'Y') }})</li>
                                        @endforeach
                                    </ul>
                                    
                                </td>
                            </tr>
                            <tr>
                                <td><b>Total Waktu (Pembuatan - Approved)</b></td>
                                <td>:</td>
                                <td>
                                    {{$lamaProses}} hari
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