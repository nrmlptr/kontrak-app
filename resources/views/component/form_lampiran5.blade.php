<div class="row">
    <form id="inputLampiran5">
        @csrf
        <input type="hidden" name="kontraks_id" id="kontraks_id" value="{{ $data->id }}">
        {{-- FORM INPUT PPN JADI 1 SAJA --}}
        <div class="row">
            <div class="form-group col-1">
                <label for="ppn">PPN %</label>
                <input type="text" name="ppn" class="form-control" id="ppn" value="11" required>
            </div>
            <div class="form-group col-4">
                <label for="waktu_khs">Jangka Waktu (Harga Satuan)</label>
                <input type="text" name="waktu_khs" class="form-control" id="waktu_khs" required>
            </div>
        </div>
        <hr>
        {{-- FORM DINAMIS --}}
        <div id="loadinputlampiran5"></div>
        {{-- FORM FOOTER TOTAL KESELURUHAN --}}
        <div class="card-footer">
            <hr>
            <div class="form-group col-3">
                <label for="total_keseluruhan">Total Keseluruhan</label>
                <input style=" border: 2px solid #ff0000;" type="text" name="total_keseluruhan" class="form-control" required readonly>   
            </div>
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran5()">Submit</button>
        </div>
    </form>
</div>
@push('scripts')
    <script type="text/javascript">
    
        // Fungsi untuk mengisi nilai input form dengan data barang
        function isiNilaiForm5(dataBarang) {
            // console.log(dataBarang)
            if (dataBarang) {
                var fields = ``;
                dataBarang.forEach(function(row) {
                    fields+=`
                <div class="row">
                <div class="form-group col-1">
                    <label for="no_sppb">No.SPPB</label>
                    <input type="text" name="no_sppb[]" class="form-control" value="${row.purchase_requisition_number}" id="nosppblampiran5" required readonly>
                    
                </div>
                <div class="form-group col-2">
                    <label for="nama_barang">Kode Barang</label>
                    <input type="text" name="kode_barang[]" placeholder="Kode Barang" value="${row.material_number}" id="kodebaranglampiran5" class="form-control" readonly required>
                    
                </div>
                <div class="form-group col-4">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang[]" placeholder="Nama Barang" value="${row.material_name}" id="nmbaranglampiran5" class="form-control" readonly required>
                    
                </div>
                <div class="form-group col-1">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan[]" class="form-control" value="${row.purchase_order_unit_of_measure}" id="satuanlampiran5" required readonly>
                    
                </div>
                <div class="form-group col-2">
                    <label for="lokasi">Lokasi Gudang</label>
                    <input type="text" name="plant[]" class="form-control" value="${row.plant}" id="plantlampiran5" required readonly>                    
                </div>
                <div class="form-group col-2">
                    <label for="harga_awal">Harga Sebelum PPN</label>
                    <input type="text" name="harga_awal[]" class="form-control" value="${row.net_price}" id="hargaawallampiran5" required readonly>
                
                </div>
                <div class="form-group col-1">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" name="jumlah[]" class="form-control"  value="${row.purchase_order_quantity}" id="jumlahlampiran5" required readonly>
                
                </div>
               
                <div class="form-group col-2">
                    <label for="harga_akhir">Total Harga + PPN</label>
                    <input type="text" name="harga_akhir[]" class="form-control" required readonly>
                    
                </div>
                
                </div>`;
                });

                $('#loadinputlampiran5').append(fields);
            
                // Panggil fungsi replacePlantValues setelah menambahkan fields ke dalam DOM
                replacePlantValues();
            }
        }

        //===============================================================================================
        // Fungsi untuk melakukan perhitungan nilai
        // Inisialisasi totalKeseluruhan di luar fungsi
        // var totalKeseluruhan = 0;

        // $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], input[name="ppn[]"]', function() {
        //     // Bersihkan nilai totalKeseluruhan
        //     totalKeseluruhan = 0;

        //     // Iterasi untuk setiap barang
        //     $('input[name="harga_akhir[]"]').each(function() {
        //         var totalHarga = 0;
        //         var row = $(this).closest('.row');
        //         var jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
        //         var hargaAwal = parseInt(row.find('input[name="harga_awal[]"]').val()) || 0;
        //         var ppn = parseInt(row.find('input[name="ppn[]"]').val()) || 0;    //set nilai default ppn

        //         // Perhitungan total harga akhir untuk barang saat ini
        //         totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));

        //         // Mengisi nilai total harga akhir pada input harga_akhir
        //         $(this).val(totalHarga.toFixed(2));

        //         // Menambahkan total harga akhir barang saat ini ke totalKeseluruhan
        //         totalKeseluruhan += totalHarga;
        //     });

        //     // Mengisi nilai total keseluruhan ke dalam input total_keseluruhan
        //     $('input[name="total_keseluruhan"]').val(totalKeseluruhan.toFixed(2));
        // });

        //========================================================================================================================

        // after modified fungsi perhitungan harga
        function hitungTotalHarga() {
            var totalKeseluruhan = 0;
            var ppn = parseInt($('#ppn').val()) || 11;  // Default PPN 11% jika tidak ada nilai yang dimasukkan

            $('input[name="harga_akhir[]"]').each(function() {
                var totalHarga = 0;
                var row = $(this).closest('.row');
                var jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
                var hargaAwal = parseInt(row.find('input[name="harga_awal[]"]').val()) || 0;
                // var ppn = parseInt(row.find('input[name="ppn[]"]').val()) || parseInt(row.find('input[name="ppn[]"]').attr('data-ppn')) || 0;

                totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));
                $(this).val(totalHarga.toFixed(2));
                totalKeseluruhan += totalHarga;
            });

            $('input[name="total_keseluruhan"]').val(totalKeseluruhan.toFixed(2));
        }

        // $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], input[name="ppn[]"]', function() {
        //     hitungTotalHarga();
        // });

        $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], #ppn', function() {
            hitungTotalHarga();
        });

        //=========================================================================================================================
        // SUBMIT DATA
        function submitLampiran5() {
            var form = $('#inputLampiran5');

            $.ajax({
                method: "POST",
                url: "{{ route('submitLampiran5') }}",
                data: form.serialize(),
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran6').addClass('show');
                    console.log(result.message);
                    // if (result.redirect) {
                    //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                    // }
                }
            });
        }

        function submit_Lampiran5() {
            submitLampiran5();
        }
    </script>
@endpush
