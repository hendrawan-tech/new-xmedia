<?php

namespace App\Helpers;

class Helper
{
    public static function price($price)
    {
        return "Rp. " . number_format($price, 0, ',', '.');
    }

    public static function time($tgl)
    {
        $k = explode(" ", $tgl);
        $kk = explode("-", $k[0]);
        $bln = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

        $tanggal = (int)$kk[2]; // Ambil hari dari $kk[2]
        $bulan = $bln[(int)$kk[1]]; // Ambil bulan dari $bln
        $tahun = $kk[0]; // Ambil tahun dari $kk[0]

        // Pemisah antara tanggal, bulan, dan tahun
        $qq = "$tanggal $bulan $tahun";

        if (count($k) > 1) {
            $qq .= ' ' . $k[1]; // Jika ada waktu, tambahkan waktu ke variabel $qq
        }

        return $qq;
    }
}
