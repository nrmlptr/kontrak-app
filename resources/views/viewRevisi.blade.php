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
                        <li class="breadcrumb-item"><a href="{{ route('rKontrak') }}">Home</a></li>
                        <li class="breadcrumb-item active">Note Revisi Kontrak</li>
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
                    {{-- @if(Auth::user()->permission =='writer' || Auth::user()->permission=='admin') --}}
                        <a href="{{ route('editLampiran', ['id' => $revisi->kontraks_id]) }}" class="btn btn-primary mb-3">Edit Lampiran</a>
                    {{-- @endif --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><b>NOTE REVISI</b></h3>
                        </div>
                        <!-- /.card-header -->
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