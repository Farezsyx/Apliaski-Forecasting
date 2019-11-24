<?php 
error_reporting(0);
extract($_GET);
extract($_POST);
	 include 'db.php';
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Aplkasi Ramalan Forecasting</title>
 </head>
 <body>
 <table width="600" border="0">
 	<tr>
 		<td width="27">NO</td>
 		<td width="219">Time Series</td>
 		<td width="155" align="right">Penjualan</td>
 		<td width="34" align="right">X</td>
 		<td width="34" align="right">Y</td>
 		<td width="75" align="right">XX</td>
 		<td width="26" align="right">XY</td>
 	</tr>
 	<?php 
 		$total_x = 0;
 		$total_y = 0;
 		$total_xx = 0;
 		$total_xy = 0;
 		$x = -1;
 		$no = 0;

 		$penjualan = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY id_jual ASC");
 		while ($hs = mysqli_fetch_array($penjualan)) {
 			$no++;
 			$x++;
 			$minggu=$hs[1];
 			$bulan=$hs[2];
 			$tahun=$hs[3];
 			$jumlah=$hs[4];
 			$xx = $x * $x;
 			$xy = $x * $jumlah;
 			$total_x = $total_x + $x;
 			$total_y = $total_y + $jumlah;
 			$total_xx = $total_xx + $xx;
 			$total_xy = $total_xy + $xy;
	 ?>
	 <tr>
	 	<td><?php echo $no; ?></td>
	 	<td><?php echo "Minggu ke-$minggu Bulan $bulan $tahun"; ?></td>
	 	<td align="right"><?php echo $jumlah; ?></td>
	 	<td align="right"> <?php echo $x; ?></td>
	 	<td align="right"><?php echo $jumlah; ?></td>
	 	<td align="right"><?php echo $xx; ?></td>
	 	<td align="right"><?php echo $xy; ?></td>
	 </tr>
	<?php } ?>
	<tr>
		<td colspan="3">Jumlah</td>
		<td align="right"><?php echo $total_x; ?></td>
		<td align="right"><?php echo $total_y; ?></td>
		<td align="right"><?php echo $total_xx; ?></td>
		<td align="right"><?php echo $total_xy; ?></td>
	</tr>
	<tr>
		<td colspan="3">Rata-rata</td>
		<td align="right"><?php echo $total_x/$no; ?></td>
		<td align="right"><?php echo $total_y/$no; ?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
 </table>
 <?php 
// Regresi Linear
 $b1 = ($total_xy - (($total_x * $total_y)/$no))/ ($total_xx - (($total_x * $total_x)/$no));
 $b0 = ($total_y/$no) - $b1 * ($total_x/$no);
 echo "Rumus Regresi Linear<br>";
 echo "y = $b0 + $b1 X<br>";
  ?>
<?php 
if ($prediksi) {
	$list_pilihan = $_POST['list_pilihan'];
	$x = $x + $list_pilihan;
	$y = $b0 + $b1 * $x;
	echo "Prediksi Penjualan untuk $list_pilihan minggu berikutnya adalah $y";
}
 ?>
 <p><a href="index.php">Halaman Utama</a></p>
 </body>
 </html>