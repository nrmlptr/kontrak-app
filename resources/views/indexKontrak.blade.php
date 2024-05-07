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
                            <a class="btn btn-primary mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="Filter Data"><i class="fas fa-filter"></i>
                                Filter Data
                            </a>
                            <a href="{{ route('indexKontrak') }}" class="btn btn-warning mb-2" title="Refresh Data"><i class="fas fa-sync-alt"></i></a>
                            <div class="collapse" id="collapseExample">
                                <form action="{{ route('indexKontrak') }}" method="GET">
                                @csrf
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="">Nama Vendor</label>
                                            <input type="text" name="nm_vendor" id="filter-nama-vendor" class="form-control filter">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Status</label>
                                            <select name="status" id="filter-status" class="form-control filter">
                                                <option value="">Pilih Status</option>
                                                <option value="draft">Draft</option>
                                                <option value="reviewkasek">Review By Kasek</option>
                                                <option value="revisikasek">Revisi By Kasek</option>
                                                <option value="editedkasek">Diperiksa Ulang Kasek</option>
                                                <option value="approvedkasek">Disetujui by Kasek</option>
                                                <option value="reviewkadept">Review By Kadept</option>
                                                <option value="revisikadept">Revisi By Kadept</option>
                                                <option value="editedkadept">Diperiksa Ulang Kasek</option>
                                                <option value="approvedkadept">Disetujui by Kadept</option>
                                                <option value="reviewkadiv">Review By Kadiv</option>
                                                <option value="revisikadiv">Revisi By Kadiv</option>
                                                <option value="editedkadiv">Diperiksa Ulang Kasek</option>
                                                <option value="approvedkadiv">Disetujui Kadiv (NET)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Unit Kerja</label>
                                            <select name="unit_kerja" id="filter-unit-kerja" class="form-control filter">
                                                <option value="">Pilih Unit Kerja</option>
                                                <option value="41A10">Investasi</option>
                                                <option value="41A20">Jasa Barum</option>
                                                <option value="41A30">Lokal</option>
                                                <option value="41A40">Import</option> 
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Jenis Kontrak</label>
                                            <select name="jenis_kontrak" id="filter-jenis-kontrak" class="form-control filter">
                                                <option value="">Pilih Jenis Kontrak</option>
                                                <option value="1">Lumpsum</option>
                                                <option value="2">Harga Satuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label for="">Status Jaminan</label>
                                            <select name="status_jaminan" id="filter-status-jaminan" class="form-control filter">
                                                <option value="">Pilih Status Jaminan</option>
                                                <option value="1">Jaminan</option>
                                                <option value="2">Tanpa Jaminan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <label for="">Tanggal SP</label>
                                            {{-- <hr> --}}
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="startdate">Start</label>
                                                <input type="date" class="form-control" name="startdate">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="enddate">End</label>
                                                <input type="date" class="form-control" name="enddate">
                                            </div>
                                        </div>
                                        <div class="col-md-4 mt-3 input-group-append">
                                            {{-- <br> --}}
                                            <button type="submit" class="btn btn-primary" title="Search Data"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <table id="kontrakdatatable" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>                                        
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            <th style="width: 10%">U/D</th>
                                            <th></th>
                                        @endif
                                        <th>No</th>
                                        <th>Nomor SP</th>
                                        <th>Tanggal SP</th>
                                        <th>Nomor SOP</th>
                                        <th>Tanggal SOP</th>
                                        <th>Nama Vendor</th>
                                        <th>Perihal</th>
                                        <th>Pembuat</th>
                                        <th>Unit Kerja</th>
                                        <th>Jenis Kontrak</th>
                                        <th>Status Jaminan</th>
                                        <th>Status</th>
                                        <th>Total Harga (Incl PPN)</th>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach($data as $d)
                                        <tr>
                                            
                                            @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                                @if($d->status == 'approvedkadiv')
                                                    <td class="d-none d-sm-table-cell">
                                                        <span class="badge badge-warning mb-2"> Status Doc : 
                                                            @if($d->statusdoc !== null)
                                                                {{ $d->statusdoc }}
                                                            @else
                                                                Belum Upload Document
                                                            @endif
                                                        </span><br>
                                                        @if($d->statusdoc !== 'NET')
                                                            <a data-toggle="modal" data-target="#modal-upload-doc{{ $d->id }}" class="btn btn-success sm" title="Upload Document Kontrak"><i class="fas fa-file-upload"></i></a>
                                                        @endif
                                                        
                                                        <a href="{{ route('downloadKontrak', ['id' => $d->id]) }}" class="btn btn-primary sm" title="Download Document Kontrak"><i class="fas fa-download"></i></a>
                                                    </td>
                                                @else
                                                    <td><span class="badge badge-dark">Unfinished</span></td>
                                                @endif
                                                @php
                                                    $cekPembuat = Auth::user()->name;
                                                @endphp
                                                {{-- buat kondisi untuk admin dan writer karena ada tombol addLampiran jadi disitu dicek dlu apakah kontrak tersebut pembuatnya sama dengan name user yang lagi login? kalau iya, baru bisa addLampiran, kalau engga berarti forbidden --}}
                                                @if($d->pembuat == $cekPembuat)
                                                    <td><a data-toggle="modal" data-target="#modal-hapus-kontrak{{$d->id }}" class="btn btn-sm btn-danger" title="Hapus Kontrak"><i class="fas fa-trash-alt"></i></a></td>
                                                @else
                                                    <td><span class="badge badge-dark">Forbidden</span></td>
                                                @endif

                                            @endif
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->detail_number }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->date_kontrak)) }}</td>
                                            <td>{{ $d->nomor_sop }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->tanggal_sop)) }}</td>
                                            <td>{{ $d->nm_vendor }}</td>
                                            <td>{{ $d->perihal }}</td>
                                            <td>{{ $d->pembuat }}</td>
                                            <td>@if($d->unit_kerja == '41A10')
                                                    Investasi
                                                @elseif($d->unit_kerja == '41A20')
                                                    Jasa Barum
                                                @elseif($d->unit_kerja == '41A30')
                                                    Lokal
                                                @else
                                                    Import
                                                @endif
                                            </td>
                                            <td>
                                                @if($d->jenis_kontrak == '1')
                                                    <span class="badge badge-info">Lumpsum</span>
                                                @else
                                                    <span class="badge badge-secondary">Harga Satuan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($d->status_jaminan == '1')
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
                                            <th>{{ @formatRupiah($d->total_keseluruhan) }}</th>
                                            @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                                @php
                                                    $cekPembuat = Auth::user()->name;
                                                @endphp
                                                {{-- buat kondisi untuk admin dan writer karena ada tombol addLampiran jadi disitu dicek dlu apakah kontrak tersebut pembuatnya sama dengan name user yang lagi login? kalau iya, baru bisa addLampiran, kalau engga berarti forbidden --}}
                                                @if($d->pembuat == $cekPembuat)
                                                    {{-- Check if Lampiran7 exists for this kontraks_id --}}
                                                    @php
                                                        $cekLampiran7 = \App\Models\Lampiran7::where('kontraks_id', $d->id)->doesntExist();
                                                        // dd($cekLampiran7)
                                                    @endphp
                                                    {{-- If Lampiran7 untuk kontrak tersebut benar tidak ada, show the button --}}
                                                    @if($cekLampiran7)
                                                        <td>
                                                            <a href="{{ route('createLampiran', ['id' => $d->id]) }}" class="btn btn-sm btn-warning" title="Tambah Lampiran"><i class="fas fa-pen"></i> Add Lampiran</a>

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
                                        <div class="modal fade" id="modal-upload-doc{{ $d->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Upload Document Kontrak</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('loadUpload', ['id' => $d->id]) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="form-group">
                                                                        <label for="statusdoc">Status Dokumen Kontrak</label>
                                                                        <select name="statusdoc" id="statusdoc" class="form-control">
                                                                            <option value="">Pilih Status</option>
                                                                            <option value="DRAFT">DRAFT</option>
                                                                            <option value="NET">NET</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="uploadDoc">Upload kontrak</label>
                                                                        <input type="file" name="docKontrak" class="form-control" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    
                                                </div>
                                            </div>
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

