<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php echo $config['webdesc']; ?>">
  <meta name="author" content="Restu Fadhilah">
  <title>Halaman <?php echo ucfirst($self); ?> | <?php echo $config['webname']; ?></title>
  <!-- Favicon -->
  <link rel="icon" href="<?php echo $config['url']; ?>assets/img/favicon.png" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/nucleo/css/nucleo.css" type="text/css">
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
  <?php if($self == "pemasukan" || $self == "pengeluaran" || $self == "logs" || $self == "rekap"){ ?>
  <!-- Component CSS -->
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <?php } ?>
  <!-- Argon CSS -->
  <link rel="stylesheet" href="<?php echo $config['url']; ?>assets/css/argon.css?v=1.2.0" type="text/css">
  <!-- Sweet Alert -->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner">
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="/">
                    <h2><i class="ni ni-diamond"></i> <?php echo strtoupper($config['webname']); ?></h2>
                </a>
            </div>
            
            <div class="navbar-inner">
                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php if($self == "dashboard"){ ?>active<?php } ?>" href="/">
                                <i class="fa fa-home text-primary"></i>
                                <span class="nav-link-text">Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($self == "pemasukan"){ ?>active<?php } ?>" href="<?php echo $config['url']; ?>page/pemasukan">
                                <i class="ni ni-chart-bar-32 text-info"></i>
                                <span class="nav-link-text">Pemasukan</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($self == "pengeluaran"){ ?>active<?php } ?>" href="<?php echo $config['url']; ?>page/pengeluaran">
                                <i class="ni ni-books text-danger"></i>
                                <span class="nav-link-text">Pengeluaran</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($self == "rekap"){ ?>active<?php } ?>" href="<?php echo $config['url']; ?>page/rekap">
                                <i class="ni ni-book-bookmark text-purple"></i>
                                <span class="nav-link-text">Rekapitulasi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if($self == "logs"){ ?>active<?php } ?>" href="<?php echo $config['url']; ?>page/logs">
                                <i class="ni ni-calendar-grid-58 text-pink"></i>
                                <span class="nav-link-text">Logs</span>
                            </a>
                        </li>
                    </ul>
                    <hr class="my-3">
                    <ul class="navbar-nav mb-md-3">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $config['url']; ?>auth/logout">
                                <i class="fa fa-sign-out-alt text-danger"></i>
                                <span class="nav-link-text">Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    
    <div class="main-content" id="panel">
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav align-items-center  ml-md-auto ">
                        <li class="nav-item d-xl-none">
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        
                        <!--<li class="nav-item dropdown">-->
                        <!--    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
                        <!--        <i class="ni ni-bell-55"></i>-->
                        <!--    </a>-->
                            
                        <!--    <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">-->
                        <!--        <div class="px-3 py-3">-->
                        <!--            <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>-->
                        <!--        </div>-->
                                
                        <!--        <div class="list-group list-group-flush">-->
                        <!--            <a href="#!" class="list-group-item list-group-item-action">-->
                        <!--                <div class="row align-items-center">-->
                        <!--                    <div class="col-auto">-->
                        <!--                        <img alt="Image placeholder" src="<?php echo $config['url']; ?>assets/img/theme/team-1.jpg" class="avatar rounded-circle">-->
                        <!--                    </div>-->
                        <!--                <div class="col ml--2">-->
                        <!--                    <div class="d-flex justify-content-between align-items-center">-->
                        <!--                        <div>-->
                        <!--                            <h4 class="mb-0 text-sm">John Snow</h4>-->
                        <!--                        </div>-->
                        <!--                        <div class="text-right text-muted">-->
                        <!--                            <small>2 hrs ago</small>-->
                        <!--                        </div>-->
                        <!--                    </div>-->
                        <!--                    <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--        </a>-->
                        <!--    </div>-->
                        <!--    <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>-->
                        <!--    </div>-->
                        <!--</li>-->
                    </ul>
                    
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="Image placeholder" src="<?php echo $config['url']; ?>assets/img/photo/<?php echo $data_user['photo']; ?>">
                                    </span>
                                    
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold"><?php echo $data_user['nama']; ?></span>
                                    </div>
                                </div>
                            </a>
                            
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <a href="<?php echo $config['url']; ?>page/profile" class="dropdown-item">
                                    <i class="ni ni-single-02"></i>
                                    <span>Profile</span>
                                </a>
                                <a href="<?php echo $config['url']; ?>page/change-password" class="dropdown-item">
                                    <i class="ni ni-settings-gear-65"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="<?php echo $config['url']; ?>page/logs" class="dropdown-item">
                                    <i class="ni ni-calendar-grid-58"></i>
                                    <span>Activity</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo $config['url']; ?>auth/logout" class="dropdown-item">
                                    <i class="fa fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>