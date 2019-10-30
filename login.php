<?php
session_start();
include_once "admin/library/inc.connection.php";
$txtUser 	= $_POST['username'];
$txtUser 	= mysql_real_escape_string($txtUser);

$txtPassword=$_POST['password'];
$txtPassword= mysql_real_escape_string($txtPassword);


$mySql = "SELECT * FROM petugas WHERE username='".$txtUser."' AND password='".md5($txtPassword)."' AND level='user'";
$myQry = mysql_query($mySql, $koneksidb) or die ("Query Salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

# JIKA LOGIN SUKSES
if(mysql_num_rows($myQry) >=1) {
	$_SESSION['SES_LOGIN'] = $myData['kd_petugas']; 
	$_SESSION['SES_USER'] = $myData['username']; 
	$_SESSION['SES_NAMA'] = $myData['nm_petugas'];
	$_SESSION['SES_TELP'] = $myData['no_telepon'];  
	$_SESSION['SES_LEVEL'] = "User";
	// Refresh
	echo "<meta http-equiv='refresh' content='0; url=home.php'>";
}else{
	echo "<meta http-equiv='refresh' content='0; url=index.php?p=Gagal-Login'>";
}

?>