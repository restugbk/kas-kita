<?php
session_start();
require("../lib/config.php");
$self = "password";

    if (isset($_SESSION['user'])) {
        $sesi_user = $_SESSION['user']['username'];
        $cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
        $data_user = mysqli_fetch_assoc($cek_user);
        if (mysqli_num_rows($cek_user) == 0) {
            header("Location: ".$config['url']."auth/logout");
        }
        
        if (isset($_POST['save'])) {
            $post_password = $db->real_escape_string(trim(filter($_POST['password'])));
            $post_npassword = $db->real_escape_string(trim(filter($_POST['npassword'])));
            $post_cnpassword = $db->real_escape_string(trim(filter($_POST['cnpassword'])));
            
			$hash_password = password_hash($post_cnpassword, PASSWORD_DEFAULT);
		    $verif_pass = password_verify($post_password, $data_user['password']);
		    
    		if (empty($post_password) || empty($post_npassword) || empty($post_cnpassword)) {
    			$msg_type = "error";
    			$msg_content = "Mohon mengisi semua input.";
    		} else if (strlen($post_npassword) < 5) {
    			$msg_type = "error";
    			$msg_content = "Password baru telalu pendek, minimal 6 karakter.";
    		} else if ($post_cnpassword <> $post_npassword) {
    			$msg_type = "error";
    			$msg_content = "Konfirmasi password baru tidak sesuai.";
    		} else if ($verif_pass <> $data_user['password']) {
				$msg_type = "error";
				$msg_content = 'Password yang anda masukkan salah.';
			} else {
                $pesan = "User $sesi_user telah melakukan aktifitas perubahan password.";
                $insert_user = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$sesi_user', '$ip', '$browser', '$os', '$pesan', 'Ubah Password', '$date', '$time')");
    			$update_user = mysqli_query($db, "UPDATE users SET password = '$hash_password', updated_at = '$date & $time' WHERE username = '$sesi_user'");
    			if ($update_user == TRUE) {
    				$msg_type = "success";
    				$msg_content = "Password anda berhasil diubah.";
    			} else {
    				$msg_type = "error";
					$msg_content = "System error.";
    			}
    		}
        }
    
include("../lib/header.php");
?>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#">Settings</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid mt--6">
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Ubah Password</h3>
                        </div>
                        
                        <form role="form" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Password Lama</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password Baru</label>
                                    <input type="password" name="npassword" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Konfirmasi Password Baru</label>
                                    <input type="password" name="cnpassword" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary" name="save">Save Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
<?php
include("../lib/footer.php");
} else {
    header('location:auth/login');
}
?>