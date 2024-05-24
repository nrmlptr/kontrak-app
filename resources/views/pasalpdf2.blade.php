<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        #header {
            position: fixed;
            left: 0;
            right: 0;
            color: black;
            font-size: 0.9em;
            padding: 10px; 
            /* Padding untuk jarak dari konten */
            box-sizing: border-box; 
            /* Untuk menghitung padding dalam ukuran total */
            top: -140px;
        }

        /* Mengatur awal nomor halaman */
        body {
            counter-reset: page 1; /* Mulai dari nomor 2 */
            margin-top: -55px;
        }

        /* Mengatur nomor halaman untuk elemen dengan kelas .nomornya */
        .nomornya::after {
            content: counter(page); /* Menampilkan nomor halaman */
        }

        /* Mengatur penambahan nomor halaman setiap kali halaman baru dimulai */
        @page {
            counter-increment: page; /* Menambah nomor halaman */
            margin-top: 150px; /* create space for header */
        }

        .note-editable ul,
        #content ul {
            list-style-type: lower-alpha; /* Change ordered list to a, b, c, d */
        }
    </style>
    
</head>
<body>

<div id="header">
    <div style="padding-right: 10px; float: right;margin-bottom:20px;">
        <p style="text-align: center; margin-bottom: -30px !important;">Lembar ke - <span class="nomornya"></span> -</p>
        <p style="text-align: left;">
            <table cellpadding="0" cellspacing="0">
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
    <div style="clear: both;"></div>
</div>
<div style="clear: both;"></div>

<!-- Tambahkan id pada konten setelah tabel -->
<div id="content">
    {!! $teks !!}
</div>

</body>
</html>
