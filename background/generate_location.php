<?php
	include_once "document_root_path.php";
	include_once "common.php";
	echo "TRUNCATE TABLE locations;".$__enter;
	$id = 0;
	$propinsiSeqNo = 0;
	$propinsiS = $db->fetch_all_data("bakal_locations",["propinsi"],"1=1 group by propinsi order by id");
	foreach($propinsiS as $_propinsi){
		$id++;
		$propinsiSeqNo++;
		$propinsi = $_propinsi["propinsi"];
		$sql = "INSERT INTO locations (id,parent_id,seqno,name_id,name_en) VALUES ($id,0,$propinsiSeqNo,'$propinsi','$propinsi');";
		echo $sql.$__enter;
		
		$parentPropinsi_id = $id;
		$kotaSeqNo = 0;
		$kotaS = $db->fetch_all_data("bakal_locations",["kabupaten"],"propinsi LIKE '$propinsi' group by concat(propinsi,kabupaten) order by id");
		foreach($kotaS as $_kota){
			$id++;
			$kotaSeqNo++;
			$kota = $_kota["kabupaten"];
			$sql = "INSERT INTO locations (id,parent_id,seqno,name_id,name_en) VALUES ($id,$parentPropinsi_id,$kotaSeqNo,'$kota','$kota');";
			echo $__tab.$sql.$__enter;
			
			$parentKota_id = $id;
			$kecamatanSeqNo = 0;
			$kecamatanS = $db->fetch_all_data("bakal_locations",["kecamatan"],"propinsi LIKE '$propinsi' AND kabupaten LIKE '$kota' group by concat(propinsi,kabupaten,kecamatan) order by id");
			foreach($kecamatanS as $_kecamatan){
				$id++;
				$kecamatanSeqNo++;
				$kecamatan = $_kecamatan["kecamatan"];
				$sql = "INSERT INTO locations (id,parent_id,seqno,name_id,name_en) VALUES ($id,$parentKota_id,$kecamatanSeqNo,'$kecamatan','$kecamatan');";
				echo $__tab.$__tab.$sql.$__enter;
				
				$parentKecamatan_id = $id;
				$kelurahanSeqNo = 0;
				$kelurahanS = $db->fetch_all_data("bakal_locations",["kelurahan","zipcode"],"propinsi LIKE '$propinsi' AND kabupaten LIKE '$kota' AND kecamatan LIKE '$kecamatan' group by concat(propinsi,kabupaten,kecamatan,kelurahan) order by id");
				foreach($kelurahanS as $_kelurahan){
					$id++;
					$kelurahanSeqNo++;
					$kelurahan = $_kelurahan["kelurahan"];
					$zipcode = $_kelurahan["zipcode"];
					$sql = "INSERT INTO locations (id,parent_id,seqno,name_id,name_en,zipcode) VALUES ($id,$parentKecamatan_id,$kelurahanSeqNo,'$kelurahan','$kelurahan','$zipcode');";
					echo $__tab.$__tab.$__tab.$sql.$__enter;
				}
			}
		}
	}
?>