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
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            <th></th>
                                        @endif
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
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                             @php
                                                $cekPembuat = Auth::user()->name;
                                            @endphp
                                            {{-- buat kondisi untuk admin dan writer karena ada tombol addLampiran jadi disitu dicek dlu apakah kontrak tersebut pembuatnya sama dengan name user yang lagi login? kalau iya, baru bisa addLampiran, kalau engga berarti forbidden --}}
                                            @if($d->pembuat == $cekPembuat)
                                                <td><a data-toggle="modal" data-target="#modal-hapus-kontrak{{$d->id }}" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a></td>
                                            @else
                                                <td><span class="badge badge-dark">Forbidden</span></td>
                                            @endif
                                        @endif
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
                                            @elseif($d->status == 'editedkasek')
                                            <span class="badge badge-info">revisi by kasek</span>
                                            @elseif($d->status == 'approvedkasek')
                                            <span class="badge badge-success">approved by kasek</span>
                                            @elseif($d->status == 'reviewkadept')
                                            <span class="badge badge-danger">on review kadept</span>
                                             @elseif($d->status == 'editedkadept')
                                            <span class="badge badge-info">revisi by kadept</span>
                                            @elseif($d->status == 'approvedkadept')
                                            <span class="badge badge-success">approved by kadept</span>
                                            @elseif($d->status == 'reviewkadiv')
                                            <span class="badge badge-danger">on review kadiv</span>
                                            @elseif($d->status == 'editedkadiv')
                                            <span class="badge badge-info">revisi by kadiv</span>
                                            @else
                                            <span class="badge badge-success">approved kadiv NET</span>
                                            @endif
                                        </td>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            @php
                                                $cekPembuat = Auth::user()->name;
                                            @endphp
                                            {{-- buat kondisi untuk admin dan writer karena ada tombol addLampiran jadi disitu dicek dlu apakah kontrak tersebut pembuatnya sama dengan name user yang lagi login? kalau iya, baru bisa addLampiran, kalau engga berarti forbidden --}}
                                            @if($d->pembuat == $cekPembuat)
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
                                            @else
                                                <td><span class="badge badge-dark">Forbidden</span></td>
                                            @endif
                                        @endif
                                    </tr>
                                    <div class="modal fade" id="modal-hapus-kontrak{{ $d->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Konfirmasi Hapus Data Kontrak</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Yakin Akan Menghapus Kontrak <b>{{ $d->perihal }}</b> ?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <form action="{{ route('deleteKontrak',['id' => $d->id]) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Ya, Hapus!</button>
                                                    </form>

                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
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