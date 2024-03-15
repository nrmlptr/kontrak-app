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
<div class="row">
    <form class="inputlampiran1" id="inputlampiran1">
        @csrf
        <div class=" form-group forminput_lampiran1">
            <div class="ListContainer">
                <a class="btn btn-primary text-white" type="button" id="btn-addrow">Add</a>
                <br><br>
                <ul id="sortable">
                    <li class="ui-state-default">
                        <input class="numbering" name="numbering[]">
                        <a href="#" type="button" style="color: red;" class="btn-deleterow"><i class="fa fa-trash"></i></a>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="text" name="perihal[]" placeholder="Nama Header" class="form-control" value="Surat Permintaan Penawaran Harga dari PIHAK PERTAMA">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <input type="date" name="tanggal_surat[]" class="form-control">
                            </div>
                        </div>
                    </li>


                    <!-- header ke 2 -->
                    <li class="ui-state-default">
                        <input class="numbering" name="numbering[]">
                        <a href="#" type="button" style="color: red;" class="btn-deleterow"><i class="fa fa-trash"></i></a>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="text" name="perihal[]" placeholder="Nama Header" class="form-control" value="Surat Permintaan Penawaran Harga dari PIHAK KEDUA">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <input type="date" name="tanggal_surat[]" class="form-control">
                            </div>
                        </div>
                    </li>


                    <!-- header 3 -->
                    <li class="ui-state-default">
                        <input class="numbering" name="numbering[]">
                        <a href="#" type="button" style="color: red;" class="btn-deleterow"><i class="fa fa-trash"></i></a>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="text" name="perihal[]" placeholder="Nama Header" class="form-control" id="test" value="Surat Permintaan Penurunan Harga dari PIHAK KESATU">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <input type="date" name="tanggal_surat[]" class="form-control">
                            </div>
                        </div>
                    </li>

                    <!-- HEADER 4 -->
                    <li class="ui-state-default">
                        <input class="numbering" name="numbering[]">
                        <a href="#" type="button" style="color: red;" class="btn-deleterow"><i class="fa fa-trash"></i></a>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="text" name="perihal[]" placeholder="Nama Header" class="form-control" value="Surat Penurunan Harga dari PIHAK KEDUA">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <input type="date" name="tanggal_surat[]" class="form-control">
                            </div>
                        </div>
                    </li>

                    <!-- header 5 -->
                    <li class="ui-state-default">
                        <input class="numbering" name="numbering[]">
                        <a href="#" type="button" style="color: red;" class="btn-deleterow"><i class="fa fa-trash"></i></a>
                        <div class="row">
                            <div class="form-group col-12">
                                <input type="text" name="perihal[]" placeholder="Nama Header" class="form-control" value="Surat Pemberitahuan Pemenang Pengadaan">
                            </div>
                            <div class="form-group col-6">
                                <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control">
                            </div>
                            <div class="form-group col-6">
                                <input type="date" name="tanggal_surat[]" class="form-control">
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-block btn-secondary btn-lg" onclick="submit_Lampiran1()">Submit</button>
        </div>
    </form>
</div>


<!-- JAVASCRIPT -->
<!-- jQuery -->
<script src="{{ asset('lte/plugins/jquery/jquery.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.js') }}"></script>
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
        submitLampiran1()
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
            url: 'Lampiran1',
            dataType: 'json',
            data: form2,
            success: function(result) {
                console.log(result.message)
            }
        });
    }

    function submit_Lampiran1() {
        submitLampiran1()
    }
</script>