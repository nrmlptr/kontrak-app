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
                        <li class="breadcrumb-item"><a href="{{ route('setting.edit',$setting->id) }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Akta Peruri</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('setting.update',$setting->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Akta Peruri</h3>
                            </div>
                            <!-- /.card-header -->
                                <div class="card-body">
                                    
                                    <div class="form-group">
                                        <label for="pihakname">Nama Pihak</label>
                                        <input type="text" class="form-control" name="pihakname" value="{{ @$setting->peruri_pihakname }}"
                                        id="pihakname" required>
                                        @error('pihakname')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="akta">Akta Peruri</label>
                                        <textarea type="text" class="form-control" name="akta" id="akta">{!! @$setting->peruri_akta !!}</textarea required>
                                        @error('akta')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                   
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
    <script>
        
        $(document).ready(function() {
            $('#akta').summernote();
        });
    </script>
@endpush