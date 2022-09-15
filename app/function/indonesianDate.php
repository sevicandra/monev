<?php
function indonesiaDate($val){
    $date = date_create($val);
    $tgl = date_format($date, "d");
    $bln = date_format($date, "m");
    $tahun = date_format($date, "Y");
    switch ($bln) {
        case '1':
            $bln = 'Januari';
            break;
        case '2':
            $bln = 'Februari';
            break;
        case '3':
            $bln = 'Maret';
            break;
        case '4':
            $bln = 'April';
            break;
        case '5':
            $bln = 'Mei';
            break;
        case '6':
            $bln = 'Juni';
            break;
        case '7':
            $bln = 'Juli';
            break;
        case '8':
            $bln = 'Agustus';
            break;
        case '9':
            $bln = 'September';
            break;
        case '10':
            $bln = 'Oktober';
            break;
        case '11':
            $bln = 'November';
            break;
        case '12':
            $bln = 'Desember';
            break;
    }
    $tanggal = $tgl  . ' ' . $bln . ' ' . $tahun;
    return $tanggal;
}
function indonesiaDay($val){
    $date = date_create($val);
    $hari = date_format($date, "l");

    switch ($hari) {
        case 'Sunday':
            $hari = 'Minggu';
            break;
        case 'Monday':
            $hari = 'Senin';
            break;
        case 'Tuesday':
            $hari = 'Selasa';
            break;
        case 'Wednesday':
            $hari = 'Rabu';
            break;
        case 'Thursday':
            $hari = 'Kamis';
            break;
        case 'Friday':
            $hari = 'Jumat';
            break;
        case 'Saturday':
            $hari = 'Sabtu';
            break;
    }
    return $hari;
}
function indonesiaMonth($val){
    $date = date_create($val);
    $bln = date_format($date, "m");
    switch ($bln) {
        case '1':
            $bln = 'Januari';
            break;
        case '2':
            $bln = 'Februari';
            break;
        case '3':
            $bln = 'Maret';
            break;
        case '4':
            $bln = 'April';
            break;
        case '5':
            $bln = 'Mei';
            break;
        case '6':
            $bln = 'Juni';
            break;
        case '7':
            $bln = 'Juli';
            break;
        case '8':
            $bln = 'Agustus';
            break;
        case '9':
            $bln = 'September';
            break;
        case '10':
            $bln = 'Oktober';
            break;
        case '11':
            $bln = 'November';
            break;
        case '12':
            $bln = 'Desember';
            break;
        }
    return $bln;
}
function indonesiaYear($val){
    $date = date_create($val);
    $tahun = date_format($date, "Y");
    return numberTowords($tahun);
}

function indonesiaDateWords($val){
    $date = date_create($val);
    $tgl = date_format($date, "d");
    return numberTowords($tgl);
}

function year($val){
    $date = date_create($val);
    $tahun = date_format($date, "Y");
    return $tahun;
}
?>