@push('scripts')
    <script type="text/javascript">

        $(document).ready(function() {

            var loggedInUserRole;

            $.ajax({
                url: '/get-logged-in-user-role',
                type: 'GET',
                async: false,
                success: function(data) {
                    // console.log(data);
                    loggedInUserRole = data;
                }
            });

            var exportColumns;
            if (loggedInUserRole === "admin" || loggedInUserRole === "writer") {
                exportColumns = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14];
            } else {
                exportColumns = [0,1,2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            }


            $('#kontrakdatatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "processing":true,
                
                    
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data_Kontrak_Dept_Pengadaan',
                        title: 'Data Kontrak | Dept Pengadaan',
                        exportOptions: {
                            columns: exportColumns
                            // columns: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
                        }
                    },
                    {
                        extend: 'pdf',
                        filename: 'Data_Kontrak_Dept_Pengadaan',
                        title: 'Data Kontrak | Dept Pengadaan',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: exportColumns
                            // columns: [ 2,3,4,5,6,7,8,9,10,11,12,13,14 ]
                        }
                    },
                    'pageLength'
                ]
            });
        });


        // $(document).ready(function() {
        //     $('#kontrakdatatable').DataTable({
        //         "paging": true,
        //         "lengthChange": true,
        //         "pageLength": 10,
        //         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'semua']],
        //         "searching": true,
        //         "ordering": false,
        //         "info": true,
        //         "autoWidth": false,
        //         "responsive": true,
        //         "processing": true,
        //         "dom": '<"top"Blf<"clear">>rt<"bottom"ip<"clear">>',
        //         "buttons": [
        //             {
        //                 extend: 'excel',
        //                 filename: 'Data_Kontrak_Dept_Pengadaan',
        //                 title: 'Data Kontrak | Dept Pengadaan',
        //                 exportOptions: {
        //                     columns: [ 2,3,4,5,6,7,8,9,10,11,12,13]
        //                 }
        //             },
        //             {
        //                 extend: 'pdf',
        //                 filename: 'Data_Kontrak_Dept_Pengadaan',
        //                 title: 'Data Kontrak | Dept Pengadaan',
        //                 orientation: 'landscape',
        //                 exportOptions: {
        //                     columns: [ 2,3,4,5,6,7,8,9,10,11,12,13]
        //                 }
        //             }
        //         ]
        //     });
        // });


    </script>

@endpush