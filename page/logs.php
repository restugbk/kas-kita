<?php
session_start();
require("../lib/config.php");
$self = "logs";

    if (isset($_SESSION['user'])) {
        $sesi_user = $_SESSION['user']['username'];
        $cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
        $data_user = mysqli_fetch_assoc($cek_user);
        if (mysqli_num_rows($cek_user) == 0) {
            header("Location: ".$config['url']."auth/logout");
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
                                    <li class="breadcrumb-item"><a href="#">Logs</a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid mt--6">
            
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="mb-0">Catatan Aktivitas</h3>
                        </div>
                        
                        <div class="table-responsive py-4">
                            <table class="table table-flush" id="datatable">
                                <thead class="thead-light">
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>User</b></th>
                                        <th><b>IP</b></th>
                                        <th><b>Browser</b></th>
                                        <th><b>OS</b></th>
                                        <th><b>Note</b></th>
                                        <th><b>Datetime</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 0;
        							$cek_data = mysqli_query($db, "SELECT * FROM logs ORDER BY id DESC");
        							while ($data_show = mysqli_fetch_assoc($cek_data)) {
        							$no++;
        							?>
                                    <tr>
                                        <td><?php echo $no; ?></td>
                                        <td><?php echo $data_show['user']; ?></td>
                                        <td><?php echo $data_show['ip']; ?></td>
                                        <td><?php echo $data_show['browser']; ?></td>
                                        <td><?php echo $data_show['os']; ?></td>
                                        <td><?php echo $data_show['note']; ?></td>
                                        <td><?php echo replaceDate($data_show['date']); ?> <?php echo $data_show['time']; ?></td>
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
include("../lib/footer.php");
} else {
    header('location:auth/login');
}
?>