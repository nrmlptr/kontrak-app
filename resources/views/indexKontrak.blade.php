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
                        <li class="breadcrumb-item active">Monitoring Kontrak</li>
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
                                        <th>Status</th>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach($data as $d)
                                    <tr>
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
                                        <td>
                                            @if($d->status == 'draft')
                                            <span class="badge badge-warning">draft</span>
                                            @elseif($d->status == 'reviewkasek')
                                            <span class="badge badge-danger">on review kasek</span>
                                            @elseif($d->status == 'approvedkasek')
                                            <span class="badge badge-info">approved by kasek</span>
                                            @elseif($d->status == 'reviewkadept')
                                            <span class="badge badge-danger">on review kadept</span>
                                            @elseif($d->status == 'approvedkadept')
                                            <span class="badge badge-info">approved by kadept</span>
                                            @elseif($d->status == 'reviewkadiv')
                                            <span class="badge badge-danger">on review kadiv</span>
                                            @else
                                            <span class="badge badge-success">approved kadiv NET</span>
                                            @endif
                                        </td>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            {{-- Check if Lampiran7 exists for this kontraks_id --}}
                                            @php
                                                $cekLampiran7 = \App\Models\Lampiran7::where('kontraks_id', $d->id)->doesntExist();
                                            @endphp

                                            {{-- If Lampiran7 untuk kontrak tersebut benar tidak ada, show the button --}}
                                            @if($cekLampiran7)
                                                <td>
                                                    <a href="{{ route('createLampiran', ['id' => $d->id]) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i> Add Lampiran</a>
                                                </td>
                                            @else
                                                <td><span class="badge badge-info">Lampiran sudah dibuat</span></td>
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