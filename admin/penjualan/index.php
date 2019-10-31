<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

date_default_timezone_set("Asia/Jakarta");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>TRANSAKSI PENJUALAN - APOTEK KLINIK </title>
</head>
<body>
	<link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

	<link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<link rel="stylesheet" type="text/css" href="../plugins/tigra_calendar/tcal.css" />

	<style type="text/css">
		.card {
		  /* Add shadows to create the "card" effect */
		  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
		  transition: 0.3s;
		  background-color: white;
		}
	</style>
	<script type="text/javascript" src="../plugins/tigra_calendar/tcal.js"></script> 
	</head>
	<body>
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0"> 
   <div class="navbar-header">
        <a class="navbar-brand" href="http://localhost/klinikcsc/admin"><img src="../images/logo.png" style="height: 30px;display: inline;">Cikarang Skin Centre</a>
    </div>
            <!-- /.navbar-header -->
	</nav>

	<div class="container">
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div style="margin-bottom: 20px;">
					<a href="?page=Penjualan-Baru" target="_self" class="btn card btn-default">Penjualan Baru</a>
			<a href="?page=Penjualan-Tampil" target="_self" class="btn card btn-default">Tampil Penjualan </a>
				</div>
				<div class="card col-md-12">

<?php 
# KONTROL MENU PROGRAM
if(isset($_GET['page'])) {
	// Jika mendapatkan variabel URL ?page
	$page = $_GET['page'];

		?>
		<div>
		<h2><? echo $page ?><h2>
		
		</div>
		<?

	switch($_GET['page']){				
		case 'Penjualan-Baru' :
			if(!file_exists ("penjualan_baru.php")) die ("Empty Main Page!"); 
			include "penjualan_baru.php";	break;
		case 'Pencarian-Obat' : 
			if(!file_exists ("pencarian_obat.php")) die ("Empty Main Page!"); 
			include "pencarian_obat.php";	break;
		case 'Penjualan-Tampil' : 
			if(!file_exists ("penjualan_tampil.php")) die ("Empty Main Page!"); 
			include "penjualan_tampil.php";	break;
		case 'Penjualan-Hapus' : 
			if(!file_exists ("penjualan_hapus.php")) die ("Empty Main Page!"); 
			include "penjualan_hapus.php";	break;
	}
}
else {
	?>
		<div>
		<h2>Penjualan-Baru<h2>
		
		</div>
		<?

	include "penjualan_baru.php";
}
?>
</div>
</div>
		<div class="col-md-2">
		</div>
	</div>
	</div>
	
		<script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	  <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>
	      <script src="../dist/js/sb-admin-2.js"></script>
	      <script type="text/javascript">
	      	function close_window() {
  if (confirm("Batalkan?")) {
    close();
  }
}
	      </script>
</body>
</html>
