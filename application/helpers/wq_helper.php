<?php ob_start();

define('KATEGORI', 'ms_category');
define('STOCK', 'ts_stock');
define('TBL_USER', 'mst_user');
define('NEW_CSS_PATH', base_url() . 'assets/css/material/');
define('NEW_JS_PATH',  base_url() . 'assets/js/');
define('LIBS_JS_PATH',  base_url() . 'assets/libs/');
define('PROFILE_PAGE', 'https://ekinerja-puskesmascilincing.jakarta.go.id/profile/');
define('IMAGES_PATH', base_url() . 'assets/images/');
define('ABSENSI', base_url() . 'absensi/');
define('PATH_IMAGE', 'https://puskesmascilincing.jakarta.go.id/asset/material/images/');

define('CSS_PATH', base_url() . 'assets/tabler/dist/css/');
define('DIST_PATH', base_url() . 'assets/tabler/dist/');
define('NAMA_KAPUS', 'dr. Raden Achmad Sigit Mustika Adi');
define('NIP_KAPUS', '196801242007011020');




define("EKIN_URL", 'https://ekinerja-puskesmascilincing.jakarta.go.id/');

define('SPJ', base_url() . 'spj/');
define('EKIN', base_url() . '');
define('PENILAIAN_KINERJA', base_url() . 'admin/penilaian_kinerja/');
define('DATA_PEGAWAI', base_url() . 'admin/data_pegawai/');
define('ADMIN_EKIN', EKIN_URL . 'admin/');
define('SERAPAN', 20.00);
define('API_ABSEN', 'http://puskesmascilincing.id/e-absensi/masteradmin/absensi/');

$SERVER_NAME =  $_SERVER['SERVER_NAME'];

if (strpos($SERVER_NAME, '10.15.39.96') !== false) {
	//link local

	define('MAIN_URL', 'http://' . $SERVER_NAME . '/ekinerja-cilincing/');
} else {
	//link production
	define('MAIN_URL', 'https://' . $SERVER_NAME . '/');
}



function formatBulan($date)
{
	$month = date('m', strtotime($date));
	$tgl = date('d', strtotime($date));
	$tahun = date('Y', strtotime($date));

	$bulan = getNamaBulan($month);


	$newDate = $tgl . ' ' . $bulan . ' ' . $tahun;

	return $newDate;
}


function hitung_poin_perilaku($jawaban, $jns_item)
{
	if ($jawaban === null || $jawaban === '') {
		return 0;
	}

	return ($jns_item == 1)
		? (int)$jawaban
		: 11 - (int)$jawaban;
}

function hitungTelat($jam_masuk, $jam_absen)
{
	$telat = 0;


	$explod_a   = explode(":", $jam_masuk);
	$jam_a  	= @$explod_a[0];
	$menit_a    = @$explod_a[1];

	if ($jam_a == '-') {
		$jam_a  	= 0;
		$menit_a    = 0;
	}


	$explod     = explode(":", $jam_absen);
	$jam  	    = $explod[0];
	$menit      = $explod[1];


	if ($jam == $jam_a) {

		if ($menit  > $menit_a) {
			$selihMenit  = $menit - $menit_a;
			$telat = $selihMenit;
		} else {
			$telat = 0;
		}
	} else if ($jam > $jam_a) {


		$selihAjam  = $jam - $jam_a;
		$selihMenit  = $menit - $menit_a;

		$telat =  ($selihAjam * 60) + $selihMenit;
	} else {


		$telat = 0;
	}



	return $telat;
}




function hitungHariCuti($from, $to, $skipHariLibur = false, $hariLibur = [])
{
	$start = new DateTime($from);
	$end   = new DateTime($to);
	$end->modify('+1 day');

	$total = 0;

	while ($start < $end) {

		$tanggal = $start->format('Y-m-d');
		$hari    = $start->format('N'); // 6 = sabtu, 7 = minggu

		if ($skipHariLibur) {
			if ($hari == 6 || $hari == 7) {
				$start->modify('+1 day');
				continue;
			}

			if (in_array($tanggal, $hariLibur)) {
				$start->modify('+1 day');
				continue;
			}
		}

		$total++;
		$start->modify('+1 day');
	}

	return $total;
}

function statusStyle($status)
{
	if ($status == 'approved') {
		return ['icon' => 'fa-circle-check', 'bg' => 'is-done', 'text' => 'text-success', 'label' => 'Disetujui'];
	}
	if ($status == 'rejected') {
		return ['icon' => 'mdi-close', 'bg' => '', 'text' => 'text-danger', 'label' => 'Ditolak'];
	}
	if ($status == 'pending') {
		return ['icon' => 'fa-circle-question', 'bg' => '', 'text' => 'text-warning', 'label' => 'Menunggu Persetujuan'];
	}
	return ['icon' => 'fa-circle-question', 'bg' => '', 'text' => 'text-muted', 'label' => 'Pending'];
}



