<?php
include_once "header.php";
include_once "admin/library/inc.connection.php";
include_once "admin/library/inc.library.php";
function nomorAntrian($tanggal) {
	//$tanggal dalam format Y-m-d
	$antriKe= 0;
	$mySql	= "SELECT count(*) as jum_antri FROM pendaftaran WHERE tgl_janji='$tanggal' ORDER BY nomor_antri";
	$myQry 	= mysql_query($mySql) or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
	if(mysql_num_rows($myQry) >=1) {
		$antriKe	= $myData['jum_antri'] + 1;
	}
	else {
		$antriKe	= 1;
	}
	
	return $antriKe;
}

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($_POST['txtNomorRM'])=="") {
		$pesanError[] = "Data <b>Nomor RM (Rekam Medik)</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTglDaftar'])=="") {
		$pesanError[] = "Data <b>Tgl. Daftar</b> tidak boleh kosong, silahkan pilih pada kalender !";		
	}	
	if (trim($_POST['txtTglJanji'])=="") {
		$pesanError[] = "Data <b>Tgl. Janji</b> tidak boleh kosong, silahkan pilih pada kalender !";			
	}
	if (trim($_POST['txtJamJanji'])=="") {
		$pesanError[] = "Data <b>Jam Janji</b> tidak boleh kosong, isi dengan format 00:00:00 !";		
	}
	if (trim($_POST['txtKeluhan'])=="") {
		$pesanError[] = "Data <b>Keluhan Pasien</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	if (trim($_POST['cmbTindakan'])=="KOSONG") {
		$pesanError[] = "Data <b>Tindakan</b> tidak boleh kosong, silahkan dilengkapi !";		
	}

	# Baca Variabel Form
	$txtNomorRM		= $_POST['txtNomorRM'];
	$txtTglDaftar	= InggrisTgl($_POST['txtTglDaftar']);
	$txtTglJanji	= InggrisTgl($_POST['txtTglJanji']);
	$txtJamJanji	= $_POST['txtJamJanji'];
	$txtKeluhan		= $_POST['txtKeluhan'];
	$cmbTindakan	= $_POST['cmbTindakan'];
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database	
		$userLogin	= $_SESSION['SES_LOGIN'];
		$nomorAntri = nomorAntrian($txtTglJanji);
		$kodeBaru	= buatKode("pendaftaran", "");
		$mySql	= "INSERT INTO pendaftaran (no_daftar, nomor_rm, tgl_daftar, tgl_janji, jam_janji, 
						keluhan, kd_tindakan, nomor_antri, kd_petugas) 
						VALUES ('$kodeBaru', '$txtNomorRM', '$txtTglDaftar', '$txtTglJanji', '$txtJamJanji', 
						'$txtKeluhan', '$cmbTindakan', '$nomorAntri', '$userLogin')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){			
			// Refresh halaman 
			echo "<meta http-equiv='refresh' content='0; url=home.php'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

// Membaca Nomor RM data Pasien
if(isset($_SESSION['SES_LOGIN'])){
	$NomorPT= $_SESSION['SES_LOGIN'];
	$mySql	= "SELECT nomor_rm, nm_pasien, kd_petugas FROM pasien WHERE kd_petugas='$NomorPT'";
	$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);
	$dataNamaPasien		= $myData['nm_pasien'];
	$dataKodePasien		= $myData['nomor_rm'];
}else{
	
	echo "<meta http-equiv='refresh' content='0; url=index.php'>";
}


# Kode pasien
// if($NomorRM=="") {
// 	$NomorRM= isset($_POST['txtNomorRM']) ? $_POST['txtNomorRM'] : '';
// }

# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
$dataKode		= buatKode("pendaftaran", "");
$dataTglDaftar	= isset($_POST['txtTglDaftar']) ? $_POST['txtTglDaftar'] :  date('d-m-Y');
$dataTglJanji 	= isset($_POST['txtTglJanji']) ? $_POST['txtTglJanji'] :  date('d-m-Y');
$dataJamJanji	= isset($_POST['txtJamJanji']) ? $_POST['txtJamJanji'] : '';
$dataKeluhan	= isset($_POST['txtKeluhan']) ? $_POST['txtKeluhan'] : '';
$dataTindakan	= isset($_POST['cmbTindakan']) ? $_POST['cmbTindakan'] : '';
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
              <h1 class="white">Pendaftaran Janji Temu</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="section-padding">
  <div class="container">
  <div class="row">
  	<div class="col-md-2"></div>
  	<div class="col-md-8 col-sm-12">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="3">
  	<input type="hidden" name="txtNomorRM" value="<?php echo $dataKodePasien ?>">
    <tr>
      <td><strong>Kode</strong></td>
      <td><strong>:</strong></td>
      <td><input name="textfield" value="<?php echo $dataKode; ?>" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Nama</strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtPasien" value="<?php echo $dataNamaPasien; ?>" maxlength="100" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Tgl.  Daftar </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTglDaftar" type="text" class="tcal" value="<?php echo $dataTglDaftar; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Tgl.  &amp; Jam Janji </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTglJanji" type="text" class="tcal" value="<?php echo $dataTglJanji; ?>" />
        / 
        <input name="txtJamJanji" value="<?php echo $dataJamJanji; ?>" maxlength="8" />
        <strong>ex:</strong> 12:30 </td>
    </tr>
    <tr>
      <td><strong>Keluhan Pasien </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKeluhan" value="<?php echo $dataKeluhan; ?>" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>Pilih Tindakan </strong></td>
      <td><strong>:</strong></td>
      <td><select name="cmbTindakan">
        <option value="KOSONG">....</option>
        <?php
	  $dataSql = "SELECT * FROM tindakan ORDER BY kd_tindakan";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
		if ($dataRow['kd_tindakan'] == $dataTindakan) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$dataRow[kd_tindakan]' $cek>[ $dataRow[kd_tindakan] ]  $dataRow[nm_tindakan]</option>";
	  }
	  ?>
      </select></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" class="btn btn-primary" value=" SIMPAN "></td>
    </tr>
  </table>
</form>
</div>
<div class="col-md-2"></div>
</div>
</div>
</section>

 <?php include_once "footer.php";?>
