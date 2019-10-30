<?php 
if(isset($_POST['btnLogin'])){
	$pesanError = array();
	if ( trim($_POST['txtUser'])=="") {
		$pesanError[] = 'Maaf, Username belum di isi.';	
	}
	if (trim($_POST['txtPassword'])=="") {
		$pesanError[] = 'Maaf, Password belum di isi.';			
	}
	
	# Baca variabel form
	$txtUser 	= $_POST['txtUser'];
	$txtUser 	= str_replace("'","&acute;",$txtUser);
	
	$txtPassword=$_POST['txtPassword'];
	$txtPassword= str_replace("'","&acute;",$txtPassword);
	
	$cmbLevel	= "Admin";
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "$noPesan. $pesan_tampil<br>";
			} 
		echo ""; 
		
		// Tampilkan lagi form login
		include "login.php";
	}
	else {
		# LOGIN CEK KE TABEL USER LOGIN
		$mySql = "SELECT * FROM petugas WHERE username='".$txtUser."' AND password='".md5($txtPassword)."' AND level='$cmbLevel'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah : ".mysql_error());
		$myData= mysql_fetch_array($myQry);
		
		# JIKA LOGIN SUKSES
		if(mysql_num_rows($myQry) >=1) {
			$_SESSION['SES_LOGIN'] = $myData['kd_petugas']; 
			$_SESSION['SES_USER'] = $myData['username']; 
			$_SESSION['SES_ADMIN'] = "Admin";
			
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?page=Halaman-Utama'>";
		}
		else {
			 echo "Login Anda bukan Level ".$cmbLevel;
		}
	}
} // End POST
?>
 
