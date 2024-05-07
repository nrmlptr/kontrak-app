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
                        <li class="breadcrumb-item active">Edit User</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('updateUser',['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')
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
                                        <label for="namaPengguna">Nama</label>
                                        <input type="text" class="form-control" name="nama" value="{{ $data->name }}" id="namaPengguna" placeholder="Enter Nama">
                                        @error('nama')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" name="username" value="{{ $data->username }}" id="username">
                                        @error('username')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" name="email" value="{{ $data->email }}" id="email" placeholder="Enter email">
                                        @error('email')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="unit_kerja">Unit Kerja</label>
                                        <select class="form-control" name="unit_kerja" id="unit_kerja">
                                            @php
                                                
                                            @endphp
                                            <option value="{{ $data->unit_kerja }}" selected>
                                                @if($data->unit_kerja === '41A')
                                                    Admin
                                                @elseif($data->unit_kerja === '41KDV')
                                                    Kepala Divisi
                                                @elseif($data->unit_kerja === '41KDP')
                                                    Kepala Department
                                                @elseif($data->unit_kerja === '41A10')
                                                    Investasi
                                                @elseif($data->unit_kerja === '41A20')
                                                    Jasa Barum
                                                @elseif($data->unit_kerja === '41A20')
                                                    Jasa Barum
                                                @elseif($data->unit_kerja === '41A30')
                                                    Lokal
                                                @else
                                                    Import
                                                @endif
                                            </option>
                                            <option value="">Pilih Unit Kerja</option>
                                            <option value="41A">Admin</option>
                                            <option value="41KDV">Kepala Divisi</option>
                                            <option value="41KDP">Kepala Department</option>
                                            <option value="41A10">Investasi</option>
                                            <option value="41A20">Jasa Barum</option>
                                            <option value="41A30">Lokal</option>
                                            <option value="41A40">Import</option>
                                        </select>
                                        {{-- <input type="text" class="form-control" name="unit_kerja" value="{{ $data->unit_kerja }}" id="unit_kerja"> --}}
                                        @error('unit_kerja')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="permission">Role</label>
                                        <select name="permission" id="permission" class="form-control">
                                            <option value="{{ $data->permission }}" selected>{{ $data->permission }}</option>
                                            <option value=''>-- Pilih Role --</option>
                                            <option value="admin">admin</option>
                                            <option value="writer">writer</option>
                                            <option value="kasek">kasek</option>
                                            <option value="kadept">kadept</option>
                                            <option value="kadiv">kadiv</option>
                                        </select>
                                        @error('permission')
                                        <small style=" color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                                        @error('password')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('index') }}" class="btn btn-danger">Cancel</a>
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