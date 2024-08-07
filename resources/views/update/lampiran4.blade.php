@php
    $lampiran4=$data->lampiran4;
@endphp
<div class="row">
    <form id="inputLampiran4">
        @csrf
        <div class="row" id="loadinputlampiran4">
            <input type="hidden" name="kontraks_id" value="{{ $data->id }}">
            @foreach ($lampiran4 as $l)
                <div class="form-group col-2">
                    <label for="nomor_sop">Nomor SOP</label>
                    <input type="text" name="nomor_sop[]" placeholder="Nomor SOP" class="form-control" id="nosoplampiran4" value="{{ $l->nomor_sop }}" readonly required>
                </div>
                <div class=" form-group col-2">
                    <label for="tanggal_sop">Tanggal SOP</label>
                    <input type="date" name="tanggal_sop[]" class="form-control" id="tglsoplampiran4" value="{{ $l->tanggal_sop }}" readonly required>
                </div>
                <div class=" form-group col-2">
                    <label for="lokasi">Lokasi Gudang</label>
                    <input type="text" name="plant[]" class="form-control" id="plantlampiran4" value="{{ $l->lokasi }}" required readonly>
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

                <div class=" form-group col-1">
                    <label for="no_sppb">No.SPPB</label>
                    <input type="text" name="no_sppb[]" class="form-control" id="nosppblampiran4" value="{{ $l->no_sppb }}"  required >
                </div>
                <div class=" form-group col-2">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" name="kode_barang[]" class="form-control" id="kodebaranglampiran4" value="{{ $l->kode_barang }}" required readonly>
                </div>
                <div class=" form-group col-4">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang[]" class="form-control" id="nmbaranglampiran4" value="{{ $l->nama_barang }}" required readonly>
                </div>
                <div class=" form-group col-1">
                    <label for="satuan">Satuan</label>
                    <input type="text" name="satuan[]" class="form-control" id="satuanlampiran4" value="{{ $l->satuan }}" required readonly>
                </div>
                <div class="form-group col-12">
                    <label for="inputText">Jadwal Penyerahan Barang</label>
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="jadwal_penyerahan_barang[]">{!! $l->jadwal_penyerahan_barang !!}</textarea>
                </div>
            @endforeach
        </div>
        <div class=" card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submitLampiran4()">Submit</button>
        </div>
    </form>
</div>

@push('scripts')

    <script type="text/javascript">

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

    </script>
@endpush
