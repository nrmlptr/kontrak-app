<style>
    .ListContainer ol {
        white-space: nowrap;
        overflow-x: scroll;
        overflow-y: hidden;
    }

    .ListContainer {
        overflow-y: hidden;
        overflow-x: hidden;
    }


    /* Hide the Text Input */

    li#listItem>.form-field>.form-control {
        display: none !important;
    }


    /* Re-style the Text Input Field */

    #listItem>.form-field>.frm_style_formidable-style.with_frm_style .form-field {
        margin-bottom: 0px !important;
    }

    #listItem>.form-field>.frm_primary_label.control-label {
        padding: 0px !important;
    }

    #listItem>.form-field>.frm_primary_label {
        max-width: 200px !important;
    }


    /* Field Drag & Drop Icon CSS */

    i.fa.fa-arrows {
        float: right;
        margin-top: 6px;
    }

    #sortable .numbering {
        border-radius: 50%;
        border: 2px solid white;
        background-color: #cf8e40;
        width: 25px;
        height: 25px;
        text-align: center;
        vertical-align: center;
        color: white;
    }
</style>
@php
    $lampiran1=json_decode($data->lampiran1->data_json,true);
@endphp

<div class="row">
    <form class="inputlampiran1" id="inputlampiran1">
        @csrf
        <div class=" form-group forminput_lampiran1">
            <input type="hidden" name="kontraks_id" value='{{ $data->id }}'>
            <div class="ListContainer">
                <a class="btn btn-primary text-white" type="button" id="btn-addrow">Add</a>
                <br><br>
                <ul id="sortable">
                    @php
                        if (count($lampiran1)==7) {
                           $keynum = [1,2,3];
                        } elseif (count($lampiran1)==9){
                            $keynum = [1,2,3,4,5];
                        } elseif (count($lampiran1)==11){
                            $keynum = [1,2,3,4,5,6,7];
                        }elseif (count($lampiran1)==13) {
                            $keynum = [1,2,3,4,5,6,7,8,9];
                        }elseif (count($lampiran1)==15) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11];
                        }elseif (count($lampiran1)==17) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13];
                        }elseif (count($lampiran1)==19) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15];
                        }elseif (count($lampiran1)==21) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17];
                        }elseif (count($lampiran1)==23) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19];
                        }elseif (count($lampiran1)==25) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21];
                        }elseif (count($lampiran1)==27) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23];
                        }elseif (count($lampiran1)==29) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25];
                        }elseif (count($lampiran1)==31) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27];
                        }elseif (count($lampiran1)==33) {
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29];
                        }else{
                            $keynum = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31];
                        }
                    @endphp
                    @foreach ($lampiran1 as $k => $l)
                        <li class="ui-state-default">
                            <input class="numbering" name="numbering[]">
                            <a href="#" type="button" style="color: red;" class="btn-deleterow"><i class="fa fa-trash"></i></a>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" name="perihal[]" value="{{ $l['perihal'] }}" placeholder="Nama Header" class="form-control" >
                                </div>
                                <div class="form-group col-6">
                                    <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control"  value="{{ $l['nomor_surat'] }}" @if(! in_array($k, $keynum))  @endif >
                                </div>
                                <div class="form-group col-6">
                                    <input type="date" name="tanggal_surat[]" class="form-control"  value="{{ $l['tanggal_surat'] }}" @if(! in_array($k, $keynum))  @endif>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran1()">Submit</button>
        </div>
    </form>
</div>


<!-- JAVASCRIPT -->

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            counting_container();
        });

        function counting_container() {
            var inputs = $('input.numbering');
            var nbElems = inputs.length;
            $('.ListContainer input.numbering').each(function(idx) {
                $(this).val(idx + 1);
            });
            $(".numbering").attr('disabled', 'true')
        }

        $('#sortable').sortable({
            stop: function() {
                var inputs = $('input.numbering');
                var nbElems = inputs.length;
                $('.ListContainer input.numbering').each(function(idx) {
                    $(this).val(idx + 1);
                });
            }
        });

        var fieldadd = '<li class="ui-state-default">' +
            '<input class="numbering" name="numbering[]">' +
            '<a type="button" style="color: red" class="btn-deleterow"><i class="fa fa-trash"></i></a>' +
            '<div class="row">' +
            '<div class="form-group col-12">' +
            '<input type="text" name="perihal[]" placeholder="Nama Header" class="form-control">' +
            '</div>' +
            '<div class="form-group col-6">' +
            '<input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control">' +
            '</div>' +
            '<div class="form-group col-6">' +
            '<input type="date" name="tanggal_surat[]" class="form-control">' +
            '</div>' +
            '</div>' +
            '</li>'

        $('#btn-addrow').on('click', function() {
            $('#sortable').append(fieldadd)
            counting_container();
            // submitLampiran1()
        })

        $('body').on('click', '.btn-deleterow', function() {
            $(this).parent().remove()
            counting_container();
        })


        function submitLampiran1() {

            var form2 = $('#inputlampiran1').serializeArray();
            // console.log(form2);
            $.ajax({
                method: 'POST',
                url: "{{ route('submitLampiran1') }}",
                dataType: 'json',
                data: form2,
                success: function(result) {
                    $(".collapse").removeClass('show');
                    $('#collapseLampiran2').addClass('show');
                    console.log(result.message);
                    // if (result.redirect) {
                    //     window.location.href = result.redirect; // Mengarahkan ulang halaman ke halaman monitoring
                    // }
                }
            });
        }

        function submit_Lampiran1() {
            submitLampiran1()
        }

    </script>
@endpush
