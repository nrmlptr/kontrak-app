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
                        <li class="breadcrumb-item active">Data Kontrak - Upload</li>
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
                            <h3 class="card-title">Data Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="kontrakAKdatatable" class="table table-bordered table-striped">
                                <thead align="center">
                                    <tr>
                                        @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                            <th style="width: 8%;">Action</th>
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
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    @foreach($data as $d)
                                        <tr>
                                            @if(Auth::user()->permission=='writer' || Auth::user()->permission=='admin')
                                                <td class="d-none d-sm-table-cell">
                                                    <span class="badge badge-warning mb-2">
                                                        StatusDoc:
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
                                        </tr>
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
            $('#kontrakAKdatatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data_Kontrak_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data Kontrak | Dept Pengadaan', //untuk di header nya
                        exportOptions: {
                            columns: [ 1,2,3,4,5,6,7,8,9,10,11,12]
                        }
                    },
                    {
                        extend: 'pdf',
                        filename: 'Data_Kontrak_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data Kontrak | Dept Pengadaan', //untuk di header nya
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [ 1,2,3,4,5,6,7,8,9,10,11,12]
                        }
                    }
                ]
            });
        });
    </script>

@endpush