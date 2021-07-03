<?php
session_start();
require("../../lib/config.php");
$self = "pengeluaran";

    if (isset($_SESSION['user'])) {
        $sesi_user = $_SESSION['user']['username'];
        $cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
        $data_user = mysqli_fetch_assoc($cek_user);
        if (mysqli_num_rows($cek_user) == 0) {
            header("Location: ".$config['url']."auth/logout");
        }
        
        if (isset($_POST['add'])) {
            $post_nominal = str_replace(".", "", $db->real_escape_string(filter($_POST['nominal'])));
            $post_ket = $db->real_escape_string(filter($_POST['ket']));
    
			if (empty($post_nominal) || empty($post_ket)) {
				$msg_type = "error";
				$msg_content = "Semua field tidak boleh kosong.";
			} else {
			    $pesan = "User $sesi_user telah menambah data pengeluaran sebesar Rp ".number_format($post_nominal,0,',','.');
                $insert_data = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$sesi_user', '$ip', '$browser', '$os', '$pesan', 'Uang Keluar', '$date', '$time')");
				$insert_data = mysqli_query($db, "INSERT INTO data_kas (user, ket, type, nominal, created_at) VALUES ('$sesi_user', '$post_ket', 'Kredit', '$post_nominal', '$date $time')");
				if ($insert_data == TRUE) {
					$msg_type = "success";
					$msg_content = "Data berhasil ditambah.";
				} else {
					$msg_type = "error";
					$msg_content = "System error.";
				}
			}
		} else if (isset($_POST['edit'])) {
			$post_id = dec_id($db->real_escape_string($_POST['id']));
            $post_nominal = str_replace(".", "", $db->real_escape_string(filter($_POST['nominal'])));
            $post_ket = $db->real_escape_string(filter($_POST['ket']));
            $cek_id = mysqli_query($db, "SELECT * FROM data_kas WHERE id = '$post_id'");
	        $data_id = mysqli_fetch_assoc($cek_id);
			
			if (empty($post_id) || empty($post_nominal) || empty($post_ket)) {
				$msg_type = "error";
				$msg_content = "Semua field tidak boleh kosong.";
			} else {
                $pesan = "User $sesi_user telah mengubah data pengeluaran id ".$post_id;
                $update_data = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$sesi_user', '$ip', '$browser', '$os', '$pesan', 'Edit Uang Keluar', '$date', '$time')");
				$update_data = mysqli_query($db, "UPDATE data_kas SET nominal = '$post_nominal', ket = '$post_ket', updated_at = '$date $time' WHERE id = '$post_id'");
				if ($update_data == TRUE) {
					$msg_type = "success";
					$msg_content = "Data berhasil diupdate.";
				} else {
					$msg_type = "error";
					$msg_content = "System error.";
				}
			}
		} else if (isset($_POST['delete'])) {
			$post_id = dec_id($db->real_escape_string($_POST['id']));
			$cek_id = mysqli_query($db, "SELECT * FROM data_kas WHERE id = '$post_id'");
	        $data_id = mysqli_fetch_assoc($cek_id);
            
			if (mysqli_num_rows($cek_id) == 0) {
				$msg_type = "error";
				$msg_content = "Data tidak ditemukan.";
			} else {
                $pesan = "User $sesi_user telah mendelete data pengeluaran id ".$post_id;
                $insert_data = mysqli_query($db, "INSERT INTO logs (user, ip, browser, os, note, type, date, time) VALUES ('$sesi_user', '$ip', '$browser', '$os', '$pesan', 'Edit Uang Keluar', '$date', '$time')");
				$delete_data = mysqli_query($db, "DELETE FROM data_kas WHERE id = '$post_id'");
				if ($delete_data == TRUE) {
					$msg_type = "success";
					$msg_content = "Data berhasil dihapus.";
				} else {
					$msg_type = "error";
					$msg_content = "System error.";
				}
			}
        }
        
        // Count Kas Pengeluaran
        $cek_pengeluaran = mysqli_query($db, "SELECT SUM(nominal) AS total FROM data_kas WHERE type = 'Kredit'");
        $count_pengeluaran = mysqli_fetch_assoc($cek_pengeluaran)['total'];
    
include("../../lib/header.php");
?>
        <div class="header bg-primary pb-6">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="#">Pengeluaran Kas</a></li>
                                </ol>
                            </nav>
                        </div>
                        
                        <div class="col-lg-6 col-5 text-right">
                            <button type="button" class="btn btn-md btn-neutral" data-toggle="modal" data-target="#addModal">Tambah Data</button>
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
                            <h3 class="mb-0">Pengeluaran Kas</h3>
                        </div>
                        
                        <div class="card-body">
                            
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="fas fa-money-bill-wave"></i></span>
                                <span class="alert-text"><strong>Total Kas Keluar :</strong><br>Rp <?php echo number_format($count_pengeluaran,0,',','.'); ?>,-</span>
                            </div>
                            
                            <div class="table-responsive py-4">
                                <table class="table table-flush" id="datatable">
                                    <thead class="thead-light">
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>User</b></th>
                                            <th><b>Jumlah</b></th>
                                            <th><b>Keterangan</b></th>
                                            <th><b>Datetime</b></th>
                                            <th><b>Action</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 0;
            							$cek_data = mysqli_query($db, "SELECT * FROM data_kas WHERE type = 'Kredit' ORDER BY id ASC");
            							while ($data_show = mysqli_fetch_assoc($cek_data)) {
            							$no++;
            							?>
                                        <tr>
                                            <td><?php echo $no; ?></td>
                                            <td><?php echo $data_show['user']; ?></td>
                                            <td><?php echo number_format($data_show['nominal'],0,',','.'); ?>,-</td>
                                            <td><?php if(strlen($data_show['ket']) > 50) { echo substr(nl2br($data_show['ket']), 0, 50)."..."; } else { echo nl2br($data_show['ket']); } ?></td>
                                            <td><?php echo replaceDate($data_show['created_at']); ?></td>
                                            <td>
                                                <a href="javascript:;" onclick="modal('<?php echo $config['url']; ?>ajax/pengeluaran/view?id=<?php echo enc_id($data_show['id']); ?>')" class="btn btn-sm btn-info"><i class="fa fa-eye" title="View"></i></a>
                                                <a href="javascript:;" onclick="modal('<?php echo $config['url']; ?>ajax/pengeluaran/edit?id=<?php echo enc_id($data_show['id']); ?>')" class="btn btn-sm btn-primary"><i class="fa fa-edit" title="Edit"></i></a>
                                                <a href="javascript:;" onclick="modal('<?php echo $config['url']; ?>ajax/pengeluaran/delete?id=<?php echo enc_id($data_show['id']); ?>')" class="btn btn-sm btn-danger"><i class="fa fa-trash" title="Hapus"></i></a>
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
        
        <!-- Modal Tambah Data -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalTitle">Tambah Pengeluaran Kas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form role="form" method="POST">
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="form-control-label">Jumlah</label>
                                <input type="text" class="form-control" name="nominal" placeholder="Masukkan jumlah" inputmode="numeric" onkeyup="toRp(this);" onkeypress="return numberOnly(event)" required autofocus>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Keterangan</label>
                                <textarea class="form-control" rows="10" name="ket" placeholder="Keterangan" required></textarea>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" name="add">Tambah</button>
                        </div>
                    </form>
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
include("../../lib/footer.php");
} else {
    header('location:auth/login');
}
?>