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
                    <h3 class="card-title mr-3">Edit Lampiran - Konsep Kontrak</h3>
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
                "#nosoplampiran6", "#tglsoplampiran6", "#nosplampiran6", "#tglsplampiran6", "#bulan-khs", "#tahun"
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
    </script>
@endpush
