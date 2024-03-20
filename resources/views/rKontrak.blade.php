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
                        <li class="breadcrumb-item active">Data Kontrak</li>
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
                            <h3 class="card-title">Monitoring Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th>Detail</th>
                                        <th>No</th>
                                        <!-- <th>Nomor SP</th> -->
                                        <th>Detail SP</th>
                                        <th>Tanggal SOP</th>
                                        <th>Nomor SOP</th>
                                        <th>Perihal</th>
                                        <th>Tanggal Kontrak</th>
                                        <th>Pembuat</th>
                                        <th>Unit Kerja</th>
                                        <th>Jenis Kontrak</th>
                                        {{-- <th>Status</th> --}}
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach($data as $d)
                                    <tr>
                                        <td>
                                            <a href="{{ route('showKontrak', ['id' => $d->id]) }}" class="btn btn-sm btn-primary"><i class="fas fa-info-circle"></i>Detail</a>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <!-- <td>{{ $d->number }}</td> -->
                                        <td>{{ $d->detail_number }}</td>
                                        <td>{{ $d->tanggal_sop }}</td>
                                        <td>{{ $d->nomor_sop }}</td>
                                        <td>{{ $d->perihal }}</td>
                                        <td>{{ $d->date_kontrak }}</td>
                                        <td>{{ $d->pembuat }}</td>
                                        <td>{{ $d->unit_kerja }}</td>
                                        <td>
                                            @if($d->jenis_kontrak == '1')
                                            <span class="badge badge-success">Jaminan</span>
                                            @else
                                            <span class="badge badge-secondary">Tanpa Jaminan</span>
                                            @endif
                                        </td>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            {{-- Check if datarevisi tidak ada for this kontraks_id --}}
                                           <?php 
                                                $RkontrakExists = \App\Models\revisiKontrak::where('kontraks_id', $d->id)->doesntExist();
                                           
                                           ?>        
                                            {{-- JIKA DATA REVISI UNTUK KONTRAK TERSEBUT BENAR TIDAK ADA --}}
                                            @if($RkontrakExists)
                                                <td><span class="badge badge-info">Tidak Ada Revisi</span></td>
                                            @else
                                                <td>
                                                    <a href="{{ route('viewRevisi', ['id' => $d->id]) }}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i><br> Show Revisi</a>
                                                    {{-- <a href="{{ route('editLampiran', ['id' => $d->id]) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i> Edit Lampiran</a> --}}
                                                </td>    
                                            @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
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