<?php
include_once "../library/inc.seslogin.php";

# HAPUS DAFTAR tindakan DI TMP
if(isset($_GET['Aksi'])){
	if(trim($_GET['Aksi'])=="Hapus"){
		# Hapus Tmp jika datanya sudah dipindah
		$id			= $_GET['id'];
		$userLogin	= $_SESSION['SES_LOGIN'];
		
		$mySql = "DELETE FROM tmp_rawat WHERE id='$id' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(trim($_GET['Aksi'])=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

# TOMBOL TAMBAH DIKLIK
if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['cmbDokter'])=="KOSONG") {
		$pesanError[] = "Data <b>Nama Dokter</b> belum dipilih, harus Anda pilih dari combo !";		
	}
	if (trim($_POST['cmbTindakan'])=="KOSONG") {
		$pesanError[] = "Data <b>Nama Tindakan</b> belum dipilih, harus Anda pilih dari combo !";		
	}
	if (trim($_POST['txtHarga'])=="" or ! is_numeric(trim($_POST['txtHarga']))) {
		$pesanError[] = "Data <b>Harga Tindakan (Rp) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}

	# BACA VARIABEL DARI FORM INPUT tindakan
	$txtNomorRM	= $_POST['txtNomorRM'];
	
	$cmbDokter	= $_POST['cmbDokter'];
	$cmbTindakan= $_POST['cmbTindakan'];
	
	$txtHarga	= $_POST['txtHarga'];
	$txtHarga	= str_replace("'","&acute;",$txtHarga);
	$txtHarga	= str_replace(".","",$txtHarga);

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
		// Membaca data bagi hasil yang diberikan kepada Dokter
		$bacaSql ="SELECT bagi_hasil FROM dokter WHERE kd_dokter='$cmbDokter'";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		$bacaData = mysql_fetch_array($bacaQry);

		# SIMPAN DATA KE DATABASE (tmp_rawat)
		# Jika jumlah error pesanError tidak ada, skrip di bawah dijalankan
		$tmpSql 	= "INSERT INTO tmp_rawat (kd_tindakan, harga, kd_dokter, bagi_hasil_dokter, kd_petugas) 
					   VALUES ('$cmbTindakan', '$txtHarga', '$cmbDokter', '$bacaData[bagi_hasil]', '".$_SESSION['SES_LOGIN']."')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());				

	}
}

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtNomorRM'])=="") {
		$pesanError[] = "Data <b>Nomor Rekam Medik (RM)</b> belum diisi, silahkan klik <b>daftar pasien</b> !";		
	}
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Rawat</b> belum diisi, silahkan pilih pada kalender !";		
	}
	if (trim($_POST['txtUangBayar'])==""  or ! is_numeric(trim($_POST['txtUangBayar']))) {
		$pesanError[] = "Data <b> Uang Bayar (Rp)</b> belum diisi, silahkan isi dengan uang (Rp) !";		
	}

	# Validasi jika belum ada satupun data item yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_rawat WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR TINDAKAN MASIH KOSONG</b>, Daftar item tindakan belum ada yang dimasukan, <b>minimal 1 data</b>.";
	}

	# Baca variabel
	$txtTanggal 	= $_POST['txtTanggal'];
	$txtNomorRM		= $_POST['txtNomorRM'];
	$txtDiagnosa	= $_POST['txtDiagnosa'];
	$txtUangBayar	= $_POST['txtUangBayar'];
			
			
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
		# SIMPAN KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka proses Penyimpanan akan dikalkukan
		
		// Membuat kode Transaksi baru
		$nomorRawat = buatKode("rawat", "RP");
		
		$tanggal	= InggrisTgl($_POST['txtTanggal']);
		$userLogin	= $_SESSION['SES_LOGIN'];
		
		// Skrip menyimpan data ke tabel transaksi utama
		$mySql	= "INSERT INTO rawat SET 
						no_rawat='$nomorRawat', 
						tgl_rawat='$tanggal', 
						nomor_rm='$txtNomorRM', 
						hasil_diagnosa='$txtDiagnosa', 
						uang_bayar='$txtUangBayar', 
						kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

		# Ambil semua data tindakan/tindakan yang dipilih, berdasarkan user yg login
		$tmpSql ="SELECT * FROM tmp_rawat WHERE kd_petugas='$userLogin'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Membaca data dari tabel TMP
			$kodeTindakan	= $tmpData['kd_tindakan'];
			$hargaTindakan	= $tmpData['harga'];
			$kodeDokter		= $tmpData['kd_dokter'];
			$bagiHasilDokter= $tmpData['bagi_hasil_dokter'];
			
			// Masukkan semua tindakan dari TMP ke tabel rawat detail
			$itemSql = "INSERT INTO rawat_tindakan SET
							 tgl_tindakan='$tanggal', 
							 no_rawat='$nomorRawat', 
							 kd_tindakan='$kodeTindakan', 
							 harga='$hargaTindakan', 
							 kd_dokter='$kodeDokter', 
							 bagi_hasil_dokter='$bagiHasilDokter'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
		}
			
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_rawat WHERE kd_petugas='$userLogin'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Jalankan skrip Nota
		echo "<script>";
		echo "window.open('rawat_nota.php?nomorRawat=$nomorRawat', width=330,height=330,left=100, top=25)";
		echo "</script>";
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=index.php'>";

	}	
}

