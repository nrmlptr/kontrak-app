@extends('layout.main')
@section('content')
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
                    <a href="{{ route('createPasal') }}" class="btn btn-primary mb-3">Add Pasal</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Pasal Kontrak</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="pasaldatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pasal</th>
                                        <th class="d-none d-sm-table-cell" style="width: 15%;">Keterangan</th>
                                        <th>Isi Pasal</th>
                                        <th>Urutan</th>
                                        <th>Jenis Kontrak</th>
                                        <th class="text-center" style="width: 10%;">Action</th>
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
                                            @if($d->jenis_pasal == '1')
                                            <span class="badge badge-success">Jaminan</span>
                                            @else
                                            <span class="badge badge-info">Tanpa Jaminan</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-sm-table-cell" align="center">
                                            <a href="{{ route('editPasal', ['id' => $d->id]) }}" class="btn btn-sm btn-warning mr-1"><i class="fas fa-pen"></i></a>
                                            <a data-toggle="modal" data-target="#modal-hapus{{$d->id }}" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></a>
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
    <script>
        $(document).ready(function() {
            $('#pasaldatatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,

                
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data_Pasal_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data Pasal Kontrak | Dept Pengadaan', //untuk di header nya
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5]
                        }
                    },
                     {
                        extend: 'pdf',
                        filename: 'Data_Pasal_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data Pasal Kontrak | Dept Pengadaan', //untuk di header nya
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5]
                        }
                    }
                ]
            });
        });
    </script>

@endpush