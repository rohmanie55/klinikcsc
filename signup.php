<?php 
include_once "header.php";
include_once "admin/library/inc.library.php";
include_once "admin/library/inc.tanggal.php";
include_once "admin/library/inc.connection.php";
?>

<?php

# Tombol Simpan diklik
if(isset($_POST['btnSimpan'])){
  # Validasi form, jika kosong sampaikan pesan error
  $pesanError = array();
  if (trim($_POST['txtNama'])=="") {
    $pesanError[] = "Data <b>Nama Pasien</b> tidak boleh kosong !";   
  }
  if (trim($_POST['txtNoIdentitas'])=="") {
    $pesanError[] = "Data <b>No. Identitas</b> tidak boleh kosong !";
  }
  if (trim($_POST['cmbKelamin'])=="KOSONG") {
    $pesanError[] = "Data <b>Jenia Kelamin</b> belum dipilih !";
  } 
  if (trim($_POST['cmbGDarah'])=="KOSONG") {
    $pesanError[] = "Data <b>Golongan Darah</b> belum dipilih !";
  } 
  if (trim($_POST['cmbAgama'])=="KOSONG") {
    $pesanError[] = "Data <b>Agama</b> belum dipilih !";
  } 
  if (trim($_POST['txtTempatLahir'])=="") {
    $pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong !";
  }
  if (trim($_POST['txtAlamat'])=="") {
    $pesanError[] = "Data <b>Alamat Tinggal</b> tidak boleh kosong !";
  }
  if (trim($_POST['txtTelepon'])=="") {
    $pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";
  }
  if (trim($_POST['cmbSttsNikah'])=="KOSONG") {
    $pesanError[] = "Data <b>Status Nikah</b> belum dipilih !";
  }
  if (trim($_POST['cmbPekerjaan'])=="KOSONG") {
    $pesanError[] = "Data <b>Pekerjaan</b> belum dipilih !";
  }
  if (trim($_POST['cmbSttsKeluarga'])=="KOSONG") {
    $pesanError[] = "Data <b>Status Keluarga</b> tidak boleh kosong !";   
  }
  if (trim($_POST['txtKlgNama'])=="") {
    $pesanError[] = "Data <b>Nama Keluarga</b> tidak boleh kosong !";   
  }
  if (trim($_POST['txtKlgTelepon'])=="") {
    $pesanError[] = "Data <b>No. Telepon Keluarga</b> tidak boleh kosong !";    
  }
   if (trim($_POST['username'])=="") {
    $pesanError[] = "Data <b>Username</b> tidak boleh kosong !";    
  }
  if (trim($_POST['password'])=="") {
    $pesanError[] = "Data <b>Password</b> tidak boleh kosong !";    
  }
  
  # Baca Variabel Form
  $txtNama    = $_POST['txtNama'];
  $txtNoIdentitas = $_POST['txtNoIdentitas'];
  $cmbKelamin   = $_POST['cmbKelamin'];
  $cmbGDarah    = $_POST['cmbGDarah'];
  $cmbAgama   = $_POST['cmbAgama'];
  $txtAlamat    = $_POST['txtAlamat'];
  $txtTelepon   = $_POST['txtTelepon'];
  $cmbSttsNikah = $_POST['cmbSttsNikah'];
  $cmbPekerjaan = $_POST['cmbPekerjaan'];
  $cmbSttsKeluarga= $_POST['cmbSttsKeluarga'];
  $txtKlgNama   = $_POST['txtKlgNama'];
  $txtKlgTelepon  = $_POST['txtKlgTelepon'];
  $txtTempatLahir = $_POST['txtTempatLahir'];
  if (isset($_POST['username'])&&isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
  }else{
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
  }
  
  // Membaca form tanggal lahir (comboBox : tanggal, bulan dan tahun lahir)
  $cmbTglLahir  = $_POST['cmbTglLahir'];
  $cmbBlnLahir  = $_POST['cmbBlnLahir'];
  $cmbThnLahir  = $_POST['cmbThnLahir'];
  $tanggalLahir = "$cmbThnLahir-$cmbBlnLahir-$cmbTglLahir";


  # JIKA ADA PESAN ERROR DARI VALIDASI
  if (count($pesanError)>=1 ){
    echo "<div class='mssgBox'>";
    echo "<img src='images/attention.png'> <br><hr>";
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
    $kodePetugas = buatKode("petugas", "P");
    $mySql    = "INSERT INTO petugas (kd_petugas, nm_petugas, no_telepon, 
                     username, password, level)
            VALUES ('$kodePetugas', 
                '$txtNama', 
                '$txtTelepon', 
                '$username', 
                '$password', 
                'user')";
    $myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
    if($myQry){ 
      $tanggal  = date('Y-m-d');
      $kodeBaru = buatKode("pasien", "RM");
      $mySql  = "INSERT INTO pasien (nomor_rm, nm_pasien, no_identitas, jns_kelamin, 
              gol_darah, agama, tempat_lahir, tanggal_lahir, 
              no_telepon, alamat, stts_nikah, pekerjaan, 
              keluarga_status, keluarga_nama, keluarga_telepon, tgl_rekam, 
              kd_petugas) 
            VALUES ('$kodeBaru', '$txtNama', '$txtNoIdentitas', '$cmbKelamin', 
                '$cmbGDarah', '$cmbAgama', '$txtTempatLahir', '$tanggalLahir', 
                '$txtTelepon', '$txtAlamat', '$cmbSttsNikah', '$cmbPekerjaan', 
                '$cmbSttsKeluarga', '$txtKlgNama', '$txtKlgTelepon', '$tanggal', '$kodePetugas')"; 

      $myQry  = mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
      if($myQry){
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=Berhasil'>";
      }else{
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=Gagal'>";
      }
    }else{
        echo "<meta http-equiv='refresh' content='0; url=index.php?p=Gagal'>";
    }
    exit;
  } 
} // Penutup Tombol Simpan


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
                <li class="active"><a href="index.php">Home</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
      <div class="container">
        <div class="row">
          <div class="banner-info">
            
            <div class="banner-text text-center">
              <h1 class="white">Lengkapi Akun</h1>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="service" class="section-padding">
    <div class="container">
      <div class="row">
