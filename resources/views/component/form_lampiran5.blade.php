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
        {{-- FORM INPUT PPN JADI 1 SAJA --}}
        <div class="row">
            <div class="form-group col-1">
                <label for="ppn">PPN %</label>
                <input type="text" name="ppn" class="form-control" id="ppn" value="11" required>
            </div>
            <div class="form-group col-2">
                <label for="jenis_kontrak">Jenis Kontrak</label>
                <input type="text" name="jenis_kontrak" class="form-control" id="jenis_kontrak"
                value="{{ $jenisKontrak }}"
                disabled>
            </div>
            {{-- <div id="khs-fields" class="form-group-row" style="display: {{ $jenisKontrak === 'Harga Satuan' ? 'block' : 'none' }}"> --}}
            <div class="form-group col-2" style="display: {{ $jenisKontrak === 'Harga Satuan' ? 'block' : 'none' }}" id="khs-fields" >
                <label for="waktu_khs">Masa Berlaku KHS</label>
                <input type="text" name="waktu_khs" class="form-control" id="waktu_khs" required>
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
            {{-- </div> --}}
        </div>
        <hr>
        {{-- FORM DINAMIS --}}
        <div id="loadinputlampiran5"></div>
        {{-- FORM FOOTER TOTAL KESELURUHAN --}}
        <div class="card-footer">
            <hr>
            <div class="form-group col-3">
                <label for="total_keseluruhan">Total Keseluruhan</label>
                <input style=" border: 2px solid #ff0000;" type="text" name="total_keseluruhan" class="form-control" required readonly>
            </div>
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran5()">Submit</button>
        </div>
    </form>
</div>
@push('scripts')
    <script type="text/javascript">

        // Fungsi untuk mengisi nilai input form dengan data barang
        function isiNilaiForm5(dataBarang) {
            console.log(dataBarang)
            if (dataBarang) {
                var fields = ``;
                dataBarang.forEach(function(row) {
                    fields+=`
                <div class="row">
                <div class="form-group col-1">
                    <label for="no_sppb">No.SPPB</label>
                    <input type="text" name="no_sppb[]" class="form-control" value="${row.purchase_requisition_number}" id="nosppblampiran5" required readonly>

                </div>
                <div class="form-group col-2">
                    <label for="nama_barang">Kode Barang</label>
                    <input type="text" name="kode_barang[]" placeholder="Kode Barang" value="${row.material_number}" id="kodebaranglampiran5" class="form-control" readonly required>

                </div>
                <div class="form-group col-4">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang[]" placeholder="Nama Barang" value="${row.material_name}" id="nmbaranglampiran5" class="form-control" readonly required>

                </div>
                <div class="form-group col-1">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan[]" class="form-control" value="${row.purchase_order_unit_of_measure}" id="satuanlampiran5" required readonly>

                </div>
                <div class="form-group col-2">
                    <label for="lokasi">Lokasi Gudang</label>
                    <input type="text" name="plant[]" class="form-control" value="${row.plant}" id="plantlampiran5" required readonly>
                </div>
                <div class="form-group col-2">
                    <label for="harga_awal">Harga Sebelum PPN</label>
                    <input type="text" name="harga_awal[]" class="form-control" value="${row.net_price}" id="hargaawallampiran5" required readonly>

                </div>
                <div class="form-group col-1">
                    <label for="jumlah">Jumlah</label>
                    <input type="text" name="jumlah[]" class="form-control"  value="${row.purchase_order_quantity}" id="jumlahlampiran5" required readonly>

                </div>

                <div class="form-group col-2">
                    <label for="harga_akhir">Total Harga + PPN</label>
                    <input type="text" name="harga_akhir[]" class="form-control" required readonly>

                </div>

                </div>`;
                });

                $('#loadinputlampiran5').append(fields);

                // Panggil fungsi replacePlantValues setelah menambahkan fields ke dalam DOM
                replacePlantValues();
            }
        }

        //===============================================================================================
        // Fungsi untuk melakukan perhitungan nilai
        // Inisialisasi totalKeseluruhan di luar fungsi
        // var totalKeseluruhan = 0;

        // $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], input[name="ppn[]"]', function() {
        //     // Bersihkan nilai totalKeseluruhan
        //     totalKeseluruhan = 0;

        //     // Iterasi untuk setiap barang
        //     $('input[name="harga_akhir[]"]').each(function() {
        //         var totalHarga = 0;
        //         var row = $(this).closest('.row');
        //         var jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
        //         var hargaAwal = parseInt(row.find('input[name="harga_awal[]"]').val()) || 0;
        //         var ppn = parseInt(row.find('input[name="ppn[]"]').val()) || 0;    //set nilai default ppn

        //         // Perhitungan total harga akhir untuk barang saat ini
        //         totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));

        //         // Mengisi nilai total harga akhir pada input harga_akhir
        //         $(this).val(totalHarga.toFixed(2));

        //         // Menambahkan total harga akhir barang saat ini ke totalKeseluruhan
        //         totalKeseluruhan += totalHarga;
        //     });

        //     // Mengisi nilai total keseluruhan ke dalam input total_keseluruhan
        //     $('input[name="total_keseluruhan"]').val(totalKeseluruhan.toFixed(2));
        // });

        // FUNGSI HIDE FORM BATAS WAKTU KHS (HARGA SATUAN)
       document.addEventListener('DOMContentLoaded', function() {
            const jenisKontrakInput = document.getElementById('jenis_kontrak');
            const khsFields = document.getElementById('khs-fields');

            function toggleKhsFields() {
                if (jenisKontrakInput.value === 'Harga Satuan') {
                    khsFields.style.display = 'block';
                } else {
                    khsFields.style.display = 'none';
                }
            }

            // Initial check
            toggleKhsFields();

            // Add event listener if the jenis_kontrak can change
            jenisKontrakInput.addEventListener('change', toggleKhsFields);
        });

        //========================================================================================================================

        // after modified fungsi perhitungan harga
        function hitungTotalHarga() {
            var totalKeseluruhan = 0;
            var ppn = parseInt($('#ppn').val()) || 11;  // Default PPN 11% jika tidak ada nilai yang dimasukkan

            $('input[name="harga_akhir[]"]').each(function() {
                var totalHarga = 0;
                var row = $(this).closest('.row');
                var jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
                var hargaAwal = parseInt(row.find('input[name="harga_awal[]"]').val()) || 0;
                // var ppn = parseInt(row.find('input[name="ppn[]"]').val()) || parseInt(row.find('input[name="ppn[]"]').attr('data-ppn')) || 0;

                totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));
                $(this).val(totalHarga.toFixed(2));
                totalKeseluruhan += totalHarga;
            });

            $('input[name="total_keseluruhan"]').val(totalKeseluruhan.toFixed(2));
        }

        // $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], input[name="ppn[]"]', function() {
        //     hitungTotalHarga();
        // });

        $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"], #ppn', function() {
            hitungTotalHarga();
        });

        //=========================================================================================================================
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
                    // if (result.redirect) {
                    //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                    // }
                }
            });
        }

        function submit_Lampiran5() {
            submitLampiran5();
        }
    </script>
@endpush
