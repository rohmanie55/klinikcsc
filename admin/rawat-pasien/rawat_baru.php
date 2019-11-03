<?php
include_once "../library/inc.seslogin.php";

# HAPUS DAFTAR tindakan DI TMP
if(isset($_GET['at'])){
	if(trim($_GET['at'])=="del"){
		# Hapus Tmp jika datanya sudah dipindah
		$id			= $_GET['id'];
		$userLogin	= $_SESSION['SES_LOGIN'];
		
		$mySql = "DELETE FROM tmp_rawat WHERE id='$id' AND kd_petugas='$userLogin'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(trim($_GET['at'])=="succ"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}

# HAPUS DAFTAR OBAT DI TMP
if(isset($_GET['ao'])){
	if(trim($_GET['ao'])=="del"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_penjualan WHERE id='".$_GET['id']."' AND kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(trim($_GET['ao'])=="succ"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================

# TOMBOL TAMBAH DIKLIK
if(isset($_POST['btnTambahTindakan'])){
	$pesanError = array();
	if (trim($_POST['txtNomorRM'])=="") {
			$pesanError[] = "Data <b>Pasien belum terisi</b>, harap pilih pasien terlebih dahulu</b> !";		
	}
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
		// Membaca data bagi hasil yang diberikan kepada Dokter
		$bacaSql ="SELECT bagi_hasil FROM dokter WHERE kd_dokter='$cmbDokter'";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		$bacaData = mysql_fetch_array($bacaQry);

		# SIMPAN DATA KE DATABASE (tmp_rawat)
		# Jika jumlah error pesanError tidak ada, skrip di bawah dijalankan
		$tmpSql 	= "INSERT INTO tmp_rawat (kd_tindakan, harga, kd_dokter, bagi_hasil_dokter, kd_petugas, kd_pasien) 
					   VALUES ('$cmbTindakan', '$txtHarga', '$cmbDokter', '$bacaData[bagi_hasil]', '".$_SESSION['SES_LOGIN']."', '$txtNomorRM')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());				

	}
}

# ========================================================================================================
# JIKA TOMBOL Tambah obat  DIKLIK



	# TOMBOL TAMBAH (INPUT OBAT) DIKLIK
	if(isset($_POST['btnTambahObat'])){
		$pesanError = array();
		if (trim($_POST['txtKodeObat'])=="") {
			$pesanError[] = "Data <b>Kode Obat belum diisi</b>, ketik Kode dari Keyboard atau dari <b>Barcode Reader</b> !";		
		}
		if (trim($_POST['txtJumlah'])=="" or ! is_numeric(trim($_POST['txtJumlah']))) {
			$pesanError[] = "Data <b>Jumlah Obat (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
		}
		
		# Baca variabel
		$txtNomorRM	= $_POST['txtNomorRM'];
		$txtKodeObat	= $_POST['txtKodeObat'];
		$txtKodeObat	= str_replace("'","&acute;", $txtKodeObat);
		$txtJumlah	= $_POST['txtJumlah'];

		# Skrip validasi Stok Obat
		# Jika stok < (kurang) dari Jumlah yang dibeli, maka buat Pesan Error
		$cekSql	= "SELECT stok FROM obat WHERE kd_obat='$txtKodeObat'";
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
		$cekRow = mysql_fetch_array($cekQry);
		if ($cekRow['stok'] < $txtJumlah) {
			$pesanError[] = "Stok Obat untuk Kode <b>$txtKodeObat</b> adalah <b> $cekRow[stok]</b>, tidak dapat dijual!";
		}
				
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
			# SIMPAN KE DATABASE (tmp_penjualan)	
			// Periksa, apakah Kode obat atau Kode Barcode yang diinput ada di dalam tabel obat
	$mySql ="SELECT * FROM obat WHERE kd_obat='$txtKodeObat'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query".mysql_error());
	$myRow = mysql_fetch_array($myQry);
	if (mysql_num_rows($myQry) >= 1) {
		// Membaca kode obat/ obat
		$kodeObat	= $myRow['kd_obat'];
		$harga	= $myRow['harga_jual'] * $txtJumlah;
		
		// Jika Kode ditemukan, masukkan data ke Keranjang (TMP)
		$tmpSql 	= "INSERT INTO tmp_penjualan (kd_obat, jumlah, harga,  kd_petugas, kd_pasien) 
					VALUES ('$kodeObat', '$txtJumlah', '$harga', '".$_SESSION['SES_LOGIN']."', '$txtNomorRM')";
		mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
	}
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

	if (trim($_POST['txtUangBayar']) < trim($_POST['txtTotBayar'])) {
		$pesanError[] = "Data <b> Uang Bayar Tidak Cukup</b>.  
						 Total transaksi adalah <b> Rp. ".format_angka($_POST['txtTotBayar'])."</b>";		
	}

	# Validasi jika belum ada satupun data item yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_rawat WHERE kd_pasien='".$_POST['txtNomorRM']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR TINDAKAN MASIH KOSONG</b>, Daftar item tindakan belum ada yang dimasukan <b>minimal 1 data</b>.";
	}


	# Baca variabel
	$txtTanggal 	= $_POST['txtTanggal'];
	$txtNomorRM		= $_POST['txtNomorRM'];
	$txtDiagnosa	= $_POST['txtDiagnosa'];
	$txtUangBayar	= $_POST['txtUangBayar'];
	$txtTotBayar	= $_POST['txtTotBayar'];
	$txtPasien      = $_POST['txtPasien'];
			
			
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

				# simpan trx Tmp jika datanya sudah dipindah
		$SaveTrx = "INSERT INTO `transaksi` (`id`, `harga`, `bayar`, `timestamp`, `idpetugas`) VALUES (NULL, '$txtTotBayar', '$txtUangBayar', NULL, '".$_SESSION['SES_LOGIN']."')";
		mysql_query($SaveTrx, $koneksidb) or die ("Gagal simpan trx".mysql_error());

		$idtrx = mysql_insert_id();

		$tmpRawat   = $_POST['tmpRawat'];

		$nomorRawat = buatKode("rawat", "RP");
		
		$tanggal	= InggrisTgl($_POST['txtTanggal']);
		$userLogin	= $_SESSION['SES_LOGIN'];
		
		// Skrip menyimpan data ke tabel transaksi utama
		$mySql	= "INSERT INTO rawat SET 
						no_rawat='$nomorRawat', 
						tgl_rawat='$tanggal', 
						nomor_rm='$txtNomorRM', 
						hasil_diagnosa='$txtDiagnosa', 
						uang_bayar='$tmpRawat', 
						kd_petugas='$userLogin',
						idtransaksi='$idtrx'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());


		# Ambil semua data tindakan/tindakan yang dipilih, berdasarkan pasien
		$tmpSql ="SELECT * FROM tmp_rawat WHERE kd_pasien='$txtNomorRM'";
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

		$tmpSql ="SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_pasien='".$_POST['txtNomorRM']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		$tmpData = mysql_fetch_array($tmpQry);
		if ($tmpData['qty'] > 0) {
			
			$tmpPenjualan = $_POST['tmpPenjualan'];
	
			$noTransaksi = buatKode("penjualan", "JL");
			$mySql	= "INSERT INTO penjualan SET 
							no_penjualan='$noTransaksi', 
							tgl_penjualan='".InggrisTgl($_POST['txtTanggal'])."', 
							pelanggan='$txtPasien', 
							keterangan='Perawatan Pasien', 
							uang_bayar='$tmpPenjualan',
							kd_petugas='".$_SESSION['SES_LOGIN']."',
							idtransaksi=$idtrx";

			mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

			# SIMPAN DATA TMP KE PENJUALAN_ITEM
		# Ambil semua data obat yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT obat.*, tmp.jumlah FROM obat, tmp_penjualan As tmp
					WHERE obat.kd_obat = tmp.kd_obat AND tmp.kd_pasien='".$_POST['txtNomorRM']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel obat dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_obat'];
			$dataHargaM	= $tmpData['harga_modal'];
			$dataHargaJ	= $tmpData['harga_jual'];
			$dataJumlah	= $tmpData['jumlah'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO penjualan_item SET 
									no_penjualan='$noTransaksi', 
									kd_obat='$dataKode', 
									harga_modal='$dataHargaM', 
									harga_jual='$dataHargaJ', 
									jumlah='$dataJumlah'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE obat SET stok = stok - $dataJumlah WHERE kd_obat='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_pasien='".$_POST['txtNomorRM']."'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());

		}
			
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_rawat WHERE kd_pasien='".$_POST['txtNomorRM']."'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Jalankan skrip Nota
		echo "<script>";
		echo "window.open('rawat_nota.php?nomorRawat=$nomorRawat', width=330,height=330,left=100, top=25)";
		echo "</script>";
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=index.php'>";

	}	
}

