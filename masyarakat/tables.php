<?php 
session_start();
require "../koneksi.php";

// Periksa apakah pengguna telah login sebagai admin
if ($_SESSION['role'] !== 'masyarakat') {
  header('Location: ../login.php');
  exit();
}

if (isset($_GET['logout'])) {
  session_destroy();
  header('Location: ../login.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Tabel Pengaduan</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<style>
  .bg-wrap .user-logo .img {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    margin: 0 auto;
    margin-bottom: 10px; }
  .bg-wrap .user-logo h3 {
    color: #fff;
    font-size: 18px; }
    

</style>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

   <!-- Sidebar -->
   <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(44,231,156,1) 0%, rgba(0,212,255,1) 100%);">


      <!-- Sidebar - Brand -->
      <div class="img bg-wrap text-center py-4" style="background-image: url(images/test.jpg);">
	  			<div class="user-logo">
	  				<div class="img" style="background-image: url();"></div>
	  				<h3 id=nama_ni></h3>
	  			</div>
	  		</div>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Home</span></a>
      </li>
      
      

 
      <!-- Heading -->
      
      <li class="nav-item">
        <a class="nav-link" href="pengaduan.php">
          <i class="fas fa-fw fa-user"></i>
          <span>Ajukan pengaduan</span></a>
      </li>

<li class="nav-item active">
        <a class="nav-link" href="tables.php">
          <i class="fas fa-fw fa-user"></i>
          <span>riwayat pengaduan</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" id="accordionSidebar">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
        

        <!-- Topbar Navbar -->
<?php include("header/topbar.php");?>
        <!-- End of Topbar -->
        <!-- Page Content  -->
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-2 text-gray-800">Tabel</h1>

          <!-- DataTales Example -->
          <div class="card shadow mb-4 animated--grow-in">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Riwayat pengaduan</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>NO</th>
                      <th>Tanggal</th>
                      <th>NIK</th>
                      <th>Isi</th>
                      <th>Foto</th>
                      <th>Status</th>
                      <th>Tanggapan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>NO</th>
                      <th>Tanggal</th>
                      <th>NIK</th>
                      <th>Isi</th>
                      <th>Foto</th>
                      <th>Status</th>
                      <th>Tanggapan</th>
                    </tr>
                  </tfoot>
                  <tbody>
<?php
$no = 1;
  $nikuser = $_SESSION['nik'];
  $out = mysqli_query($conn, "SELECT * FROM pengaduan WHERE nik='$nikuser'");
  while($keluar = mysqli_fetch_array($out)){
?>

                    <tr>
                      <td><?php echo $no++?></td>
                      <td><?php echo $keluar['tgl_pengaduan'];?></td>
                      <td><?php echo $keluar['nik'];?></td>
                      <td><?php echo $keluar['isi_laporan'];?></td>
                      <td align="Center"><img src="../uploads/<?php echo $keluar['foto'];?>" style="width: 100px;height: auto;"></td>
                      <td><?php
                      $sts = $keluar['status'];
                      if($sts=="selesai"){
                        echo "<span class=\"text-success animated--grow-in\"><b>Selesai</b></span>";
                      }elseif($sts=="proses"){
                        echo "<span class=\"text-primary animated--grow-in\"><b>Diproses</b></span>";
                      }else{
                        echo "Belum Diproses";
                      }
                      ?></td>
                      <td><?php
                      $sts = $keluar['status'];
                      if($sts=="selesai"){
                        echo "<a href=\"?id_pengaduan=".base64_encode($keluar['id_pengaduan'])."\">Lihat Tanggapan</a>";
                      }elseif($sts=="proses"){
                        echo "<a href=\"?id_pengaduan=".base64_encode($keluar['id_pengaduan'])."\">Lihat Tanggapan</a>";
                      }else{
                        echo "Belum Ditanggapi";
                      }
                      ?></td>
                    </tr>
<?php
}
?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

<!-- Modal -->
<?php
if(isset($_GET['id_pengaduan'])){?>
  <script type="text/javascript">window.onload = function(){document.getElementById('tombol').click();}</script>
  <input id="tombol" data-toggle="modal" data-target="#exampleModal" type="hidden">
<?php
  }
  if(isset($_GET['id_pengaduan'])){
    $idtgp = base64_decode($_GET['id_pengaduan']);
    $outtgp = mysqli_query($conn, "SELECT * FROM tanggapan WHERE id_pengaduan='$idtgp'");
    $keluartgp = mysqli_fetch_array($outtgp);
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tanggapan <?= "[ID: ".$keluartgp['id_tanggapan']."]";?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<?php if(empty($keluartgp['tanggapan'])){ echo "<div class=\"alert bg-danger text-light\"><b>Ups.. Tanggapan tidak Ditemukan ! :(</b><br/>Kode : $_GET[id_pengaduan]</div>"; }else{echo $keluartgp['tanggapan'];}?>
      </div>
      <div class="modal-footer">
  <?= "ditanggapi pada : ". $keluartgp['tgl_tanggapan'];?>      
      </div>
    </div>
  </div>
</div>
<?php } ?>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
           
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="?logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

</body>

</html>
