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
            <div class="form-group">
                <label for="template">Contoh Template Kalimat</label>
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Template Kalimat</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p id="templateText">
                            yang dalam hal ini jabatannya selaku Direktur Utama dari dan oleh karena itu bertindak untuk dan atas nama <span class="highlight">PT. Kertas Padalarang</span> yang didirikan dengan Akta Notaris <span class="highlight">Nomor: 4 tanggal 1 April 1992 yang dibuat dihadapan Masri Husen S.H., Notaris di Bandung</span> dan telah diubah untuk terakhir kalinya dengan <span class="highlight">Akta Notaris Nomor: 152 tanggal 09 Desember 2021 yang dibuat oleh Ekaputri MS Respati, Sarjana Hukum, M.H, M.Kn, Notaris di Bandung</span> yang dibuat berdasarkan Hukum Negara RI, yang berkedudukan hukum di <span class="highlight">Jl. Cihaliwung No. 181, Padalarang, Bandung, Jawa Barat</span>, dengan Nomor Pokok Wajib Pajak (NPWP) Nomor: <span class="highlight">01.000.015.6-051.000</span> yang untuk selanjutnya dalam perbuatan hukum ini disebut sebagai : <br>
                            ---------------------------------------- PIHAK KEDUA ------------------------------------
                        </p>
                        <button type="button" class="btn btn-secondary mt-2" onclick="copyTemplate()">Copy Template</button>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="form-group col-12">
                            <label for="alamat">Alamat Vendor</label>
                            <textarea type="text" id="alamat" class="form-control" disabled></textarea>
                        </div>
                    </div>
                    
                </div>
            </div>
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
    <style>
        .highlight {
            background-color: yellow;
            font-weight: bold;
        }
    </style>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/summernote-0.8.18-dist/summernote.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
    <script>
        function copyTemplate() {
            var templateText    = document.getElementById("templateText").innerText;
            var textarea        = document.createElement("textarea");
            textarea.value      = templateText;
            document.body.appendChild(textarea);
            textarea.select();
            document.execCommand("copy");
            document.body.removeChild(textarea);
            alert("Template copied to clipboard!");
        }

        $(document).ready(function() {
            $('#akta').summernote();
            // GET DATA NPWP VENDOR ===========================================================================
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
            // GET DATA PEJABAT VENDOR =========================================================================
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
                console.error("Failed to fetch Nama Pejabat Vendor data:", error);
            });
            // GET DATA ALAMAT VENDOR ===========================================================================
            $.get(`/dataAlamatVendor/{{ $data->registration_no }}`, function(data) {
                // Pastikan bahwa respons yang diterima dapat diuraikan dengan benar sebagai JSON
                try {
                    // Setelah mendapatkan data, set nilai input
                    $('#alamat').val(data.alamat);
                    console.log(data);
                } catch (error) {
                    console.error("Error parsing JSON data: ", error);
                }
            }).fail(function(xhr, status, error) {
                console.error("Failed to fetch Alamat Vendor data:", error);
            });
        });
    </script>
@endpush