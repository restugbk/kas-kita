<?php
session_start();
require("lib/config.php");
$self = "dashboard";

    if (isset($_SESSION['user'])) {
        $sesi_user = $_SESSION['user']['username'];
        $cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
        $data_user = mysqli_fetch_assoc($cek_user);
        if (mysqli_num_rows($cek_user) == 0) {
            header("Location: ".$config['url']."auth/logout");
        }
        
        // Count Kas Pemasukan
        $cek_pemasukan = mysqli_query($db, "SELECT SUM(nominal) AS total FROM data_kas WHERE type = 'Debit'");
        $count_pemasukan = mysqli_fetch_assoc($cek_pemasukan)['total'];
        
        // Count Kas Pengeluaran
        $cek_pengeluaran = mysqli_query($db, "SELECT SUM(nominal) AS total FROM data_kas WHERE type = 'Kredit'");
        $count_pengeluaran = mysqli_fetch_assoc($cek_pengeluaran)['total'];
        
        // Count Sisa Saldo
        $sisa_saldo = $count_pemasukan - $count_pengeluaran;
    
include("lib/header.php");
?>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Dashboard</a></li>
                                </ol>
                            </nav>
                        </div>
                        
                        <div class="col-lg-6 col-5 text-right d-none d-md-block">
                            <button type="button" class="btn btn-neutral"><i class="ni ni-calendar-grid-58" style="position: relative;top: 1px;"></i> &nbsp;<?php echo replaceDate(date('d-M-Y')); ?></button>
                            <button type="button" class="btn btn-neutral"><i class="ni ni-time-alarm" style="position: relative;top: 1px;"></i><span id="jam"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container-fluid">
                <div class="header-body">
                    
                    <div class="row">
                        
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Pemasukan</h5>
                                            <span class="h2 font-weight-bold mb-0">Rp <?php echo number_format($count_pemasukan,0,',','.'); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                                <i class="ni ni-chart-bar-32"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Pengeluaran</h5>
                                            <span class="h2 font-weight-bold mb-0">Rp <?php echo number_format($count_pengeluaran,0,',','.'); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
                                                <i class="ni ni-books"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card card-stats">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <h5 class="card-title text-uppercase text-muted mb-0">Sisa Saldo</h5>
                                            <span class="h2 font-weight-bold mb-0">Rp <?php echo number_format($sisa_saldo,0,',','.'); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
                                                <i class="ni ni-money-coins"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="mt-3 mb-0 text-sm">
                                        <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                                        <span class="text-nowrap">Since last month</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid mt--6">
            
            <div class="row card-wrapper">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Catatan Penggunaan</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <dl>
                                <dt>Fungsi</dt>
                                <dd>
                                    Aplikasi ini memiliki beberpa fungsi, antara lain:
                                    <ol>
                                        <li>Form Login & Register</li>
                                        <li>Input Data Pemasukan & Pengeluaran Dana</li>
                                        <li>List Data Pemasukan dan Pengeluaran Dana</li>
                                        <li>Rekapitulasi Dana</li>
                                        <li>Ubah Profile</li>
                                        <li>Ubah Foto Profile</li>
                                    </ol>
                                </dd>
                                <dd>
                                    <dt>Version</dt>
                                    <ol>
                                        <li><?php echo $config['webname']; ?> v1.0.0</li>
                                        <li>PHP V.7.x</li>
                                        <li>Theme By: Argon Dashboard - v1.2.0</li>
                                    </ol>
                                    Info lebih lanjut mengenai aplikasi:
                                    <ul>
                                        <li>WhatsApp : <a href="https://api.whatsapp.com/send?phone=6285281822916" target="blank">0852-8182-2916</a></li>
                                        <li>Email : <a href="mailto:gamalrestu@gmail.com">gamalrestu@gmail.com</a></li>
                                    </ul>
                                </dd>
                            </dl>
                        </div>
                        <div class="card-footer">
                            <p style="text-align: center;font-weight: bold;r">~<i> Created by Restu Fadhilah</i><i class="fa fa-smile-o"></i>  ~</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="mb-0">Catatan Aktivitas</h3>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">User</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Datetime</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
        							$cek_data = mysqli_query($db, "SELECT * FROM logs WHERE user = '$sesi_user' ORDER BY id DESC LIMIT 5");
        							while ($data_show = mysqli_fetch_assoc($cek_data)) {
        							?>
                                    <tr>
                                        <td><?php echo ucfirst($data_show['user']); ?></td>
                                        <td><?php echo $data_show['type']; ?></td>
                                        <td><?php echo replaceDate($data_show['created_at']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
<?php
include("lib/footer.php");
} else {
    header('location:auth/login');
}
?>