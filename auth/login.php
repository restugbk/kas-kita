<?php
session_start();
require("../lib/config.php");

    if (isset($_POST['login'])) {
        $post_username = $db->real_escape_string(trim(filter($_POST['username'])));
        $post_password = $db->real_escape_string(trim(filter($_POST['password'])));
        
        if (empty($post_username) || empty($post_password)) {
            $msg_type = "error";
            $msg_content = "Username dan Passowrd tidak boleh kosong.";
        } else {
            $cek_username = mysqli_query($db, "SELECT * FROM users WHERE username = '$post_username'");
            $data_username = mysqli_fetch_assoc($cek_username);
            
            if (mysqli_num_rows($cek_username) == 0) {
                $msg_type = "error";
                $msg_content = "Username yang anda masukkan salah.";
            } else {
                $verif_pass = password_verify($post_password, $data_username['password']);
                
                if ($verif_pass <> $data_username['password']) {
                    $msg_type = "error";
                    $msg_content = "Password yang anda masukkan salah.";
                } else {
                    $pesan = "User $post_username telah login";
                    $type = "User Login";
                    $insert_user = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$post_username', '$ip', '$browser', '$os', '$pesan', '$type', '$date', '$time')");
                    if ($insert_user == TRUE) {
                        $_SESSION['user'] = $data_username;
                        header("Location: ".$config['url']);
                    } else {
                        $msg_type = "error";
                        $msg_content = "System error.";
                    }
                }
            }
        }
    }
    
    if (isset($_SESSION['user'])) {
        header("Location: ".$config['url']."");
    }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $config['webdesc']; ?>">
  <meta name="author" content="Restu Fadhilah">
  <title>Halaman Login | <?php echo $config['webname']; ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?php echo $config['url']; ?>assets/img/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/css/argon.css?v=1.2.0" type="text/css">
  <!-- Sweet Alert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-default">
    
    <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <h2 class="text-white"><i class="ni ni-diamond"></i> <?php echo strtoupper($config['webname']); ?></h2>
            </a>
        </div>
    </nav>
    
    <div class="main-content">
        <div class="header bg-gradient-primary py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-5">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <h1 class="text-white">Welcome to <?php echo $config['webname']; ?>!</h1>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        
        <div class="container mt--8 pb-5">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-header bg-transparent pb-5">
                            <div class="text-muted text-center mt-2"><h3>Silahkan Login</h3></div>
                        </div>
                        
                        <div class="card-body px-lg-5 py-lg-5">
                            
                            <form role="form" method="POST">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="username" placeholder="Username" id="uspace" autocomplete="off" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                        </div>
                                        <input type="password" class="form-control" name="password" placeholder="Password" id="pspace" autocomplete="off" required>
                                    </div>
                                </div>
                                
                                <div class="text-center">
                                    <a href="register" class="btn btn-success my-4">Register</a>
                                    <button type="submit" class="btn btn-primary my-4" name="login">Login</button>
                                </div>
                            </form>
                            
                        </div>
                        
                        <div class="card-footer">
                            <p style="text-align: center;font-weight: bold;r">~<i> Created by Restu Fadhilah</i><i class="fa fa-smile-o"></i>  ~</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="py-5" id="footer-main">
        <div class="container"></div>
    </footer>
    
    <!-- Component JS -->
    <script src="<?php echo $config['url']; ?>assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/js/argon.js?v=1.2.0"></script>
    <?php if($msg_type == "error"){ ?>
    <script>
        Swal.fire({
          title: 'Failed!',
          text: '<?php echo $msg_content; ?>',
          icon: 'error',
          confirmButtonText: 'OK'
        })
    </script>
    <?php } ?>
</body>
</html>