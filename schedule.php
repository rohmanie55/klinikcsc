<?php  
include_once "header.php";
include_once "admin/library/inc.connection.php";
include_once "admin/library/inc.library.php";

if(!isset($_SESSION['SES_LOGIN'])){
	echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}else{
	# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

	# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
	$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
	$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

	// Jika tombol filter tanggal (Tampilkan) diklik
	if (isset($_POST['btnTampil'])) {
		// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
		$filterPeriode = "WHERE ( tgl_janji BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
	}
	else {
		// Membaca data tanggal dari URL, saat menu Pages diklik
		$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
		$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
		
		// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
		$filterPeriode = "WHERE ( tgl_janji BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
	}

	# UNTUK PAGING (PEMBAGIAN HALAMAN)
	$row = 50;
	$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
	$pageSql = "SELECT * FROM pendaftaran $filterPeriode";
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
      <div class="container">
        <div class="row">
          <div class="banner-info">
            <div class="banner-text text-center">
              <h1 class="white">Jadwal Janji Temu</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
  	<div class="container">
  		<div class="row">
  			<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
			<div class="dataTable-wrapper">
			<div class="table-responsive">
			  <table  class="table table-striped table-bordered table-hover" id="dataTables-example"  width="100%"cellspacing="1" cellpadding="3">
			    <tr>
			      <td colspan="3" bgcolor="#CCCCCC"><strong>PERIODE JANJI </strong></td>
			    </tr>
			    <tr>
			      <td width="90"><strong>Periode </strong></td>
			      <td width="5"><strong>:</strong></td>
			      <td width="391">
				  <input name="txtTglAwal" type="text" class="tcal" value="<?php echo $tglAwal; ?>" /> s/d
			      <input name="txtTglAkhir" type="text" class="tcal" value="<?php echo $tglAkhir; ?>" /></td>
			    </tr>
			    <tr>
			      <td>&nbsp;</td>
			      <td>&nbsp;</td>
			      <td><input name="btnTampil" type="submit" value=" Tampilkan " /></td>
			    </tr>
			  </table>
			  </div></div>
			</form>

			<div class="dataTable-wrapper">
			<div class="table-responsive">
			  <table  class="table table-striped table-bordered table-hover" id="dataTables-example"  width="100%"cellspacing="1" cellpadding="3">
			  <tr>
			    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
			    <td width="67" bgcolor="#CCCCCC"><strong>No. Daftar </strong></td>
			    <td width="75" bgcolor="#CCCCCC"><strong>Tgl. Daftar </strong></td>
			    <td width="75" bgcolor="#CCCCCC"><strong>Nomor RM </strong></td>
			    <td width="150" bgcolor="#CCCCCC"><strong>Nama Pasien </strong></td>
			    <td width="75" bgcolor="#CCCCCC"><strong>Tgl. Janji </strong></td>
			    <td width="70" bgcolor="#CCCCCC"><strong>Jam. Janji </strong></td>
			    <td width="182" bgcolor="#CCCCCC"><strong>Tindakan</strong></td>
			    <td width="37" align="center" bgcolor="#CCCCCC"><strong>Antri</strong></td>
			  </tr>
			  <?php
				$mySql = "SELECT pendaftaran.*, pasien.nm_pasien, tindakan.nm_tindakan 
							FROM pendaftaran 
							LEFT JOIN pasien ON pendaftaran.nomor_rm = pasien.nomor_rm
							LEFT JOIN tindakan ON pendaftaran.kd_tindakan = tindakan.kd_tindakan
							$filterPeriode
							ORDER BY pendaftaran.no_daftar ASC LIMIT $hal, $row";
				$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
				$nomor = $hal; 
				while ($myData = mysql_fetch_array($myQry)) {
					$nomor++;		
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
			  </tr>
			  <?php } ?>
			  <tr>
			    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jml; ?></td>
			    <td colspan="6" align="right"><strong>Halaman ke :</strong>
			    <?php
				for ($h = 1; $h <= $max; $h++) {
					$list[$h] = $row * $h - $row;
					echo " <a href='?page=Laporan-Pendaftaran&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
				}
				?></td>
			  </tr>
			</table>
			</div></div>
  			
  		</div>	
  	</div>
  </section>

<?php
}
 include_once "footer.php";
?>