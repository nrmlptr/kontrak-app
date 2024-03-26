@php
    $lampiran5=$data->lampiran5;
    $ppnArray=[];
@endphp
<div class="row">
    <form id="inputLampiran5">
        @csrf
        <input type="hidden" name="kontraks_id" id="kontraks_id" value="{{ $data->id }}">
        <div id="loadinputlampiran5">
            @foreach ($lampiran5 as $l)
                @php
                    $ppnArray[]=$l->ppn;
                @endphp
            
            <div class="row">
            <div class="form-group col-1">
                <label for="no_sppb">Nomor SPPB</label>
                <input type="text" name="no_sppb[]" class="form-control" value="{{ $l->no_sppb }}" required>
                
            </div>
            <div class="form-group col-4">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang[]" placeholder="Nama Barang" value="{{ $l->nama_barang }}" class="form-control" readonly required>
                   
            </div>
            <div class="form-group col-1">
                <label for="satuan">Satuan</label>
                <input type="text" name="satuan[]" class="form-control" value="{{ $l->satuan }}" required readonly>
                
            </div>
            <div class="form-group col-2">
                <label for="no_sppb">Lokasi Gudang</label>
                <input type="text" name="lokasi[]" class="form-control" value="{{ $l->lokasi }}" required>
                
            </div>
            <div class="form-group col-2">
                <label for="harga_awal">Harga Sebelum PPN</label>
                <input type="text" name="harga_awal[]" class="form-control" value="{{ $l->harga_awal }}" required readonly>
               
            </div>
            <div class="form-group col-1">
                <label for="jumlah">Jumlah</label>
                <input type="text" name="jumlah[]" class="form-control"  value="{{ $l->qty }}" required readonly>
               
            </div>
            <div class="form-group col-1">
                <label for="ppn">PPN %</label>
                <input type="text" name="ppn[]" class="form-control"  required>
                
            </div>
            <div class="form-group col-2">
                <label for="harga_akhir">Total Harga + PPN</label>
                <input type="text" name="harga_akhir[]" class="form-control" required readonly>
                
            </div>
            
            </div>
            @endforeach
        </div>
        <div class="card-footer">
            <hr>
            <div class="form-group col-3">
                <label for="total_keseluruhan">Total Keseluruhan</label>
                <input style=" border: 2px solid #ff0000;" type="text" name="total_keseluruhan" class="form-control" required readonly>
                
            </div>
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran5()">Submit</button>
        </div>
    </form>
</div>
@push('scripts')
    

<script type="text/javascript">



    // Fungsi untuk menghitung total keseluruhan
function calculateTotal() {
    // Bersihkan nilai totalKeseluruhan
    var totalKeseluruhan = 0;

    // Iterasi untuk setiap barang
    $('input[name="harga_akhir[]"]').each(function() {
        var totalHarga = 0;
        var row = $(this).closest('.row');
        var jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
        var hargaAwal = parseInt(row.find('input[name="harga_awal[]"]').val()) || 0;
        var ppn = parseInt(row.find('input[name="ppn[]"]').val()) || 0;

        // Perhitungan total harga akhir untuk barang saat ini
        totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));

        // Mengisi nilai total harga akhir pada input harga_akhir
        $(this).val(totalHarga.toFixed(2));

        // Menambahkan total harga akhir barang saat ini ke totalKeseluruhan
        totalKeseluruhan += totalHarga;
    });

    // Mengisi nilai total keseluruhan ke dalam input total_keseluruhan
    $('input[name="total_keseluruhan"]').val(totalKeseluruhan.toFixed(2));
}
   

    // Event listener untuk input[name="ppn[]"]
    $(document).on('input', 'input[name="ppn[]"]', function() {
        // Panggil fungsi perhitungan setiap kali ada perubahan pada input PPN
        calculateTotal();
    });

    $(document).ready(function () {
         // Ambil nilai PPN dari variabel PHP dan simpan dalam array JavaScript
        var ppnValues = {!! json_encode($ppnArray) !!};

        // Loop melalui semua input dengan nama ppn[] dan atur nilai PPN sesuai dengan nilai dari array ppnValues
        $('input[name="ppn[]"]').each(function(index) {
            // Atur nilai PPN pada setiap input berdasarkan nilai dari array ppnValues
            $(this).val(ppnValues[index]).change();
        });
         // Panggil fungsi perhitungan setelah mengatur nilai PPN
     calculateTotal();
    });
    //===============================================================================================
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
