<?php
session_start();
require("../lib/config.php");

if (isset($_SESSION['user'])) {
	$sesi_user = $_SESSION['user']['username'];
	$cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
	$data_user = mysqli_fetch_assoc($cek_user);
	
	if (session_destroy() == TRUE) {
    $pesan = "User $sesi_user telah logout";
    $type = "User Logout";
    $insert_user = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$sesi_user', '$ip', '$browser', '$os', '$pesan', '$type', '$date', '$time')");
    header("Location: ".$config['url']."");
    } else {
        header("Location: ".$config['url']."");
    }
} else {
    session_destroy();
    header("Location: ".$config['url']."");
}

?>