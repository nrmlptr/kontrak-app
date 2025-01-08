@extends('layout.main')
@section('content')
<style>
    .note-editable ul,
    .content ul {
        list-style-type: lower-alpha; /* Change ordered list to a, b, c, d */
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('vPasal') }}">Home</a></li>
                        <li class="breadcrumb-item active">Pasal Management</li>
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
                    <a href="{{ route('createPasal') }}" class="btn btn-primary mb-3" title="Tambah Pasal">Add Pasal</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Pasal Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a class="btn btn-primary mb-2" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" title="Filter Data"><i class="fas fa-filter"></i>
                                Filter Data
                            </a>
                            <a href="{{ route('vPasal') }}" class="btn btn-warning mb-2" title="Refresh Data"><i class="fas fa-sync-alt"></i></a>
                            <div class="collapse" id="collapseExample">
                                <form action="{{ route('vPasal') }}" method="GET">
                                @csrf
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <label for="nama_pasal">Nama Pasal</label>
                                            <input type="text" name="nama_pasal" id="filter-nama-pasal" class="form-control filter" placeholder="Cari Nama Pasal">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="keterangan_pasal">Keterangan</label>
                                            <input type="text" name="keterangan_pasal" id="filter-keterangan-pasal" class="form-control filter" placeholder="Cari Keterangan Pasal">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="isi_pasal">Isi Pasal</label>
                                            <input type="text" name="isi_pasal" id="filter-isi-pasal" class="form-control filter" placeholder="Cari Isi Pasal">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Jenis Kontrak</label>
                                            <select name="jenis_kontrak" id="filter-jenis-kontrak" class="form-control filter">
                                                <option value="">Pilih Jenis Kontrak</option>
                                                <option value="1">Lumpsum</option>
                                                <option value="2">Harga Satuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="">Status Jaminan</label>
                                            <select name="status_jaminan" id="filter-status-jaminan" class="form-control filter">
                                                <option value="">Pilih Status Jaminan</option>
                                                <option value="1">Jaminan</option>
                                                <option value="2">Tanpa Jaminan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-5 mt-5 mb-3 input-group-append">
                                            <button type="submit" class="btn btn-primary" title="Search Data"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>


                            <table id="pasaldatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr align="center">
                                        <th>No</th>
                                        <th>Nama Pasal</th>
                                        <th class="d-none d-sm-table-cell" style="width: 15%;">Keterangan</th>
                                        <th>Isi Pasal</th>
                                        <th>Urutan</th>
                                        <th>Status Jaminan</th>
                                        <th>Jenis Kontrak</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dataPasal as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->nama_pasal }}</td>
                                        <td>{{ $d->keterangan_pasal }}</td>
                                        <td>{!! $d->isi_pasal !!}</td>
                                        <td>{{ $d->urutan }}</td>
                                        <td>
                                            @if($d->status_jaminan == '1')
                                                <span class="badge badge-success">Jaminan</span>
                                            @else
                                                <span class="badge badge-info">Tanpa Jaminan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($d->jenis_kontrak == '1')
                                                <span class="badge badge-danger">Lumpsum</span>
                                            @else
                                                <span class="badge badge-dark">Harga Satuan</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell" align="center">
                                            <a href="{{ route('editPasal', ['id' => $d->id]) }}" class="btn btn-sm btn-warning mr-1" title="Edit Pasal"><i class="far fa-edit"></i></a>
                                            <a data-toggle="modal" data-target="#modal-hapus{{$d->id }}" class="btn btn-sm btn-danger" title="Delete Pasal"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus{{$d->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Yakin Akan Menghapus Pasal <b>{{ $d->nama_pasal }}</b> ?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <form action="{{ route('deletePasal',['id' => $d->id]) }}" method="POST">
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

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#pasaldatatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "responsive": true,
            });
        });
    </script>
@endpush
