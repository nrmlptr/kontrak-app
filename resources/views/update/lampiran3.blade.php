@php
    $lampiran3=$data->lampiran3;
@endphp
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
                    <input class="form-check-input" type="radio" name="jspek" id="standarLab" value="1" checked >
                    <label class="form-check-label" for="standarLab">Standar Lab</label>
                </div>
                <div class="form-check col-12">
                    <input class="form-check-input" type="radio" name="jspek" id="nonStandarLab" value="2" >
                    <label class="form-check-label" for="nonStandarLab">Non Standar Lab</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div id="formGambar">
                <div class="form-group">
                    <div class="mb-3">
                        <label for="gambar">Upload Spesifikasi (Image Only)</label>
                        <input type="file" name="gambar[]" id="gambar[]" multiple class="form-control" >
                    </div>
                </div> 
                <div id="validationErrors" style="color: red;"></div>
            </div>
        </div>
        
        <div class="row d-none" id="loadnonstandar">
            @if (@$lampiran3[0]->jenis_spesifikasi=='2')
                @foreach (@$lampiran3 as $l)
                    <div class="form-group col-2">
                        <label for="inputNOSPPB">Nomor SPPB</label>
                        <input type="text" name="no_sppb[]" value="{{ $l->no_sppb }}" class="form-control" readonly>
                    </div>
                    <div class="form-group col-2">
                        <label for="inputKodeBarang">Kode Barang</label>
                        <input type="text" name="kode_barang[]" class="form-control" value="{{ $l->kode_barang }}" readonly>
                    </div>
                    <div class="form-group col-6">
                        <label for="jenisBarang">Nama Barang</label>
                        <input type="text" name="nama_barang[]" class="form-control" value="{{ $l->jenis_barang }}" readonly>
                    </div>
                    <div class="form-group col-2">
                        <label for="jenisBarang">Nama Barang</label>
                        <input type="text" name="satuan[]" class="form-control" value="{{ $l->satuan }}" readonly>
                    </div>
                    <div class="form-group col-12">
                        <label for="inputText">Keterangan Non Spesifikasi Lab</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan Spesifikasi" name="spesifikasi_teknis[]">{{ $l->spesifikasi_teknis }}</textarea>
                    </div>
                @endforeach
            @endif
        </div>

        <div class=" card-footer">
            <button type="submit" class="btn btn-block btn-secondary btn-lg" >Submit</button>
        </div>
    </form>
</div>

@push('scripts')
    
    <script type="text/javascript">

        document.addEventListener('DOMContentLoaded', function() {
            // Ambil elemen radio button
            var standarLabRadio = document.getElementById('standarLab');
            var nonStandarLabRadio = document.getElementById('nonStandarLab');

            // Ambil elemen form gambar dan form teks
            var formGambar = document.getElementById('formGambar');
            

            // Tambahkan event listener untuk setiap perubahan pada radio button
            standarLabRadio.addEventListener('change', function() {
                // Jika standarLabRadio dipilih, tampilkan formGambar dan sembunyikan formText
                if (this.checked) {
                    formGambar.style.display = 'block';
                    $('#loadnonstandar').addClass('d-none');
                }
            });

            nonStandarLabRadio.addEventListener('change', function() {
                // Jika nonStandarLabRadio dipilih, tampilkan formText dan sembunyikan formGambar
                if (this.checked) {
                    formGambar.style.display = 'none';
                    $('#loadnonstandar').removeClass('d-none');
                }
            });

            // Setelah DOM dimuat, periksa status awal radio button
            if (nonStandarLabRadio.checked) {
                formGambar.style.display = 'none';
                $('#loadnonstandar').addClass('d-none');
            }

            // Set nilai default yang ingin di pilih
            let nilaiDefault = '{{ @$lampiran3[0]->jenis_spesifikasi }}';

            // Cari radio button dengan nilai yang sesuai dan tandai sebagai terpilih
            $('input[type="radio"][name="jspek"][value="' + nilaiDefault + '"]').trigger('click');
            $('input[type="radio"][name="jspek"]').prop('disabled',true)
        });

        $('#inputLampiran3').submit(function(e) {
            e.preventDefault();
            $('input[type="radio"][name="jspek"]').prop('disabled',false)
            let formData = new FormData(this);
            
            $.ajax({
                url: "{{ route('submitLampiran3') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran4').addClass('show');
                    console.log(result.message);
                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    $('#validationErrors').html(err.message);
                }
            });
        });
    
    </script>
    
@endpush