//amnbil total bayar
if(isset($_GET['NomorRM'])){
	$tmpSql ="SELECT sum(harga) as harga FROM tmp_penjualan WHERE kd_pasien='".$_GET['NomorRM']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpPenjualan = mysql_fetch_array($tmpQry);

	$tmpSql ="SELECT sum(harga) as harga FROM tmp_rawat WHERE kd_pasien='".$_GET['NomorRM']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpRawat = mysql_fetch_array($tmpQry);

	$txtTotBayar = $tmpRawat['harga'] + $tmpPenjualan['harga'];
}

// Membaca Nomor RM data Pasien
$NomorRM= isset($_GET['NomorRM']) ?  $_GET['NomorRM'] : '';
$kode   = isset($_GET['kode']) ?  $_GET['kode'] : '';
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
    <label class="col-sm-2 control-label">Tgl Rawat</label>
    <div class="col-sm-10">
     <input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" size="23" />
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
    <div class="col-sm-6">
    <input name="txtHarga" size="18" maxlength="12" class="form-control"/>
        
	</div>
	<div class="col-sm-4">
		<input name="btnTambahTindakan" type="submit" style="cursor:pointer;" value=" Tambah " class="btn btn-default" />
	</div>
  </div>
</div>

 	<div class="alert alert-success">
  		<h4>Tambah Obat</h4>

  		 <div class="form-group">
    <label class="col-sm-2 control-label">Kode Obat</label>
    
    <div class="col-sm-8">
   <input name="txtKodeObat" value="<?php echo $kode; ?>" size="23" maxlength="10" class="form-control" readonly="readonly"/>
   <?
   if ($NomorRM=='') {
   	 echo "pilih pasien terlebih dahulu";
   }else{
   	echo " * pilih dari daftar obat, lalu klik menu <strong>daftar</strong>";
   }
   ?>
  	</div>
  	<div class="col-sm-2">
	  	<?
	   if ($NomorRM!='') {
	   ?>
    	<a href="?page=Pencarian-Obat&NomorRM=<? echo $NomorRM; ?>" target="_self" class="btn btn-success"><i class="fa fa-search"></i></a>
    	<?}?>
    </div>
  </div>

  		<div class="form-group">
	    <label class="col-sm-2 control-label">Jumlah</label>
	    <div class="col-sm-6">
	    	 <input class="angkaC form-control" name="txtJumlah"
				 onblur="if (value == '') {value = '1'}" 
				 onfocus="if (value == '1') {value =''}" />
		</div>
		<div class="col-sm-4">
				<?
			   if ($NomorRM!='') {
			   ?>
		    	<input name="btnTambahObat" type="submit" style="cursor:pointer;" value=" Tambah " class="btn btn-default" />
		    	<?}?>
		</div>
  		</div>
  	</div>

  <table class="table table-striped">
    <tr>
      <th colspan="6"><strong>DAFTAR TINDAKAN</strong></th>
    </tr>
    <tr>
      <th ><strong>No</strong></td>
      <th><strong>Kode </strong></td>
      <th><strong>Nama Tindakan </strong></td>
      <th><strong>Dokter</strong></td>
      <th><strong>Harga (Rp) </strong></td>
      <th><strong>Tools</strong></td>
    </tr>
    <?php
	// Query SQL menampilkan data Tindakan dalam TMP_RAWAT
	$tmpSql ="SELECT tmp_rawat.*, tindakan.nm_tindakan, dokter.nm_dokter FROM tmp_rawat
			  LEFT JOIN tindakan ON tmp_rawat.kd_tindakan=tindakan.kd_tindakan 
			  LEFT JOIN dokter ON tmp_rawat.kd_dokter=dokter.kd_dokter
			  WHERE tmp_rawat.kd_petugas='".$_SESSION['SES_LOGIN']."' and tmp_rawat.kd_pasien='$NomorRM' ORDER BY id";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor=0;  $totalHargaTindakan = 0; 
	while($tmpData = mysql_fetch_array($tmpQry)) {
		$nomor++;
		$totalHargaTindakan	+=  $tmpData['harga'];
	?>
	  <tr>
		<td><?php echo $nomor; ?></td>
		<td><?php echo $tmpData['kd_tindakan']; ?></td>
		<td><?php echo $tmpData['nm_tindakan']; ?></td>
		<td><?php echo $tmpData['nm_dokter']; ?></td>
		<td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
		<td><a href="?NomorRM=<?php echo $NomorRM?>&at=del&id=<?php echo $tmpData['id']; ?>" target="_self" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
	  </tr>
    <?php } ?>
    <tr>
      <td colspan="4" align="right"><b>TOTAL  : </b></td>
      <td align="right"><strong>Rp. <?php echo format_angka($totalHargaTindakan); ?></strong></td>
      <td>&nbsp;</td>
    </tr>
  </table>

    <table class="table table-striped" width="800" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="7">DAFTAR OBAT </th>
    </tr>
    <tr>
      <th><strong>No</strong></td>
      <th><strong>Kode</strong></td>
      <th><strong>Nama Obat </strong></td>
      <th align="right"><strong>Harga (Rp) </strong></td>
      <th align="right"><strong>Jumlah</strong></td>
      <th align="right"><strong>Sub Total(Rp) </strong></td>
      <th align="center">Tools</td>
    </tr>
    <?php
	// Qury menampilkan data dalam Grid TMP_Penjualan 
	$tmpSql ="SELECT obat.*, tmp.id, tmp.jumlah FROM obat, tmp_penjualan As tmp
			WHERE obat.kd_obat=tmp.kd_obat AND tmp.kd_petugas='".$_SESSION['SES_LOGIN']."'
			AND tmp.kd_pasien='$NomorRM' ORDER BY obat.kd_obat ";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor=0;  $hargaDiskon = 0;
	while($tmpData = mysql_fetch_array($tmpQry)) {
		$nomor++;
		$subSotal 	+= $tmpData['jumlah'] * $tmpData['harga_jual'];
		$jumlahobat	+= $tmpData['jumlah'];
	?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_obat']; ?></b></td>
      <td><?php echo $tmpData['nm_obat']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga_jual']); ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?NomorRM=<?php echo $NomorRM?>&ao=del&id=<?php echo $tmpData['id']; ?>" target="_self" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>TOTAL   (Rp.) : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><?php echo $jumlahobat; ?></strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBayar); ?></strong></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
  </table>

 <div class="form-group">
    <label class="col-sm-5 control-label">Grand Total (Rp.)</label>
    <div class="col-sm-7">
     <input name="txtTotBayar" value="<?php echo $txtTotBayar; ?>" size="23" maxlength="23" class="form-control" readonly="readonly"/>
     <input name="tmpRawat" type="hidden" value="<?php echo $tmpRawat['harga']; ?>" />

     <input name="tmpPenjualan" type="hidden" value="<?php echo $tmpPenjualan['harga']; ?>"/>
	</div>
  </div>

  <div class="form-group">
    <label class="col-sm-5 control-label">Uang Bayar/ DP (Rp.)</label>
    <div class="col-sm-7">
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