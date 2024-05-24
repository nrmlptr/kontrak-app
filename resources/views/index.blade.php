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
                        <li class="breadcrumb-item active">User Management</li>
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
                    <a href="{{ route('createUser') }}" class="btn btn-primary mb-3" title="Tambah User">Add User</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Data Pengguna Sistem</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="userdatatable" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Unit Kerja</th>
                                        <th>Role</th>
                                        <th class="text-center" style="width: 10%;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $d)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->name }}</td>
                                        <td>{{ $d->username }}</td>
                                        <td>{{ $d->email }}</td>
                                        <td>@if($d->unit_kerja == '41A10')
                                                <span class="badge badge-info">Investasi</span>
                                            @elseif($d->unit_kerja == '41A20')
                                                <span class="badge badge-warning">Jasa Barum</span>
                                            @elseif($d->unit_kerja == '41A30')
                                                <span class="badge badge-success">Lokal</span>
                                            @elseif($d->unit_kerja == '41A40')
                                                <span class="badge badge-primary">Import</span>
                                            @elseif($d->unit_kerja == '41A00')
                                                <span class="badge badge-dark">Kepala Department</span>
                                            @elseif($d->unit_kerja == '41KDV')
                                                <span class="badge badge-dark">Kepala Divisi</span>
                                            @else
                                                <span class="badge badge-dark">Admin</span>
                                            @endif
                                        </td>
                                        <td>{{ $d->permission }}</td>
                                        <td>
                                            <a href="{{ route('editUser', ['id' => $d->id]) }}" class="btn btn-sm btn-warning" title="Edit User"><i class="far fa-edit"></i></a>
                                            <a data-toggle="modal" data-target="#modal-hapus{{$d->id }}" class="btn btn-sm btn-danger" title="Delete User"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="modal-hapus{{ $d->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Konfirmasi Hapus Data</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Yakin Akan Menghapus Data <b>{{ $d->name }}</b> ?</p>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <form action="{{ route('deleteUser',['id' => $d->id]) }}" method="POST">
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
            $('#userdatatable').DataTable({
                "paging": true,
                "lengthChange": true,
                "pageLength": 5,
                "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'semua']],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,


                dom: 'Bflrtip',
                buttons: [
                    {
                        extend: 'excel',
                        filename: 'Data_User_AP_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data Pengguna Aplikasi Kontrak | Dept Pengadaan', //untuk di header nya
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5]
                        }
                    },
                    {
                        extend: 'pdf',
                        filename: 'Data_User_AP_Dept_Pengadaan', // untuk nama filenya
                        title: 'Data Pengguna Aplikasi Kontrak | Dept Pengadaan', //untuk di header nya
                        // orientation: 'ladnscape',
                        exportOptions: {
                            columns: [ 0,1,2,3,4,5]
                        }
                    }
                ]
            });
        });
    </script>

@endpush