<?php
include_once "../library/inc.seslogin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM rawat";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
	<table class="table table-striped" >
      <tr>
        <th width="29" align="center"><strong>No</strong></th>
        <th width="102"><strong>No. Rawat </strong></th>
        <th width="103"><strong>Tgl. Rawat </strong></th>
        <th width="133"><strong>Nomor RM  </strong></th>
        <th width="291"><strong>Nama Pasien </strong></th>
        <th width="291"><strong>Hasil Diagnosa </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
      </tr>
      <?php
	$mySql = "SELECT rawat.*, pasien.nm_pasien
				FROM rawat 
				LEFT JOIN pasien ON rawat.nomor_rm = pasien.nomor_rm
				ORDER BY rawat.no_rawat DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_rawat'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['no_rawat']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_rawat']); ?></td>
        <td><?php echo $myData['nomor_rm']; ?></td>
        <td><?php echo $myData['nm_pasien']; ?></td>
        <td><?php echo $myData['hasil_diagnosa']; ?></td>
        <td width="45" align="center"><a href="rawat_nota.php?nomorRawat=<?php echo $Kode; ?>" target="_blank" class="btn btn-success"><i class="fa fa-credit-card"></i></a></td>
        <td width="45" align="center"><a href="?page=Rawat-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA RAWAT INI ... ?')" class="btn btn-danger"><i class="fa fa-trash"></i></a></td>
      </tr>
      <?php } ?>
        <tr>
    <td colspan="3"><strong>Jumlah Data :</strong> </td>
    <td colspan="4" align="right"><strong>Halaman ke : </strong>
  <?php
 for ($h = 1; $h <= $max; $h++) {
    $list[$h] = $row * $h - $row;
    echo " <a href='?page=Rawat-Tampil&hal=$list[$h]'>$h</a> ";
  }
  ?></td>
  </tr>
    </table>