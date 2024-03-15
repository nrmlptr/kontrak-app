@extends('layout.main')
@section('content')
<style>
    #accordion .btn {
        border-radius: 2em;
        background-color: #4aacf7;
        border-color: #f7fafa
    }

    input {
        border-radius: 1em;
    }

    .label-collapse {
        font-size: 11pt;
        font-family: 'Segoe UI';

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
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Add Kontrak</li>
                    </ol>
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
                            <h3 class="card-title">Input Kontrak Baru</h3>
                        </div>
                        <br>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <form id="inputKontrak">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-2" style="text-align: center;">
                                            <select class="form-control" name="jenis_kontrak" id="" onchange="">
                                                <option value="" disabled selected hidden>Jenis Kontrak</option>
                                                <option value="jaminan">Jaminan</option>
                                                <option value="tanpa_jaminan">Tanpa Jaminan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center;">
                                            <!-- <select class="select2 select2bs4 browser-default list_sop" name="list_sop" id="list_sop" style="width: 50%">
                                                <option value="" disabled selected hidden>Search NO SOP</option>
                                            </select> -->
                                            <select class="form-control select2" name="purchasing_document_number" id="purchasing_document_number">
                                                <option value="">Pilih No SOP</option>
                                            </select>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row justify-content-center">
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="noSOP_manual">Nomor SOP</label>
                                                <input type="number" placeholder="Masukkan No SOP" name="nomor_sop" class="form-control" id="nomor_sop">
                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                @if($errors->has('nomor_sop'))
                                                <span class="text-danger">{{ $errors->first('nomor_sop') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="tanggal_sop">Tanggal SOP</label>
                                                <input type="date" name="tanggal_sop" class="form-control" id="tanggal_sop">
                                                <!-- tempat error -->
                                                @if($errors->has('tanggal_sop'))
                                                <span class="text-danger">{{ $errors->first('tanggal_sop') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="perihal">Perihal</label>
                                                <input type="text" placeholder="Masukan Perihal" name="perihal" class="form-control" id="perihal">
                                                <!-- tempat naro error -->
                                                @if($errors->has('perihal'))
                                                <span class="text-danger">{{ $errors->first('perihal') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="date_kontrak">Tanggal Kontrak</label>
                                                <input type="date" name="date_kontrak" class="form-control" id="date_kontrak">
                                                <!-- tempat error -->
                                                @if($errors->has('date_kontrak'))
                                                <span class="text-danger">{{ $errors->first('date_kontrak') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="noSP">Nomor SP</label>
                                                <input type="number" placeholder="Masukkan No SP" name="number" class="form-control" id="number">
                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                @if($errors->has('number'))
                                                <span class="text-danger">{{ $errors->first('number') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="pembuat">Nama Pembuat Kontrak</label>
                                                <input type="text" name="pembuat" class="form-control" id="pembuat" value="{{ Auth::user()->name }}" disabled>
                                                <!-- tempat naro error -->
                                                @if($errors->has('pembuat'))
                                                <span class="text-danger">{{ $errors->first('pembuat') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="unit_kerja">Unit Kerja</label>
                                                <input type="text" name="unit_kerja" class="form-control" id="unit_kerja" value="{{ Auth::user()->unit_kerja }}" disabled>
                                                <!-- tempat naro error -->
                                                @if($errors->has('unit_kerja'))
                                                <span class="text-danger">{{ $errors->first('unit_kerja') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-secondary" onclick="submit_data()">Submit</button>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Script Anda -->
<script>
    function submitKontrak() {

        var formKontrak = $('#inputKontrak');
        console.log(formKontrak);

        $.ajax({
            method: 'POST',
            url: 'loadKontrak',
            data: formKontrak.serialize(),
            success: function(result) {
                console.log(result.message)
            }
        });

    }

    function submit_data() {
        submitKontrak()
    }
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            ajax: {
                url: 'dataSOP',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.purchasing_document_number + '\xa0\xa0\xa0\xa0\xa0\xa0\xa0' + item.vendor_name,
                                id: item.purchasing_document_number,
                                document_date: item.document_date, // Pastikan properti document_date ada dalam respons
                                tender_name: item.tender_name // Pastikan properti tender_name ada dalam respons
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('.select2').on('select2:select', function(e) {
            var data = e.params.data;
            $('#perihal').val(data.tender_name); // Isi nilai perihal
            $('#nomor_sop').val(data.id); // Isi nilai nomor SOP
            $('#tanggal_sop').val(data.document_date); // Isi nilai tanggal SOP

        });
    });
</script>


@endsection