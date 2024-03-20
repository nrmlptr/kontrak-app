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
    <form class="editLampiran1" id="editLampiran1">
        @csrf
        <div class="form-group editLampiran1">
            <input type="hidden" name="kontraks_id" value='{{ $data->id }}'>
            {{-- Check if data lampiran 1 tidak ada for this kontraks_id --}}
           <?php
                // Ambil data JSON dari model Lampiran1 berdasarkan kontraks_id
                   $lampiran1Data = \App\Models\Lampiran1::where('kontraks_id', $data->id)->first();
                // Jika data JSON ditemukan
                if($lampiran1Data) {
                    // Konversi data JSON menjadi array PHP
                    $lampiran1Array = json_decode($lampiran1Data->data_json, true);
                ?>

                    <!-- Tampilkan tombol Add -->
                    <div class="ListContainer">
                        <a class="btn btn-primary text-white" type="button" id="btn-addrow">Add</a>
                        <br><br>
                        <!-- Menampilkan data lampiran1 yang telah ada dalam form -->
                        <ul id="sortable">
                            <?php foreach($lampiran1Array as $item): ?>
                                <li class="ui-state-default">
                                    <!-- Input numbering (jika diperlukan) -->
                                    <input class="numbering" name="numbering[]" value="<?= $item['nomor_urut'] ?>">
                                    <!-- Isi nilai input perihal, nomor surat, dan tanggal surat sesuai dengan data lampiran1 yang telah ada -->
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <input type="text" name="perihal[]" placeholder="Nama Header" class="form-control" value="<?= $item['perihal'] ?>">
                                        </div>
                                        <div class="form-group col-6">
                                            <input type="text" name="nomor_surat[]" placeholder="Nomor Surat" class="form-control" value="<?= $item['nomor_surat'] ?>">
                                        </div>
                                        <div class="form-group col-6">
                                            <input type="date" name="tanggal_surat[]" class="form-control" value="<?= $item['tanggal_surat'] ?>">
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                <?php
                } else {
                    // Jika data JSON tidak ditemukan
                ?>
                    <td><span class="badge badge-info">Tidak Ada Data Lampiran 1 dalam Kontrak ini</span></td>
                <?php
                }
                ?>

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

        var form2 = $('#editLampiran1').serializeArray();
        // console.log(form2);
        $.ajax({
            method: 'POST',
            url: "{{ route('submitEditLampiran1') }}",
            dataType: 'json',
            data: {
                _token: $("input[name='_token']").val(),
                form2
            },
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