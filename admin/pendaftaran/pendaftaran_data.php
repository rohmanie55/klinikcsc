<?php
include_once "../library/inc.seslogin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pendaftaran";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
	<table class="table table-striped" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="28" align="center"><strong>No</strong></th>
        <th width="78"><strong>No. Daftar </strong></th>
        <th width="87"><strong>Tgl. Daftar </strong></th>
        <th width="87"><strong>Nomor RM </strong></th>
        <th width="174"><strong>Nama Pasien </strong></th>
        <th width="87"><strong>Tgl. Janji </strong></th>
        <th width="115"><strong>Jam. Janji </strong></th>
        <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
	$mySql = "SELECT pendaftaran.*, pasien.nm_pasien, tindakan.nm_tindakan 
				FROM pendaftaran 
				LEFT JOIN pasien ON pendaftaran.nomor_rm = pasien.nomor_rm
				LEFT JOIN tindakan ON pendaftaran.kd_tindakan = tindakan.kd_tindakan
				ORDER BY pendaftaran.no_daftar DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_daftar'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['no_daftar']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_daftar']); ?></td>
        <td><?php echo $myData['nomor_rm']; ?></td>
        <td><?php echo $myData['nm_pasien']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_janji']); ?></td>
        <td><?php echo $myData['jam_janji']; ?></td>
        <td width="41" align="center"><a href="../cetak/pendaftaran_cetak.php?Kode=<?php echo $Kode; ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i></a><a href="?page=Pendaftaran-Ubah&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-success"><i class="fa fa-edit"></i></a>
        <a href="?page=Pendaftaran-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENDAFTARAN INI ... ?')" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="3"><strong>Jumlah Data :</strong> <?php echo $jml; ?> </td>
        <td colspan="4" align="right"><strong>Halaman ke :</strong>
        <?php
     for ($h = 1; $h <= $max; $h++) {
    $list[$h] = $row * $h - $row;
    echo " <a href='?page=Pendaftaran-Tampil&hal=$list[$h]'>$h</a> ";
  }
      ?></td>
      </tr>
    </table>
  