function getNamahari($tgl)
{
	$day = date('D', strtotime($tgl));
	switch ($day) {
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




function hitungPulangCepat($jam_pulang, $jam_absen)
{
	$pc = 0;

	$jam_pulang   = trim($jam_pulang);
	$explod_a     = explode(":", $jam_pulang);
	$jam_a  	    = $explod_a[0];
	$menit_a      = @$explod_a[1];


	$diff_menit = 0;


	if ($jam_pulang <> '00:00:00') {

		$explod     = explode(":", $jam_absen);
		$jam  	    = @$explod[0];
		$menit      = @$explod[1];

		if ($jam_absen == '-') {
			$pc = 150;
		} else {
			if ($jam < $jam_a) {
				$defMenit = 60 - $menit;
				if ($menit_a == '30') {

					$pc = $defMenit + 30;
				} else {

					$selihAjam  = $jam_a - $jam;
					if ($selihAjam == 1) {
						$pc = $defMenit;
					} else {
						$adding = ($selihAjam - 1) * 60;
						$pc = $adding + $diff_menit;
					}
				}
			} else if ($jam == $jam_a) {

				if ($menit_a == '30') {
					if ($menit >= $menit_a) {
						$pc = 0;
					} else {
						$pc = $menit_a - $menit;
					}
				} else {
					$pc = 0;
				}
			} else {
				$pc = 0;
			}
		}
	} else {
		$pc = 0;
	}



	return $pc;
}

function createTempImageName($imageName, $file_name)
{
	$newImageName = $imageName . '_temp.' . substr($_FILES[$file_name]['name'], strrpos($_FILES[$file_name]['name'], '.') + 1);
	return $newImageName;
}


function getFileType2($fileUploadName)
{

	//$format = substr($_FILES[$fileUploadName]['name'], strrpos($_FILES[$fileUploadName]['name'], '.') + 1);
	$format = substr($fileUploadName,  strrpos($fileUploadName, '.') + 1);
	return $format;
}


function formatTanggalIndo($date)
{
	$tgl = date('d', strtotime($date));
	$bln = date('m', strtotime($date));
	$thn = date('Y', strtotime($date));

	$bulan  = getBulan($bln);
	$new_date =  $tgl . ' ' . $bulan . ' ' . $thn;
	return $new_date;
}


function createImageName($imageName, $file_name)
{
	$newImageName = $imageName . '.' . substr($_FILES[$file_name]['name'], strrpos($_FILES[$file_name]['name'], '.') + 1);
	return $newImageName;
}

function getFileType($fileUploadName)
{
	// $finfo = finfo_open(FILEINFO_MIME_TYPE); // Buka resource fileinfo
	// $fileType = finfo_file($finfo, $file); // Dapatkan tipe file
	// finfo_close($finfo); // Tutup resource fileinfo

	// $xplode = explode("/", $fileType);
	// $format = $xplode[1];
	// return $format;

	$format = substr($_FILES[$fileUploadName]['name'], strrpos($_FILES[$fileUploadName]['name'], '.') + 1);
	return $format;
}



function resizeImage($file, $width, $height, $outputFile)
{
	list($originalWidth, $originalHeight, $imageType) = getimagesize($file);

	$src = imagecreatefromstring(file_get_contents($file));

	$dst = imagecreatetruecolor($width, $height);

	// Preserve transparency for PNG and GIF images
	if ($imageType == IMAGETYPE_PNG || $imageType == IMAGETYPE_GIF) {
		imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
		imagealphablending($dst, false);
		imagesavealpha($dst, true);
	}

	imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $originalWidth, $originalHeight);

	switch ($imageType) {
		case IMAGETYPE_JPEG:
			imagejpeg($dst, $outputFile);
			break;
		case IMAGETYPE_PNG:
			imagepng($dst, $outputFile);
			break;
		case IMAGETYPE_GIF:
			imagegif($dst, $outputFile);
			break;
		default:
			throw new Exception('Unsupported image type');
	}

	imagedestroy($src);
	imagedestroy($dst);
}




#untuk ngecek apakah jam absen itu termasuk absen masuk atau absen pulang
if (!function_exists('cekStatusAbsen')) {
	function cekStatusAbsen($jam_absen)
	{

		//echo $jam_absen;
		$status = 0;
		$pecah = explode(":", $jam_absen);
		$jam   = $pecah[0];

		//klo absen nya kurang dari jam 10 maka dianggap absen masuk
		if ($jam < 10) {
			$status = 0;
		}

		if ($jam > 14) {
			$status = 1;
		}


		return $status;
	}
}


function resize_and_crop($original_image_url, $thumb_image_url, $thumb_w, $thumb_h, $quality = 75)
{
	// ACQUIRE THE ORIGINAL IMAGE: http://php.net/manual/en/function.imagecreatefromjpeg.php
	$original = imagecreatefromjpeg($original_image_url);
	if (!$original) return FALSE;

	// GET ORIGINAL IMAGE DIMENSIONS
	list($original_w, $original_h) = getimagesize($original_image_url);

	// RESIZE IMAGE AND PRESERVE PROPORTIONS
	$thumb_w_resize = $thumb_w;
	$thumb_h_resize = $thumb_h;
	if ($original_w > $original_h) {
		$thumb_h_ratio  = $thumb_h / $original_h;
		$thumb_w_resize = (int)round($original_w * $thumb_h_ratio);
	} else {
		$thumb_w_ratio  = $thumb_w / $original_w;
		$thumb_h_resize = (int)round($original_h * $thumb_w_ratio);
	}
	if ($thumb_w_resize < $thumb_w) {
		$thumb_h_ratio  = $thumb_w / $thumb_w_resize;
		$thumb_h_resize = (int)round($thumb_h * $thumb_h_ratio);
		$thumb_w_resize = $thumb_w;
	}

	// CREATE THE PROPORTIONAL IMAGE RESOURCE
	$thumb = imagecreatetruecolor($thumb_w_resize, $thumb_h_resize);
	if (!imagecopyresampled($thumb, $original, 0, 0, 0, 0, $thumb_w_resize, $thumb_h_resize, $original_w, $original_h)) return FALSE;

	// ACTIVATE THIS TO STORE THE INTERMEDIATE IMAGE
	// imagejpeg($thumb, 'RAY_temp_' . $thumb_w_resize . 'x' . $thumb_h_resize . '.jpg', 100);

	// CREATE THE CENTERED CROPPED IMAGE TO THE SPECIFIED DIMENSIONS
	$final = imagecreatetruecolor($thumb_w, $thumb_h);

	$thumb_w_offset = 0;
	$thumb_h_offset = 0;
	if ($thumb_w < $thumb_w_resize) {
		$thumb_w_offset = (int)round(($thumb_w_resize - $thumb_w) / 2);
	} else {
		$thumb_h_offset = (int)round(($thumb_h_resize - $thumb_h) / 2);
	}

	if (!imagecopy($final, $thumb, 0, 0, $thumb_w_offset, $thumb_h_offset, $thumb_w_resize, $thumb_h_resize)) return FALSE;

	// STORE THE FINAL IMAGE - WILL OVERWRITE $thumb_image_url
	if (!imagejpeg($final, $thumb_image_url, $quality)) return FALSE;
	return TRUE;
}

function lowerCase($string)
{
	$new_string = strtolower($string);
	return $new_string;
}


function upperCase($string)
{
	$new_string = strtolower($string);
	$new_string = strtoupper($new_string);

	return $new_string;
}



if (!function_exists('getJamKerjaShift')) {
	function getJamKerjaShift($shift_name)
	{

		switch ($shift_name) {
			case "OFF":
				$jam_kerja = "-";
				break;
			case "P":
				$jam_kerja = "07:30:00 - 14:00:00";
				break;
			case "S":
				$jam_kerja = "14:00:00 - 21:00:00";
				break;
			case "PS":
				$jam_kerja = "07:30:00 - 21:00:00";
				break;
			case "SM":
				$jam_kerja = "14:00:00 - 00:00:00";
				break;
			case "SM-L":
				$jam_kerja = "00:01:00 - 07:30:00";
				break;
			case "M":
				$jam_kerja = "21:00:00 - 00:00:00";
				break;
			case "M-L":
				$jam_kerja = "00:01:00 - 07:30:00";
				break;
			case "PSM":
				$jam_kerja = "07:30:00 - 00:00:00";
				break;
			case "PSM-L":
				$jam_kerja = "00:01:00 - 07:30:00";
				break;
			case "REG":
				$jam_kerja = "07:30:00 - 15:00:00";
				break;
			case "REG-JUM":
				$jam_kerja = "07:30:00 - 15:30:00";
				break;
			default:
				$jam_kerja = "-";
				break;
		}

		return $jam_kerja;
	}
}



function cekShift($shiftName)
{
	if ($shiftName == 'OFF' || $shiftName == 'SM-OUT' || $shiftName == 'PSM-OUT' || $shiftName == 'M-OUT') {
		return true;
	} else {
		return false;
	}
}



function cekShiftMasuk($shiftName)
{
	if ($shiftName == 'OFF' || $shiftName == 'SM-IN' || $shiftName == 'PSM-IN' || $shiftName == 'M-IN') {
		return true;
	} else {
		return false;
	}
}



function cekAbsenMasuk($absen)
{
	if ($absen == 'IZIN' || $absen == 'CUTI' || $absen == 'DL-AWAL' || $absen == 'SAKIT' || $absen == 'DL_PENUH' || $absen == 'LIBUR NASIONAL' || $absen == 'ISOLASI MANDIRI' || $absen == 'PDP - POSITIF') {
		return true;
	} else {
		return false;
	}
}

function cekAbsenKeluar($absen)
{
	if ($absen == 'IZIN' || $absen == 'CUTI' || $absen == 'DL-AKHIR' || $absen == 'SAKIT' || $absen == 'DL_PENUH' || $absen == 'LIBUR NASIONAL' || $absen == 'ISOLASI MANDIRI' || $absen == 'PDP - POSITIF') {
		return true;
	} else {
		return false;
	}
}


function format_jam($jam)
{
	$newJam = substr($jam, 0, 5);
	return $newJam;
}

function hitungJamKerja($IN, $OUT)
{
	$to_time 	= strtotime($OUT);
	$from_time  = strtotime($IN);
	$MenitKerja = round(abs($to_time - $from_time) / 60);
	$jamKerja   = round($MenitKerja / 60);

	return $jamKerja;
}


function getMasaKerja($tahun, $bulan)
{
	if ($tahun  < 2) {
		$masa_kerja =  '0 - 2 Tahun';
	} else if ($tahun >= 2 && $tahun < 4) {
		$masa_kerja =  '2 - 4 Tahun';
	} else if ($tahun >= 4 && $tahun < 6) {
		$masa_kerja =  '4 - 6 Tahun';
	} else if ($tahun >= 6 && $tahun < 8) {
		$masa_kerja =  '6 - 8 Tahun';
	} else if ($tahun >= 8 && $tahun < 10) {
		$masa_kerja =  '8 - 10 Tahun';
	} else if ($tahun >= 10 && $tahun < 12) {
		$masa_kerja =  '10 - 12 Tahun';
	} else if ($tahun >= 12 && $tahun < 14) {
		$masa_kerja =  '12 - 14 Tahun';
	} else if ($tahun >= 14 && $tahun < 16) {
		$masa_kerja =  '14 - 16 Tahun';
	} else if ($tahun >= 16 && $tahun < 18) {
		$masa_kerja =  '16 - 18 Tahun';
	} else {
		$masa_kerja =  '18 - 20 Tahun';
	}

	return $masa_kerja;
}


function getIdMasaKerja($tahun, $bulan)
{

	if ($tahun <  2) {
		$id = 1;
	} else if ($tahun >= 2 && $tahun < 4) {
		$id = 2;
	} else if ($tahun >= 4 && $tahun < 6) {
		$id = 3;
	} else if ($tahun >= 6 && $tahun < 8) {
		$id = 4;
	} else if ($tahun >= 8 && $tahun < 10) {
		$id = 6;
	} else if ($tahun >= 10 && $tahun < 12) {
		$id = 7;
	} else if ($tahun >= 12 && $tahun < 14) {
		$id = 8;
	} else if ($tahun >= 14 && $tahun < 16) {
		$id = 9;
	} else if ($tahun >= 16 && $tahun < 18) {
		$id = 10;
	} else {
		$id = 11;
	}

	return $id;
}
function get_array($arr)
{
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}
function clear_tags($val)
{
	$new_val = str_replace(',', "", $val);
	$new_val = str_replace('.', "", $new_val);
	return $new_val;
}
function format_full_day($date)
{
	$new_date = date('l, d M Y', strtotime($date));
	return $new_date;
}
function format_db($date)
{
	$new_date = date('Y-m-d', strtotime($date));
	return $new_date;
}
function format_view($date)
{
	$new_date = date('d-m-Y', strtotime($date));
	return $new_date;
}
function format_slash($date)
{
	$new_date = date('d/m/Y', strtotime($date));
	return $new_date;
}
function format_semi($date)
{
	$new_date = date('d M Y', strtotime($date));
	return $new_date;
}

function format_full($date)
{
	$new_date = date('d M Y', strtotime($date));

	$tanggal = str_replace("Jan", "Januari", $new_date);
	$tanggal = str_replace("Feb", "Februari", $tanggal);
	$tanggal = str_replace("Mar", "Maret", $tanggal);
	$tanggal = str_replace("Apr", "April", $tanggal);
	$tanggal = str_replace("May", "Mei", $tanggal);
	$tanggal = str_replace("Jun", "Juni", $tanggal);
	$tanggal = str_replace("Jul", "Juli", $tanggal);
	$tanggal = str_replace("Aug", "Agustus", $tanggal);
	$tanggal = str_replace("Sep", "September", $tanggal);
	$tanggal = str_replace("Oct", "Oktober", $tanggal);
	$tanggal = str_replace("Nov", "November", $tanggal);
	$tanggal = str_replace("Dec", "Desember", $tanggal);


	return $tanggal;
}


if (!function_exists('getIDBulan')) {
	function getIDBulan($bln)
	{

		switch ($bln) {
			case 'Januari':
				$id = 1;
				break;
			case 'Februari':
				$id = 2;
				break;
			case 'Maret':
				$id = 3;
				break;
			case 'April':
				$id = 4;
				break;
			case 'Mei':
				$id = 5;
				break;
			case 'Juni':
				$id = 6;
				break;
			case 'Juli':
				$id = 7;
				break;
			case 'Agustus':
				$id = 8;
				break;
			case 'September':
				$id = 9;
				break;
			case 'Oktober':
				$id = 10;
				break;

			case 'November':
				$id = 11;
				break;

			default:
				$id = 12;
		}

		return $id;
	}
}



function format_hari($date)
{
	$hari = date('l', strtotime($date));
	if ($hari == 'Sunday') {
		$day = 'Minggu';
	} elseif ($hari == 'Monday') {
		$day = 'Senin';
	} elseif ($hari == 'Tuesday') {
		$day = 'Selasa';
	} elseif ($hari == 'Wednesday') {
		$day = 'Rabu';
	} elseif ($hari == 'Thursday') {
		$day = 'Kamis';
	} elseif ($hari == 'Friday') {
		$day = 'Jumat';
	} elseif ($hari == 'Saturday') {
		$day = 'Sabtu';
	}
	return $day;
}


if (!function_exists('add_date')) {
	function add_date($date, $days)
	{
		$plus2 = strtotime('+' . $days . ' day', strtotime($date)); //tambah 1 hari
		$newDate  = date('Y-m-d', $plus2);
		return $newDate;
	}
}


if (!function_exists('reduce_date')) {
	function reduce_date($date, $days)
	{
		$plus2 = strtotime('-' . $days . ' day', strtotime($date)); //tambah 1 hari
		$newDate  = date('Y-m-d', $plus2);
		return $newDate;
	}
}

function getStatusCuti($status)
{
	switch ($status) {
		case 'PEND0':
			$flag_status = '<span class="badge bg-warning-subtle text-warning fs-sm">Pend -  ACC Pengganti</span>';
			break;
		case 'PEND1':
			$flag_status = '<span class="badge bg-info-subtle text-info fs-sm">Pend - ACC Kapustu</span>';
			break;
		case 'PEND2':
			$flag_status = '<span class="badge bg-success-subtle text-success fs-sm">Pend -  ACC Kasubbag TU</span>';
			break;
		case 'PEND3':
			$flag_status = '<span class="badge bg-success-subtle text-success fs-sm">Pend -  ACC Kapus Kecamatan</span>';
			break;
		case 'APPROVE':
			$flag_status = '<span class="badge bg-success fs-sm">Disetujui</span>';
			break;
		case 'REJECT':
			$flag_status = '<span class="badge bg-danger fs-sm">Ditolak</span>';
			break;
		case 'CANCEL':
			$flag_status = '<span class="badge bg-danger fs-sm">Dibatalkan</span>';
			break;

		default:
			$flag_status = '<span class="badge bg-warning fs-sm">Ditangguhkan</span>';
	}

	return $flag_status;
}
/*\
	PENDING      				 - PEND0       -> Belum di ACC Pengganti
	PENDING KAPUSKEL/KASATPEL    - PEND1
	PENDING KTU					 - PEND2
	PENDING KAPUSKEL             - PEND3


	DISETUJUI    				 - APPROVED   -> Sudah disetujui kapuskec
	DiTOLAK      				 - REJECT     -> ditolak
	DIBATALKAN   				 - CANCEL     ->
	DITANGGUHKAN 				 - HOLD



*/


function getJamKerjaPegawai($hari)
{

	if ($hari == 'Minggu' || $hari == 'Sabtu') {
		$bg = '#fef5f5; color:#b33030';
		$jamMasuk = '';
		$jamPulang = '';
		$weekday = true;
	} else if ($hari == 'Jumat') {
		$bg = '#FFF';
		$jamMasuk = '07:30:00';
		$jamPulang = '16:30:00';
		$weekday = false;
	} else {
		$bg = '#FFF';
		$jamMasuk = '07:30:00';
		$jamPulang = '16:00:00';
		$weekday = false;
	}


	$newArray = array(
		'bg' => $bg,
		'jam_masuk' => $jamMasuk,
		'jam_pulang' => $jamPulang,
		'weekday' => $weekday

	);

	return $newArray;
}

if (!function_exists('changeFormatDate')) {

	function changeFormatDate($date)
	{
		//Sat Nov 27 2021

		$newDate  = explode(" ", $date);
		$bulan  = $newDate[1];
		$tgl = $newDate[2];
		$tahun  = $newDate[3];

		$newDate = $tahun . '-' . $bulan . '-' . $tgl;
		$newFormat = format_db($newDate);

		return $newFormat;
	}
}


function hitungMasaKerja($date1, $date2)
{
	$datetime1 = new DateTime($date1);
	$datetime2 = new DateTime($date2);
	$interval = $datetime1->diff($datetime2);

	$years = $interval->y;
	$months = $interval->m;
	$days = $interval->d;

	return array('years' => $years, 'months' => $months, 'days' => $days);
}



function getListJnsDiklat()
{

	$jns = 'SEMINAR/
	WORKSHOP/
	SOSIALISASI/
	KURSUS/
	PENATARAN/
	BIMTEK/
	STRUKTURAL/
	MANAJERIAL/
	FUNGSIONAL/
	JARAK JAUH/
	COACHING/
	MENTORING/
	E-LEARNING/
	BELAJAR MANDIRI/
	PATOK BANDING';

	$arayJenis = explode("/", $jns);

	return $arayJenis;
}


function tanggalCuti($tgl_dari, $tgl_sampai)
{
	$bulan1 = date('m', strtotime($tgl_dari));
	$bulan2 = date('m', strtotime($tgl_sampai));

	$tgl1 = date('d', strtotime($tgl_dari));
	$tgl2 = date('d', strtotime($tgl_sampai));

	$tahun1 = date('Y', strtotime($tgl_dari));
	$tahun2 = date('Y', strtotime($tgl_sampai));


	$nama_bulan = getNamaBulan($bulan1);
	$nama_bulan2 = getNamaBulan($bulan2);

	if ($bulan1 == $bulan2) {
		$tgl_cuti = $tgl1 . '-' . $tgl2 . ' ' . $nama_bulan . ' ' . $tahun1;
		if ($tgl_dari == $tgl_sampai) {
			$tgl_cuti = $tgl1 . ' ' . $nama_bulan . ' ' . $tahun1;
		}
	} else {

		$tgl_cuti = $tgl1 . ' ' . $nama_bulan . ' ' . $tahun1 . ' s/d ' . $tgl2 . ' ' . $nama_bulan2 . ' ' . $tahun2;
	}


	return $tgl_cuti;
}

function arrayPendidikan()
{
	$arrayPendididkan = array('Belum/Tidak Bersekolah', 'Lulus SD', 'Lulus SMP', 'Lulus SLTA', 'Lulus Perguruan Tinggi');
	return $arrayPendididkan;
}


function arrayUsergroup()
{
	$arrayUG = array('Superadmin', 'Kapuskec', 'Kasubbag TU', 'PJ Pustu/PJ Klaster', 'User', 'Penanggung Jawab');
	return $arrayUG;
}

function renderStatusDot($status) {
    switch ((string)$status) {
        case '0':
            return '<span class="status-dot status-dot-pending" data-bs-toggle="tooltip" title="Belum Divalidasi"></span>';
        case '1':
            return '<span class="status-dot status-dot-approved" data-bs-toggle="tooltip" title="Validasi Disetujui"></span>';
        case '2':
            return '<span class="status-dot status-dot-rejected" data-bs-toggle="tooltip" title="Validasi Ditolak"></span>';
        default:
            return '';
    }
}


function createMessageInfo($msg, $alert_type = 'success')
{


	if ($alert_type == 'success') {
		$mssage = '<div class="alert bg-success-subtle text-success alert-dismissible bg-success border-0 fade show" role="alert">
			<button type="button" class="btn-close btn-close-success" data-bs-dismiss="alert" aria-label="Close"></button>
			<strong>Success! </strong> ' . $msg . '
		</div>';
	} else {
		$mssage = '<div class="alert bg-' . $alert_type . '-subtle text-' . $alert_type . ' alert-dismissible  border-0 fade show" role="alert">
					<button type="button" class="btn-close btn-close-danger" data-bs-dismiss="alert" aria-label="Close"></button>
					<strong>Gagal! </strong> ' . $msg . '
				</div>';
	}


	return $mssage;
}



if (!function_exists('ugName')) {
	function getugName($id)
	{

		$usergroup = arrayUsergroup();
		$groupName = $usergroup[$id];
		return $groupName;
	}
}


function addDaysToDate($date, $days)
{
	$datetime = new DateTime($date);
	$datetime->add(new DateInterval('P' . $days . 'D'));
	return $datetime->format('Y-m-d');
}


function formatDayOfWeek($date)
{
	$datetime = new DateTime($date);
	return $datetime->format('N'); // Returns the day of the week as a numeric value
}



function dateDifference($date1, $date2)
{

	$datetime1 = new DateTime($date1);
	$datetime2 = new DateTime($date2);
	$interval = $datetime1->diff($datetime2);
	return $interval->format('%a'); // Returns the difference in days
}



if (!function_exists('getPendidikan')) {
	function getPendidikan($id)
	{

		switch ($id) {
			case 0:
				$pendidikan = 'Belum/Tidak Bersekolah';
				break;
			case 1:
				$pendidikan = 'SD';
				break;
			case 2:
				$pendidikan = 'SMP';
				break;
			case 3:
				$pendidikan = 'SLTA';
				break;
			case 4:
				$pendidikan = 'D III/D IV';
				break;
			case 5:
				$pendidikan = 'S1';
				break;
			case 6:
				$pendidikan = 'S2/dr/drg/Apoteker/Ners';
				break;

			default:
				$pendidikan = 'not found';
		}

		return $pendidikan;
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




function getJenisCuti($id)
{
	if ($id == 1) {
		$cuti = 'Cuti Tahunan';
	} else if ($id == 2) {
		$cuti = 'Cuti Sakit';
	} else if ($id == 3) {
		$cuti = 'Cuti Karena Alasan Penting';
	} else if ($id == 4) {
		$cuti = 'Cuti Besar';
	} else {
		$cuti = 'Cuti Melahirkan';
	}

	return $cuti;
}
function getHariTerakhir($bulan)
{
	if ($bulan == 2) {
		$numDays = 28;
	} elseif ($bulan == 4 || $bulan == 6 || $bulan == 9 || $bulan == 11) {
		$numDays = 30;
	} else {
		$numDays = 31;
	}

	return $numDays;
}
function getJenisAbsensi($jns_absensi, $id_absen_dl, $keterangan)
{
	if ($jns_absensi == 1) {
		//DL-AWAL

		$data = array(
			'absen_masuk'  => 'DL-AWAL',
			'id_absen_dl'  => $id_absen_dl,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	} elseif ($jns_absensi == 2) {
		//DL-AKHIR
		$data = array(
			'absen_keluar'  => 'DL-AKHIR',
			'id_absen_dl'  => $id_absen_dl,
			'keterangan'   => $keterangan,
			'pulang_cepat' => 0
		);
	} elseif ($jns_absensi == 3) {
		//DL-PENUH
		$data = array(
			'absen_masuk'  => 'DL-PENUH',
			'absen_keluar' => 'DL-PENUH',
			'id_absen_dl'  => $id_absen_dl,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	} elseif ($jns_absensi == 4) {
		//CUTI
		$data = array(
			'absen_masuk'  => 'CUTI',
			'absen_keluar' => 'CUTI',
			'id_absen_dl'  => $id_absen_dl,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	} else if ($jns_absensi == 5) {
		//SAKIT
		$data = array(
			'absen_masuk'  => 'SAKIT',
			'absen_keluar' => 'SAKIT',
			'id_absen_dl'  => $id_absen_dl,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	} else if ($jns_absensi == 6) {
		//IZIN
		$data = array(
			'absen_masuk'  => 'IZIN',
			'absen_keluar' => 'IZIN',
			'id_absen_dl'  => $id_absen_dl,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	} else if ($jns_absensi == 7) {
		//WFH
		$data = array(
			'absen_masuk'  => 'WFH',
			'absen_keluar' => 'WFH',
			'id_absen_dl'  => 0,
			'keterangan'   => $keterangan,
			'terlambat' => 0,
			'pulang_cepat' => 0
		);
	} else if ($jns_absensi == 8) {
		//ODP
		$data = array(
			'absen_masuk'  => 'ISOLASI MANDIRI',
			'absen_keluar' => 'ISOLASI MANDIRI',
			'id_absen_dl'  => 0,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	} else {
		//ALPHA
		$data = array(
			'absen_masuk'  => 'ALPHA',
			'absen_keluar' => 'ALPHA',
			'id_absen_dl'  => 0,
			'keterangan'   => $keterangan,
			'terlambat' => 0
		);
	}

	return $data;
}
function getJnsDl($id)
{
	if ($id == 1) {
		$cuti = 'DL-AWAL';
	} else if ($id == 2) {
		$cuti = 'DL-AKHIR';
	} else if ($id == 3) {
		$cuti = 'DL-PENUH';
	} else if ($id == 4) {
		$cuti = 'CUTI';
	} else if ($id == 5) {
		$cuti = 'SAKIT';
	} else if ($id == 6) {
		$cuti = 'IZIN';
	} else if ($id == 7) {
		$cuti = 'WFH';
	} else if ($id == 8) {
		$cuti = 'ISOLASI MANDIRI';
	} else {
		$cuti = 'ALPHA';
	}

	return $cuti;
}
function getWaktu()
{

	$waktu = array('07:00', '07:30', '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30');



	return $waktu;
}

/*	function getWaktu()
	{

		$waktu = array('00:00', '00:30', '01:00', '01:30', '02:00', '02:30', '03:00', '03:30', '04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', '08:00', '08:30', '09:00', '09:30','10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30','20:00', '20:30', '21:00', '21:30', '22:00', '22:30', '23:00', '23:30') ;



		return $waktu ;

	}*/
function format_db2($date)
{
	$expl = explode("/", $date);
	//$impl = implode("-", $expl);
	$ar0 = $expl[0]; //bulan
	$ar1 = $expl[1]; //tanggal
	$ar2 = $expl[2]; //tahun
	//$tgl = str_replace("/", "-", $date);
	$new_date = $ar2 . '-' . $ar0 . '-' . $ar1;
	return $new_date;
}
function format_db3($date)
{
	$expl = explode("/", $date);
	//$impl = implode("-", $expl);
	$ar0 = $expl[0]; //tanggal
	$ar1 = $expl[1]; //bulan
	$ar2 = $expl[2]; //tahun
	//$tgl = str_replace("/", "-", $date);
	$new_date = $ar2 . '-' . $ar1 . '-' . $ar0;
	return $new_date;
}
function rupiah($val)
{
	$return = str_replace(',', '.', number_format($val));
	return $return;
}

function noCommas($val)
{
	#$return = str_replace(',', '.', number_format($val));
	return $val;
}


if (!function_exists('datePlus')) {
	function datePlus($tgl, $num)
	{
		$newDate = strtotime('+' . $num . ' day', strtotime($tgl)); //tambah 1 hari
		$newDate = date('Y-m-d', $newDate);
		return $newDate;
	}
}
if (!function_exists('dateMinus')) {
	function dateMinus($tgl, $num)
	{
		$newDate = strtotime('-' . $num . ' day', strtotime($tgl)); //tambah 1 hari
		$newDate = date('Y-m-d', $newDate);
		return $newDate;
	}
}

function getHourDifference($startHour, $endHour, $case = 'telat')
{
	$format = 'H:i:s'; // Format for representing hours and minutes


	//case digunakan untuk menghitung telat atau menghitung pulang cepat

	// Create DateTime objects for the start and end hours
	$startDateTime = DateTime::createFromFormat($format, $startHour);
	$endDateTime = DateTime::createFromFormat($format, $endHour);

	// Calculate the difference between the two DateTime objects
	$interval = $startDateTime->diff($endDateTime);

	// Extract the difference in hours and minutes
	$hours = $interval->h;
	$minutes = $interval->i;
	$invert = $interval->invert;


	if ($case == 'telat') {
		if ($invert == 1) {
			//hasil hitungan sudah min (tidak terlambat)
			$totalMinutes = 0;
		} else {
			// Convert the difference to minutes
			$totalMinutes = $hours * 60 + $minutes;
		}
	} else {
		//hitung pulang
		if ($invert == 0) {
			//hasil hitungan sudah min (tidak terlambat)
			$totalMinutes = 0;
		} else {
			// Convert the difference to minutes
			$totalMinutes = $hours * 60 + $minutes;
		}
	}




	return $totalMinutes;
}



function getPoinPerilaku($value = '')
{
	switch ($value) {
		case 1:
			$newPoin = 10;
			break;
		case 2:
			$newPoin = 9;
			break;
		case 3:
			$newPoin = 8;
			break;
		case 4:
			$newPoin = 7;
			break;
		case 5:
			$newPoin = 6;
			break;
		case 6:
			$newPoin = 5;
			break;
		case 7:
			$newPoin = 4;
			break;
		case 8:
			$newPoin = 3;
			break;
		case 9:
			$newPoin = 2;
			break;
		case 10:
			$newPoin = 1;
			break;
	}


	return $newPoin;
}

function nilaiJenisItem2($val)
{
	$nilai = $val - 11;
	$newVal = str_replace("-", "", $nilai);

	return $newVal;
}
function getJnsAbsensi($jns)
{

	if ($jns == 1) {
		$cuti = 'DL-AWAL';
	} else if ($jns == 2) {
		$cuti = 'DL-AKHIR';
	} else if ($jns == 3) {
		$cuti = 'DL-PENUH';
	} else if ($jns == 4) {
		$cuti = 'CUTI';
	} else if ($jns == 5) {
		$cuti = 'SAKIT';
	} else {
		$cuti = 'IZIN';
	}

	return $cuti;
}
function word_format($string)
{
	$newFormat = strtolower($string);
	$newFormat = ucwords($newFormat);
	return $newFormat;
}
if (!function_exists('umurbulan')) {
	function umurbulan($date2, $date1)
	{
		$diff = abs(strtotime($date2) - strtotime($date1));
		$years = floor($diff / (365 * 60 * 60 * 24));
		$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
		$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
		$bulan = ($years * 12) + $months;
		return $bulan;
	}
}
// if (!function_exists('hitungMasaKerja')) {
// 	function hitungMasaKerja($date2, $date1)
// 	{
// 		$diff = abs(strtotime($date2) - strtotime($date1));
// 		$years = floor($diff / (365 * 60 * 60 * 24));
// 		$months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
// 		$days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
// 		$array = array(
// 			'tahun' => $years,
// 			'bulan' => $months,
// 			'hari' => $days,
// 		);
// 		return $array;
// 	}
// }
function cekMasaKerja($tahun, $bulan, $hari)
{
	$naik = false;
	if ($tahun % 2 == 0 && $tahun > 1) {
		//klo angkanya genap
		if ($bulan == 0) {
			if ($hari == 0) {
				$naik = false; // ga naik
			} else {
				$naik = true; // naik gaji
			}
		} else {
			$naik = true; // naik gaji
		}
	}
	return $naik;
}
function getBulan($bulan)
{
	$arrayBulan = array('--Bulan--', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	for ($b = 0; $b < 13; $b++) {
		if ($bulan == $b) {
			$newMonth = $arrayBulan[$b];
		}
	}
	return $newMonth;
}

function array_bulan()
{
	$bulan = array('--Bulan--', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	return $bulan;
}
function array_bulan2()
{
	$bulan = array('--Semua--', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
	return $bulan;
}


function print_array($var)
{
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}


function calculateMasakerja($tgl_masuk)
{

	#$bulanTahun = '2023-06-30';
	#$today = new DateTime($bulanTahun);
	$today = new DateTime();

	#print_array($today);
	$diff = $today->diff(new DateTime($tgl_masuk));
	return $diff->y . '-' . $diff->m . '-' . $diff->d;
}


if (!function_exists('format_tanggal_indo')) {

	function format_tanggal_indo($tanggal)
	{
		if (empty($tanggal) || $tanggal == '0000-00-00') {
			return '-';
		}

		$bulan = [
			1  => 'Jan',
			2  => 'Feb',
			3  => 'Mar',
			4  => 'Apr',
			5  => 'Mei',
			6  => 'Jun',
			7  => 'Jul',
			8  => 'Agu',
			9  => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des'
		];

		$timestamp = strtotime($tanggal);

		$hari  = date('d', $timestamp);
		$bulan_angka = date('n', $timestamp);
		$tahun = date('Y', $timestamp);

		return $hari . ' ' . $bulan[$bulan_angka] . ' ' . $tahun;
	}
}

if (!function_exists('format_periode_cuti')) {

	function format_periode_cuti($tgl_mulai, $tgl_selesai)
	{
		if (empty($tgl_mulai) || empty($tgl_selesai)) {
			return '-';
		}

		$bulan = [
			1  => 'Jan',
			2  => 'Feb',
			3  => 'Mar',
			4  => 'Apr',
			5  => 'Mei',
			6  => 'Jun',
			7  => 'Jul',
			8  => 'Agu',
			9  => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Des'
		];

		$start = strtotime($tgl_mulai);
		$end   = strtotime($tgl_selesai);

		$d1 = date('d', $start);
		$m1 = date('n', $start);
		$y1 = date('Y', $start);

		$d2 = date('d', $end);
		$m2 = date('n', $end);
		$y2 = date('Y', $end);

		// Kalau 1 hari
		if ($start == $end) {
			return $d1 . ' ' . $bulan[$m1] . ' ' . $y1;
		}

		// Kalau 1 bulan & 1 tahun
		if ($m1 == $m2 && $y1 == $y2) {
			return $d1 . '-' . $d2 . ' ' . $bulan[$m1] . ' ' . $y1;
		}

		// Kalau beda bulan tapi 1 tahun
		if ($y1 == $y2) {
			return $d1 . ' ' . $bulan[$m1] . ' - ' .
				$d2 . ' ' . $bulan[$m2] . ' ' . $y1;
		}

		// Kalau beda tahun
		return $d1 . ' ' . $bulan[$m1] . ' ' . $y1 . ' - ' .
			$d2 . ' ' . $bulan[$m2] . ' ' . $y2;
	}
}



function dateIndo()
{
	// Ambil waktu server terkini, ambil tanggal dan jam untuk zona indonesia
	$dat_server = mktime(date("G"), date("i"), date("s"), date("n"), date("j"), date("Y"));
	//echo 'Waktu server: '.date("H:i:s", $dat_server);
	// Ambil perbedaan waktu server dengan GMT
	$diff_gmt = substr(date("O", $dat_server), 1, 2);
	// karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
	$datdif_gmt = 60 * 60 * $diff_gmt;
	// Hitung perbedaannya
	if (substr(date("O", $dat_server), 0, 1) == '+') {
		$dat_gmt = $dat_server - $datdif_gmt;
	} else {
		$dat_gmt = $dat_server + $datdif_gmt;
	}
	// Hitung perbedaan GMT dengan waktu Indonesia (GMT+7)
	// karena perbedaan waktu adalah dalam jam, maka kita jadikan detik
	$datdif_id = 60 * 60 * 7;
	$dat_id = $dat_gmt + $datdif_id;
	//echo 'Waktu Indonesia: '.date("H:i:s", $dat_id);
	$date = date("Y-m-d H:i:s", $dat_id);
	return $date;
}


function calculateMinutesDifference($jam_mulai, $jam_selesai)
{
	// Membuat objek DateTime dari string

	//tanggal dummy utk menghitung seilih waktu dalam waktu 1 hari
	$tgl = '2024-01-01';
	$start_date = $tgl . ' ' . $jam_mulai;
	$end_date = $tgl . ' ' . $jam_selesai;


	$start = new DateTime($start_date);
	$end = new DateTime($end_date);

	// Menghitung selisih antara dua tanggal
	$interval = $start->diff($end);

	// Mengonversi selisih waktu menjadi menit
	$total_minutes = ($interval->y * 525600) + // 1 tahun = 525600 menit
		($interval->m * 43800) +  // 1 bulan = 43800 menit (rata-rata)
		($interval->d * 1440) +   // 1 hari = 1440 menit
		($interval->h * 60) +     // 1 jam = 60 menit
		$interval->i;             // menit

	return $total_minutes;
}


if (!function_exists('gotoEncript')) {
	function gotoEncript($str)
	{
		return str_replace('=', 'equal', str_replace('+', 'plus', base64_encode($str)));
	}
}
if (!function_exists('gotoDecript')) {
	function gotoDecript($str)
	{
		$decript = $str;
		$decript = str_replace('plus', '+', $decript);
		$decript = str_replace('equal', '=', $decript);
		$decript = base64_decode($decript);
		return $decript;
	}
}
function isWeekend($date)
{
	return (date('N', strtotime($date)) >= 6);
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
