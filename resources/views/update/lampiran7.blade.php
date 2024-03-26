<div class="row">
    <form id="inputLampiran7">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <input type="hidden" name="nextstatus" value="edited">
            <div class="form-group col-12">
                <label>Alamat Peruri</label>
                <textarea class="form-control summernote" rows="5" style="resize: vertical; width: 100%;" name="alamat_peruri" id="alamat_peruri">{!! $data->lampiran7->alamat_peruri !!}</textarea>
               
            </div>
            <div class="form-group col-12">
                <label>Alamat Vendor</label>
                <textarea class="form-control summernote" rows="5" style="resize: vertical; width: 100%;" name="alamat_vendor" id="alamat_vendor">{!! $data->lampiran7->alamat_vendor !!}</textarea>
               
            </div>
            <!-- <div class="card-footer"> -->
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran7()">Submit</button>
            <!-- </div> -->
        </div>

    </form>
</div>

@push('scripts')
    
<script type="text/javascript">
   
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
                    window.location.href = result.redirect; // Mengarahkan ke halaman review
                }
            }
        });
    }
</script>
@endpush
