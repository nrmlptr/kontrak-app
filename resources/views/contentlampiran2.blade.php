<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            counter-reset: page;
            padding-top: 130px;
            margin: 0;
            position: relative;
        }

        .nomornya::before {
            content: counter(page); /* Menampilkan nomor halaman */
        }

        @page {
            counter-increment: page; /* Menambah nomor halaman */
        }

        #header {
            position: fixed;
            /* box-sizing: border-box;
            padding: 10px;  */
            top: 0;
            left: 0;
            width: 100%;
            background-color: white;
            z-index: 1; 
            /* margin-bottom: 50px;  */
        }
        table{
            border-collapse: collapse;
            width: auto;
        }
        table tr td{
            padding: 5px;
            margin: 5px;
            width: auto;
        }
        .text-center{
            text-align: center;
        }
        .table-header p {
            font-size: 12px;
            margin: 0
        }

        .total-pages::after {
            content: counter(page); 
        }

    </style>
</head>
<body>

<div id="header">
    <table class="table-header" style="border-collapse: collapse; width: 100%;" border="1">
        <tbody>
            <tr>
                <td style="width: 20%; font-size: 14px;"><b>LAMPIRAN II</b></td>
                <td style="width: 2%; font-size: 14px;"><b>:</b></td>
                <td style="font-size: 14px;"><b>LINGKUP PERJANJIAN</b></td>
               <td style="font-size: 14px;"><b>Halaman: <span class="nomornya"></span> / <span class="total-pages"></span></b></td>
            </tr>
            <tr>
                <td style="width: 13%; font-size: 14px;" rowspan="2"><b>PERIHAL</b></td>
                <td rowspan="2" style="width: 2%; border: none; font-size: 14px;"><b> : </b></td>
                <td rowspan="2" style="width: 60%; font-size: 14px;"><b>{{ strtoupper($data->perihal) }}</b></td>
                <td style="width: 30%; font-size: 14px;"><b>Nomor : {{ $data->detail_number }}</b></td>
            </tr>
            <tr>
                <td style="font-size: 14px;"><b>Tanggal : {{ tanggal_indonesia($data->date_kontrak) }}</b></td>
            </tr>
        </tbody>
    </table>
   <div><br></div>
    <div style="text-align: center;"><b>LINGKUP PERJANJIAN</b></div>
</div>

@php
    $lampiran2=$data->lampiran2;
@endphp
<div id="content">
    <ol>
        <li style="text-align: justify; font-size: 14px;">
                PIHAK KEDUA dengan ini berjanji dan mengikatkan diri untuk Jual {{  $lampiran2->perihal }}, yang kemudian dalam Perjanjian ini akan disebut dengan “barang” kepada PIHAK KESATU, demikian juga PIHAK KESATU dengan ini telah setuju dan mengikatkan diri untuk membeli barang tersebut dari PIHAK KEDUA, yang pelaksanaannya akan dituangkan di dalam Surat Order Pembelian (SOP) Nomor : {{  $lampiran2->nomor_sop }} tanggal {{ tanggal_indonesia($lampiran2->tanggal_sop) }}.
        </li>
        <li style="text-align: justify; font-size: 14px;">
                Lingkup Perjanjian sebagaimana dimaksud Pasal 3 Perjanjian ini merupakan bagian yang tidak terpisahkan dari Perjanjian ini.
        </li>
    </ol>
    <div><br></div>
    <div><br></div>
    <div><br></div>
    <table style="width: 100%;
            border-collapse: collapse;
            margin-top: 20px;">
        <tr>
            <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KEDUA,</th>
            <th style="width: 50%;text-align: center; font-size: 14px;">PIHAK KESATU,</th>
        </tr>
        <tr>
            <td style="vertical-align: top;">
                <div style="padding-top: 150px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak2name }}</b></div>
                </div>
            </td>
            <td style="vertical-align: top;">
                <div style="padding-top: 150px; text-align: center; font-size: 14px;">
                    <div style=""><b>{{ $pihak1name }}</b></div>
                </div>
            </td>
        </tr>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalPages = Math.ceil(document.body.scrollHeight / window.innerHeight);
        document.querySelector('.total-pages').textContent = totalPages;
    });
</script>
</body>
</html>