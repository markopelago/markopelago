<?php
    /**************************************************************************
    include "classes/database.php";
    $database = new Database();
    $database->addtable("table1");
    $database->addtable("table2");
    $database->addtable("table3");

    $database->addfield("field1");
    $database->addfield("field2");
    $database->addfield("field3",1);
    $database->addfield("field4",1);
    $database->addfield("field5",2);
    $database->addfield("field6",2);
    $database->addfield("field7",2);

    $database->joiner(0,"id",1,"user_id");
    $database->joiner(0,"education_id",2,"id");

    $database->where("email","warih@karir.com");
    $database->where("gender_id","1",null,null,1);
	
    $database->order("gender_id");
    
    $database->fetch_data();
    $database->insert();
    $database->update();
    $database->delete_();

    **************************************************************************/
    
    class Database {
		protected $lines = array();
		protected $arrconfig = array();
        protected $host   = "";
        protected $user   = "";
        protected $pass   = "";
        protected $dbname = "";
        protected $tables = array();
        protected $fields = array();
        protected $values = array();
        protected $where  = array();
        protected $awhere  = "";
        protected $order  = array();
        protected $limit  = "";
        protected $joiners = array();
        protected $last_query = "";
		protected $db;
		
        public $max_counting = 100000;
		public $searchjob_limit		= 15;
		
		public function __construct(){	
			$this->lines = file($_SERVER["DOCUMENT_ROOT"]."/db_config_markopelago.txt");
			$this->arrconfig = explode("|",$this->lines[0]);
			$this->host   = $this->arrconfig[0];
			$this->user   = $this->arrconfig[1];
			$this->pass   = $this->arrconfig[2];
			$this->dbname = $this->arrconfig[3];
			$this->db = $this->conn();
		
		}

        protected function conn(){
			return mysqli_connect($this->host,$this->user,$this->pass,$this->dbname);
        }

        protected function close(){
			mysqli_close($this->db);
        }

	public function filter_request($request) {
		if (is_array($request))	{
			foreach ($request as $key => $value) {
			  $request[$key] = $this->filter_request($value);
			}
			return $request;
		} else {
			// remove everything except for a-ZA-Z0-9_.-&=
			// $request = preg_replace('/[^a-ZA-Z0-9_\.\-&=]/', '', $request);
			$array1 = array("<script","</script","javascript:","'","database(");
			$array2 = array("","","","`","");
			$request = str_ireplace($array1,$array2,$request);
			return $request;
		}
	}

        protected function field_info($table,$field){
            return $this->fetch_query("select data_type,column_default,is_nullable,extra from information_schema.columns where table_name='$table' and column_name='$field'");
        }

        protected function no_nullable_fields($table,$exceptions){
            foreach($exceptions as $except_field => $none){ $arr_exceptions[] = $except_field; }
            $arr = $this->fetch_query("SELECT column_name FROM information_schema.columns WHERE table_schema = '".$this->dbname."' table_name = '$table' AND is_nullable = 'NO'");
            $_return = array();
            foreach ($arr as $arrfield){
                if(!in_array($arrfield[0],$arr_exceptions)) $_return[] = $arrfield[0];
            }
            return $_return;
        }

        protected function execute($sql){
			//mysqli_select_db($this->dbname,$this->db);
			//mysqli_query($this->db,"INSERT INTO sql_log VALUES (NULL,'".str_replace("'","''",$sql)."','".@$_SESSION["user_id"]."',NOW(),'".$_SERVER["REMOTE_ADDR"]."',NULL)");
            return mysqli_query($this->db,$sql);
        }
		
		protected function in_value($value){
			$arr = explode(",",$value);
			$return = "";
			foreach($arr as $val){ if($val!="") $return .= $val.","; }
			return substr($return,0,-1);
		}

        public function fetch_query($sql,$withindex = false){
			$this->last_query = $sql;
            $hsl = $this->execute($sql);
            if(mysqli_affected_rows($this->db)>0){
                if(mysqli_affected_rows($this->db)>1 || $withindex){
                    $arr = array();
                    while($temp = mysqli_fetch_array($hsl)){ $arr[] = $temp; }
                    return $arr;
                } else {
                    return mysqli_fetch_array($hsl);
                }
            }
            return array();
        }
        
        protected function fetch_data_clear(){
            $this->tables = array();
            $this->fields = array();
            $this->values = array();
            $this->where = array();
            $this->awhere = "";
            $this->order = array();
            $this->limit = "";
            $this->joiners = array();
        }

        public function addtable($table){
            array_push($this->tables,$table);
        }

        public function addfield($field,$tablekey=0){
			if(stripos(" ".$field,"concat(") == 0 && stripos(" ".$field,"count(") == 0){
				$arrfield = explode(",",$field);
				foreach($arrfield as $_field){
					$this->fields[$_field]=$tablekey;
				}
			} else {
				$this->fields[$field]=$tablekey;
			}
        }

        public function addvalue($value){
	    $value = $this->filter_request($value);
            array_push($this->values,$value);
        }

        public function joiner($tablekey1,$field1,$tablekey2,$field2){
            $this->joiners[] = array("tablekey1"=>$tablekey1,"tablekey2"=>$tablekey2,"field1"=>$field1,"field2"=>$field2);
        }

        public function where($field,$value,$datatype = 's',$operator = '=',$tablekey = 0){
            if(!$datatype) $datatype = "s";
            if(!$operator) $operator = "=";
            $this->where[] = array("tablekey"=>$tablekey,"field"=>$field,"value"=>$value,"datatype"=>$datatype,"operator"=>$operator);
        }

        public function awhere($additionalwhere){
			$this->awhere = $additionalwhere;
		}
		
        public function order($field,$tablekey = 0){
            $this->order[] = array("tablekey"=>$tablekey,"field"=>$field);
        }
		
        public function limit($value){
            $this->limit = $value;
        }
		
		public function fetch_single_data($table,$field,$wheres,$orders = array()) {
			$this->addtable($table);
			$this->addfield($field);
			$this->limit(1);
			
			if(count($wheres) > 0) {
				foreach($wheres as $condition => $value) {
					$values = explode(":",$value);
					$this->where(@$condition,@$values[0],"",@$values[1]);
				}
			}
			
			if(count($orders) > 0) {
				foreach($orders as $key => $value) {
					$this->order($value);
				}
			}
			
			return $this->fetch_data(false,0);
		}
		
		public function selected_to_string($table,$id,$field,$values,$separator) {
			$this->addtable($table);
			$this->addfield($field);
			$values = str_replace("||",",",$values); $values = str_replace("|","",$values);
			$this->where($id,$values,"i",'IN');
			$return = "";
			foreach($this->fetch_data(true) as $arrdata){
				$return .= $arrdata[0].$separator;
			}
			return substr($return,0,-1);
			
		}
		
		public function fetch_select_data($table,$id,$field,$wheres = array(),$orders = array(),$limit = "",$startwithnone = false) {
			$this->addtable($table);
			$this->addfield($id);
			$this->addfield($field);
			
			if(count($wheres) > 0 && (is_array($wheres) || is_object($wheres))) {
				foreach($wheres as $condition => $value) {
					$values = explode(":",$value);
					$this->where($condition,$values[0],"",$values[1]);
				}
			}
			
			if(count($orders) > 0 && (is_array($orders) || is_object($orders))) {
				foreach($orders as $key => $value) {
					$this->order($value);
				}
			}
			
			if($limit != "") $this->limit($limit);
			
			$return = array();
			if($startwithnone) $return[""] = "";
			foreach($this->fetch_data(true) as $arrdata){
				$return[$arrdata[0]] = $arrdata[1];
			}
			return $return;
		}
		
		public function get_maxrow($table,$where = ""){
			$this->addtable($table);
			$this->addfield("concat(count(*))");
			if($where != "") $this->awhere($where);$this->limit($this->max_counting);
			return $this->fetch_data()[0];
		}
		
		public function get_last_query(){
			return $this->last_query;
		}
		
		public function fetch_all_data($table,$fields = array(),$where = "",$order="",$limit=""){
			$this->addtable($table);
			if(count($fields) > 0){
				foreach($fields as $field){
					$this->addfield($field);
				}
			}
			if($where != "") $this->awhere($where);
			if($order != "") $this->order($order);
			if($limit != "") $this->limit($limit);
			return $this->fetch_data(true);
		}

        public function fetch_data($withindex = false,$field_index = null){
            $_fields = "";
			if(count($this->fields) > 0){
				foreach ($this->fields as $field => $tablekey){ 
					if(stripos(" ".$field,"concat(") > 0 || stripos(" ".$field,"count(") > 0){
						$_fields .= $field.",";
					} else {
						$_fields .= $this->tables[$tablekey].".`".$field."`,";
					}
				}
				$_fields = substr($_fields,0,-1);
			} else {
				$_fields = " * ";
			}

            foreach($this->joiners as $arr){
                $joinkeys[] = $this->tables[$arr["tablekey1"]].".".$arr["field1"]." = ".$this->tables[$arr["tablekey2"]].".".$arr["field2"];
            }

            foreach ($this->tables as $key => $table){
                if($key == 0) {
                    $_tables = $table;
                } else {
                    $_tables .= " INNER JOIN ".$table." ON ".$joinkeys[$key-1];
                }
            }
            $whereclause = "";
            foreach($this->where as $arr){
                $wherevalue = " ".$arr["operator"]." ";
				if(strtoupper($arr["operator"]) == "IN"){
						$wherevalue .= "(".$this->in_value($arr["value"]).")";
				}else{
					if($arr["datatype"] == 's'){
						$wherevalue .= "'".$arr["value"]."'";
					}else{
						$wherevalue .= $arr["value"];
					}
				}
                $whereclause .= " ".$this->tables[$arr["tablekey"]].".".$arr["field"].$wherevalue." AND";
            }
            if($whereclause) $whereclause = "WHERE ".substr($whereclause,0,-4);
			if($this->awhere != ""){$whereclause = "WHERE ".$this->awhere;}
			
			$orderclause = "";
            foreach($this->order as $arr){
                $orderclause .= $this->tables[$arr["tablekey"]].".".$arr["field"].",";
            }
            if($orderclause) $orderclause = "ORDER BY ".substr($orderclause,0,-1);
			
			if($this->limit != ""){$limit = " LIMIT ".$this->limit;} else {$limit = "";}
			
            $this->fetch_data_clear();
            $return = $this->fetch_query("SELECT $_fields FROM $_tables $whereclause $orderclause $limit",$withindex);
			if(is_null($field_index)){ 
				return $return; 
			} else { 
				if(count($return) > 0) return $return[$field_index]; 
			}
        }

        public function insert(){
            $_table = $this->tables[0];

            $_fields = "";
            foreach($this->fields as $field => $key){ $_fields .= "`".$field."`,"; }
			$nonull_fields = array();
            foreach($this->no_nullable_fields($_table,$this->fields) as $field){ $_fields .= "`".$field."`,"; $nonull_fields[] = $field;}
            $_fields = substr($_fields,0,-1);
			
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'created_at'",true)) > 0 && stripos(" ".$_fields,"created_at") <= 0){
				$_fields .= ",`created_at`"; array_push($this->values,date("Y-m-d H:i:s"));
			}
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'created_by'",true)) > 0 && stripos(" ".$_fields,"created_by") <= 0){
				$_fields .= ",`created_by`"; array_push($this->values,$_SESSION["username"]);
			}
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'created_ip'",true)) > 0 && stripos(" ".$_fields,"created_ip") <= 0){
				$_fields .= ",`created_ip`"; array_push($this->values,$_SERVER["REMOTE_ADDR"]);
			}
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'updated_at'",true)) > 0 && stripos(" ".$_fields,"updated_at") <= 0){
				$_fields .= ",`updated_at`"; array_push($this->values,date("Y-m-d H:i:s"));
			}
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'updated_by'",true)) > 0 && stripos(" ".$_fields,"updated_by") <= 0){
				$_fields .= ",`updated_by`"; array_push($this->values,$_SESSION["username"]);
			}
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'updated_ip'",true)) > 0 && stripos(" ".$_fields,"updated_ip") <= 0){
				$_fields .= ",`updated_ip`"; array_push($this->values,$_SERVER["REMOTE_ADDR"]);
			}

            $_values = "";
            foreach($this->values as $values){ $_values .= "'".$values."',"; }
			foreach($nonull_fields as $field){
                $field_info = $this->field_info($_table,$field);
				if($field_info["extra"] == "auto_increment")              				$_values .= "NULL,";
                else if(!$field_info["column_default"]){
					if(isset($field_info["data_type"])){
						if($field_info["data_type"] == "integer")              				$_values .= "0,";
						else if($field_info["data_type"] == "int")                   		$_values .= "0,";
						else if($field_info["data_type"] == "smallint")                  	$_values .= "0,";
						else if($field_info["data_type"] == "tinyint")                  	$_values .= "0,";
						else if($field_info["data_type"] == "character varying")     		$_values .= "'',";
						else if($field_info["data_type"] == "varchar")         				$_values .= "'',";
						else if(stripos(" ".$field_info["data_type"],"timestamp") > 0)   	$_values .= "NOW(),";
						else if($field_info["data_type"] == "inet")                      	$_values .= "'127.0.0.1',";
						else if($field_info["data_type"] == "boolean")                  	$_values .= "false,";
						else if($field_info["data_type"] == "text")                      	$_values .= "'',";
						else if($field_info["data_type"] == "datetime")                     $_values .= "NOW(),";
						else if($field_info["data_type"] == "date")		                    $_values .= "NOW(),";
						else if($field_info["data_type"] == "time")		                    $_values .= "NOW(),";
						else																$_values .= "'',";
					} else {
																							$_values .= "'',";
					}
                } else {
                    $_values .= $field_info["column_default"].",";
                }

            }
            $_values = substr($_values,0,-1);
			$sql = "INSERT INTO $_table ($_fields) VALUES ($_values)";
            $hsl = $this->execute($sql);
			$arr_return["sql"] = $sql;
			$arr_return["insert_id"] = mysqli_insert_id($this->db);
			$arr_return["affected_rows"] = mysqli_affected_rows($this->db);
			$arr_return["error"] = mysqli_error($this->db);
			$this->fetch_data_clear();
            return $arr_return;
        }

        public function update(){
            $_table = $this->tables[0];

            $_fields = array();
            foreach($this->fields as $field => $key){ $_fields[] = $field; }

            $_values = "";
            foreach($this->values as $key => $values){
                $_values .= $_fields[$key]." = ";
                $field_info = $this->field_info($_table,$_fields[$key]);				
				if(isset($field_info["data_type"])){
					if($field_info["data_type"] == "integer")                   	$_values .= "'$values',";
					else if($field_info["data_type"] == "int")                   	$_values .= "'$values',";
					else if($field_info["data_type"] == "smallint")                 $_values .= "'$values',";
					else if($field_info["data_type"] == "tinyint")                  $_values .= "'$values',";
					else if($field_info["data_type"] == "character varying")        $_values .= "'$values',";
					else if($field_info["data_type"] == "varchar")         			$_values .= "'$values',";
					else if(stripos(" ".$field_info["data_type"],"timestamp") > 0)  $_values .= "'$values',";
					else if($field_info["data_type"] == "inet")                     $_values .= "'$values',";
					else if($field_info["data_type"] == "boolean")                  $_values .= "'$values',";
					else if($field_info["data_type"] == "text")                     $_values .= "'$values',";
					else if($field_info["data_type"] == "datetime")                 $_values .= "'$values',";
					else if($field_info["data_type"] == "date")		                $_values .= "'$values',";
					else if($field_info["data_type"] == "time")		                $_values .= "'$values',";
					else 															$_values .= "'$values',";	
				} else {
																					$_values .= "'$values',";
				}
            }
           
            $_values = substr($_values,0,-1);
			
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'updated_at'",true)) > 0 && stripos(" ".$_values,"updated_at") <= 0) $_values .= ",`updated_at` = '".date("Y-m-d H:i:s")."'";
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'updated_by'",true)) > 0 && stripos(" ".$_values,"updated_by") <= 0) $_values .= ",`updated_by` = '".$_SESSION["username"]."'";
			if(count($this->fetch_query("SHOW COLUMNS FROM $_table WHERE field = 'updated_ip'",true)) > 0 && stripos(" ".$_values,"updated_ip") <= 0) $_values .= ",`updated_ip` = '".$_SERVER["REMOTE_ADDR"]."'";

            $whereclause = "";
            foreach($this->where as $arr){
                $wherevalue = " ".$arr["operator"]." ";
				
				if(strtoupper($arr["operator"]) == "IN"){
						$wherevalue .= "(".$this->in_value($arr["value"]).")";
				}else{
					if($arr["datatype"] == 's'){
						$wherevalue .= "'".$arr["value"]."'";
					}else{
						$wherevalue .= $arr["value"];
					}
				}
				
                $whereclause .= " ".$this->tables[$arr["tablekey"]].".".$arr["field"].$wherevalue." AND";
            }
            if($whereclause) $whereclause = substr($whereclause,0,-4);

            $sql = "UPDATE $_table SET $_values WHERE $whereclause";
			
			$hsl = $this->execute($sql);
			$arr_return["sql"] = $sql;
			$arr_return["affected_rows"] = mysqli_affected_rows($this->db);
			$arr_return["error"] = mysqli_error($this->db);
			$this->fetch_data_clear();
            return $arr_return;
			
        }

        public function delete_(){
            $_table = $this->tables[0];
            $whereclause = "";
            foreach($this->where as $arr){
                $wherevalue = " ".$arr["operator"]." ";
				
				if(strtoupper($arr["operator"]) == "IN"){
						$wherevalue .= "(".$this->in_value($arr["value"]).")";
				}else{
					if($arr["datatype"] == 's'){
						$wherevalue .= "'".$arr["value"]."'";
					}else{
						$wherevalue .= $arr["value"];
					}
				}
				
                $whereclause .= " ".$this->tables[$arr["tablekey"]].".".$arr["field"].$wherevalue." AND";
            }
            if($whereclause) $whereclause = substr($whereclause,0,-4);			
			
			
			$sql = "DELETE FROM $_table WHERE $whereclause";
            $hsl = $this->execute($sql);
			$arr_return["sql"] = $sql;
			$arr_return["affected_rows"] = mysqli_affected_rows($this->db);
			$arr_return["error"] = mysqli_error($this->db);
			$this->fetch_data_clear();
            return $arr_return;
        }

        public function generate_token($id_key){
			$ip = $this->fetch_single_data("tokens","ip",array("ip" => $_SERVER["REMOTE_ADDR"],"id_key" => $id_key));
			$token = "";
			for($i=0 ; $i<40; $i++){ $token .= rand(0,9); }
			$this->addtable("tokens");
			$this->addfield("token");$this->addvalue($token);
			if($ip == "" || !isset($ip)){
				$this->addfield("id_key");$this->addvalue($id_key);
				$this->addfield("ip");$this->addvalue($_SERVER["REMOTE_ADDR"]);
				$this->insert();
			} else {
				$this->where("ip",$_SERVER["REMOTE_ADDR"]);
				$this->where("id_key",$id_key);
				$this->update();
			}
			return $token;
		}
    }
?>
