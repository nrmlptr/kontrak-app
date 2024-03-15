<div class="row">
    <form id="inputLampiran2">
        @csrf
        <div class="row">
            <div class="form-group col-12">
                <input type="text" name="perihal" placeholder="Perihal" class="form-control">
            </div>
            <div class="form-group col-6">
                <input type="text" name="nomor_sop" placeholder="Nomor SOP" class="form-control">
            </div>
            <div class="form-group col-6">
                <input type="date" name="tanggal_sop" class="form-control">
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran2()">Submit</button>
        </div>
    </form>
</div>


<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript">
    // function submitLampiran2() {
    //     var form3 = $('#inputLampiran2');
    //     console.log(form3);
    // }

    // function submit_Lampiran2() {
    //     submitLampiran2()
    // }
</script>
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
            url: "Lampiran2",
            data: form.serialize(),
            success: function(result) {
                console.log(result.message)
            }
        });
    }

    function submit_Lampiran2() {
        submitLampiran2();
    }
</script>