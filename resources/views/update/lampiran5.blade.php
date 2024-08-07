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
                        {{-- <select name="lokasi[]" id="lokasi" class="form-control" required>
                            <option value="{{ $l->lokasi }}" selected>@if($l->lokasi == 'GAT')
                                Gudang Tengah
                            @elseif($l->lokasi == 'UGM')
                                Gudang Ugam
                            @elseif($l->lokasi == 'TGN')
                                Gudang Tasganu
                            @elseif($l->lokasi == 'UMUM')
                                Gudang Umum
                            @else
                                Gudang Utas
                            @endif</option>
                            <option value="">--Pilih Gudang--</option>
                            <option value="GAT">Gudang Tengah</option>
                            <option value="UGM">Gudang Ugam</option>
                            <option value="TGN">Gudang Tasganu</option>
                            <option value="UMUM">Gudang Umum</option>
                            <option value="UTAS">Gudang Utas</option>
                        </select> --}}
                    </div>
                    <div class="form-group col-2">
                        <label for="harga_awal">Harga Sebelum PPN</label>
                        <input type="text" name="harga_awal[]" class="form-control" value="{{ $l->harga_awal }}" id="hargaawallampiran5" required readonly>

                    </div>
                    <div class="form-group col-1">
                        <label for="jumlah">Jumlah</label>
                        <input type="text" name="jumlah[]" class="form-control"  value="{{ $l->qty }}" id="jumlahlampiran5" required readonly>

                    </div>
                    {{-- <div class="form-group col-1">
                        <label for="ppn">PPN %</label>
                        <input type="text" name="ppn[]" class="form-control"  required>

                    </div> --}}
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
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran5()">Submit</button>
        </div>
    </form>
</div>


@push('scripts')
    <script type="text/javascript">

        // Fungsi untuk menghitung total keseluruhan
        function calculateTotal() {
            // Bersihkan nilai totalKeseluruhan
            var totalKeseluruhan = 0;

            // Ambil nilai PPN dari input di luar loop
            var ppn = parseInt($('#ppn').val()) || 0;

            // Iterasi untuk setiap barang
            $('input[name="harga_akhir[]"]').each(function() {
                var totalHarga = 0;
                var row = $(this).closest('.row');
                var jumlah = parseInt(row.find('input[name="jumlah[]"]').val()) || 0;
                var hargaAwal = parseInt(row.find('input[name="harga_awal[]"]').val()) || 0;
                // var ppn = parseInt(row.find('input[name="ppn[]"]').val()) || 0;

                // Perhitungan total harga akhir untuk barang saat ini
                totalHarga = (jumlah * hargaAwal) + ((jumlah * hargaAwal) * (ppn / 100));

                // Mengisi nilai total harga akhir pada input harga_akhir
                $(this).val(totalHarga.toFixed(2));

                // Menambahkan total harga akhir barang saat ini ke totalKeseluruhan
                totalKeseluruhan += totalHarga;
            });

            // Mengisi nilai total keseluruhan ke dalam input total_keseluruhan
            $('input[name="total_keseluruhan"]').val(totalKeseluruhan.toFixed(2));
        }


        // // Event listener untuk input[name="ppn[]"]
        // $(document).on('input', 'input[name="ppn[]"]', function() {
        //     // Panggil fungsi perhitungan setiap kali ada perubahan pada input PPN
        //     calculateTotal();
        // });

        // Event listener untuk input PPN di luar loop
        $(document).on('input', '#ppn', function() {
            // Panggil fungsi perhitungan setiap kali ada perubahan pada input PPN
            calculateTotal();
        });

        // $(document).ready(function () {
        //     // Ambil nilai PPN dari variabel PHP dan simpan dalam array JavaScript
        //     var ppnValues = {!! json_encode($ppnArray) !!};

        //     // Loop melalui semua input dengan nama ppn[] dan atur nilai PPN sesuai dengan nilai dari array ppnValues
        //     $('input[name="ppn[]"]').each(function(index) {
        //         // Atur nilai PPN pada setiap input berdasarkan nilai dari array ppnValues
        //         $(this).val(ppnValues[index]).change();
        //     });

        //     // Panggil fungsi perhitungan setelah mengatur nilai PPN
        //     calculateTotal();
        // });

        // Event listener untuk input jumlah dan harga_awal
        $(document).on('input', 'input[name="jumlah[]"], input[name="harga_awal[]"]', function() {
            // Panggil fungsi perhitungan setiap kali ada perubahan pada input jumlah atau harga_awal
            calculateTotal();
        });

        $(document).ready(function () {
            // Panggil fungsi perhitungan saat dokumen siap
            calculateTotal();
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
                    // if (result.redirect) {
                    //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                    // }
                }
            });
        }

    </script>
@endpush
