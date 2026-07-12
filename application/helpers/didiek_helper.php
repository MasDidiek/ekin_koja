<?php

$baseUrl = base_url();

//define('IPADDR','192.168.100.8');

define('CSS_PATH', base_url() . 'assets/css/');
define('JS_PATH', base_url() . 'assets/js/');
define('MASTERADMIN', base_url() . 'masteradmin/');
define('THEMES', base_url() . 'assets/theme');
define('CSS_ADMIN', base_url() . 'assets/admin/css/');
define('JS_ADMIN', base_url() . 'assets/admin/js/');

function changeDateFormat($tgl){
	$expl =explode("/", $tgl);
	#$t = $expl[0]; $b = $expl[1]; $th = $expl[2];
	$newDate = implode("-", $expl);
	$format_db = format_db($newDate);
	return $format_db;
}

function calculateAge($birthdate) {
	$today = new DateTime();
	$diff = $today->diff(new DateTime($birthdate));
	return $diff->y;
  }



function generateRegistrationCode($length = 8) {
	$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randomString = '';

	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, strlen($characters) - 1)];
	}

	return $randomString;
}

function hitungUmur($tgl_lahir, $tgl_hari_ini, $return ='Y')
{
	$birthDate = new \DateTime($tgl_lahir);
	$today = new \DateTime($tgl_hari_ini);


	if ($birthDate > $today) {
	return "0 tahun 0 bulan 0 hari";
	}
	$y = $today->diff($birthDate)->y;
	// dd($y);
	$m = $today->diff($birthDate)->m;
	$d = $today->diff($birthDate)->d;

	if($return=='Y')
	{
		return $y; //klo mau lihat usia dalam Tahun
	}else{
		return $y . " tahun " . $m . " bulan " . $d . " hari"; //lihat usia lengkap, tahun bulan hari
	}

}

function getImageExt($input_name){
   $ext =  substr($_FILES[$input_name]['name'], strrpos($_FILES[$input_name]['name'], '.') + 1);

   return $ext;
}

function getStartDate($bulan, $tahun)
{
	$periode = $tahun . '-' . $bulan;
	$from_date = $periode . '-01';
	$start_date = format_db($from_date);

	return $start_date;
}


function getEndDate($bulan, $tahun)
{

	$start_date = getStartDate($bulan, $tahun);
	$last_date = date('t', strtotime($start_date));
	$periode = $tahun . '-' . $bulan;
	$end_date = $periode . '-' . $last_date;

	return $end_date;
}


function print_array($array)
{

	echo '<pre>';
	print_r($array);
	echo '</pre>';
}



function getStatusHipertensi($sistol, $diastol)
{

	if($sistol < 120){
		$status = 'Normal';
		$id_status = 1;
	}else if($sistol >= 120 && $sistol < 140){
		if($diastol < 90){
			$status = 'HT Ringan';
			$id_status = 2;

		}else if($diastol > 89 && $diastol < 100){
			$status = 'HT Sedang';
			$id_status = 3;
		}else{
			$status = 'HT Berat';
			$id_status = 4;
		}

	}else if($sistol >= 140 && $sistol < 160){
		if($diastol < 100){
			$status = 'HT Sedang';
			$id_status = 3;
		}else{
			$status = 'HT Berat';
			$id_status = 4;
		}
	}else{
		$status = 'HT Berat';
		$id_status = 4;
	}

	return array($status, $id_status);

}

function getStatusGDS($nilai_gds, $penyerta=0){
	if($nilai_gds <= 200){
		$status_gds = 1; // normal
	}else{
		if($penyerta==0){
			$status_gds = 2; // ringan
		}else{
			$status_gds = 3; // berat
		}
	}

	return $status_gds;
}