// Membaca Nomor RM data Pasien
$NomorRM= isset($_GET['NomorRM']) ?  $_GET['NomorRM'] : '';
$mySql	= "SELECT nomor_rm, nm_pasien FROM pasien WHERE nomor_rm='$NomorRM'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);
$dataPasien		= $myData['nm_pasien'];

# Kode pasien
if($NomorRM=="") {
	$NomorRM= isset($_POST['txtNomorRM']) ? $_POST['txtNomorRM'] : '';
}

# MEMBACA DATA DARI FORM UTAMA TRANSAKSI, Nilai datanya dimasukkan kembali ke Form utama DATA TRANSAKSI
$noTransaksi 	= buatKode("rawat", "RP");
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataDiagnosa	= isset($_POST['txtDiagnosa']) ? $_POST['txtDiagnosa'] : '';
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
$dataDokter		= isset($_POST['cmbDokter']) ? $_POST['cmbDokter'] : '';
$dataTindakan	= isset($_POST['cmbTindakan']) ? $_POST['cmbTindakan'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" class="form-horizontal">
  <div class="form-group">
    <label class="col-sm-2 control-label">No Rawat</label>
    <div class="col-sm-10">
     <input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly" class="form-control"/>
	</div>
  </div>
    <div class="form-group">
    <label class="col-sm-2 control-label">Tgl Rawat</label>
    <div class="col-sm-10">
     <input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" />
	</div>
  </div>
    <div class="form-group">
    <label class="col-sm-2 control-label">Nomor RM</label>
    
    <div class="col-sm-8">
    <input name="txtNomorRM" value="<?php echo $NomorRM; ?>" size="23" maxlength="10" class="form-control" readonly="readonly"/>
      * pilih dari daftar pasien, lalu klik menu <strong>daftar</strong>
  	</div>
  	<div class="col-sm-2">
    	<a href="?page=Pencarian-Pasien" target="_self" class="btn btn-success"><i class="fa fa-users" aria-hidden="true"></i></a>
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">Nama Pasien</label>
    <div class="col-sm-10">
     <input name="txtPasien" value="<?php echo $dataPasien; ?>" size="80" maxlength="100" readonly="readonly" class="form-control"/>
	</div>
  </div>

   <div class="form-group">
    <label class="col-sm-2 control-label">Hasil Diagnosa Dokter</label>
    <div class="col-sm-10">
     <textarea name="txtDiagnosa" value="<?php echo $dataDiagnosa; ?>" size="80" maxlength="100" class="form-control"></textarea>
	</div>
  </div>



  <div class="alert alert-success">
  	<h4>Tambah tindakan</h4>
     <div class="form-group">
    <label class="col-sm-2 control-label">Dokter</label>
    <div class="col-sm-10">
     <select name="cmbDokter" class="form-control">
          <option value="KOSONG">....</option>
          <?php
	  $bacaSql = "SELECT * FROM dokter ORDER BY kd_dokter";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_dokter'] == $dataDokter) {
			$cek = " selected";
		} else { $cek=""; }
		
		echo "<option value='$bacaData[kd_dokter]' $cek>[ $bacaData[kd_dokter] ]  $bacaData[nm_dokter]</option>";
	  }
	  ?>
        </select>
	</div>
  </div>

       <div class="form-group">
    <label class="col-sm-2 control-label">Tindakan</label>
    <div class="col-sm-10">
     <select name="cmbTindakan" class="form-control">
        <option value="KOSONG">....</option>
        <?php
	  $bacaSql = "SELECT * FROM tindakan ORDER BY kd_tindakan";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_tindakan'] == $dataTindakan) {
			$cek = " selected";
		} else { $cek=""; }
		
		$harga = format_angka($bacaData['harga']);
		echo "<option value='$bacaData[kd_tindakan]' $cek>[ $bacaData[kd_tindakan] ]  $bacaData[nm_tindakan] | $harga</option>";
	  }
	  ?>
      </select>
	</div>
  </div>

  <div class="form-group">
    <label class="col-sm-2 control-label">Harga Tindakan (Rp)</label>
    <div class="col-sm-8">
    <input name="txtHarga" size="18" maxlength="12" class="form-control"/>
        
	</div>
	<div class="col-sm-2"><input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " class="btn btn-success" /></div>
  </div>
