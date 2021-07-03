    <div class="container-fluid mt-3">
            <footer class="footer pt-0">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6">
                        <div class="copyright text-center  text-lg-left  text-muted">
                            Copyright &copy; <?php echo date('Y'); ?> | Powered By <a href="<?php echo $config['url']; ?>" class="font-weight-bold ml-1" target="_blank"><?php echo $config['webname']; ?></a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        
    </div>
    
    <!-- Component JS -->
    <script src="<?php echo $config['url']; ?>assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/js-cookie/js.cookie.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
    <?php if($self == "pemasukan" || $self == "pengeluaran" || $self == "logs" || $self == "rekap"){ ?>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo $config['url']; ?>assets/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
    <?php } ?>
    <script src="<?php echo $config['url']; ?>assets/js/argon.js?v=1.2.0"></script>
    <?php if($self == "pemasukan" || $self == "pengeluaran" || $self == "profile"){ ?>
    <script>
        function toRp(objek) {
            separator = ".";
            a = objek.value;
            b = a.replace(/[^\d]/g,"");
            c = "";
            panjang = b.length; 
            j = 0; 
            for (i = panjang; i > 0; i--) {
                j = j + 1;
                if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i-1,1) + separator + c;
                } else {
                c = b.substr(i-1,1) + c;
                }
            }
            objek.value = c;
        }
        
        function numberOnly(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
            
            return false;
                return true;
        }
    </script>
    <?php } ?>
    <?php if($self == "dashboard"){ ?>
    <script type="text/javascript">
     window.onload = function() { jam(); }
    
     function jam() {
      var e = document.getElementById('jam'),
      d = new Date(), h, m, s;
      h = d.getHours();
      m = set(d.getMinutes());
      s = set(d.getSeconds());
    
      e.innerHTML = h +':'+ m +':'+ s;
    
      setTimeout('jam()', 1000);
     }
    
     function set(e) {
      e = e < 10 ? '0'+ e : e;
      return e;
     }
    </script>
    <?php } ?>
    <?php if($self == "profile"){ ?>
    <script>
        function viewPhoto(gambar,idpreview){
            var gb = gambar.files;
            for (var i = 0; i < gb.length; i++){
                var gbPreview = gb[i];
                var imageType = /image.*/;
                var preview=document.getElementById(idpreview);            
                var reader = new FileReader();
                        
                if (gbPreview.type.match(imageType)) {
                    preview.file = gbPreview;
                    reader.onload = (function(element) { 
                        return function(e) { 
                            element.src = e.target.result; 
                        }; 
                    })(preview);
                    reader.readAsDataURL(gbPreview);
                } else{
                        alert("File yang anda upload tidak sesuai. Khusus mengunakan image!.");
                }    
            }    
        }
    </script>
    <?php } ?>
    <?php if($self != "profile"){ ?>
    <?php if($msg_type == "success"){ ?>
    <script>
        Swal.fire({
          title: 'Success!',
          text: '<?php echo $msg_content; ?>',
          icon: 'success',
          confirmButtonText: 'OK'
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
    <?php } ?>
</body>
</html>