<?php
session_start();
require ("../../lib/config.php");

    if (isset($_SESSION['user'])) {
        $sesi_user = $_SESSION['user']['username'];
        $cek_user = mysqli_query($db, "SELECT * FROM users WHERE username = '$sesi_user'");
        $data_user = mysqli_fetch_assoc($cek_user);
        if (mysqli_num_rows($cek_user) == 0) {
            header("Location: ".$config['url']."auth/logout");
        }

        if (isset($_GET['id'])) {
			$post_id = dec_id($db->real_escape_string(filter($_GET['id'])));
			$cek_id = mysqli_query($db, "SELECT * FROM data_kas WHERE id = '$post_id'");
			$db_id = mysqli_fetch_assoc($cek_id);
			if (mysqli_num_rows($cek_id) == 0) {
				header("Location: ".$config['url']."page/pengeluaran");
			}
?>
        <span id="getTitle" title-modal="Edit Pengeluaran Kas"></span>
        <form role="form" method="POST">
			<input type="hidden" name="id" class="form-control" value="<?php echo enc_id($db_id['id']); ?>" readonly>
            <div class="form-group">
                <label class="form-control-label">Jumlah</label>
                <input type="text" class="form-control" name="nominal" placeholder="Masukkan jumlah" inputmode="numeric" onkeyup="toRp(this);" onkeypress="return numberOnly(event)" value="<?php echo number_format($db_id['nominal'],0,',','.'); ?>" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-control-label">Keterangan</label>
                <textarea class="form-control" rows="10" name="ket" placeholder="Keterangan"><?php echo $db_id['ket']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="edit">Edit Data</button>
        </form>
<?php
} else {
    header("Location: ".$config['url']."page/pengeluaran");
}
} else {
    header("Location: ".$config['url']."auth/login");
}
?>