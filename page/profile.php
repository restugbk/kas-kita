<?php
session_start();
require("../lib/config.php");
$self = "profile";

    if (isset($_SESSION['user'])) {
        $sesi_user = $_SESSION['user']['username'];
        $cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
        $data_user = mysqli_fetch_assoc($cek_user);
        if (mysqli_num_rows($cek_user) == 0) {
            header("Location: ".$config['url']."auth/logout");
        }
        
        if (isset($_POST['save'])) {
            $post_nama = $db->real_escape_string(filter($_POST['nama']));
            $post_hp = $db->real_escape_string(filter($_POST['hp']));
            $post_bio = $db->real_escape_string(filter($_POST['bio']));
            
    	    $nama_file = $_FILES['gambar']['name'];
    	    $source = $_FILES['gambar']['tmp_name'];
    	    $folder = '../assets/img/photo/';
    	    $size = $_FILES['gambar'] ['size'];
    	    $valid = array('jpg','png','jpeg');
    	    $temp = explode(".", $nama_file);
    	    $nama_baru = round(microtime(true)) . '.' . end($temp);
    	    $ext = strtolower(end($temp));
    	    
    	    $cek_hp = mysqli_query($db, "SELECT * FROM users WHERE hp = '$post_hp'");
    	    
    	    if (empty($post_nama) || empty($post_hp)) {
    			$msg_type = "error";
    			$msg_content = "Semua field tidak boleh kosong.";
    		} else if ($post_hp != $data_user['hp'] AND mysqli_num_rows($cek_hp) > 0) {
    		    $msg_type = "error";
    		    $msg_content = "No HP $post_hp sudah terdaftar dalam database.";
		    } else if (strlen($size) > 1024 * 512) {
    		    $msg_type = "error";
    		    $msg_content = "Ukuran Gambar Terlalu Besar, Max 500KB.";
    	    } else {
    	        
    	        if($nama_baru != null) {
    	            if(in_array($ext, $valid) === true){
    	                move_uploaded_file($source, $folder.$nama_baru);
                        $insert_user = mysqli_query($db, "UPDATE users SET photo = '$nama_baru' WHERE username = '$sesi_user'");
    	            } else {
                        $imgValid = "error";
                    }
    	        }
    	        
    	        if($imgValid == "error") {
    	            $msg_type = "error";
    	            $msg_content = "Ekstensi Tidak Diperbolehkan!";
    	        } else {
    	            $pesan = "User $sesi_user telah melakukan aktifitas perubahan data profile.";
                    $insert_user = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$sesi_user', '$ip', '$browser', '$os', '$pesan', 'Ubah Profile', '$date', '$time')");
                    $insert_user = mysqli_query($db, "UPDATE users SET nama = '$post_nama', hp = '$post_hp', bio = '$post_bio', updated_at = '$date $time' WHERE username = '$sesi_user'");
                    if ($insert_user == TRUE) {
            			$msg_type = "success";
            			$msg_content = "Data berhasil diubah.";
            		} else {
            			$msg_type = "error";
            			$msg_content = "System error.";
            		}
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
                                    <li class="breadcrumb-item"><a href="#">Profile</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid mt--6">
            
            <div class="row">
                <div class="col-xl-4 order-xl-2">
                    <div class="card card-profile">
                        <img src="<?php echo $config['url']; ?>assets/img/theme/img-1-1000x600.jpg" alt="Profile" class="card-img-top">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="<?php echo $config['url']; ?>assets/img/photo/<?php echo $data_user['photo']; ?>" height="140" width="200" class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div>
                        
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center">
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <h5 class="h3">
                                    <?php echo $data_user['nama']; ?>
                                </h5>
                                
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i><?php echo $data_user['level']; ?>
                                </div>
                                
                                <div class="h5 mt-4">
                                    <i class="ni business_briefcase-24 mr-2"></i>No HP : <?php echo hp($data_user['hp']); ?>
                                </div>
                                
                                <div>
                                    <i class="ni education_hat mr-2"></i><?php echo $data_user['bio']; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p style="text-align: center;font-weight: bold;r">~<i> Created by Restu Fadhilah</i><i class="fa fa-smile-o"></i>  ~</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Profile User</h3>
                        </div>
                        
                        <form role="form" method="POST" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-control-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" value="<?php echo $data_user['nama']; ?>" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">No HP</label>
                                    <input type="text" class="form-control" name="hp" placeholder="No HP" value="<?php echo $data_user['hp']; ?>" maxlength="13" inputmode="numeric" onkeypress="return numberOnly(event)" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Biodata</label>
                                    <textarea class="form-control" rows="10" name="bio" placeholder="Biodata"><?php echo $data_user['bio']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Change Photo</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="gambar" id="customFile" accept="image/*" onchange="viewPhoto(this,'preview')" lang="en">
                                        <label class="custom-file-label" for="customFile"></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div align="center">
                                        <img id="preview" width="300px"/>
                                    </div>
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
        <?php if($msg_type == "success"){ ?>
        <script>
            Swal.fire({
              title: 'Success!',
              text: '<?php echo $msg_content; ?>',
              icon: 'success',
              confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "<?php echo $config['url']; ?>page/profile";
                }
            })
        </script>
        <?php } else if($msg_type == "error"){ ?>
        <script>
            Swal.fire({
              title: 'Failed!',
              text: '<?php echo $msg_content; ?>',
              icon: 'error',
              confirmButtonText: 'OK'
            })
        </script>
        <?php } ?>
<?php
include("../lib/footer.php");
} else {
    header('location:auth/login');
}
?>