<?php    
    class Rajaongkir {
		protected $api	= "";
		protected $url	= "";
		
		public function __construct(){
			$this->api = "2d6f75f04f060ebf03bdd3bfb77537bc";
			$this->url = "https://pro.rajaongkir.com/api/";
		}
		
		public function provinces(){
			$curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt_array($curl, 
				[
					CURLOPT_URL => $this->url."province",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => ["key: ".$this->api]
				]
			);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
            echo $err;
			if ($err) {
				return json_decode($err, true)["rajaongkir"];
			} else {
				return json_decode($response, true)["rajaongkir"];
			}
		}
		
		public function cities($province_id){
			$curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt_array($curl, 
				[
					CURLOPT_URL => $this->url."city?province=".$province_id,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "GET",
					CURLOPT_HTTPHEADER => ["key: ".$this->api]
				]
			);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				return json_decode($err, true)["rajaongkir"];
			} else {
				return json_decode($response, true)["rajaongkir"];
			}
		}
		
		public function cost($origin,$destination,$weight,$courier){
			//origin=501&originType=city&destination=574&destinationType=subdistrict&weight=1700&courier=jne
			$curl = curl_init();
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt_array($curl,
				[
					CURLOPT_URL => $this->url."cost",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => "",
					CURLOPT_MAXREDIRS => 10,
					CURLOPT_TIMEOUT => 30,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => "POST",
					CURLOPT_POSTFIELDS => "origin=".$origin."&destination=".$destination."&weight=".$weight."&courier=".$courier."&originType=city&destinationType=subdistrict",
					CURLOPT_HTTPHEADER => ["content-type: application/x-www-form-urlencoded","key: ".$this->api]
				]
			);
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				return json_decode($err, true)["rajaongkir"];
			} else {
				return json_decode($response, true)["rajaongkir"];
			}
		}
		
		public function location_id($province,$postal_code="",$city=""){
			$arr = $this->provinces()["results"];
			$province_id = 0;
			foreach($arr as $data){
				if(stripos(" ".$data["province"],$province) > 0){
					$province_id = $data["province_id"];
					break;
				}
			}
			if($province_id > 0){
				$arr = $this->cities($province_id)["results"];
				foreach($arr as $data){
					if($postal_code != ""){
						if($data["postal_code"] == $postal_code){
							return $data["city_id"];
						}
					}
					if($city != ""){
						if(stripos(" ".$data["city_name"],$city) > 0){
							return $data["city_id"];
						}
					}
				}
			}
			return 0;
		}
    }
?>
