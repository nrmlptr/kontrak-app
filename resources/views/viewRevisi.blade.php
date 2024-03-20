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
                        <li class="breadcrumb-item"><a href="{{ route('rKontrak') }}">Home</a></li>
                        <li class="breadcrumb-item active">Note Revisi Kontrak</li>
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
                    <a href="{{ route('editLampiran', ['id' => $revisi->kontraks_id]) }}" class="btn btn-primary mb-3">Edit Lampiran</a>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Pesan Revisi</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- <div class="container"> --}}
                                <div class="row">
                                    <p>{{ $revisi->revisi }}</p>
                                </div>
                            {{-- </div> --}}
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