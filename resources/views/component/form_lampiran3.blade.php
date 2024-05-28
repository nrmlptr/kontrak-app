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
                    <input class="form-check-input" type="radio" name="jspek" id="standarLab" value="1" checked>
                    <label class="form-check-label" for="standarLab">Standar Lab</label>
                </div>
                <div class="form-check col-12">
                    <input class="form-check-input" type="radio" name="jspek" id="nonStandarLab" value="2">
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
    
        <div class="row d-none" id="loadnonstandar"></div>
        <div class=" card-footer">
            <button type="submit" class="btn btn-block btn-secondary btn-lg" >Submit</button>
        </div>
    </form>
</div>


@push('scripts')
    
    <script type="text/javascript">
        // Memanggil fungsi untuk mengisi nilai input form dengan data barang
        function isiNilaiForm3(dataBarang) {
            if (dataBarang) {
                var fields = ``;
                dataBarang.forEach(function(row) {
                    fields+=`<div class="form-group">
                    <label for="gambarnon">Upload Gambar (Optional)</label>
                    <input type="file" name="gambarnon[]" id="gambarnon[]" multiple class="form-control" >
                    </div>
                    <div class="form-group col-1">
                    <label for="inputNOSPPB">No.SPPB</label>
                        <input type="text" name="no_sppb[]" class="form-control" value="${row.purchase_requisition_number}" readonly>
                    </div>
                    <div class="form-group col-2">
                        <label for="inputKodeBarang">Kode Barang</label>
                        <input type="text" name="kode_barang[]" class="form-control" value="${row.material_number}" readonly>
                    </div>
                    <div class="form-group col-5">
                        <label for="jenisBarang">Nama Barang</label>
                        <input type="text" name="nama_barang[]" class="form-control" value="${row.material_name}" readonly>
                    </div>
                    <div class="form-group col-1">
                        <label for="jenisBarang">Satuan</label>
                        <input type="text" name="satuan[]" class="form-control" value="${row.purchase_order_unit_of_measure}" readonly>
                    </div>
                    <div class="form-group col-12">
                        <label for="inputText">Keterangan Non Spesifikasi Lab</label>
                        <textarea class="form-control" rows="3" placeholder="Masukkan Spesifikasi" name="spesifikasi_teknis[]"></textarea>
                    </div>`;
                });

                $('#loadnonstandar').html(fields);
            }
        }

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
        });


        $('#inputLampiran3').submit(function(e) {
            e.preventDefault();
            
            let formData = new FormData(this);
            
            $.ajax({
                url: "{{ route('submitLampiran3') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(result) {
                    // // Tambahkan notifikasi flash di sini
                    // flash()
                    //     .option('position', 'top-center')
                    //     .option('timeout', 3000)
                    //     .addSuccess('Lampiran 3 Berhasil Dibuat!');
                        
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran4').addClass('show');
                    console.log(result.message);
                },
                error: function(xhr, status, error) {
                    var err = JSON.parse(xhr.responseText);
                    $('#validationErrors').html(err.message);
                    // Tambahkan notifikasi flash di sini jika diperlukan
                    // flash()
                    //     .option('position', 'top-center')
                    //     .option('timeout', 3000)
                    //     .addError('Lampiran 3 Gagal Dibuat!');

                }
            });
        });
    
    </script>
    
@endpush