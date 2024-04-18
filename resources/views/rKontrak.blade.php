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
                        <li class="breadcrumb-item active">Review Kontrak</li>
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
                            <h3 class="card-title">Data Review Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        <th>Detail</th>
                                        <th>No</th>
                                        <th>Nomor SP</th>
                                        <th>Tanggal SP</th>
                                        <th>Nomor SOP</th>
                                        <th>Tanggal SOP</th>
                                        <th>Perihal</th>
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
                                    @php
                                          $statuslist=['reviewkasek','reviewkadept','reviewkadiv'];
                                    @endphp
                                    @foreach($data as $d)
                                    <tr>
                                        <td>
                                            @if($d->status !== 'draft')
                                                <a href="{{ route('showKontrak', ['id' => $d->id]) }}" class="btn btn-sm btn-primary my-1"><i class="fas fa-info-circle"></i>Detail</a>
                                            @endif
                                            <a href="{{ route('logKontrak', ['id' => $d->id]) }}" class="logkontrak btn btn-sm btn-info my-1"><i class="fas fa-retweet"></i>Log</a>
                                             <a href="{{ route('historyRevisiK', ['id' => $d->id]) }}" class="historyRkontrak btn btn-sm btn-warning my-1"><i class="fas fa-retweet"></i>History Revisi</a>
                                        </td>

                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->detail_number }}</td>
                                        <td>{{ date('d-m-Y', strtotime($d->date_kontrak)) }}</td>
                                        <td>{{ $d->nomor_sop }}</td>
                                        <td>{{ date('d-m-Y', strtotime($d->tanggal_sop)) }}</td>
                                        <td>{{ $d->perihal }}</td>
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
                                                <span class="badge badge-info">Review Kasek</span>
                                            @elseif($d->status == 'revisikasek')
                                                <span class="badge badge-danger">Revisi by Kasek</span>
                                            @elseif($d->status == 'editedkasek')
                                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                                            @elseif($d->status == 'approvedkasek')
                                                <span class="badge badge-success">Disetujui Kasek</span>
                                            @elseif($d->status == 'reviewkadept')
                                                <span class="badge badge-info">Review Kadept</span>
                                            @elseif($d->status == 'revisikadept')
                                                <span class="badge badge-danger">Revisi by Kadept</span>
                                            @elseif($d->status == 'editedkadept')
                                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                                            @elseif($d->status == 'approvedkadept')
                                                <span class="badge badge-success">Disetujui Kadept</span>
                                            @elseif($d->status == 'reviewkadiv')
                                                <span class="badge badge-info">Review Kadiv</span>
                                            @elseif($d->status == 'revisikadiv')
                                                <span class="badge badge-danger">Revisi by Kadiv</span>
                                            @elseif($d->status == 'editedkadiv')
                                                <span class="badge badge-warning">Diperiksa ulang by Kasek</span>
                                            @else
                                                <span class="badge badge-success">Disetujui Kadiv (NET)</span>
                                            @endif
                                        </td>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                           @php
                                                $rkontrakexist=$d->revisiKontraks->pluck('user_id')->toArray();
                                           @endphp
                                            {{-- JIKA DATA REVISI UNTUK KONTRAK TERSEBUT BENAR TIDAK ADA --}}
                                            @if(!empty($rkontrakexist))
                                               <td>
                                                    <a href="{{ route('viewRevisi', ['id' => $d->id]) }}" class="btn btn-sm btn-secondary"><i class="fas fa-eye"></i><br> Show Revisi</a>
                                                    {{-- <a href="{{ route('editLampiran', ['id' => $d->id]) }}" class="btn btn-sm btn-warning"><i class="fas fa-pen"></i> Edit Lampiran</a> --}}
                                                </td>    
                                            @else
                                             <td><span class="badge badge-info">Tidak Ada Revisi</span></td>
                                                
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

@push('scripts')
    <script>
        $(document).on('click','.logkontrak',function (e) {
            e.preventDefault();
            let href=$(this).attr('href')
            // console.log(href)
            winpopup(href,'logkontrak')
        });

        $(document).on('click','.historyRkontrak',function (e) {
            e.preventDefault();
            let href=$(this).attr('href')
            // console.log(href)
            winpopup(href,'historyRkontrak')
        });
    </script>
@endpush