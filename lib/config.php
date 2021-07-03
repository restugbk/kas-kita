<?php
date_default_timezone_set('Asia/Jakarta');
error_reporting(0);

$cfg_mt = 0; // Maintenance? 1 = ya 0 = tidak
if($cfg_mt == 1) {
    die('Site Maintenance');
}

// Config Website
$config['url'] = "https://localhost/"; // Link website kamu
$config['webname'] = "Kas Kita";
$config['webdesc'] = "Ini adalah aplikasi kas berbasis website yang dibuat oleh restu fadhilah";

// Config Database
$config['host'] = "localhost"; // Host Database
$config['user'] = "root"; // User Database
$config['pass'] = ""; // Password Database
$config['name'] = "kaskita"; // Nama Database

// Date & Time
$date = date("d-m-Y");
$time = date("H:i:s");

// Require File
require("database.php");
require("function.php");