<?php

function set_active($uri) {
	if (is_array($uri)) {
		foreach ($uri as $u) {
			if (Route::is($u)) {
				return 'active';
			}
		}
	} else {
		if (Route::is($uri)) {
			return 'active';
		}
	}
}

function terbilang($satuan) {
	if (!empty($satuan)) {
		$huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh",
			"Delapan", "Sembilan", "Sepuluh", "Sebelas");
		if ($satuan < 12) {
			return " ".$huruf[$satuan];
		} elseif ($satuan < 20) {
			return Terbilang($satuan-10)." Belas";
		} elseif ($satuan < 100) {
			return Terbilang($satuan/10)." Puluh".
			Terbilang($satuan%10);
		} elseif ($satuan < 200) {
			return " Seratus".Terbilang($satuan-100);
		} elseif ($satuan < 1000) {
			return Terbilang($satuan/100)." Ratus".
			Terbilang($satuan%100);
		} elseif ($satuan < 2000) {
			return "Seribu".Terbilang($satuan-1000);
		} elseif ($satuan < 1000000) {
			return Terbilang($satuan/1000)." Ribu".
			Terbilang($satuan%1000);
		} elseif ($satuan < 1000000000) {
			return Terbilang($satuan/1000000)." Juta".
			Terbilang($satuan%1000000);
		} elseif ($satuan >= 1000000000) {
			echo "Hasil terbilang tidak dapat di proses, nilai terlalu besar";
		}
	}
}

function hitung_umur($tgl, $bln = '') {
	$lahir = new DateTime($tgl);
	$today = new DateTime();
	$umur  = $today->diff($lahir);
	if (!empty($bln)) {
		return $umur->y.' th '.$umur->m.' bl ';
	} else {
		return $umur->y.' th '.$umur->m.' bl '.$umur->d.' hr';
	}
}

function rupiah($angka) {
	$d = str_replace('.', '', $angka);
	$r = str_replace(',', '', $d);
	return $r;
}

function valid_date($tgl_indo) {
	$t = explode('-', $tgl_indo);
	return $t[2].'-'.$t[1].'-'.$t[0];
}

function tgl_indo($tgl) {
	$t = explode('-', $tgl);
	return $t[2].'-'.$t[1].'-'.$t[0];
}