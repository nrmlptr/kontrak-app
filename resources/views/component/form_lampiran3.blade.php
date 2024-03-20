<div class="row">
    @if($errors->any())
    <ul class="alert alert-danger">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <form id="inputLampiran3" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-12">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jspek" id="standarLab" value="1">
                    <label class="form-check-label" for="standarLab">Standar Lab</label>
                </div>
                <div class="form-check col-12">
                    <input class="form-check-input" type="radio" name="jspek" id="nonStandarLab" value="2">
                    <label class="form-check-label" for="nonStandarLab">Non Standar Lab</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group" id="formGambar" style="display: none;">
                <div class="mb-3">
                    <label for="gambar">Upload Spesifikasi (Image Only)</label>
                    <input type="file" name="gambar" id="gambar" multiple class="form-control" >
                </div>


                {{-- <label for="gambar">Upload Spesifikasi (Image Only)</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-15" id="gambar" name="gambar[]" multiple>
                        <label class="custom-file-label" for="gambar">Choose file</label>
                    </div>
                </div> --}}
               
            </div>
        </div>
       
        <div class="row">
            <div class="form-group col-2" id="formText" style="display: none;">
                <label for="inputNOSPPB">Nomor SPPB</label>
                <input type="text" name="no_sppb" class="form-control">
            </div>
            <div class="form-group col-2" id="formText2" style="display: none;">
                <label for="inputKodeBarang">Kode Barang</label>
                <input type="text" name="kode_barang" class="form-control">
            </div>
            <div class="form-group col-6" id="formText4" style="display: none;">
                <label for="jenisBarang">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control">
            </div>
            <div class="form-group mr-5 col-6" id="formText5" style="display: none;">
                <label for="inputText">Keterangan Non Spesifikasi Lab</label>
                <textarea class="form-control" rows="3" style="width: auto;" placeholder="Masukkan Spesifikasi" name="spesifikasi_teknis"></textarea>
            </div>
        </div>
        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran3()">Submit</button>
        </div>
    </form>
</div>

<script type="text/javascript">
    // Memanggil fungsi untuk mengisi nilai input form dengan data barang
    function isiNilaiForm3(dataBarang) {
        // console.log(dataBarang);
        // Pastikan dataBarang tidak kosong
        if (dataBarang) {
            // Mengisi nilai input form dengan data barang
            $('input[name="kode_barang"]').val(dataBarang.material_number);
            $('input[name="nama_barang"]').val(dataBarang.material_name);

            // console.log(dataBarang.material_number);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen radio button
        var standarLabRadio = document.getElementById('standarLab');
        var nonStandarLabRadio = document.getElementById('nonStandarLab');

        // Ambil elemen form gambar dan form teks
        var formGambar = document.getElementById('formGambar');
        var formText = document.getElementById('formText');
        var formText2 = document.getElementById('formText2');
        // var formText3 = document.getElementById('formText3');
        var formText4 = document.getElementById('formText4');
        var formText5 = document.getElementById('formText5');

        // Tambahkan event listener untuk setiap perubahan pada radio button
        standarLabRadio.addEventListener('change', function() {
            // Jika standarLabRadio dipilih, tampilkan formGambar dan sembunyikan formText
            if (this.checked) {
                formGambar.style.display = 'block';
                formText.style.display = 'none';
                formText2.style.display = 'none';
                formText4.style.display = 'none';
                formText5.style.display = 'none';
            }
        });

        nonStandarLabRadio.addEventListener('change', function() {
            // Jika nonStandarLabRadio dipilih, tampilkan formText dan sembunyikan formGambar
            if (this.checked) {
                formGambar.style.display = 'none';
                formText.style.display = 'block';
                formText2.style.display = 'block';
                formText4.style.display = 'block';
                formText5.style.display = 'block';

                // Tampilkan semua elemen dalam formText container
                var formTextElements = formText.querySelectorAll('.form-group');
                formTextElements.forEach(function(element) {
                    element.style.display = 'block';
                });

                $(document).ready(function() {
                    var nomor_sop = "{{ $data->nomor_sop }}";

                    $.ajax({
                        type: 'GET',
                        url: "{{route('dataBarang')}}",
                        data: {
                            _token: $("input[name='_token']").val(),
                            po: nomor_sop
                        },
                        success: function(response) {
                            // console.log(response[0]);
                            if (response[0].id) {
                                // $('#kontraks_id').val(response.kontraks.id);
                                isiNilaiForm3(response[0]);
                            } else {
                                console.log("Kontrak tidak ditemukan");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log("error");
                        }
                    });
                });
            }
        });

        // Setelah DOM dimuat, periksa status awal radio button
        if (nonStandarLabRadio.checked) {
            formGambar.style.display = 'none';
            formText.style.display = 'block';
            formText2.style.display = 'block';
            formText4.style.display = 'block';
            formText5.style.display = 'block';
        }
    });



    function submitLampiran3() {
        var form = $('#inputLampiran3');
        console.log(form.serialize())
        $.ajax({
            method: "POST",
            url: "{{ route('submitLampiran3') }}",
            data: form.serialize(),
            success: function(result) {
                $(".collapse").removeClass('show');
                $('#collapseLampiran4').addClass('show');
                console.log(result.message);
                // if (result.redirect) {
                //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                // }
            }
        });
    }

    function submit_Lampiran3() {
        submitLampiran3();
    }
</script>