<?php
        # VARIABEL DATA UNTUK DIBACA FORM
$dataKode = buatKode("pasien", "RM");
$dataNama = isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataNoIdentitas= isset($_POST['txtNoIdentitas']) ? $_POST['txtNoIdentitas'] : '';
$dataKelamin= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataGDarah = isset($_POST['cmbGDarah']) ? $_POST['cmbGDarah'] : '';
$dataAgama  = isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon= isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
$dataSttsNikah  = isset($_POST['cmbSttsNikah']) ? $_POST['cmbSttsNikah'] : '';
$dataPekerjaan  = isset($_POST['cmbPekerjaan']) ? $_POST['cmbPekerjaan'] : '';
$dataSttsKeluarga= isset($_POST['cmbSttsKeluarga']) ? $_POST['cmbSttsKeluarga'] : '';
$dataKlgNama  = isset($_POST['txtKlgNama']) ? $_POST['txtKlgNama'] : '';
$dataKlgTelepon = isset($_POST['txtKlgTelepon']) ? $_POST['txtKlgTelepon'] : '';

// Tempat, Tgl Lahir
$dataTempatLahir= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';
$dataThn    = isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : date('Y');
$dataBln    = isset($_POST['cmbBlnLahir']) ? $_POST['cmbBlnLahir'] : date('m');
$dataTgl    = isset($_POST['cmbTglLahir']) ? $_POST['cmbTglLahir'] : date('d');
$dataTglLahir   = $dataThn."-".$dataBln."-".$dataTgl;

