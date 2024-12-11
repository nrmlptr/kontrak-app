@php
    $lampiran6=$data->lampiran6;
@endphp
<div class="row">
    <form id="inputLampiran6">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-12">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jpemb" id="langsung" value="1" @if (@$lampiran6->jenis_pembayaran=='1')
                        checked
                    @endif>
                    <label class="form-check-label" for="langsung">Langsung</label>
                </div>
                <div class="form-check col-12">
                    <input class="form-check-input" type="radio" name="jpemb" id="bertahap" value="2" @if (@$lampiran6->jenis_pembayaran=='2')
                        checked
                    @endif>
                    <label class="form-check-label" for="bertahap">Bertahap</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-2" id="formLangsung">
                <label for="nomor_sop">Nomor SOP</label>
                <input type="text" name="nomor_sop" class="form-control" id="nosoplampiran6" value="{{ @$lampiran6->nomor_sop }}" readonly>
            </div>
            <div class="form-group col-2" id="formLangsung2">
                <label for="tanggal_sop">Tanggal SOP</label>
                <input type="date" name="tanggal_sop" class="form-control" id="tglsoplampiran6" value="{{ @$lampiran6->tanggal_sop }}" readonly>
            </div>
            <div class="form-group col-2" id="formLangsung3">
                <label for="no_kontrak">No Kontrak</label>
                <input type="text" name="no_kontrak" class="form-control" id="nosplampiran6" value="{{ @$lampiran6->no_kontrak }}" readonly>
            </div>
            <div class="form-group col-2" id="formLangsung4">
                <label for="date_kontrak">Tanggal Kontrak</label>
                <input type="date" name="date_kontrak" class="form-control" id="tglsplampiran6" value="{{ @$lampiran6->date_kontrak }}" readonly>
            </div>
            <div class="form-group col-3" id="formLangsung5">
                <label for="lama_pembayaran">Waktu Pembayaran (Hari)</label>
                <input type="text" name="lama_pembayaran" class="form-control" value="{{ @$lampiran6->lama_pembayaran }}">
            </div>
        </div>


        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran6()">Input</button>
        </div>
    </form>
</div>
@push('scripts')
    <script type="text/javascript">

        // SUBMIT DATA

        function submitLampiran6() {
            var form = $('#inputLampiran6');

            $.ajax({
                method: "POST",
                url: "{{ route('submitLampiran6') }}",
                data: form.serialize(),
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran7').addClass('show');
                    console.log(result.message);
                }
            });
        }
    </script>
@endpush
