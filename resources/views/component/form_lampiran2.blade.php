<div class="row">
    <form id="inputLampiran2">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-6">
                <label for="nomor_sop">Nomor SOP</label>
                <input type="text" name="nomor_sop" placeholder="Nomor SOP" class="form-control" value="{{ $valueNomorSop }}" id="nosoplampiran2" readonly required>
            </div>
            <div class=" form-group col-6">
                <label for="tanggal_sop">Tanggal SOP</label>
                <input type="date" name="tanggal_sop" class="form-control" value="{{ $data->tanggal_sop }}" id="tglsoplampiran2" readonly required>
            </div>
            <div class="form-group col-12">
                <label for="perihal">Ruang Lingkup</label>
                <input type="text" name="perihal" placeholder="Perihal" class="form-control" value="{{ $data->perihal }}" required>
            </div>

        </div>
        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran2()">Submit</button>
        </div>
    </form>
</div>

@push('scripts')
    <script type="text/javascript">
        function submitLampiran2() {
            // var form = $('#inputLampiran2');
            // var perihal = form.find('input[name="perihal"]').val();
            // var nomorSOP = form.find('input[name="nomor_sop"]').val();
            // var tanggalSOP = form.find('input[name="tanggal_sop"]').val();

            // console.log("Perihal:", perihal);
            // console.log("Nomor SOP:", nomorSOP);
            // console.log("Tanggal SOP:", tanggalSOP);

            var form = $('#inputLampiran2');

            $.ajax({
                method: "POST",
                url: "{{ route('submitLampiran2') }}",
                data: form.serialize(),
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran3').addClass('show');
                    console.log(result.message);
                    // if (result.redirect) {
                    //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                    // }
                }
            });
        }

        // function submit_Lampiran2() {
        //     submitLampiran2();
        // }
    </script>
@endpush