if (isset($_POST['username'])&&isset($_POST['password'])) {
    $user = $_POST['username'];
    $user = mysql_real_escape_string($user);
    $pass = $_POST['password'];
    $pass = mysql_real_escape_string($pass);
    $pass = md5($pass);
  }else{
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
  }

?>
<div class="col-md-2"></div>
<div class="col-md-8 col-sm-12">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" target="_self">
  <table  class="table-list" border="0" cellspacing="1" cellpadding="3">
    <input type="hidden" name="username" value="<?php echo $user?>">
    <input type="hidden" name="password" value="<?php echo $pass?>">
    <tr>
      <td><strong>Kode</strong></td>
      <td width="10px"><strong>:</strong></td>
      <td><input name="textfield" value="<?php echo $dataKode; ?>" maxlength="10" readonly="readonly"/></td>
    </tr>
    <tr>
      <td><strong>Nama </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNama" value="<?php echo $dataNama; ?>" maxlength="100" /></td>
    </tr>
    <tr>
      <td><strong>No. Identitas (KTP/SIM) </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoIdentitas" value="<?php echo $dataNoIdentitas; ?>" maxlength="40" /></td>
    </tr>
    <tr>
      <td><b>Jenis Kelamin </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbKelamin">
          <option value="KOSONG">....</option>
          <?php
      $pilihan  = array("Laki-laki", "Perempuan");
          foreach ($pilihan as $nilai) {
            if ($dataKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Gol. Darah </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbGDarah">
          <option value="KOSONG">....</option>
          <?php
      $pilihan  = array("A", "B", "AB", "O");
          foreach ($pilihan as $nilai) {
            if ($dataGDarah == $nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Agama</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbAgama">
          <option value="KOSONG">....</option>
          <?php
      $pilihan  = array("Islam", "Kristen", "Katolik", "Buda", "Hindu");
          foreach ($pilihan as $nilai) {
            if ($dataAgama ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Tempat, Tgl. Lahir </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" maxlength="100" />
        , <?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><strong>Alamat Tinggal </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamat" value="<?php echo $dataAlamat; ?>" maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtTelepon" value="<?php echo $dataTelepon; ?>" maxlength="20" /></td>
    </tr>
    <tr>
      <td><b>Status Nikah </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbSttsNikah">
          <option value="KOSONG">....</option>
          <?php
      $pilihan  = array("Menikah", "Belum Nikah");
          foreach ($pilihan as $nilai) {
            if ($dataSttsNikah ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><b>Pekerjaan</b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbPekerjaan">
          <option value="KOSONG">....</option>
          <?php
      $pilihan  = array("Pegawai Negri Sipil(PNS)", 
                "Karyawan",
              "Wiraswasta",
              "Petani");
          foreach ($pilihan as $nilai) {
            if ($dataPekerjaan ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td bgcolor="#CCCCCC"><strong> KELUARGA</strong> </td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><b>Status Keluarga </b></td>
      <td><b>:</b></td>
      <td><b>
        <select name="cmbSttsKeluarga">
          <option value="KOSONG">....</option>
          <?php
      $pilihan  = array("Ayah", "Ibu", "Suami", "Istri", "Saudara");
          foreach ($pilihan as $nilai) {
            if ($dataSttsKeluarga ==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><strong>Nama Keluarga </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKlgNama" value="<?php echo $dataKlgNama; ?>" maxlength="200" /></td>
    </tr>
    <tr>
      <td><strong>No. Telepon </strong></td>
      <td><strong>:</strong></td>
      <td><input name="txtKlgTelepon" value="<?php echo $dataKlgTelepon; ?>" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><input type="submit" name="btnSimpan" class="btn btn-primary pull-right" value=" SIMPAN "></td>
    </tr>
  </table>
</form>
</div>
<div class="col-md-2"></div>
       
      </div>
    </div>
  </section>

<?php include_once "footer.php";?>