<?php  
include_once "header.php";
include_once "admin/library/inc.connection.php";
include_once "admin/library/inc.library.php";
if(!isset($_SESSION['SES_LOGIN'])){
	echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}else{
	$kdPetugas = $_SESSION['SES_LOGIN'];
	$row = 50;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	$pageSql = "SELECT pendaftaran.*, pasien.nm_pasien, tindakan.nm_tindakan FROM pendaftaran LEFT JOIN pasien ON pendaftaran.nomor_rm = pasien.nomor_rm LEFT JOIN tindakan ON pendaftaran.kd_tindakan = tindakan.kd_tindakan WHERE pasien.kd_petugas = '$kdPetugas'";
	$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
	$jml	 = mysql_num_rows($pageQry);
	$max	 = ceil($jml/$row);
?>

  <section class="banner">
    <div class="bglight-blue">
      <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="col-md-12">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				        <span class="icon-bar"></span>
				      </button>
              <a class="navbar-brand" href="#"><img src="img/logo.png" class="img-responsive" style="width: 140px; margin-top: -16px;"></a>
            </div>
            <div class="collapse navbar-collapse navbar-right" id="myNavbar">
              <ul class="nav navbar-nav">
                <li class="active"><a href="home.php">Home</a></li>
                <li class=""><a href="apointment.php">Pendaftaran</a></li>
                <li class=""><a href="schedule.php">Jadwal</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong><?php echo $_SESSION['SES_USER'] ?></strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <p class="text-center">
                                            <span class="glyphicon glyphicon-user icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong><?php echo $_SESSION['SES_NAMA'] ?></strong></p>
                                        <p><?php echo $_SESSION['SES_TELP'] ?></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                    	<div class="col-md-6">
                                            <a href="#" class="btn btn-primary btn-block btn-sm">Edit Profile</a>
                                        </div>
                                        <div class="col-md-6">
                                            <a href="logout.php" class="btn btn-danger btn-block btn-sm">Logout</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
            </div>
          </div>
        </div>
      </nav>
      <div class="container" style="padding-bottom: 20px;">
        <div class="row">
          <div class="banner-info">
            <div class="banner-text text-center">
              <h1 class="white">Selamat datang di website CSC</h1>
              <p>We take our self very seriously, coz we seriously care about our patients.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
  <div class="container">
  	<div class="row">
  		<div class="col-md-12"><h3>Janji temu yang terdaftar</h3></div>
  		<div class="col-md-12">
  			<table class="table table-bordered">
            <tr>
			    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
			    <td width="67" bgcolor="#CCCCCC"><strong>No. Daftar </strong></td>
			    <td width="75" bgcolor="#CCCCCC"><strong>Tgl. Daftar </strong></td>
			    <td width="75" bgcolor="#CCCCCC"><strong>Nomor RM </strong></td>
			    <td width="150" bgcolor="#CCCCCC"><strong>Nama Pasien  </strong></td>
			    <td width="75" bgcolor="#CCCCCC"><strong>Tgl. Janji </strong></td>
			    <td width="70" bgcolor="#CCCCCC"><strong>Jam. Janji </strong></td>
			    <td width="182" bgcolor="#CCCCCC"><strong>Tindakan</strong></td>
			    <td width="37" align="center" bgcolor="#CCCCCC"><strong>Antri</strong></td>
			    <td width="20"  bgcolor="#CCCCCC">Tools</td>
			  </tr>
			  <?php
				# Perintah untuk menampilkan Semua Daftar Transaksi pendaftaran
				$mySql = "SELECT pendaftaran.*, pasien.nm_pasien, tindakan.nm_tindakan 
							FROM pendaftaran LEFT JOIN pasien ON pendaftaran.nomor_rm = pasien.nomor_rm LEFT JOIN tindakan ON pendaftaran.kd_tindakan = tindakan.kd_tindakan WHERE pasien.kd_petugas = '$kdPetugas' ORDER BY pendaftaran.no_daftar ASC LIMIT $hal, $row";
				$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
				$nomor = $hal; 
				while ($myData = mysql_fetch_array($myQry)) {
					$nomor++;		
					
				# Membaca Kode pendaftaran/ Nomor transaksi
				$noDaftar = $myData['no_daftar']; 
				?>
				<tr>
			    <td><?php echo $nomor; ?></td>
			    <td><?php echo $myData['no_daftar']; ?></td>
			    <td><?php echo IndonesiaTgl($myData['tgl_daftar']); ?></td>
			    <td><?php echo $myData['nomor_rm']; ?></td>
			    <td><?php echo $myData['nm_pasien']; ?></td>
			    <td><?php echo IndonesiaTgl($myData['tgl_janji']); ?></td>
			    <td><?php echo $myData['jam_janji']; ?></td>
			    <td><?php echo $myData['nm_tindakan']; ?></td>
			    <td align="center"><?php echo $myData['nomor_antri']; ?></td>
			    <td><a href="pendaftaran_cetak.php?Kode=<?php echo $myData['no_daftar']; ?>" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
			  </tr>
			  <?php } ?>
			  <tr>
			    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jml; ?></td>
			    <td colspan="7" align="right"><strong>Halaman ke :</strong>
				<?php
				for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $row * $h - $row;
					echo " <a href='?page=Laporan-Pendaftaran&hal=$list[$h]'>$h</a> ";
				}
				?></td>
			  </tr>
        </table>
  		</div>
  	</div>
  </div>
<?php
}
 ?>
 <?php include_once "footer.php";?>