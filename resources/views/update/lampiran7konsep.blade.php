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
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran7()">
                {{-- <span id="loading-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> --}}
                Submit Update Lampiran
            </button>
            <!-- </div> -->
        </div>

    </form>
</div>

@push('scripts')
{{-- <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script> --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('#loading-spinner').hide();
    });

    // SUBMIT DATA
    function submitLampiran7() {
        var form = $('#inputLampiran7');

        $.ajax({
            method: "POST",
            url: "{{ route('submitUpdateKonsep') }}",
            data: form.serialize(),
            beforeSend: function(){
                $('#loading-spinner').show();
            },
            success: function(result) {
                $('#loading-spinner').hide();
                console.log(result.message);
                if (result.redirect) {
                    window.location.href = result.redirect; // Mengarahkan ke halaman preview lagi
                }
            }
        });
    }
</script>
@endpush
