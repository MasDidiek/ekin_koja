<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function timeAgo($datetime)
{
    if (!$datetime) return '-';

    $time = strtotime($datetime);
    $now  = time();
    $diff = $now - $time;

    if ($diff < 60) {
        return $diff . ' detik lalu';
    }

    $minutes = floor($diff / 60);
    if ($minutes < 60) {
        return $minutes . ' menit lalu';
    }

    $hours = floor($minutes / 60);
    if ($hours < 24) {
        return $hours . ' jam lalu';
    }

    $days = floor($hours / 24);
    if ($days < 30) {
        return $days . ' hari lalu';
    }

    $months = floor($days / 30);
    if ($months < 12) {
        return $months . ' bulan lalu';
    }

    $years = floor($months / 12);
    return $years . ' tahun lalu';
}


?>
