<?php
// Ambil data JSON dari kolom data_json dalam tabel lampiran1
// $json_data = $lampiran1->data_json;

// dd($json_data);// Misalnya $lampiran1 adalah objek dari model Lampiran1

// Konversi data JSON menjadi array PHP
// $datas = json_decode($json_data, true);

// Array baru dengan struktur yang diinginkan
// $new_datas = [];
// foreach ($datas as $data) {
//     $new_datas[] = [
//         "id" => $data['nomor_urut'],
//         "header" => $data['perihal'],
//         "nomor" => $data['nomor_surat'],
//         "tanggal" => date('d F Y', strtotime($data['tanggal_surat'])) // Format tanggal
//     ];
// }
// ?>

<body>
    <div class="head">
        <table>
            <tbody class="auto-style1">
                <tr>
                    <th class="lampiran">&nbsp;LAMPIRAN I</th>
                    <th class="double-dot"> : </th>
                    <th class="fill-lampiran">&nbsp;DOKUMEN-DOKUMEN PENGADAAN</th>
                    <th class="halaman">&nbsp;Halaman</th>
                    <th class="double-dot"> : </th>
                    <th class="fill-halaman">&nbsp;1 / 1</th>
                </tr>
                <tr>
                    <td rowspan="2">&nbsp;PERIHAL</td>
                    <td rowspan="2" class="double-dot"> : </td>
                    <td rowspan="2" class="fill-perihal">&nbsp;{{ $data->perihal }}</td>
                    <td class="nomor">&nbsp;Nomor</td>
                    <td class="double-dot"> : </td>
                    <td class="fill-nomor">&nbsp;{{ $data->detail_number }}</td>
                </tr>
                <tr>
                    <td style="border-right: 0px solid">&nbsp;Tanggal</td>
                    <td style="border-left: 0px solid;border-right: 0px solid;"> : </td>
                    <td style="border-left: 0px solid">&nbsp;{{ $data->date_kontrak }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <h4 style="text-align: center">DOKUMEN-DOKUMEN PENGADAAN</h4>
        <table style="width: 100%">
            <tbody>
                <tr>
                    <td colspan="4">Dalam melaksanakan jual beli barang, PIHAK KEDUA harus mengikuti syarat-syarat pelaksanaan umum yang mengikat sebagai berikut :</td>
                </tr>
                <td><br></td>
               
            </tbody>
        </table>
    </div>
    <br><br><br><br><br>
</body>