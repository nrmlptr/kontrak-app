@extends('layout.main')
@section('content')
<style>
    input {
        border-radius: 1em;
    }
</style>

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
                        <li class="breadcrumb-item"><a href="{{ route('rKontrak') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add Revisi
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <!-- left column -->
                <div class="col-lg-12 d-flex align-items-strech">
                    <!-- general form elements -->
                    <div class="card card-primary w-100">
                        <div class="card-header">
                            <h3 class="card-title">Input Revisi Kontrak</h3>
                        </div>
                        <br>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <form id="inputRevisi">
                                    @csrf
                                    <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="noSOP_manual">Nomor Kontrak</label>
                                                <input type="text" name="no_kontrak" class="form-control" id="no_kontrak" value="{{ $data->detail_number }}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="date_kontrak">Tanggal Kontrak</label>
                                                <input type="date" name="date_kontrak" class="form-control" id="date_kontrak" value="{{ $data->date_kontrak }}" required readonly>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="revisi">Revisi Kontrak</label>
                                                {{-- <textarea class="form-control" name="revisi" id="revisi" style="display: none;"></textarea> --}}
                                                <textarea name="revisi" id="revisi" cols="30" rows="10" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        {{-- <button type="button" class="btn btn-secondary" onclick="submitRevisi()">Submit</button> --}}
                                        <button class="btn btn-primary" type="button" onclick="submitRevisi()">
                                            <span id="loading-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>

<!-- Script Anda -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#loading-spinner').hide();
    });


    // submit data
    function submitRevisi() {
        var formRevisi = $('#inputRevisi');
        // console.log(formRevisi);
        
        $.ajax({
            method: 'POST',
            url: "{{ route('submitRevisi') }}",
            data: formRevisi.serialize(),
            beforeSend: function(){
                $('#loading-spinner').show();
            },
            success: function(result) {
                $('#loading-spinner').hide();
                // console.log(result.message)
                if (result.redirect) {
                    window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                }
            }
        });

    }
</script>
@endsection