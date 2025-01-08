@php
    $lampiran5=$data->lampiran5;
    $ppnArray=[];
@endphp
<style>
    .form-group-row {
        display: flex;
        align-items: flex-start;
    }

    .form-group-row .form-group {
        margin-right: 10px; /* Adjust spacing between items as needed */
    }

    .readonly {
        pointer-events: none;
        background-color: #e9ecef;
    }
</style>
<div class="row">
    <form id="inputLampiran5">
        @csrf
        <input type="hidden" name="kontraks_id" id="kontraks_id" value="{{ $data->id }}">
        <div class="row">
            <div class="form-group col-1">
                <label for="ppn">PPN %</label>
                <input type="text" name="ppn" class="form-control" id="ppn" value="{{ $lampiran5[0]->ppn ?? 11 }}" required>
            </div>
            <div class="form-group col-2">
                <label for="jenis_kontrak">Jenis Kontrak</label>
                <input type="text" name="jenis_kontrak" class="form-control" id="jenis_kontrak"
                value="{{ $jenisKontrak }}"
                disabled>
            </div>
            <div class="form-group col-2" style="display: {{ $jenisKontrak === 'Harga Satuan' ? 'block' : 'none' }}" id="khs-fields" >
                <label for="waktu_khs">Masa Berlaku KHS</label>
                <input type="text" name="waktu_khs" class="form-control" id="waktu_khs" required value="{{ $lampiran5[0]->waktu_khs }}">
            </div>
            <div class="form-group col-3" style="display: {{ $jenisKontrak === 'Harga Satuan' ? 'block' : 'none' }}" id="khs-fields" >
                <label for="bulan">Bulan</label>
                <select name="bulan" id="bulan-khs" class="form-control readonly">
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember" selected>Desember</option>
                </select>
            </div>
            <div class="form-group col-2" style="display: {{ $jenisKontrak === 'Harga Satuan' ? 'block' : 'none' }}" id="khs-fields" >
                <label for="tahun">Tahun</label>
                <input type="text" name="tahun" class="form-control" id="tahun" value="2024" readonly>
            </div>
        </div>
        <hr>
        <div id="loadinputlampiran5">
            @foreach ($lampiran5 as $l)
                @php
                    $ppnArray[]=$l->ppn;
                @endphp

                <div class="row">
                    <div class="form-group col-1">
                        <label for="no_sppb">No.SPPB</label>
                        <input type="text" name="no_sppb[]" class="form-control" value="{{ $l->no_sppb }}" id="nosppblampiran5" required readonly>

                    </div>
                    <div class="form-group col-2">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" name="kode_barang[]" placeholder="Kode Barang" value="{{ $l->kode_barang }}" class="form-control" id="kodebaranglampiran5" readonly required>

                    </div>
                    <div class="form-group col-4">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang[]" placeholder="Nama Barang" value="{{ $l->nama_barang }}" class="form-control" id="nmbaranglampiran5" readonly required>

                    </div>
                    <div class="form-group col-1">
                        <label for="satuan">Satuan</label>
                        <input type="text" name="satuan[]" class="form-control" value="{{ $l->satuan }}" id="satuanlampiran5" required readonly>

                    </div>
                    <div class="form-group col-2">
                        <label for="lokasi">Lokasi Gudang</label>
                        <input type="text" name="plant[]" class="form-control" value="{{ $l->lokasi }}" id="plantlampiran5" required readonly>
                    </div>
                    <div class="form-group col-2">
                        <label for="harga_awal">Harga Sebelum PPN</label>
                        <input type="text" name="harga_awal[]" class="form-control" value="{{ $l->harga_awal }}" id="hargaawallampiran5" required readonly>

                    </div>
                    <div class="form-group col-1">
                        <label for="jumlah">Jumlah</label>
                        <input type="text" name="jumlah[]" class="form-control"  value="{{ $l->qty }}" id="jumlahlampiran5" required readonly>

                    </div>
                    <div class="form-group col-2">
                        <label for="harga_akhir">Total Harga + PPN</label>
                        <input type="text" name="harga_akhir[]" class="form-control" required readonly>

                    </div>

                </div>
            @endforeach
        </div>

        <div class="card-footer">
            <hr>
            <div class="form-group col-3">
                <label for="total_keseluruhan">Total Keseluruhan</label>
                <input style=" border: 2px solid #ff0000;" type="text" name="total_keseluruhan" class="form-control" required readonly>

            </div>
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran5()">Input</button>
        </div>
    </form>
</div>


@push('scripts')
    <script type="text/javascript">

        // new code perhitungan
        function calculateTotalBackend() {
            // Serialisasi form data
            var data = $('#inputLampiran5').serialize();

            // Kirim data ke backend untuk perhitungan
            $.ajax({
                method: "POST",
                url: "{{ route('calculateTotalLampiran5') }}", // Endpoint backend
                data: data,
                success: function(result) {
                    // Masukkan hasil perhitungan dari backend ke input field
                    $('input[name="harga_akhir[]"]').each(function(index) {
                        $(this).val(result.data.harga_akhir[index].toFixed(2));
                    });
                    $('input[name="total_keseluruhan"]').val(result.data.total_keseluruhan.toFixed(2));
                },
                error: function(error) {
                    console.error('Error perhitungan total', error);
                }
            });
        }

        // Event listener untuk input perubahan
        $(document).on('input', '#ppn, input[name="jumlah[]"], input[name="harga_awal[]"]', function() {
            calculateTotalBackend();
        });

        // Panggil fungsi saat dokumen siap
        $(document).ready(function () {
            calculateTotalBackend();
        });


        //===============================================================================================
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
                }
            });
        }

    </script>
@endpush
