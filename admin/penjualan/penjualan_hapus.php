<?php
include_once "../library/inc.seslogin.php";

// Periksa ada atau tidak variabel Kode pada URL (alamat browser)
if(isset($_GET['Kode'])){
	$Kode	= $_GET['Kode'];

	$mySql = "SELECT * FROM penjualan WHERE no_penjualan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	$myData = mysql_fetch_array($myQry);

	$mySql = "SELECT * FROM transaksi WHERE id= ".$myData['idtransaksi'];
	$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	$myTrx = mysql_fetch_array($myQry);

	

	if ($myTrx['harga']>$myData['uang_bayar']) {
		// Skrip Update stok
		$bayar = $myData['uang_bayar'];
		$trxSql = "UPDATE transaksi SET harga = harga - $bayar WHERE id= ".$myTrx['id'];
		mysql_query($trxSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
	}else{
		$trxSql = "DELETE FROM transaksi WHERE id= ".$myTrx['id'];
		$test = mysql_query($trxSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
	}
	
	// Hapus data sesuai Kode yang didapat di URL
	$mySql = "DELETE FROM penjualan WHERE no_penjualan='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
	if($myQry){
	
		// Baca data dalam tabel anak (penjualan_item)
		$bacaSql = "SELECT * FROM penjualan_item WHERE no_penjualan='$Kode'";
		$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query baca data".mysql_error());
		while($bacaData = mysql_fetch_array($bacaQry)) {
			$KodeObat	= $bacaData['kd_obat'];
			$jumlah		= $bacaData['jumlah'];
			
			// Skrip Kembalikan Jumlah Stok
			$stokSql = "UPDATE obat SET stok = stok + $jumlah WHERE kd_obat='$KodeObat'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
		}
		
		// Hapus data pada tabel anak (penjualan_item)
		$mySql = "DELETE FROM penjualan_item WHERE no_penjualan='$Kode'";
		mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());

		// Refresh halaman
		echo "<meta http-equiv='refresh' content='0; url=?page=Penjualan-Tampil'>";
	}
}
else {
	// Jika tidak ada data Kode ditemukan di URL
	echo "<b>Data yang dihapus tidak ada</b>";
}
?>