</div>

  <table class="table table-striped">
    <tr>
      <th colspan="6"><strong>DAFTAR TINDAKAN </strong></th>
    </tr>
    <tr>
      <td width="27" ><strong>No</strong></td>
      <td width="58" ><strong>Kode </strong></td>
      <td width="300"><strong>Nama Tindakan </strong></td>
      <td width="190"><strong>Dokter</strong></td>
      <td width="150"><strong>Harga (Rp) </strong></td>
      <td width="39"><strong>Tools</strong></td>
    </tr>
    <?php
	// Query SQL menampilkan data Tindakan dalam TMP_RAWAT
	$tmpSql ="SELECT tmp_rawat.*, tindakan.nm_tindakan, dokter.nm_dokter FROM tmp_rawat
			  LEFT JOIN tindakan ON tmp_rawat.kd_tindakan=tindakan.kd_tindakan 
			  LEFT JOIN dokter ON tmp_rawat.kd_dokter=dokter.kd_dokter
			  WHERE tmp_rawat.kd_petugas='".$_SESSION['SES_LOGIN']."' ORDER BY id";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor=0;  $totalHarga = 0; 
	while($tmpData = mysql_fetch_array($tmpQry)) {
		$nomor++;
		$totalHarga	= $totalHarga +  $tmpData['harga'];
	?>
	  <tr>
		<td><?php echo $nomor; ?></td>
		<td><?php echo $tmpData['kd_tindakan']; ?></td>
		<td><?php echo $tmpData['nm_tindakan']; ?></td>
		<td><?php echo $tmpData['nm_dokter']; ?></td>
		<td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
		<td><a href="?Aksi=Hapus&id=<?php echo $tmpData['id']; ?>" target="_self" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
	  </tr>
    <?php } ?>
    <tr>
      <td colspan="4" align="right"><b> GRAND TOTAL  : </b></td>
      <td align="right"><strong>Rp. <?php echo format_angka($totalHarga); ?></strong></td>
      <td>&nbsp;</td>
    </tr>
  </table>

      <div class="form-group">
    <label class="col-sm-2 control-label">Uang Bayar/ DP (Rp.)</label>
    <div class="col-sm-10">
     <input name="txtUangBayar" value="<?php echo $dataUangBayar; ?>" size="23" maxlength="23" class="form-control"/>
	</div>
  </div>

   <div class="form-group">
  	<div class="col-sm-9"></div>
  	<div class="col-sm-3">
  	<button class="btn btn-danger" onclick="close_window()">BATAL</button>
  		<input type="submit" name="btnSimpan" class="btn btn-primary" value=" SIMPAN ">
	</div>
  </div>

</form>