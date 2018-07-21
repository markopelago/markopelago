<?php
mysql_connect("localhost","root","");
mysql_select_db("markopelago");
 
$kota = $_GET['kota'];
$kec  = mysql_query("SELECT id_kec, nama_kec FROM district WHERE id_kabkot='$kota' order by nama_kec");
 
echo "<option>-- Pilih Kecamatan --</option>";
while($k = mysql_fetch_array($kec)){
echo "<option value=\"".$k['id_kec']."\">".$k['nama_kec']."</option>\n";
}
?>