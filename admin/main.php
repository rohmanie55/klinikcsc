<?php
if(isset($_SESSION['SES_ADMIN'])) {
?>


<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Home</h1>
</div>

<h4>Selamat datang di Klinik & Apotek</h4></b><br/>


            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Pasien</div>
                                    <div>Pengelolaan Data</div>
                                </div>
                            </div>
                        </div>
                        <a href="?page=Pasien-Data">
                            <div class="panel-footer">
                                <span class="pull-left">Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Dokter</div>
                                    <div>Pengelolaan Data</div>
                                </div>
                            </div>
                        </div>
                        <a href="?page=Dokter-Data">
                            <div class="panel-footer">
                                <span class="pull-left">Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Obat</div>
                                    <div>Data Penjualan</div>
                                </div>
                            </div>
                        </div>
                        <a href="?page=Obat-Data">
                            <div class="panel-footer">
                                <span class="pull-left">Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-file fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Laporan</div>
                                    <div>Penjualan</div>
                                </div>
                            </div>
                        </div>
                        <a href="?page=Laporan">
                            <div class="panel-footer">
                                <span class="pull-left">View Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

	<?php
}
else if(isset($_SESSION['SES_KLINIK'])) {

?>


<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Home</h1>
</div>

<h4>Selamat datang di Klinik & Apotek</h4></b><br/>


            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Pasien</div>
                                    <div>Tambah Data</div>
                                </div>
                            </div>
                        </div>
                        <a href="pendaftaran/">
                            <div class="panel-footer">
                                <span class="pull-left">Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Rawat</div>
                                    <div>Tambah Data</div>
                                </div>
                            </div>
                        </div>
                        <a href="rawat-pasien/">
                            <div class="panel-footer">
                                <span class="pull-left">Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->

	<?php

}
else if(isset($_SESSION['SES_APOTEK'])) {
?>


<div class="row">
<div class="col-lg-12">
<h1 class="page-header">Home</h1>
</div>

<h4>Selamat datang di Klinik & Apotek</h4></b><br/>


            <!-- /.row -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">Obat</div>
                                    <div>Data Penjualan</div>
                                </div>
                            </div>
                        </div>
                        <a href="penjualan/">
                            <div class="panel-footer">
                                <span class="pull-left">Details</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            <!-- /.row -->

	<?php
}
else {
	?>
	<div class="row">
    <div class="col-md-9 col-xs-12" style="text-align: center;">
        <img src="./images/logobg.png" style="height: 300px;">
        <h2>Selamat datang di Klinik Cikarang Skin Centre</h2>
        <h4>Anda belum login, silahkan login untuk mengakses sitem </h4>
        <a class="btn btn-warning btn-lg" href='?page=Login' alt='Login' style="display: inline-block;margin: 10 0 10 0;">LOGIN</a>
    </div>
    <div class="col-md-3 col-xs-12" style="background-color: #f8f8f8; height: 100%">
        
    </div>
</div>
<?php
}
?>