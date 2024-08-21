@extends('layout.main')
@section('content')
<style>
    #accordion .btn {
        border-radius: 100em;
        background-color: #4aacf7;
        border-color: #f7fafa
    }

    input {
        border-radius: 50em;
    }

    .label-collapse {
        font-size: 15pt;
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
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('previewKontrak', ['id' => $data->id]) }}">Back</a></li>
                        <li class="breadcrumb-item active">Edit Konsep Kontrak</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- <div class="row justify-content-center"> -->
            <!-- left column -->
            <!-- <div class="col-lg-12 d-flex align-items-strech"> -->
            <!-- general form elements -->
            <div class="card card-primary w-100">
                <div class="card-header">
                    <h3 class="card-title mr-3">Edit Data - Konsep Kontrak</h3>
                    <a href="{{ route('previewKontrak', ['id' => $data->id]) }}" target="_blank"  style="float: right;" class="btn btn-sm btn-danger mr-1 mb-3">
                        <i class="fas fa-backward"></i> Back
                    </a>
                </div>
                <div class="row mt-2 ml-2">
                    <div class="col-12">
                        <select style="width:auto;" class="form-control" id="lockfitur" onChange="opsi()">
                            <option>Action</option>
                            <option value="on">Unlock</option>
                            <option value="off">Lock</option>
                        </select>
                    </div>
                </div>

                {{-- BAGIAN KONTRAK --}}
                    <div class="col-lg-12 d-flex align-items-strech">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="accordion">
                                    <div class="card" id="kontrak">
                                        <!-- HEADER -->
                                        <div class="card-header" id="headingKontrak">
                                            <h5 class="mb-0">
                                                <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseKontrak">Edit Kontrak</a>
                                                <span class="label-collapse">Perbaiki Data Kontrak</span>
                                            </h5>
                                        </div>
                                        <!-- ISI KONTEN KONTRAK -->
                                        <div id="collapseKontrak" class="collapse" aria-labelledby="headingKontrak" data-parent="#accordion">
                                            <div class="card-body">
                                                <form id="formEditKontrak" action="{{ route('submitUpdateKontrak', ['id' => $data->id]) }}" method="POST">
                                                    @csrf
                                                    {{-- <input type="hidden" value="{{ $data->id }}" name="id"> --}}
                                                    @method('PUT')
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-2" style="text-align: center;">
                                                            <select class="form-control" name="jenis_kontrak" required>
                                                                <option value="{{ $data->jenis_kontrak }}" selected>
                                                                    @if($data->jenis_kontrak == 1)
                                                                        Lumpsum
                                                                    @else
                                                                        Harga Satuan
                                                                    @endif
                                                                </option>
                                                                <option value="" disabled>-- Jenis Kontrak -- </option>
                                                                <option value="lumpsum">Lumpsum</option>
                                                                <option value="harga_satuan">Harga Satuan</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2" style="text-align: center;">
                                                            <select class="form-control" name="status_jaminan" required>
                                                                <option value="{{ $data->status_jaminan }}" selected>
                                                                    @if($data->status_jaminan == 1)
                                                                        Jaminan
                                                                    @else
                                                                        Tanpa Jaminan
                                                                    @endif
                                                                </option>
                                                                <option value="" disabled> -- Status Jaminan -- </option>
                                                                <option value="jaminan">Jaminan</option>
                                                                <option value="tanpa_jaminan">Tanpa Jaminan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="row justify-content-center mt-2">
                                                        <div class="col-md-6 col-sm-6 col-xs-6" style="text-align: center;">
                                                            <select class="form-control select2" name="purchasing_document_number" id="purchasing_document_number">
                                                                <option value="">Pilih No SOP</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <br> --}}
                                                    <br>
                                                    <div class="row justify-content-center">
                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <label for="nomor_sop">Nomor SOP</label>
                                                                <input type="number" placeholder="Masukkan No SOP" name="nomor_sop" class="form-control" id="nomor_sop" value="{{ $data->nomor_sop }}" required>
                                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                                <small style="color: red;" class="error-message" id="error_nomor_sop"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <label for="tanggal_sop">Tanggal SOP</label>
                                                                <input type="date" name="tanggal_sop" class="form-control" id="tanggal_sop" value="{{ $data->tanggal_sop }}" required>
                                                                <!-- tempat error -->
                                                            <small style="color: red;" class="error-message" id="error_tanggal_sop"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                                            <div class="form-group">
                                                                <label for="perihal">Perihal</label>
                                                                <input type="text" placeholder="Masukan Perihal" name="perihal" class="form-control" id="perihal" value="{{ $data->perihal }}" required>
                                                                <!-- tempat naro error -->
                                                                <small style="color: red;" class="error-message" id="error_perihal"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <label for="date_kontrak">Tanggal Kontrak</label>
                                                                <input type="date" name="date_kontrak" class="form-control" id="date_kontrak" value="{{ $data->date_kontrak }}" required>
                                                                <!-- tempat error -->
                                                            <small style="color: red;" class="error-message" id="error_date_kontrak"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-6 col-sm-8 col-md-6">
                                                            <div class="form-group">
                                                                <label for="nm_vendor">Nama Vendor</label>
                                                                <input type="text" placeholder="Nama Vendor" name="nm_vendor" class="form-control" id="nm_vendor" value="{{ $data->nm_vendor }}" readonly required>
                                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                                <small style="color: red;" class="error-message" id="error_nm_vendor"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <label for="noSP">Nomor Kontrak</label>
                                                                <input type="number" placeholder="Masukkan No SP" name="number" class="form-control" id="number" value="{{ $data->number }}" required>
                                                                <!-- TEMPAT BUAT NARO ERROR -->
                                                            <small style="color: red;" class="error-message" id="error_number"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <label for="pembuat">Nama Pembuat Kontrak</label>
                                                                <input type="text" name="pembuat" class="form-control" id="pembuat" value="{{ $data->pembuat }}" readonly required>
                                                                <!-- tempat naro error -->
                                                            <small style="color: red;" class="error-message" id="error_pembuat"></small>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-2 col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <label for="unit_kerja">Unit Kerja</label>
                                                                <input type="text" name="unit_kerja" class="form-control" id="unit_kerja" value="{{ $data->unit_kerja }}" readonly required>
                                                                <!-- tempat naro error -->
                                                                <small style="color: red;" class="error-message" id="error_unit_kerja"></small>
                                                            </div>
                                                        </div>
                                                        {{-- kolom input akta --}}
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="peruri_text">Akta Peruri</label>
                                                                <textarea name="peruri_text" class="form-control" id="peruri_text" cols="30" rows="10">{!! $data->peruritext !!}</textarea>
                                                                <!-- tempat naro error -->
                                                                <small style="color: red;" class="error-message" id="error_peruri_text"></small>
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="akta">Akta Vendor</label>
                                                                <textarea class="form-control summernote" rows="5" style="resize: vertical; width: 100%;" name="akta" id="akta">
                                                                    {!! $data->vendortext !!}
                                                                </textarea>
                                                                <!-- tempat naro error -->
                                                            <small style="color: red;" class="error-message" id="error_akta"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-secondary" >
                                                        <span id="loading-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Submit</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <br>
                <hr>
                {{-- BAGIAN LAMPIRAN --}}
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row col-12">
                        <div id="accordion">
                            <!-- Lampiran 1 -->
                            <div class="card" id="lampiran1">
                                <!-- HEADER -->
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran1">Lampiran 1</a>
                                        <span class="label-collapse">DOKUMEN-DOKUMEN PENGADAAN</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 1 -->
                                <div id="collapseLampiran1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        @include('update/lampiran1')
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran 2 -->
                            <div class="card" id="lampiran2">
                                <!-- HEADER -->
                                <div class="card-header" id="headingTwo">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran2">Lampiran 2</a>
                                        <span class="label-collapse">LINGKUP PEKERJAAN</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 2 -->
                                <div id="collapseLampiran2" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                   @include('update/lampiran2')
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran 3 -->
                            <div class="card" id="lampiran3">
                                <!-- HEADER -->
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran3">Lampiran 3</a>
                                        <span class="label-collapse">SPESIFIKASI TEKNIS</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 3 -->
                                <div id="collapseLampiran3" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                      @include('update/lampiran3')
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran 4 -->
                            <div class="card" id="lampiran4">
                                <!-- HEADER -->
                                <div class="card-header" id="headingFour">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran4">Lampiran 4</a>
                                        <span class="label-collapse">JADWAL PENYERAHAN BARANG</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 4 -->
                                <div id="collapseLampiran4" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body">
                                         @include('update/lampiran4')
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran 5 -->
                            <div class="card" id="lampiran5">
                                <!-- HEADER -->
                                <div class="card-header" id="headingFive">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran5">Lampiran 5</a>
                                        <span class="label-collapse">HARGA BARANG</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 5 -->
                                <div id="collapseLampiran5" class="collapse" aria-labelledby="headingFive" data-parent="#accordion">
                                    <div class="card-body">
                                      @include('update/lampiran5')
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran 6 -->
                            <div class="card" id="lampiran6">
                                <!-- HEADER -->
                                <div class="card-header" id="headingSix">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran6">Lampiran 6</a>
                                        <span class="label-collapse">PEMBAYARAN</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 6 -->
                                <div id="collapseLampiran6" class="collapse" aria-labelledby="headingSix" data-parent="#accordion">
                                    <div class="card-body">
                                   @include('update/lampiran6')
                                    </div>
                                </div>
                            </div>

                            <!-- Lampiran 7 -->
                            <div class="card" id="lampiran7">
                                <!-- HEADER -->
                                <div class="card-header" id="headingSeven">
                                    <h5 class="mb-0">
                                        <a href="" class="btn btn-primary text-white" data-toggle="collapse" data-target="#collapseLampiran7">Lampiran 7</a>
                                        <span class="label-collapse">ALAMAT SURAT MENYURAT</span>
                                    </h5>
                                </div>
                                <!-- ISI KONTEN LAMPIRAN 7 -->
                                <div id="collapseLampiran7" class="collapse" aria-labelledby="headingSeven" data-parent="#accordion">
                                    <div class="card-body">
                                    @include('update/lampiran7konsep')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <!-- <button type="button" class="btn btn-primary" onclick="submit_data()">Submit</button> -->
                </div>
            </div>
            <!-- /.card -->
            <!-- </div> -->
            <!--/.col (left) -->
            <!-- </div> -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/summernote-0.8.18-dist/summernote.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#peruri_text').summernote();
        });


        $(document).ready(function() {
            $('.summernote').summernote();

            // Set inputs to readonly on page load
            setReadonly(true);

            $('#lockfitur').change(function() {
                let isReadonly = $(this).val() === 'off';
                setReadonly(isReadonly);
            });

            var nomor_sop = "{{ $data->nomor_sop }}";

            $.ajax({
                type: 'GET',
                url: "{{route('dataBarang')}}",
                data: {
                    _token: $("input[name='_token']").val(),
                    po: nomor_sop
                },
                success: function(response) {
                    console.log(response);
                    // if (response[0].id) {
                    //     // isiNilaiForm4(response);
                    //     // isiNilaiForm5(response);
                    //     // $.get(`/dataVendor/${response[0].registration_no}`,function(data){
                    //     //     $('textarea[name="alamat_vendor"]').val(data.alamat)
                    //     //  });
                    // } else {
                    //     console.log("Kontrak tidak ditemukan");
                    // }
                },
                error: function(xhr, status, error) {
                    console.log("error");
                }
            });
        });

        function setReadonly(isReadonly) {
            let elements = [
                "#nosurat-header1", "#nosurat-header2", "#nosurat-header3", "#nosurat-header4",
                "#notgl-header1", "#notgl-header2", "#notgl-header3", "#notgl-header4",
                "#nosoplampiran2", "#tglsoplampiran2", "#nosppblampiran3", "#kodebaranglampiran3", "#nmbrglampiran3", "#satuanbrglampiran3", "#nosoplampiran4", "#tglsoplampiran4",
                "#plantlampiran4", "#nosppblampiran4", "#kodebaranglampiran4", "#nmbaranglampiran4",
                "#satuanlampiran4", "#nosppblampiran5", "#kodebaranglampiran5", "#nmbaranglampiran5",
                "#satuanlampiran5", "#plantlampiran5", "#hargaawallampiran5", "#jumlahlampiran5",
                "#nosoplampiran6", "#tglsoplampiran6", "#nosplampiran6", "#tglsplampiran6", "#bulan-khs", "#tahun", "#nm_vendor", "#pembuat", "#unit_kerja"
            ];

            let elementBulanKHS = ["#bulan-khs"];

            elements.forEach(function(element) {
                $(element).prop('readOnly', isReadonly);
            });


            elementBulanKHS.forEach(function(element) {
                if (isReadonly) {
                    $(element).addClass('readonly');
                } else {
                    $(element).removeClass('readonly');
                }
            });

        }

        // Fungsi untuk mengubah properti readOnly berdasarkan pilihan dropdown
        function opsi() {
            var st = $("#lockfitur").val();
            if (st === "on") {
                setReadonly(false);
            } else {
                setReadonly(true);
            }
        }


        // BAGIAN SUBMIT KALAU YANG DI EDIT DATA KONTRAK NYA ======================================================================================================================================================
        $(document).ready(function(){
            $('#loading-spinner').hide();
        });

        $('#formEditKontrak').on('submit', function(e) {
            e.preventDefault(); // Mencegah form dari submit normal

            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                method: "POST",
                url: "{{ route('submitUpdateKontrak', ['id' => $data->id]) }}",
                data: formData,
                beforeSend: function(){
                    $('#loading-spinner').show();
                },
                success: function(result) {
                    $('#loading-spinner').hide();
                    console.log(result.message);
                    if (result.redirect) {
                        window.location.href = result.redirect; // Mengarahkan ke halaman preview lagi
                    } else {
                        alert('Gagal memperbarui kontrak');
                    }
                },
                error: function(xhr, status, error) {
                    $('#loading-spinner').hide();
                    console.error('Error:', error);
                    alert('Terjadi kesalahan dalam memperbarui data. Silakan coba lagi.');
                }
            });
        });
    </script>
@endpush
