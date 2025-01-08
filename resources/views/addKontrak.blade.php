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

    .note-editor.note-frame.panel.panel-default.fullscreen {
        background-color: #fff;
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
                                            <select class="form-control" name="jenis_kontrak" required>
                                                <option value="" disabled selected hidden>Jenis Kontrak</option>
                                                <option value="lumpsum">Lumpsum</option>
                                                <option value="harga_satuan">Harga Satuan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2" style="text-align: center;">
                                            <select class="form-control" name="status_jaminan" required>
                                                <option value="" disabled selected hidden>Status Jaminan</option>
                                                <option value="jaminan">Jaminan</option>
                                                <option value="tanpa_jaminan">Tanpa Jaminan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row justify-content-center mt-2">
                                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center;">
                                            <select class="form-control select2" name="purchasing_document_number" id="purchasing_document_number">
                                                <option value="">Pilih No SOP</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row justify-content-center">
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="nomor_sop">Nomor SOP</label>
                                                <input type="number" placeholder="Masukkan No SOP" name="nomor_sop" class="form-control" id="nomor_sop" required>
                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                <small style="color: red;" class="error-message" id="error_nomor_sop"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="tanggal_sop">Tanggal SOP</label>
                                                <input type="date" name="tanggal_sop" class="form-control" id="tanggal_sop" required>
                                                <!-- tempat error -->
                                               <small style="color: red;" class="error-message" id="error_tanggal_sop"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <label for="perihal">Perihal</label>
                                                <input type="text" placeholder="Masukan Perihal" name="perihal" class="form-control" id="perihal" required>
                                                <!-- tempat naro error -->
                                                <small style="color: red;" class="error-message" id="error_perihal"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="date_kontrak">Tanggal Kontrak</label>
                                                <input type="date" name="date_kontrak" class="form-control" id="date_kontrak" required>
                                                <!-- tempat error -->
                                               <small style="color: red;" class="error-message" id="error_date_kontrak"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-8 col-md-6">
                                            <div class="form-group">
                                                <label for="nm_vendor">Nama Vendor</label>
                                                <input type="text" placeholder="Nama Vendor" name="nm_vendor" class="form-control" id="nm_vendor" readonly>
                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                <small style="color: red;" class="error-message" id="error_nm_vendor"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="noSP">Nomor Kontrak</label>
                                                <input type="number" placeholder="Masukkan No SP" name="number" class="form-control" id="number" required>
                                                <!-- TEMPAT BUAT NARO ERROR -->
                                               <small style="color: red;" class="error-message" id="error_number"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="pembuat">Nama Pembuat Kontrak</label>
                                                <input type="text" name="pembuat" class="form-control" id="pembuat" value="{{ Auth::user()->name }}" disabled>
                                                <!-- tempat naro error -->
                                               <small style="color: red;" class="error-message" id="error_pembuat"></small>
                                            </div>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                            <div class="form-group">
                                                <label for="unit_kerja">Unit Kerja</label>
                                                <input type="text" name="unit_kerja" class="form-control" id="unit_kerja" value="{{ Auth::user()->unit_kerja }}" disabled>
                                                <!-- tempat naro error -->
                                                <small style="color: red;" class="error-message" id="error_unit_kerja"></small>
                                            </div>
                                        </div>
                                        {{-- kolom input akta --}}
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="peruri_text">Akta Peruri</label>
                                                <textarea name="peruri_text" class="form-control" id="peruri_text" cols="30" rows="10">{!! $setting->peruri_akta !!}</textarea>
                                                <!-- tempat naro error -->
                                                <small style="color: red;" class="error-message" id="error_peruri_text"></small>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="akta">Akta Vendor</label>
                                                <textarea class="form-control summernote" rows="5" style="resize: vertical; width: 100%;" name="akta" id="akta"></textarea>
                                                <!-- tempat naro error -->
                                               <small style="color: red;" class="error-message" id="error_akta"></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-secondary" onclick="submit_data()">
                                        <span id="loading-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Submit</button>
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

@endsection

@push('scripts')
{{-- select 2 --}}
<link rel="stylesheet" href="{{ asset('assets/select2.min.css') }}">
<script src="{{ asset('assets/select2.min.js') }}"></script>
<script src="{{ asset('assets/summernote-0.8.18-dist/summernote.min.js') }}"></script>
<script>

    $(document).ready(function() {
        $('#peruri_text').summernote();
    });


    $(document).ready(function(){
        $('#loading-spinner').hide();
    });

    function submitKontrak() {
        var formKontrak = $('#inputKontrak');
        var formData = formKontrak.serialize();
        // console.log(formKontrak);

        $.ajax({
            method: 'POST',
            url: 'loadKontrak',
            data: formData,
            beforeSend: function(){
                $('#loading-spinner').show();
                // Clear previous error messages
                $('.error-message').text('');
            },
            success: function(result) {
                $('#loading-spinner').hide();
                // console.log(result.message)
                if (result.redirect) {
                    window.location.href = result.redirect; // Mengarahkan ke halaman monitoring
                }
            },
            error: function(xhr) {
                $('#loading-spinner').hide();
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    // Display error messages
                    for (var key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            $('#error_' + key).text(errors[key][0]);
                        }
                    }
                }
            }
        });

    }

    function submit_data() {
        submitKontrak()
    }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.select2').select2({
            ajax: {
                url: 'dataSOP',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log(data);
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.purchasing_document_number + '\xa0\xa0\xa0\xa0\xa0\xa0\xa0' + item.vendor_name,
                                id: item.purchasing_document_number,
                                document_date: item.document_date,
                                tender_name: item.tender_name,
                                vendor_name: item.vendor_name,
                                akta: item.akta

                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('.select2').on('select2:select', function(e) {
            var data = e.params.data;
            console.log(data);
            $('#perihal').val(data.tender_name); // Isi nilai perihal
            $('#nomor_sop').val(data.id); // Isi nilai nomor SOP
            $('#tanggal_sop').val(data.document_date); // Isi nilai tanggal SOP
            $('#date_kontrak').val(data.document_date);
            $('#nm_vendor').val(data.vendor_name);
            $('textarea[name="akta"]').summernote('code',data.akta);


        });

        $('.summernote').summernote();
    });
</script>
@endpush
