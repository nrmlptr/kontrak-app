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
                            <li class="breadcrumb-item"><a href="{{ route('role') }}">Home</a></li>
                            <li class="breadcrumb-item active">Detail Role - Permission</li>
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
                                <h3 class="card-title">Detail Role</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hovered table-sm table-bordered">
                                        <tr>
                                            <td><b>Nama Role</b></td>
                                            <td>:</td>
                                            <td>{{ $role->name }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>List Permission</b></td>
                                            <td>:</td>
                                            <td>
                                                <ul>
                                                    @foreach($role->permissions as $permission)
                                                        <li>{{ $permission->name .' = '. $permission->detail }}</li>
                                                    @endforeach
                                                </ul>
                                                
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('role') }}" class="btn btn-primary">Back</a>
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