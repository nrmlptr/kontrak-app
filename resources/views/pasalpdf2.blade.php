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
            background-color: lightgray; /* Warna latar belakang */
            padding: 10px; /* Padding untuk jarak dari konten */
            box-sizing: border-box; /* Untuk menghitung padding dalam ukuran total */
            top: 0;
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

        /* Mengatur gaya konten */
        #content {
            margin-top: 120px; /* Mengatur margin atas agar konten tidak bertabrakan dengan header */
            margin-bottom: 50px; /* Mengatur margin bawah untuk memberikan jarak antara konten dan footer */
        }

        /* Mengatur gaya footer */
        #footer {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            color: black;
            font-size: 0.9em;
            background-color: lightgray; /* Warna latar belakang */
            padding: 10px; /* Padding untuk jarak dari konten */
            box-sizing: border-box; /* Untuk menghitung padding dalam ukuran total */
        }

    </style>
</head>
<body>

<div id="header">
    <div style="padding-right: 10px; float: right;">
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

<!-- Tambahkan id pada konten setelah tabel -->
<div id="content">
    {!! $teks !!}
</div>

</body>
</html>
