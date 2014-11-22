<?php

class Audit{

    public $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct(){
    }
		
    public function connect(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->set_charset("utf8")) {
			$this->errors[] = $this->db_connection->error;
		}
	}

    public function displayDate($date, $type){
		if($date!=""){
			if($type=="valid"){
				$parts1 = explode (' ' , $date);
				$parts = explode ('-' , $parts1[0]);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
				return $day."/".$month."/".$year;
			}else{
				$parts1 = explode (' ' , $date);
				$parts = explode ('-' , $parts1[0]);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
				$parts = explode (':' , $parts1[1]);
					$sec=$parts[2];
					$min=$parts[1];
					$hour=$parts[0];
				return $day."/".$month."/".$year."&nbsp;".$hour.":".$min.":".$sec;
			}
		}
	}
}
