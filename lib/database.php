<?php
define('DB_SERVER', $config['host']);
define('DB_USERNAME', $config['user']);
define('DB_PASSWORD', $config['pass']);
define('DB_DATABASE', $config['name']);
$db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

if (mysqli_connect_error()) {
	die("Database tidak ditemukan!");
}