<?php
include_once "../library/inc.seslogin.php";

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($_POST['txtNomorRM'])=="") {
		$pesanError[] = "Data <b>Nomor RM (Rekam Medik)</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTglDaftar'])=="") {
		$pesanError[] = "Data <b>Tgl. Daftar</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtTglJanji'])=="") {
		$pesanError[] = "Data <b>Tgl. Janji</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtJamJanji'])=="") {
		$pesanError[] = "Data <b>Jam Janji</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtKeluhan'])=="") {
		$pesanError[] = "Data <b>Keluhan Pasien</b> tidak boleh kosong !";		
	}
	if (trim($_POST['cmbTindakan'])=="KOSONG") {
		$pesanError[] = "Data <b>Tindakan</b> tidak boleh kosong !";		
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
		echo "<div class='alert alert-danger'>";
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
		$mySql	= "UPDATE pendaftaran SET nomor_rm = '$txtNomorRM',
				tgl_daftar = '$txtTglDaftar',
				tgl_janji = '$txtTglJanji',
				jam_janji = '$txtJamJanji',
				keluhan = '$txtKeluhan',
				kd_tindakan = '$cmbTindakan'
				WHERE no_daftar ='". $_POST['textfield']."'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Pendaftaran-Tampil'>";
		}
		exit;
	}	
} // Penutup Tombol Simpan

# MENGAMBIL DATA YANG DIEDIT, SESUAI KODE YANG DIDAPAT DARI URL
$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 

$mySql	= "SELECT pendaftaran.*, pasien.nm_pasien FROM pendaftaran 
			LEFT JOIN pasien ON pendaftaran.nomor_rm = pasien.nomor_rm 
			WHERE no_daftar='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA DARI FORM KE VARIABEL TEMPORARY (SEMENTARA)
	$dataKode	= $myData['no_daftar'];
	$dataPasien	= $myData['nm_pasien'];
	$dataNomorRM	= isset($_POST['txtNomorRM']) ? $_POST['txtNomorRM'] : $myData['nomor_rm'];
	$dataTglDaftar	= isset($_POST['txtTglDaftar']) ? $_POST['txtTglDaftar'] :  IndonesiaTgl($myData['tgl_daftar']);
	$dataTglJanji 	= isset($_POST['txtTglJanji']) ? $_POST['txtTglJanji'] :  IndonesiaTgl($myData['tgl_janji']);
	$dataJamJanji	= isset($_POST['txtJamJanji']) ? $_POST['txtJamJanji'] : $myData['jam_janji'];
	$dataKeluhan	= isset($_POST['txtKeluhan']) ? $_POST['txtKeluhan'] : $myData['keluhan'];
	$dataTindakan	= isset($_POST['cmbTindakan']) ? $_POST['cmbTindakan'] : $myData['kd_tindakan'];
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" class="form-horizontal">
	 <div class="form-group">
    <label class="col-sm-2 control-label">Kode</label>
    <div class="col-sm-10">
    <input name="textfield" value="<?php echo $dataKode; ?>" size="10" readonly="readonly" class="form-control" />
	</div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Nomor RM</label>
    
    <div class="col-sm-10">
    <input name="txtNomorRM" value="<?php echo $dataNomorRM; ?>" size="23" maxlength="10" readonly="readonly" class="form-control" />
  	</div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Nama Pasien</label>
    <div class="col-sm-10">
    <input name="txtPasien" value="<?php echo $dataPasien; ?>" size="80" maxlength="100" readonly="readonly" class="form-control" />
</div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Tgl Daftar</label>
    <div class="col-sm-10">
    <input name="txtTglDaftar" type="text" class="tcal" value="<?php echo $dataTglDaftar; ?>" />
</div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Tgl/Jam Janji</label>
    <div class="col-sm-10">
    <input name="txtTglJanji" type="text" class="tcal" value="<?php echo $dataTglJanji; ?>" />
        / 
        <input name="txtJamJanji" value="<?php echo $dataJamJanji; ?>" size="10" maxlength="8"  />
        <strong>ex:</strong> 12:30 
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Keluhan Pasien</label>
    <div class="col-sm-10">
    <input name="txtKeluhan" value="<?php echo $dataKeluhan; ?>" size="80" maxlength="100" class="form-control" />
</div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">Keluhan Pasien</label>
    <div class="col-sm-10">
  <select name="cmbTindakan" class="form-control">
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
      </select>
  </div>
  </div>
  <div class="form-group">
  	<div class="col-sm-9"></div>
  	<div class="col-sm-3">
  	<button class="btn btn-danger" onclick="close_window()">BATAL</button>
  <input type="submit" name="btnSimpan" class="btn btn-primary" value=" UPDATE ">
</div>
  </div>
</form>
