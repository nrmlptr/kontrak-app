<div class="row">
    <form id="inputLampiran7">
        @csrf
        <div class="row">
            <div class="form-group">
                <label>Alamat Vendor</label>
                <textarea class="form-control" rows="5" style="resize: vertical; width: 100%;" name="alamat_vendor"></textarea>
            </div>
            <!-- <div class="card-footer"> -->
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran7()">Submit</button>
            <!-- </div> -->
        </div>

    </form>
</div>


<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.js') }}"></script>
<script type="text/javascript">
    function submitLampiran7() {

        var form = $('#inputLampiran7');
        var Alamat = form.find('textarea[name="alamat_vendor"]').val();
        console.log(Alamat);

        // var formL7 = $('#inputLampiran7');
        // console.log(formL7);

        // $.ajax({
        //     method: 'POST',
        //     url: 'loadKontrak',
        //     data: formKontrak.serialize(),
        //     success: function(result) {
        //         console.log(result.message)
        //     }
        // });

    }

    function submit_Lampiran7() {
        submitLampiran7();
    }
</script>