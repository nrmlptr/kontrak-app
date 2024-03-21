<div class="row">
    <form id="inputLampiran6">
        @csrf
        <div class="row">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            <div class="form-group col-12">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jpemb" id="langsung" value="1">
                    <label class="form-check-label" for="langsung">Langsung</label>
                </div>
                <div class="form-check col-12">
                    <input class="form-check-input" type="radio" name="jpemb" id="bertahap" value="2">
                    <label class="form-check-label" for="bertahap">Bertahap</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-2" id="formLangsung" style="display: none;">
                <label for="nomor_sop">Nomor SOP</label>
                <input type="text" name="nomor_sop" class="form-control" value="{{ $data->nomor_sop }}">
            </div>
            <div class="form-group col-2" id="formLangsung2" style="display: none;">
                <label for="tanggal_sop">Tanggal SOP</label>
                <input type="date" name="tanggal_sop" class="form-control" value="{{ $data->tanggal_sop }}">
            </div>
            <div class="form-group col-2" id="formLangsung3" style="display: none;">
                <label for="no_kontrak">No Kontrak</label>
                <input type="text" name="no_kontrak" class="form-control" value="{{ $data->detail_number }}">
            </div>
            <div class="form-group col-2" id="formLangsung4" style="display: none;">
                <label for="date_kontrak">Tanggal Kontrak</label>
                <input type="date" name="date_kontrak" class="form-control" value="{{ $data->date_kontrak }}">
            </div>
            <div class="form-group col-3" id="formLangsung5" style="display: none;">
                <label for="lama_pembayaran">Waktu Pembayaran (Hari)</label>
                <input type="text" name="lama_pembayaran1" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-2" id="formBertahap" style="display: none;">
                <label for="nomor_sop">Nomor SOP</label>
                <input type="text" name="nomor_sop" class="form-control" value="{{ $data->nomor_sop }}">
            </div>
            <div class=" form-group col-2" id="formBertahap2" style="display: none;">
                <label for="tanggal_sop">Tanggal SOP</label>
                <input type="date" name="tanggal_sop" class="form-control" value="{{ $data->tanggal_sop }}">
            </div>
            <div class=" form-group col-2" id="formBertahap3" style="display: none;">
                <label for="no_kontrak">No Kontrak</label>
                <input type="text" name="no_kontrak" class="form-control" value="{{ $data->detail_number }}">
            </div>
            <div class=" form-group col-2" id="formBertahap4" style="display: none;">
                <label for="date_kontrak">Tanggal Kontrak</label>
                <input type="date" name="date_kontrak" class="form-control" value="{{ $data->date_kontrak }}">
            </div>
            <div class=" form-group col-3" id="formBertahap5" style="display: none;">
                <label for="lama_pembayaran">Waktu Pembayaran (Hari)</label>
                <input type="text" name="lama_pembayaran2" class="form-control">
            </div>
        </div>
        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran6()">Submit</button>
        </div>
    </form>
</div>
@push('scripts')
    
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen radio button
        var langsung = document.getElementById('langsung');
        var bertahap = document.getElementById('bertahap');

        // Ambil elemen form gambar dan form teks
        var FL1 = document.getElementById('formLangsung');
        var FL2 = document.getElementById('formLangsung2');
        var FL3 = document.getElementById('formLangsung3');
        var FL4 = document.getElementById('formLangsung4');
        var FL5 = document.getElementById('formLangsung5');

        var FB1 = document.getElementById('formBertahap');
        var FB2 = document.getElementById('formBertahap2');
        var FB3 = document.getElementById('formBertahap3');
        var FB4 = document.getElementById('formBertahap4');
        var FB5 = document.getElementById('formBertahap5');


        // Tambahkan event listener untuk setiap perubahan pada radio button
        langsung.addEventListener('change', function() {
            // Jika langsung dipilih, tampilkan formlangsung dan sembunyikan formbertahap
            if (this.checked) {
                FL1.style.display = 'block';
                FL2.style.display = 'block';
                FL3.style.display = 'block';
                FL4.style.display = 'block';
                FL5.style.display = 'block';
                FB1.style.display = 'none';
                FB2.style.display = 'none';
                FB3.style.display = 'none';
                FB4.style.display = 'none';
                FB5.style.display = 'none';
            }
        });

        bertahap.addEventListener('change', function() {
            if (this.checked) {
                FL1.style.display = 'none';
                FL2.style.display = 'none';
                FL3.style.display = 'none';
                FL4.style.display = 'none';
                FL5.style.display = 'none';
                FB1.style.display = 'block';
                FB2.style.display = 'block';
                FB3.style.display = 'block';
                FB4.style.display = 'block';
                FB5.style.display = 'block';

                // // Tampilkan semua elemen dalam formText container
                // var formTextElements = formText.querySelectorAll('.form-group');
                // formTextElements.forEach(function(element) {
                //     element.style.display = 'block';
                // });
            }
        });
    });

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
                // if (result.redirect) {
                //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                // }
            }
        });
    }
</script>
@endpush