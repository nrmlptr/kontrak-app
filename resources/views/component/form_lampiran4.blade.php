@php
    $successMessage = session('success');
@endphp

<div class="row">
    <form id="inputLampiran4">
        @csrf
        <div class="row" id="loadinputlampiran4">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
        </div>
        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran4()">Submit</button>
        </div>
    </form>
</div>

@push('scripts')

    {{-- <script type="text/javascript">

        // Fungsi untuk mengisi nilai input form dengan data barang
        function isiNilaiForm4(dataBarang) {
            // console.log(dataBarang)
            if (dataBarang) {
                var fields = ``;
                dataBarang.forEach(function(row) {
                    fields+=`<div class="form-group col-2">
                    <label for="nomor_sop">Nomor SOP</label>
                    <input type="text" name="nomor_sop[]" placeholder="Nomor SOP" class="form-control" value="{{ $valueNomorSop }}" readonly required>
                </div>
                <div class=" form-group col-2">
                    <label for="tanggal_sop">Tanggal SOP</label>
                    <input type="date" name="tanggal_sop[]" class="form-control" value="{{ $data->tanggal_sop }}" readonly required>
                </div>
                <div class=" form-group col-2">
                    <label for="lokasi">Gudang</label>
                    <input type="text" name="plant[]" class="form-control"  value="${row.plant}" required readonly>
                    
                </div>
            
                <div class=" form-group col-1">
                    <label for="no_sppb">Nomor SPPB</label>
                    <input type="text" name="no_sppb[]" class="form-control"  value="${row.purchase_requisition_number}" required readonly>
                </div>
                <div class=" form-group col-2">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" name="kode_barang[]" class="form-control" value="${row.material_number}" required readonly>
                </div>
                <div class=" form-group col-4">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang[]" class="form-control" value="${row.material_name}" required readonly>
                </div>
                <div class=" form-group col-1">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan[]" class="form-control" value="${row.purchase_order_unit_of_measure}" required readonly>
                </div>
                <div class="form-group col-12">
                    <label for="inputText">Jadwal Penyerahan Barang</label>
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="jadwal_penyerahan_barang[]"></textarea>
                </div>`;
                });

                $('#loadinputlampiran4').append(fields);
            }
            
        }

        $(document).ready(function() {
            var successMessage = '{{ $successMessage }}';

            // Jika ada notifikasi success, tampilkan dengan Toastr
            if (successMessage) {
                toastr.success(successMessage);
            }
        });

        function submitLampiran4() {
            var form = $('#inputLampiran4');

            $.ajax({
                method: "POST",
                url: "{{ route('submitLampiran4') }}",
                data: form.serialize(),
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran5').addClass('show');
                    console.log(result.message);
                }
            });
        }

        function submit_Lampiran4() {
            submitLampiran4();
        }
    </script> --}}

    <script type="text/javascript">
        // Mapping value plant jadi nama
        const plantMapping = {
            "1000": "Gudang Umum",
            "1100": "Gudang UTAS",
            "1200": "Gudang UTAS LB",
            "1300": "Gudang UGAM",
            "1400": "Gudang TASGANU",
            "1500": "Gudang Tengah",
            "1600": "Gudang SMV",
        };

        // Fungsi untuk mengganti value plant dengan nama gudang
        function replacePlantValues() {
            // Dapatkan semua elemen input dengan nama "plant[]"
            const plantInputs = document.querySelectorAll('input[name="plant[]"]');

            // Iterasi melalui setiap elemen input dan ganti value dengan nama gudang
            plantInputs.forEach(input => {
                const plantValue = input.value;
                if (plantMapping[plantValue]) {
                    input.value = plantMapping[plantValue];
                }
            });
        }

        // Fungsi untuk mengisi nilai input form dengan data barang
        function isiNilaiForm4(dataBarang) {
            // console.log(dataBarang)
            if (dataBarang) {
                var fields = ``;
                dataBarang.forEach(function(row) {
                    fields += `<div class="form-group col-2">
                        <label for="nomor_sop">Nomor SOP</label>
                        <input type="text" name="nomor_sop[]" placeholder="Nomor SOP" class="form-control" value="{{ $valueNomorSop }}" readonly required>
                    </div>
                    <div class="form-group col-2">
                        <label for="tanggal_sop">Tanggal SOP</label>
                        <input type="date" name="tanggal_sop[]" class="form-control" value="{{ $data->tanggal_sop }}" readonly required>
                    </div>
                    <div class="form-group col-2">
                        <label for="lokasi">Lokasi Gudang</label>
                        <input type="text" name="plant[]" class="form-control" value="${row.plant}" required readonly>
                    </div>
                    <div class="form-group col-1">
                        <label for="no_sppb">Nomor SPPB</label>
                        <input type="text" name="no_sppb[]" class="form-control" value="${row.purchase_requisition_number}" required readonly>
                    </div>
                    <div class="form-group col-2">
                        <label for="kode_barang">Kode Barang</label>
                        <input type="text" name="kode_barang[]" class="form-control" value="${row.material_number}" required readonly>
                    </div>
                    <div class="form-group col-4">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" name="nama_barang[]" class="form-control" value="${row.material_name}" required readonly>
                    </div>
                    <div class="form-group col-1">
                        <label for="satuan">Satuan</label>
                        <input type="text" name="satuan[]" class="form-control" value="${row.purchase_order_unit_of_measure}" required readonly>
                    </div>
                    <div class="form-group col-12">
                        <label for="inputText">Jadwal Penyerahan Barang</label>
                        <textarea class="form-control" rows="3" placeholder="Enter ..." name="jadwal_penyerahan_barang[]"> ... secara bertahap ......</textarea>
                    </div>`;
                });

                $('#loadinputlampiran4').append(fields);

                // Panggil fungsi replacePlantValues setelah menambahkan fields ke dalam DOM
                replacePlantValues();
            }
        }

        $(document).ready(function() {
            var successMessage = '{{ $successMessage }}';

            // Jika ada notifikasi success, tampilkan dengan Toastr
            if (successMessage) {
                toastr.success(successMessage);
            }
        });

        function submitLampiran4() {
            var form = $('#inputLampiran4');

            $.ajax({
                method: "POST",
                url: "{{ route('submitLampiran4') }}",
                data: form.serialize(),
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran5').addClass('show');
                    console.log(result.message);
                }
            });
        }

        function submit_Lampiran4() {
            submitLampiran4();
        }
    </script>

    
@endpush
