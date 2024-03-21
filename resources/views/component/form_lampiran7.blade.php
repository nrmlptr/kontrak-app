<div class="row">
    <form id="inputLampiran7">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-12">
                <label>Alamat Peruri</label>
                <textarea class="form-control" rows="5" style="resize: vertical; width: 100%;" name="alamat_peruri" id="alamat_peruri">
                    PERUM PERCETAKAN UANG REPUBLIK INDONESIA
                    Jalan Palatehan No.4 Blok K-V
                    Kebayoran Baru
                    Jakarta Selatan 12160
                    Indonesia
                </textarea>
                @error('alamat_peruri')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group col-12">
                <label>Alamat Vendor</label>
                <textarea class="form-control" rows="5" style="resize: vertical; width: 100%;" name="alamat_vendor" id="alamat_vendor"></textarea>
                @error('alamat_vendor')
                <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>
            <!-- <div class="card-footer"> -->
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran7()">Submit</button>
            <!-- </div> -->
        </div>

    </form>
</div>

@push('scripts')
    
<script type="text/javascript">
    // Fungsi untuk mendapatkan data barang dan menampilkan ke form saat halaman dimuat
    // $(document).ready(function() {
    //     var nomor_sop = "{{ $data->nomor_sop }}";

    //     $.ajax({
    //         type: 'GET',
    //         url: "{{route('dataBarang')}}",
    //         data: {
    //             _token: $("input[name='_token']").val(),
    //             po: nomor_sop
    //         },
    //         success: function(response) {
    //             // console.log(response[0]);
    //             if (response[0].id) {
    //                 // $('#kontraks_id').val(response.kontraks.id);
    //                 isiNilaiForm(response[0]);
    //             } else {
    //                 console.log("Kontrak tidak ditemukan");
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.log("error");
    //         }
    //     });
    // });

    // // Fungsi untuk mengisi nilai input form dengan data barang
    // function isiNilaiForm(dataBarang) {
    //     // console.log(dataBarang)
    //     if (dataBarang) {
    //         // Mengisi nilai input form dengan data barang
    //         $('textarea[name="alamat_vendor"]').val(dataBarang.alamat + ' ' + dataBarang.kota + ' ' + dataBarang.provinsi + ' ' + dataBarang.kode_pos);
    //     }
    // }

    // SUBMIT DATA

    function submitLampiran7() {
        var form = $('#inputLampiran7');

        $.ajax({
            method: "POST",
            url: "{{ route('submitLampiran7') }}",
            data: form.serialize(),
            success: function(result) {

                console.log(result.message);
                if (result.redirect) {
                    window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                }
            }
        });
    }
</script>
@endpush