<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        #header,
        #footer {
            position: fixed;
            left: 0;
            right: 0;
            color: black;
            font-size: 0.9em;
        }

        #header {
            top: -20;
        }
        /* Mengatur awal nomor halaman */
        body {
            counter-reset: page 1; /* Mulai dari nomor 2 */
        }

        /* Mengatur nomor halaman untuk elemen dengan kelas .nomornya */
        .nomornya::after {
            content: counter(page); /* Menampilkan nomor halaman */
        }

        /* Mengatur penambahan nomor halaman setiap kali halaman baru dimulai */
        @page {
            counter-increment: page; /* Menambah nomor halaman */
        }

    </style>
</head>
<body>

<div id="header" style="height: 100px; text-align: left;">
    <div style="padding-right: 10px;float: right;">
        <p style="text-align: center; margin-bottom: -15px !important;">Lembar ke - <span class="nomornya"></span> -</p>
        <p style="text-align: left;">
            <table>
                <tr>
                    <td>Nomor</td>
                    <td>:</td>
                    <td>{{ $data->detail_number }}</td>
                </tr>
                <tr style="border-bottom: 1px solid black;">
                    <td >Tanggal</td>
                    <td >:</td>
                    <td >{{ tanggal_indonesia($data->date_kontrak) }}</td>
                </tr>
            </table>
        </p>
    </div>
</div>
<div style="clear: both;"></div>



<!-- Tambahkan id pada konten setelah tabel -->
<div id="content">
    {!! $teks !!}
</div>

</body>
</html>
