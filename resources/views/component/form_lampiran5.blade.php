<div class="row">
    <form id="inputLampiran5">
        @csrf
        <input type="hidden" name="kontraks_id" id="kontraks_id" value="{{ $data->id }}">
        <div id="loadinputlampiran5"></div>
        <div class="card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran5()">Submit</button>
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
            <div class="form-group col-2">
                <label for="no_sppb">Nomor SPPB</label>
                <input type="text" name="no_sppb[]" class="form-control" required>
                
            </div>
            <div class="form-group col-5">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang[]" placeholder="Nama Barang" value="${row.material_name}" class="form-control" readonly required>
                   
            </div>
            <div class="form-group col-1">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan[]" class="form-control" value="${row.purchase_order_unit_of_measure}" required readonly>
                
            </div>
            <div class="form-group col-2">
                <label for="harga_awal">Harga Sebelum PPN</label>
                <input type="text" name="harga_awal[]" class="form-control" value="${row.net_price}" required readonly>
               
            </div>
            <div class="form-group col-1">
                <label for="jumlah">Jumlah</label>
                <input type="text" name="jumlah[]" class="form-control"  value="${row.purchase_order_quantity}" required readonly>
               
            </div>
            <div class="form-group col-1">
                <label for="ppn">PPN %</label>
                <input type="text" name="ppn[]" class="form-control" required>
                
            </div>
            <hr>
            <div class="form-group col-3">
                <label for="harga_akhir">Total Harga + PPN</label>
                <input type="text" name="harga_akhir[]" class="form-control" required>
                
            </div>
            
            </div>`;
            });

            $('#loadinputlampiran5').append(fields);
           
        }
    }

    // Fungsi untuk melakukan perhitungan nilai input jumlah atau harga_awal 
$(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], input[name="ppn[]"]', function() {
    // Mendapatkan nilai input jumlah, harga_awal, dan ppn pada baris yang terkait
    var row = $(this).closest('.row');
    var jumlah = parseFloat(row.find('input[name="jumlah[]"]').val()) || 0;
    var hargaAwal = parseFloat(row.find('input[name="harga_awal[]"]').val()) || 0;
    var ppn = parseFloat(row.find('input[name="ppn[]"]').val()) || 0;

    // Melakukan perhitungan total harga + PPN
    var totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));

    // Hasil perhitungan dimasukkan ke input harga_akhir pada baris yang terkait
    row.find('input[name="harga_akhir[]"]').val(totalHarga.toFixed(2));
});


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
</script>
@endpush