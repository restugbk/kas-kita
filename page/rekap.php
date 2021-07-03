<?php
session_start();
require("../lib/config.php");
$self = "rekap";

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
                                    <li class="breadcrumb-item"><a href="#">Rekapitulasi</a></li>
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
                            <h3 class="mb-0">Rekapitulasi Dana</h3>
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <span class="alert-icon"><i class="fas fa-money-bill-wave"></i></span>
                                        <span class="alert-text"><strong>Total Kas Masuk :</strong><br>Rp <?php echo number_format($count_pemasukan,0,',','.'); ?>,-</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <span class="alert-icon"><i class="fas fa-money-bill-wave"></i></span>
                                        <span class="alert-text"><strong>Total Kas Keluar :</strong><br>Rp <?php echo number_format($count_pengeluaran,0,',','.'); ?>,-</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                        <span class="alert-icon"><i class="fas fa-money-bill-wave"></i></span>
                                        <span class="alert-text"><strong>Total Saldo Akhir :</strong><br>Rp <?php echo number_format($sisa_saldo,0,',','.'); ?>,-</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>User</b></th>
                                            <th><b>Jenis</b></th>
                                            <th><b>Uang Masuk</b></th>
                                            <th><b>Uang Keluar</b></th>
                                            <th><b>Ket</b></th>
                                            <th><b>Datetime</b></th>
                                            <th><b>Detail</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
            							$cek_data = mysqli_query($db, "SELECT * FROM data_kas ORDER BY id ASC");
            							while ($data_show = mysqli_fetch_assoc($cek_data)) {
            							$no++;
            							?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $data_show['user']; ?></td>
                                            <td><?php echo $data_show['type']; ?></td>
                                            <td><?php if($data_show['type'] == "Debit") { echo number_format($data_show['nominal'],0,',','.').",-"; } else { echo "0,-"; }?></td>
                                            <td><?php if($data_show['type'] == "Kredit") { echo number_format($data_show['nominal'],0,',','.').",-"; } else { echo "0,-"; }?></td>
                                            <td><?php if(strlen($data_show['ket']) > 25) { echo substr(nl2br($data_show['ket']), 0, 25)."..."; } else { echo nl2br($data_show['ket']); } ?></td>
                                            <td><?php echo replaceDateTime($data_show['created_at']); ?></td>
                                            <td>
                                                <a href="javascript:;" onclick="modal('<?php echo $config['url']; ?>ajax/rekap/view?id=<?php echo enc_id($data_show['id']); ?>')" class="btn btn-sm btn-info"><i class="fa fa-eye" title="View"></i></a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Start Modal Crud -->
        <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="detail-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detail-title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="detail-body">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal Crud -->
    	
    	<script type="text/javascript">
            function modal(url) {
                $.ajax({
                    type: "GET",
                    url: url,
                    beforeSend: function() {
                        $('#detail-body').html('<center><i class="fa fa-spinner fa-3x faa-spin animated"></i><br><small>Mohon menunggu...</small></center>');
                    },
                    success: function(result) {
                        $('#detail-body').html(result);
                        var e = document.getElementById('getTitle');
                        var title = e.getAttribute('title-modal');
                        $('#detail-title').text(title);
                    },
                    error: function() {
                        $('#detail-body').html('Terjadi kesalahan.');
                    }
                });
                $('#detail-modal').modal();
            }
        </script>
<?php
include("../lib/footer.php");
} else {
    header('location:auth/login');
}
?>