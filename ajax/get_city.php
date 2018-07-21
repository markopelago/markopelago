<?php
mysql_connect("localhost","root","");
mysql_select_db("markopelago");
$propinsi = $_GET['propinsi'];
$kota = mysql_query("SELECT id_kabkot,nama_kabkot FROM city WHERE id_prov='$propinsi' order by nama_kabkot");
echo "<option>-- Pilih Kabupaten/Kota --</option>";
while($k = mysql_fetch_array($kota)){
echo "<option value=\"".$k['id_kabkot']."\">".$k['nama_kabkot']."</option>\n";
}
?>