function getStatusLaik($ht, $gds, $gejala, $narkoba){

	if($ht == 3){
		//ht sedang
		if($gejala==1){
			//ada gejala penyerta
			$kategori = 3; // tidak laik
		}else{

			if($narkoba == 2){
				// tes urin positif, maka masuk ke katogori tidak laik
				$kategori = 3; // tidak laik
			}else{
				//narkoba diperiksa adapun negatif tetap masuk kategori laik dengan catatan, karena ht nya sedang
				$kategori = 2;
			}

		}
	}else if($ht==4){
		//ht berat
		$kategori = 3; // tidak laik
	}else{
		// ht  normal dan ringan

		if($gds > 200){
			//masuk ke kategori laik/ tidak laik tergantung gejala

			if($gejala==1){
				//ada gejala penyerta
				$kategori = 3; // tidak laik
			}else{

				if($narkoba == 2){
					// tes urin positif, maka masuk ke katogori tidak laik
					$kategori = 3; // tidak laik
				}else{
					//narkoba diperiksa adapun negatif tetap masuk kategori laik dengan catatan, karena ht nya sedang
					$kategori = 2;
				}
			}
		}else{
				// GDS normal
				if($narkoba == 2){
					// tes urin positif, maka masuk ke katogori tidak laik langsung sekalipun HT normal, gds normal
					$kategori = 3; // tidak laik
				}else if($narkoba == 0){
					// tes urin tidak diperiksa
					$kategori = 2;
				}else{
					$kategori = 1; //kategori laik
				}
		}
	}

	return $kategori;

}


function getFlagHT($status_ht)
{

	if($status_ht==1){
		//ht normal
		$flag = '<span class="badge badge-succes-lights">Normal</span>';
	}else if($status_ht==2){
		$flag = '<span class="badge badge-success-light">HT Ringan</span>';
	}else if($status_ht==3){
		$flag = '<span class="badge badge-warning-light">HT Sedang</span>';
	}else{
		$flag = '<span class="badge badge-danger-light">HT Berat</span>';
	}

	return $flag;
}


function getFlagGDS($status_gds)
{

	if($status_gds==1){
		//ht normal
		$flag = '<span class="badge badge-success-light">Normal</span>';
	}else if($status_gds==2){
		$flag = '<span class="badge badge-success-light">Ringan</span>';
	}else{
		$flag = '<span class="badge badge-danger-light">Berat</span>';
	}

	return $flag;
}



function getFlagLaik($status_laik)
{

	if($status_laik==1){
		//ht normal
		$flag = '<span class="badge badge-success-light">LAIK</span>';
	}else if($status_laik==2){
		$flag = '<span class="badge badge-success-light">LAIK dgn Catatan</span>';
	}else{
		$flag = '<span class="badge badge-danger-light">Tidak LAIK</span>';
	}

	return $flag;
}




function getListBulan()
{
	$arrayBulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	return $arrayBulan;
}

if (!function_exists('format_hari')) {
	function format_hari($dayName)
	{

		switch ($dayName) {
			case "Mon":
				$hari = "Senin";
				break;
			case "Tue":
				$hari = "Selasa";
				break;
			case "Wed":
				$hari = "Rabu";
				break;
			case "Thu":
				$hari = "Kamis";
				break;
			case "Fri":
				$hari = "Jumat";
				break;
			case "Sat":
				$hari = "Sabtu";
				break;
			case "Sun":
				$hari = "Minggu";
				break;
			default:
				$hari = "No information available for that day.";
				break;
		}

		return $hari;
	}
}




if (!function_exists('add_date')) {
	function add_date($date, $days)
	{
		$plus2 = strtotime('+' . $days . ' day', strtotime($date)); //tambah 1 hari
		$newDate  = date('Y-m-d', $plus2);
		return $newDate;
	}
}




if (!function_exists('rupiah')) {
	function rupiah($harga)
	{
		$idr = number_format($harga, 0, ',', '.');
		return $idr;
	}
}


if (!function_exists('format_db')) {
	function format_db($tgl)
	{
	    if($tgl=='') return '';
		$newDate = date('Y-m-d', strtotime($tgl));
		return $newDate;
	}
}

if (!function_exists('format_slash')) {
	function format_slash($tgl)
	{
		$newDate = date('d/m/Y', strtotime($tgl));
		return $newDate;
	}
}
if (!function_exists('format_view')) {
	function format_view($tgl)
	{
		$newDate = date('d-m-Y', strtotime($tgl));
		return $newDate;
	}
}


if (!function_exists('format_full')) {

	function format_full($tgl)
	{
		$newDate = date('d F Y', strtotime($tgl));
		return $newDate;
	}
}


if (!function_exists('namaHari')) {
	function namaHari($nama_hari)
	{

		switch ($nama_hari) {
			case 'Sun':
				$hari = 'Minggu';
				break;
			case 'Mon':
				$hari = 'Senin';
				break;
			case 'Tue':
				$hari = 'Selasa';
				break;
			case 'Wed':
				$hari = 'Rabu';
				break;
			case 'Thu':
				$hari = 'Kamis';
				break;
			case 'Fri':
				$hari = 'Jumat';
				break;

			default:
				$hari = 'Sabtu';
		}

		return $hari;
	}
}




