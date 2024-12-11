<?php

// app/Helpers.php


function tanggal_indonesia($date, $istime = "")
{
    // Array nama bulan dalam bahasa Indonesia
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    // Pisahkan tanggal, bulan, dan tahun
    $tanggal = date('d', strtotime($date));
    $bulan_num = date('n', strtotime($date));
    $tahun = date('Y', strtotime($date));
    $time = date('H:i:s', strtotime($date));

    // Format tanggal ke format Indonesia
    $tanggal_formatted = $tanggal . ' ' . $bulan[$bulan_num] . ' ' . $tahun;
    if (isset($istime) && $istime == 'Y') {
        $tanggal_formatted .= " " . $time;
    }

    return $tanggal_formatted;
}

function formatRupiah($angka)
{
    return 'Rp. ' . number_format($angka, 2, ',', '.');
}
function terbilang($angka)
{
    $angka = (float)$angka;
    $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];

    if ($angka < 12) {
        return $bilangan[(int)$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . ' Belas';
    } elseif ($angka < 100) {
        return terbilang($angka / 10) . ' Puluh ' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return ' seratus ' . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang($angka / 100) . ' Ratus ' . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return ' seribu ' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang($angka / 1000) . ' Ribu ' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang($angka / 1000000) . ' Juta ' . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        return terbilang($angka / 1000000000) . ' Miliar ' . terbilang($angka % 1000000000);
    } elseif ($angka < 1000000000000000) {
        return terbilang($angka / 1000000000000) . ' Triliun ' . terbilang($angka % 1000000000000);
    } else {
        return 'Angka terlalu besar';
    }
}


function tahun_terbilang($angka)
{
    $angka = (float)$angka;
    $bilangan = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];

    if ($angka < 12) {
        return $bilangan[(int)$angka];
    } elseif ($angka < 20) {
        return tahun_terbilang($angka - 10) . ' belas';
    } elseif ($angka < 100) {
        return tahun_terbilang($angka / 10) . ' puluh ' . tahun_terbilang($angka % 10);
    } elseif ($angka < 200) {
        return ' seratus ' . tahun_terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return tahun_terbilang($angka / 100) . ' ratus ' . tahun_terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return ' seribu ' . tahun_terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return tahun_terbilang($angka / 1000) . ' ribu ' . tahun_terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return tahun_terbilang($angka / 1000000) . ' juta ' . tahun_terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        return tahun_terbilang($angka / 1000000000) . ' miliar ' . tahun_terbilang($angka % 1000000000);
    } elseif ($angka < 1000000000000000) {
        return tahun_terbilang($angka / 1000000000000) . ' triliun ' . tahun_terbilang($angka % 1000000000000);
    } else {
        return 'Angka terlalu besar';
    }
}
function showEncodeChar($str)
{
    return mb_convert_encoding($str, 'HTML-ENTITIES', 'UTF-8');
}

function getMonthIndo($index)
{
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    // return strtoupper($bulan[$index]);
    return ucfirst(strtolower($bulan[$index]));
}
function splitString($text, $chunkLength)
{
    // Hitung jumlah kata dalam string
    $wordCount = str_word_count($text);

    // Bagi string menjadi bagian-bagian dengan panjang yang diinginkan
    $chunks = str_split($text, $chunkLength);

    return $chunks;
}


// FORMAT FUNGSI VENDOR NAMA AGAR TIDAK KAPITAL SEMUA TAPI AWALAN NYA TETEP KAPITAL SEMUA
function formatVendorName($vendorName)
{
    // Daftar prefix yang harus tetap uppercase
    $prefixes = ['PT', 'CV', 'UD', 'PD', 'KOPERASI'];

    // Pecah nama vendor menjadi array kata
    $words = explode(' ', $vendorName);

    foreach ($words as $index => $word) {
        // Jika kata termasuk dalam prefix, tetapkan uppercase tanpa perubahan
        if (in_array(strtoupper($word), $prefixes)) {
            $words[$index] = strtoupper($word);
        } else {
            // Jika bukan prefix, ubah ke Title Case
            $words[$index] = ucfirst(strtolower($word));
        }
    }

    // Gabungkan kembali menjadi string
    return implode(' ', $words);

    // dd($words);
}


