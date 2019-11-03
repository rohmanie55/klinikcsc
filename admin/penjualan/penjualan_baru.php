<?php
include_once "../library/inc.seslogin.php";

# HAPUS DAFTAR OBAT DI TMP
if(isset($_GET['Aksi'])){
	if(trim($_GET['Aksi'])=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_penjualan WHERE id='".$_GET['id']."' AND kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(trim($_GET['Aksi'])=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================


# TOMBOL TAMBAH (INPUT OBAT) DIKLIK
if(isset($_POST['btnTambah'])){
	$pesanError = array();
	if (trim($_POST['txtKodeObat'])=="") {
		$pesanError[] = "Data <b>Kode Obat belum diisi</b>, ketik Kode dari Keyboard atau dari <b>Barcode Reader</b> !";		
	}
	if (trim($_POST['txtJumlah'])=="" or ! is_numeric(trim($_POST['txtJumlah']))) {
		$pesanError[] = "Data <b>Jumlah Obat (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	# Baca variabel
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
	$tmpSql 	= "INSERT INTO tmp_penjualan (kd_obat, jumlah, harga,  kd_petugas) 
				VALUES ('$kodeObat', '$txtJumlah', $harga, '".$_SESSION['SES_LOGIN']."')";
	mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
}
}

}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	$pesanError = array();
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if (trim($_POST['txtUangBayar'])==""  or ! is_numeric(trim($_POST['txtUangBayar']))) {
		$pesanError[] = "Data <b> Uang Bayar</b> belum diisi, isi dengan uang (Rp) !";		
	}

	if (trim($_POST['txtTotBayar'])==""  or ! is_numeric(trim($_POST['txtTotBayar']))) {
		$pesanError[] = "Data <b> Obat belum </b> belum pilih!";		
	}

	if (trim($_POST['txtUangBayar']) < trim($_POST['txtTotBayar'])) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($_POST['txtTotBayar'])."</b>";		
	}
	
	# Periksa apakah sudah ada obat yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR OBAT MASIH KOSONG</b>, belum ada obat yang dimasukan, <b>minimal 1 obat</b>.";
	}
	
	# Baca variabel from
	$txtTanggal 	= $_POST['txtTanggal'];
	$txtPelanggan	= $_POST['txtPelanggan'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtUangBayar	= $_POST['txtUangBayar'];
	$txtTotBayar    = $_POST['txtTotBayar'];


			
			
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
		//get inserted id

		$SaveTrx = "INSERT INTO `transaksi` (`id`, `harga`, `bayar`, `timestamp`, `idpetugas`) VALUES (NULL, '$txtTotBayar', '$txtUangBayar', NULL, '".$_SESSION['SES_LOGIN']."')";
		mysql_query($SaveTrx, $koneksidb) or die ("Gagal simpan trx".mysql_error());

		$idtrx = mysql_insert_id();
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
		$noTransaksi = buatKode("penjualan", "JL");
		$mySql	= "INSERT INTO penjualan SET 
						no_penjualan='$noTransaksi', 
						tgl_penjualan='".InggrisTgl($_POST['txtTanggal'])."', 
						pelanggan='$txtPelanggan', 
						keterangan='$txtKeterangan', 
						uang_bayar='$txtTotBayar',
						kd_petugas='".$_SESSION['SES_LOGIN']."',
						idtransaksi= $idtrx";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# SIMPAN DATA TMP KE PENJUALAN_ITEM
		# Ambil semua data obat yang dipilih, berdasarkan kasir yg login
		$tmpSql ="SELECT obat.*, tmp.jumlah FROM obat, tmp_penjualan As tmp
					WHERE obat.kd_obat = tmp.kd_obat AND tmp.kd_petugas='".$_SESSION['SES_LOGIN']."'";
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
		$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Jalankan skrip Nota
		echo "<script>";
		echo "window.open('penjualan_nota.php?noNota=$noTransaksi', width=330,height=330,left=100, top=25)";
		echo "</script>";
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=index.php'>";

	}	
}


# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("penjualan", "JL");
$kode           = isset($_GET['kode']) ?  $_GET['kode'] : '';
$dataTanggal 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataPelanggan	= isset($_POST['txtPelanggan']) ? $_POST['txtPelanggan'] : 'Pasien';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" class="form-horizontal">
	
  	<div class="alert alert-success">
  		<h4>Input Obat</h4>

  		 <div class="form-group">
    <label class="col-sm-2 control-label">Kode Obat</label>
    
    <div class="col-sm-8">
   <input name="txtKodeObat" value="<?php echo $kode; ?>" size="23" maxlength="10" class="form-control" readonly="readonly"/>
      * pilih dari daftar obat, lalu klik menu <strong>daftar</strong>
  	</div>
  	<div class="col-sm-2">
    	<a href="?page=Pencarian-Obat" target="_self" class="btn btn-success"><i class="fa fa-search"></i></a>
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
			<input name="btnTambah" type="submit" style="cursor:pointer;" value=" Tambah " class="btn btn-default" />
		</div>
  		</div>
  	</div>

  	  <table class="table table-striped" width="800" border="0" cellspacing="1" cellpadding="2">
    <tr>
      <th colspan="7">DAFTAR OBAT </th>
    </tr>
    <tr>
      <td width="29" bgcolor="#CCCCCC"><strong>No</strong></td>
      <td width="85" bgcolor="#CCCCCC"><strong>Kode</strong></td>
      <td width="432" bgcolor="#CCCCCC"><strong>Nama Obat </strong></td>
      <td width="85" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
      <td width="48" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
      <td width="100" align="right" bgcolor="#CCCCCC"><strong>Sub Total(Rp) </strong></td>
      <td width="22" align="center" bgcolor="#CCCCCC">&nbsp;</td>
    </tr>
<?php
// Qury menampilkan data dalam Grid TMP_Penjualan 
$tmpSql ="SELECT obat.*, tmp.id, tmp.jumlah FROM obat, tmp_penjualan As tmp
		WHERE obat.kd_obat=tmp.kd_obat AND tmp.kd_petugas='".$_SESSION['SES_LOGIN']."'
		ORDER BY obat.kd_obat ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  $hargaDiskon = 0;   $totalBayar	= 0;  $jumlahobat	= 0;
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$subSotal 	= $tmpData['jumlah'] * $tmpData['harga_jual'];
	$totalBayar	= $totalBayar + $subSotal;
	$jumlahobat	= $jumlahobat + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_obat']; ?></b></td>
      <td><?php echo $tmpData['nm_obat']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga_jual']); ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?Aksi=Delete&id=<?php echo $tmpData['id']; ?>" target="_self" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>GRAND TOTAL   (Rp.) : </strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><?php echo $jumlahobat; ?></strong></td>
      <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBayar); ?></strong></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
  </table>
  <div class="form-group">
	    <label class="col-sm-2 control-label">No Penjualan</label>
	    <div class="col-sm-10">
	     <input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" maxlength="23" readonly="readonly" class="form-control"/>
		</div>
  	</div>
  	<div class="form-group">
	    <label class="col-sm-2 control-label">Tgl Penjualan</label>
	    <div class="col-sm-10">
	     <input name="txtTanggal" type="text" class="tcal" value="<?php echo $dataTanggal; ?>" class="form-control"/>
		</div>
  	</div>
  	<div class="form-group">
	    <label class="col-sm-2 control-label">Pelanggan</label>
	    <div class="col-sm-10">
	     <input name="txtPelanggan" value="<?php echo $dataPelanggan; ?>" class="form-control"/>
		</div>
  	</div>
  	<div class="form-group">
	    <label class="col-sm-2 control-label">Keterangan</label>
	    <div class="col-sm-10">
	     <textarea name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control">
	     </textarea>
		</div>
  	</div>

  	<div class="form-group">
	    <label class="col-sm-2 control-label">UANG BAYAR (Rp.)</label>
	    <div class="col-sm-10">
    	<?

    	$tmpSql ="SELECT sum(harga) as harga FROM tmp_penjualan WHERE kd_petugas='".$_SESSION['SES_LOGIN']."'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());

		$txtTotBayar = $tmpPenjualan['harga'];

    	?>
	     <input name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" />
	     <input name="txtUangBayar" value="<?php echo $dataUangBayar; ?>" class="form-control"/>
		</div>
  	</div>
  	<div class="form-group">
  		<div class="col-sm-7">
  		</div>
  		<div class="col-sm-5">
  			<button class="btn btn-danger" onclick="close_window()">BATAL</button>
  		<input name="btnSimpan" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " class="btn btn-primary" />
  		</div>
  	</div>

</form>
