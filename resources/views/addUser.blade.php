@extends('layout.main')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Tambah Data Pengguna Sistem</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.user.loadUser') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah Data User</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="NamaPengguna">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="namaPengguna" placeholder="Enter Nama">
                                        @error('nama')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter email">
                                        @error('email')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        @error('password')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="NamaPengguna">Unit Kerja</label>
                                        <input type="text" class="form-control" name="nama" id="namaPengguna" placeholder="Enter Nama">
                                        @error('nama')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div> -->
                                    <div class="form-group">
                                        <label for="NamaPengguna">Permission</label>
                                        <select class="form-control" name="permission" id="" required>
                                            <option value="">Pilih Permission</option>
                                            <option value="admin">admin</option>
                                            <option value="writer">writer</option>
                                            <option value="kasek">kasek</option>
                                            <option value="kadept">kadept</option>
                                            <option value="kadiv">kadiv</option>
                                        </select>
                                        @error('nama')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('admin.index') }}" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
            </form>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection