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
                        <li class="breadcrumb-item"><a href="{{ route('vendor.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Edit Akta Vendor</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('vendor.update',['registration_no' => $data->registration_no]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Akta Vendor</h3>
                            </div>
                            <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="vendor_name">Nama Vendor</label>
                                        <input type="text" class="form-control" name="vendor_name" readonly value="{{ $data->vendor_name }}" id="vendor_name" required>
                                        @error('vendor_name')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="pihakname">Nama Pihak</label>
                                        <input type="text" class="form-control" name="pihakname" 
                                            @if (@$data->vendortext->pihakname)
                                                value="{{ @$data->vendortext->pihakname }}"
                                            @else
                                                value="{{ @$data->vendor[0]->full_name }}"
                                            @endif
                                        id="pihakname" required>
                                        @error('pihakname')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="npwp">No NPWP</label>
                                        <input type="text" class="form-control" name="npwp" value="{{ @$data->vendortext->tax_document_number }}" id="npwp" required>
                                        @error('npwp')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                     
                                    <div class="form-group">
                                        <label for="akta">Akta</label>
                                        <textarea type="text" class="form-control" name="akta" id="akta">{!! @$data->vendortext->akta !!}</textarea required>
                                        @error('akta')
                                        <small style="color: red;">{{ $message }}</small>
                                        @enderror
                                    </div>
                                   
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('vendor.index') }}" class="btn btn-danger">Cancel</a>
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
        // $(document).ready(function() {
        //     $('#akta').summernote();
        //     $.get(`/dataNpwp/{{ $data->registration_no }}}`, function(data) {
        //         // Setelah mendapatkan data, set nilai textarea
        //         $('#npwp').val(data.tax_document_number);
        //         console.log(data);
        //     });
            
        // });

        $(document).ready(function() {
            $('#akta').summernote();
            // $('#akta').summernote({
            //    toolbar: [
            //         ['style', ['style']],
            //         ['font', ['bold', 'underline', 'clear']],
            //         ['fontsize', ['fontsize']],
            //         ['fontname', ['fontname']],
            //         ['color', ['color']],
            //         ['para', ['ul', 'ol', 'paragraph']],
            //         ['table', ['table']],
            //         ['insert', ['link', 'picture', 'video']],
            //         ['view', ['fullscreen', 'codeview', 'help']],
            //     ],
            // });


            $.get(`/dataNpwp/{{ $data->registration_no }}`, function(data) {
                // Pastikan bahwa respons yang diterima dapat diuraikan dengan benar sebagai JSON
                try {
                    // Setelah mendapatkan data, set nilai input
                    $('#npwp').val(data.tax_document_number);
                    console.log(data);
                } catch (error) {
                    console.error("Error parsing JSON data: ", error);
                }
            }).fail(function(xhr, status, error) {
                console.error("Failed to fetch NPWP data:", error);
            });
            $.get(`/dataPejabatVendor/{{ $data->registration_no }}`, function(data) {
                // Pastikan bahwa respons yang diterima dapat diuraikan dengan benar sebagai JSON
                try {
                    // Setelah mendapatkan data, set nilai input
                    $('#pihakname').val(data.full_name);
                    console.log(data);
                } catch (error) {
                    console.error("Error parsing JSON data: ", error);
                }
            }).fail(function(xhr, status, error) {
                console.error("Failed to fetch NPWP data:", error);
            });
        });
    </script>
@endpush