if (!function_exists('getNamaBulan')) {
	function getNamaBulan($bln)
	{

		switch ($bln) {
			case 1:
				$namaBulan = 'Jan';
				break;
			case 2:
				$namaBulan = 'Feb';
				break;
			case 3:
				$namaBulan = 'Mar';
				break;
			case 4:
				$namaBulan = 'Apr';
				break;
			case 5:
				$namaBulan = 'Mei';
				break;
			case 6:
				$namaBulan = 'Juni';
				break;
			case 7:
				$namaBulan = 'Juli';
				break;
			case 8:
				$namaBulan = 'Agust';
				break;
			case 9:
				$namaBulan = 'Sep';
				break;
			case 10:
				$namaBulan = 'Okt';
				break;

			case 11:
				$namaBulan = 'Nov';
				break;

			default:
				$namaBulan = 'Des';
		}

		return $namaBulan;
	}
}



if (!function_exists('bulan')) {
	function bulan($bln)
	{

		switch ($bln) {
			case 1:
				$namaBulan = 'Januari';
				break;
			case 2:
				$namaBulan = 'Februari';
				break;
			case 3:
				$namaBulan = 'Maret';
				break;
			case 4:
				$namaBulan = 'April';
				break;
			case 5:
				$namaBulan = 'Mei';
				break;
			case 6:
				$namaBulan = 'Juni';
				break;
			case 7:
				$namaBulan = 'Juli';
				break;
			case 8:
				$namaBulan = 'Agustus';
				break;
			case 9:
				$namaBulan = 'September';
				break;
			case 10:
				$namaBulan = 'Oktober';
				break;

			case 11:
				$namaBulan = 'November';
				break;

			default:
				$namaBulan = 'Desember';
		}

		return $namaBulan;
	}
}



function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
{
	/*$interval can be:
	yyyy - Number of full years
	q - Number of full quarters
	m - Number of full months
	y - Difference between day numbers
	(eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
	d - Number of full days
	w - Number of full weekdays
	ww - Number of full weeks
	h - Number of full hours
	n - Number of full minutes
					s - Number of full seconds (default)
					*/
	if (!$using_timestamps) {
		$datefrom = strtotime($datefrom, 0);
		$dateto = strtotime($dateto, 0);
	}
	$difference = $dateto - $datefrom; // Difference in seconds
	switch ($interval) {
		case 'yyyy': // Number of full years
			$years_difference = floor($difference / 31536000);
			if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom) + $years_difference) > $dateto) {
				$years_difference--;
			}
			if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto) - ($years_difference + 1)) > $datefrom) {
				$years_difference++;
			}
			$datediff = $years_difference;
			break;
		case "q": // Number of full quarters
			$quarters_difference = floor($difference / 8035200);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($quarters_difference * 3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$quarters_difference--;
			$datediff = $quarters_difference;
			break;
		case "m": // Number of full months
			$months_difference = floor($difference / 2678400);
			while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom) + ($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
				$months_difference++;
			}
			$months_difference--;
			$datediff = $months_difference;
			break;
		case 'y': // Difference between day numbers
			$datediff = date("z", $dateto) - date("z", $datefrom);
			break;
		case "d": // Number of full days
			$datediff = floor($difference / 86400);
			break;
		case "w": // Number of full weekdays
			$days_difference = floor($difference / 86400);
			$weeks_difference = floor($days_difference / 7); // Complete weeks
			$first_day = date("w", $datefrom);
			$days_remainder = floor($days_difference % 7);
			$odd_days = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?
			if ($odd_days > 7) { // Sunday
				$days_remainder--;
			}
			if ($odd_days > 6) { // Saturday
				$days_remainder--;
			}
			$datediff = ($weeks_difference * 5) + $days_remainder;
			break;
		case "ww": // Number of full weeks
			$datediff = floor($difference / 604800);
			break;
		case "h": // Number of full hours
			$datediff = floor($difference / 3600);
			break;
		case "n": // Number of full minutes
			$datediff = floor($difference / 60);
			break;
		default: // Number of full seconds (default)
			$datediff = $difference;
			break;
	}
	return $datediff;
}
