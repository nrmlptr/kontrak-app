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
                        <li class="breadcrumb-item active">Add Pasal</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('loadPasal') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Tambah Data Pasal</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama_pasal">Nama Pasal</label>
                                        <input type="text" class="form-control" name="nama_pasal" id="nama_pasal" required>
                                        @error('nama_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan_pasal">Keterangan Pasal</label>
                                        <input type="text" class="form-control" name="keterangan_pasal" id="keterangan_pasal" required>
                                        @error('keterangan_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="isi_pasal">Isi Pasal</label>
                                        <input type="text" class="form-control" name="isi_pasal" id="isi_pasal" required>
                                        @error('isi_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_pasal">Jenis Kontrak</label>
                                        <select class="form-control" name="jenis_pasal" id="jenis_pasal" required>
                                            <option value="">Pilih</option>
                                            <option value="1">Jaminan</option>
                                            <option value="2">Tanpa Jaminan</option>
                                        </select>
                                        @error('jenis_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('vPasal') }}" class="btn btn-danger">Cancel</a>
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        
        $(document).ready(function() {
            $('#isi_pasal').summernote();
            
        });
    </script>
@endpush