<div class="row">
    <form id="inputLampiran5">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" id="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-2">
                <label for="no_sppb">Nomor SPPB</label>
                <input type="text" name="no_sppb" class="form-control" required>
                @error('no_sppb')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-5">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" name="nama_barang" placeholder="Nama Barang" class="form-control" required>
                    @error('nama_barang')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-3">
                <label for="harga_awal">Harga Sebelum PPN</label>
                <input type="text" name="harga_awal" class="form-control" required>
                @error('harga_awal')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-1">
                <label for="jumlah">Jumlah</label>
                <input type="text" name="jumlah" class="form-control" required>
                @error('jumlah')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-1">
                <label for="ppn">PPN %</label>
                <input type="text" name="ppn" class="form-control" required>
                @error('ppn')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <hr>
            <div class="form-group col-3">
                <label for="harga_akhir">Total Harga + PPN</label>
                <input type="text" name="harga_akhir" class="form-control" required>
                @error('harga_akhir')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran5()">Submit</button>
        </div>
    </form>
</div>
@push('scripts')
    

<script type="text/javascript">
    // Fungsi untuk mendapatkan data barang dan menampilkan ke form saat halaman dimuat
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
                console.log(response[0]);
                if (response[0].id) {
                    // $('#kontraks_id').val(response.kontraks.id);
                    isiNilaiForm(response[0]);
                } else {
                    console.log("Kontrak tidak ditemukan");
                }
            },
            error: function(xhr, status, error) {
                console.log("error");
            }
        });
    });

    // Fungsi untuk mengisi nilai input form dengan data barang
    function isiNilaiForm(dataBarang) {
        // console.log(dataBarang)
        if (dataBarang) {
            // Mengisi nilai input form dengan data barang
            $('input[name="nama_barang"]').val(dataBarang.material_name);
            $('input[name="jumlah"]').val(dataBarang.purchase_order_quantity);
            $('input[name="harga_awal"]').val(dataBarang.net_price);
        }
    }

    // Fungsi untuk melakukan perhitungan nilai input jumlah atau harga_awal 
    $('input[name="jumlah"], input[name="harga_awal"], input[name="ppn"]').on('input', function() {
        // Mendapatkan nilai input jumlah, harga_awal, dan ppn
        var jumlah      = parseFloat($('input[name="jumlah"]').val()) || 0;
        var hargaAwal   = parseFloat($('input[name="harga_awal"]').val()) || 0;
        var ppn         = parseFloat($('input[name="ppn"]').val()) || 0;

        // Melakukan perhitungan total harga + PPN
        var totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));

        // hasil perhitungan di input harga_akhir
        $('input[name="harga_akhir"]').val(totalHarga.toFixed(2));
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