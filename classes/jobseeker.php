<?php    
    class JobSeeker extends Database {
		
        public function is_applied($user_id,$job_id){
			$this->addtable("applied_jobs");
			$this->addfield("user_id");
			$this->where("user_id",$user_id);
			$this->where("job_id",$job_id);
			$this->limit(1);
			return count($this->fetch_data());
		}
		
        public function apply_job($user_id,$job_id){
			if($this->is_applied($user_id,$job_id) <= 0){
				if($user_id > 0){
					$applier_role = $this->fetch_single_data("a_users","role",["id" => $user_id]);
					if($applier_role == 3 || $applier_role == 5){
						$job_giver_user_id = $this->fetch_single_data("jobs","job_giver_user_id",["id" => $job_id]);
						$this->addtable("applied_jobs");
						$this->addfield("user_id");			$this->addvalue($user_id);
						$this->addfield("job_id");			$this->addvalue($job_id);
						$this->addfield("job_giver_user_id");$this->addvalue($job_giver_user_id);
						$inserting = $this->insert();
						// if($inserting["affected_rows"] > 0) $this->email_notification($user_id,$job_id);
						return $inserting["affected_rows"];
					}else{
						return "error:user_not_model";
					}
				}else{
					return "error:user_not_exist";
				}
			}else{
				return "error:already_applied";
			}
		}
		
		public function get_role($user_id){
			return $this->fetch_single_data("a_users","role",["id" => $user_id]);
		}

		public function get_fullname($user_id){
			if($this->get_role($user_id) == "2"){ $tableName = "personal_profiles";	$fieldName = "name"; }
			if($this->get_role($user_id) == "3"){ $tableName = "agency_profiles";	$fieldName = "name"; }
			if($this->get_role($user_id) == "4"){ $tableName = "corporate_profiles";$fieldName = "name"; }
			if($this->get_role($user_id) == "5"){ $tableName = "model_profiles";	$fieldName = "concat(first_name,' ',middle_name,' ',last_name) as name"; }
			return $this->fetch_single_data($tableName,$fieldName,["user_id" => $user_id]);
		}
		
		public function already_send_join_offer($agency_user_id,$model_user_id){
			return $this->fetch_single_data("agency_models","id",["model_user_id" => $model_user_id,"agency_user_id" => $agency_user_id]);
		}
		
		public function isModelJoinedAgency($model_user_id){
			return $this->fetch_single_data("agency_models","agency_user_id",["model_user_id" => $model_user_id,"join_status" => "2"]);
		}
    }
?>
