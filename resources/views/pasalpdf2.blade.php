<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            #header {
                position: fixed;
                left: 0;
                right: 0;
                color: black;
                font-size: 10pt;
                /* padding: 10px; */
                /* Padding untuk jarak dari konten */
                box-sizing: border-box;
                /* Untuk menghitung padding dalam ukuran total */
                top: -80px;
                /* background-color: blue; */
                font-family: sans-serif;
                /* display: inline-block; */
            }

            /* Mengatur awal nomor halaman */
            body {
                counter-reset: page 1; /* Mulai dari nomor 2 */
                margin-top: 5px;
            }

            /* Mengatur nomor halaman untuk elemen dengan kelas .nomornya */
            .nomornya::after {
                content: counter(page); /* Menampilkan nomor halaman */
            }

            /* Mengatur penambahan nomor halaman setiap kali halaman baru dimulai */
            @page {
                counter-increment: page; /* Menambah nomor halaman */
                margin-top: 100px; /* create space for header */
            }

            .note-editable ul,
            #content ul {
                list-style-type: lower-alpha; /* Change ordered list to a, b, c, d */
            }

            div.pasal *{
                font-family: sans-serif !important;
                font-size: 10pt !important;
                /* text-align: justify !important; */
            }

            div {
                margin-left: 20px;
                margin-right: 20px;
            }
        </style>

    </head>
    <body>
        <div id="header">
            <div style="padding-right: 10px;margin-bottom:20px; float: right">
                <p style="text-align: center; margin-bottom: -30px !important;">Lembar ke - <span class="nomornya"></span> -</p>
                <br>
                <p style="text-align: left;">
                    <table cellpadding="0" cellspacing="0">
                        <tr>
                            <td>Nomor</td>
                            <td style="padding-left: 5px;">:</td>
                            <td style="padding-left: 5px;">{{ $data->detail_number }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid black;">
                            <td >Tanggal </td>
                            <td style="padding-left: 5px;">:</td>
                            <td style="padding-left: 5px;">{{ tanggal_indonesia($data->date_kontrak) }}</td>
                        </tr>
                    </table>
                </p>
            </div>
            <div style="clear: both;"></div>
        </div>
        <div style="clear: both;"></div>

        <!-- Tambahkan id pada konten setelah tabel -->
        <div id="content" class="pasal">
            {{-- @dd($teks); --}}
            {!! $teks !!}
            {{-- @foreach ($kontraks->pasal as $key => $p)
            <div class="boxpasal">
                <h4 style="text-align: center">{{$p->nama_pasal}}
                    <br>{{$p->keterangan_pasal}}
                </h4>
                {!!$p->isi_pasal!!}
            </div>
            @endforeach --}}
        </div>

        {{-- <script>
            let element = document.getElementById('content')
element.innerHTML.replace(/style=\".*"/gm,'')

        </script> --}}
    </body>
</html>
