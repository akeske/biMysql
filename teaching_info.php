
<?php
session_start();
require_once("config/db.php");
require_once("classes/Teaching.php");
$teaching = new Teaching();
if (isset($teaching)) {
    if ($teaching->errors) {
        foreach ($teaching->errors as $error) {
            echo $error;
        }
    }
    if ($teaching->messages) {
        foreach ($teaching->messages as $message) {
            echo $message;
        }
    }
}
if(isset($_GET['tea_id'])){
	$pattern = '/select|union|insert|delete|or/i';
	if(preg_match($pattern, $_GET['tea_id'], $matches, PREG_OFFSET_CAPTURE) &&
		preg_match($pattern, $_GET['id'], $matches, PREG_OFFSET_CAPTURE) ){
		$this->errors[] = "TRY HARDER!!!!";
	}else{
		$tea_id = $_GET['tea_id'];
		$teaching->connect();
		if (!$teaching->db_connection->connect_errno) {
			$sql = "SELECT * FROM teaching
					WHERE teaching_id = '".$_GET['tea_id']."';";
			$result = $teaching->db_connection->query($sql);
			$row = $result->fetch_array();
			$teaching_id = $row['teaching_id'];
			$student_id = $row['student_id'];
			$musician_id = $row['musician_id'];
			$instrument_id = $row['instrument_id'];
			$valid_start = $row['valid_start'];
			$valid_end = $row['valid_end'];
			if($row['valid_start']!=null){
				$parts1 = explode (' ' , $row['valid_start']);
				$parts = explode ('-' , $parts1[0]);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
				$validStart = $day."/".$month."/".$year;
			}
			if($row['valid_end']!=null){
				$parts1 = explode (' ' , $row['valid_end']);
				$parts = explode ('-' , $parts1[0]);
					$day=$parts[2];
					$month=$parts[1];
					$year=$parts[0];
				$validEnd = $day."/".$month."/".$year;
			}
			$result->free(); 
			$teaching->db_connection->close();
		}
	}
}
	$teaching->connect();
	$sql = "SELECT name FROM student WHERE student_id = '".$student_id."';";
	$result = $teaching->db_connection->query($sql);
	if( mysqli_num_rows($result) != 0){
		$row = $result->fetch_array();
		$stu_name = $row['name'];
		$result->free();
	}
	$sql = "SELECT name FROM musician WHERE musician_id = '".$musician_id."';";
	$result = $teaching->db_connection->query($sql);
	if( mysqli_num_rows($result) != 0){
		$row = $result->fetch_array();
		$mus_name = $row['name'];
		$result->free();
	}
	$sql = "SELECT name FROM instrument WHERE instrument_id = '".$instrument_id."';";
	$result = $teaching->db_connection->query($sql);
	if( mysqli_num_rows($result) != 0){
		$row = $result->fetch_array();
		$ins_name = $row['name'];
		$result->free();
	}
	$teaching->db_connection->close();	
?>

<html>
<head>
	<link rel="stylesheet" href="css/buttons.css">
	<link rel="stylesheet" href="css/forms.css">
	<link rel="stylesheet" href="css/tables.css">
	<link rel="stylesheet" href="css/styles.css">

	<link rel="stylesheet" type="text/css" href="css/tcal.css" />
	<script type="text/javascript" src="js/tcal.js"></script>
</head>
<body>

<table id="table2">
<?php
if ($_SESSION['user_type']=="admin" || $_SESSION['user_type']=="secretary") { ?>
<tr>
<td>
	<form method="post" action="teaching_info.php?tea_id=<?php echo $tea_id; ?>" name="editStudentForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Set valid end for teaching</legend>
			<input value="<?php if(isset($_GET['tea_id'])){ echo $tea_id; } ?>" id="tea_id" size="1" type="hidden" autocomplete="off" name="tea_id" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['tea_id'])){ echo $stu_name; } ?>" list="student_names" id="stu_name" size="15" class="login_input" type="text" placeholder="Student name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="stu_name" required maxlength="30"/>
			<input disabled value="<?php if(isset($_GET['tea_id'])){ echo $mus_name; } ?>" list="musician_names" id="mus_name" size="15" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="mus_name" required maxlength="30"/>
			<input disabled value="<?php if(isset($_GET['tea_id'])){ echo $ins_name; } ?>" list="instrument_names" id="ins_name" size="15" class="login_input" type="text" placeholder="Instrument name" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" autocomplete="off" name="ins_name" required maxlength="30"/>
			<input disabled value="<?php if(isset($_GET['tea_id'])){ echo $validStart; } ?>" autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required maxlength="12"/>
			<input value="<?php if(isset($validEnd)){ echo $validEnd; } ?>" autocomplete="off" type="text" name="new_validEnd" class="tcal" id="new_validEnd" size="14" placeholder="Valid end"/>
		</fieldset>

		<p align="right"> <input type="submit" class="pure-button pure-button-primary" name="editTeaching" value="Edit" /> </p>
	</form>
</td>
</tr>
<?php }else{
	echo "You have no authority to be here!!!";
} ?>
</table>

</body>
</html>
