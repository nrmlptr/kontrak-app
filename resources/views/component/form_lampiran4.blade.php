<div class="row">
    <form id="inputLampiran4">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-4">
                <label for="nomor_sop">Nomor SOP</label>
                <input type="text" name="nomor_sop" placeholder="Nomor SOP" class="form-control" value="{{ $data->nomor_sop }}">
            </div>
            <div class=" form-group col-4">
                <label for="tanggal_sop">Tanggal SOP</label>
                <input type="date" name="tanggal_sop" class="form-control" value="{{ $data->tanggal_sop }}" readonly>
            </div>
            <div class=" form-group col-4">
                <label for="tanggal_sop">Lokasi Gudang</label>
                <input type="text" name="lokasi" class="form-control">
            </div>
            <div class="form-group col-12">
                <label for="inputText">Jadwal Penyerahan Barang</label>
                <textarea class="form-control" rows="3" placeholder="Enter ..." name="jadwal_penyerahan_barang"></textarea>
            </div>
        </div>
        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran4()">Submit</button>
        </div>
    </form>
</div>

@push('scripts')
    

<script type="text/javascript">
    function submitLampiran4() {
        var form = $('#inputLampiran4');

        $.ajax({
            method: "POST",
            url: "{{ route('submitLampiran4') }}",
            data: form.serialize(),
            success: function(result) {
                $(".collapse").removeClass('show');
                $('#collapseLampiran5').addClass('show');
                console.log(result.message);
                // if (result.redirect) {
                //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                // }
            }
        });
    }

    function submit_Lampiran4() {
        submitLampiran4();
    }
</script>
@endpush