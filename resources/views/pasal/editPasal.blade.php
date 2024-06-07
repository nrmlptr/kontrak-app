@extends('layout.main')
@section('content')
<style>
    .note-editable ul {
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
                        <li class="breadcrumb-item active">Edit Pasal</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('updatePasal',['id' => $data->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Data Pasal</h3>
                            </div>
                            <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="nama_pasal">Nama Pasal</label>
                                        <input type="text" class="form-control" name="nama_pasal" value="{{ $data->nama_pasal }}" id="nama_pasal" required>
                                        @error('nama_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="keterangan_pasal">Keterangan Pasal</label>
                                        <input type="text" class="form-control" name="keterangan_pasal" value="{{ $data->keterangan_pasal }}" id="keterangan_pasal">
                                        @error('keterangan_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="urutan">Urutan Pasal</label>
                                        <input type="number" min="1" class="form-control" name="urutan" id="urutan" value="{{ $data->urutan }}" required>
                                        @error('urutan')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="status_jaminan">Status Jaminan</label>
                                        <select name="status_jaminan" id="status_jaminan" class="form-control">
                                            
                                            <option value="1">Jaminan</option>
                                            <option value="2" @if ($data->status_jaminan=='2')
                                                selected
                                            @endif>Tanpa Jaminan</option>
                                        </select>
                                        @error('status_jaminan')
                                        <small style=" color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_kontrak">Jenis Kontrak</label>
                                        <select name="jenis_kontrak" id="jenis_kontrak" class="form-control">
                                            
                                            <option value="1">Lumpsum</option>
                                            <option value="2" @if ($data->jenis_kontrak=='2')
                                                selected
                                            @endif>Harga Satuan</option>
                                        </select>
                                        @error('jenis_kontrak')
                                        <small style=" color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="isi_pasal">Isi Pasal</label>
                                        <textarea type="text" class="form-control" name="isi_pasal" id="isi_pasal">{!! $data->isi_pasal !!}</textarea>
                                        @error('isi_pasal')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                   
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('vPasal') }}" class="btn btn-danger">Cancel</a>
                                </div>
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
    <script src="{{ asset('assets/summernote-0.8.18-dist/summernote.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
    <script type="text/javascript">
        
        // $(document).ready(function() {
        //     $('#isi_pasal').summernote();
            
        // });

        $(document).ready(function() {
            $('#isi_pasal').summernote({
                // height: 300, // Set the height of the editor
               toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
            });
        });
    </script>
@endpush