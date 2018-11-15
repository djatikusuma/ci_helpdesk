<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Fungsi untuk menghasilkan hash password
 * @param   [string]    $pass
 * @param   [int]       jumlah panjang hashing
 * @return  [string]    teks enkripsi
 * @author Rangga Djatikusuma Lukman
 */
function bCrypt($pass,$cost){
        $chars='./ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $salt=sprintf('$2a$%02d$',$cost);
        mt_srand();
        for($i=0;$i<22;$i++) $salt.=$chars[mt_rand(0,63)];

        return crypt($pass,$salt);
}

function rupiah($number = 0)
{
        $hasil_rupiah = "Rp. " . number_format($number,0,',','.');
	return $hasil_rupiah;
}

function uc_words($string){
        $text = strtolower($string);
        return ucwords($text);
}

function printData($data)
{
        echo "<pre>";
        print_r($data);
        echo "</pre>";
}

if(!function_exists('tanggal_indo')) {
        function tanggal_indo ($timestamp = '', $date_format = 'l, j F Y, H:i', $suffix = 'WIB') {
          if (trim ($timestamp) == '')
          {
                  $timestamp = time ();
          }
          elseif (!ctype_digit ($timestamp))
          {
              $timestamp = strtotime ($timestamp);
          }
          # remove S (st,nd,rd,th) there are no such things in indonesia :p
          $date_format = preg_replace ("/S/", "", $date_format);
          $pattern = array (
              '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
              '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
              '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
              '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
              '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
              '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
              '/April/','/June/','/July/','/August/','/September/','/October/',
              '/November/','/December/',
          );
          $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
              'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
              'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
              'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
              'Oktober','November','Desember',
          );
          $date = date ($date_format, $timestamp);
          $date = preg_replace ($pattern, $replace, $date);
          $date = "{$date} {$suffix}";
          return $date;
        }
      }
      if(!function_exists('tanggalindo')) {
        function tanggalindo ($timestamp = '', $date_format = 'j F Y', $suffix = 'WIB') {
          if (trim ($timestamp) == '')
          {
                  $timestamp = time ();
          }
          elseif (!ctype_digit ($timestamp))
          {
              $timestamp = strtotime ($timestamp);
          }
          # remove S (st,nd,rd,th) there are no such things in indonesia :p
          $date_format = preg_replace ("/S/", "", $date_format);
          $pattern = array (
              '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
              '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
              '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
              '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
              '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
              '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
              '/April/','/June/','/July/','/August/','/September/','/October/',
              '/November/','/December/',
          );
          $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
              'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
              'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
              'Januari','Februari','Maret','April','Juni','Juli','Agustus','Sepember',
              'Oktober','November','Desember',
          );
          $date = date ($date_format, $timestamp);
          $date = preg_replace ($pattern, $replace, $date);
          $date = "{$date}";
          return $date;
        }
      }
?>