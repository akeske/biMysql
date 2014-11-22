<?php

class Instrument{

    public $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct(){
        if (isset($_POST["deleteInstrument"])) {
            $this->deleteInstrument();
        }
        if (isset($_POST["insertInstrument"])) {
            $this->insertInstrument();
        }
    }
		
    public function connect(){
		$this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if (!$this->db_connection->set_charset("utf8")) {
			$this->errors[] = $this->db_connection->error;
		}
	}

    private function deleteInstrument(){
    	if (empty($_POST['id_ins'])) {
    		$this->errors[] = "There are missing a lot information.";
		} else {
			$this->connect();
			if (!$this->db_connection->connect_errno) {
				$id_ins = $this->db_connection->real_escape_string(strip_tags($_POST['id_ins'], ENT_QUOTES));
				$name_ins = $this->db_connection->real_escape_string(strip_tags($_POST['name_ins'], ENT_QUOTES));

				$sql = "UPDATE instrument
						SET trans_end = CURRENT_TIMESTAMP
						WHERE instrument_id = '".$id_ins."'";
				$this->db_connection->query($sql);
				
				$sql = "INSERT INTO audit
					(id, user_id, table_name, query, trans_time) VALUES
					(NULL, '".$_SESSION['user_id']."', 'instrument', 'deleted instrument: ".$name_ins."', CURRENT_TIMESTAMP);";
				$this->db_connection->query($sql);

				$this->db_connection->close();
			} else {
                $this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
            }
		}
	}
	
    private function insertInstrument(){
        if (empty($_POST['ins_name'])) {
            $this->errors[] = "Some fields are empty.";
        } else {
			$this->connect();
			if (!$this->db_connection->connect_errno) {
	
				$ins_name = $this->db_connection->real_escape_string($_POST['ins_name']);

				$sql = "INSERT INTO instrument
						(instrument_id, name, trans_start, trans_end) VALUES
						(NULL, '".$ins_name."', CURRENT_TIMESTAMP, NULL);";
				$result_insert_instrument = $this->db_connection->query($sql);
					
				if ($result_insert_instrument) {
					$this->messages[] = "New instrument has id: " . $this->db_connection->insert_id;
				}else{
					$this->errors[] =  "Error: " . $sql . "<br>" . mysqli_error($this->db_connection);
				}

				$sql = "INSERT INTO audit
					(id, user_id, table_name, query, trans_time) VALUES
					(NULL, '".$_SESSION['user_id']."', 'instrument', 'insert new instrument: ".$ins_name."', CURRENT_TIMESTAMP);";
				$this->db_connection->query($sql);
					
				$this->db_connection->close();
            } else {
                $this->errors[] = "Database connection problem: ".$this->db_connection->connect_error;
            }
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
