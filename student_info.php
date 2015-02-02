
<?php
session_start();
require_once("config/db.php");
require_once("classes/Student.php");
$student = new Student();
if (isset($student)) {
    if ($student->errors) {
        foreach ($student->errors as $error) {
            echo $error;
        }
    }
    if ($student->messages) {
        foreach ($student->messages as $message) {
            echo $message;
        }
    }
}
if(isset($_GET['id'])){
	$pattern = '/select|union|insert|delete|or/i';
	if(preg_match($pattern, $_GET['stu_id'], $matches, PREG_OFFSET_CAPTURE) ||
		preg_match($pattern, $_GET['id'], $matches, PREG_OFFSET_CAPTURE) ){
		$this->errors[] = "TRY HARDER!!!!";
	}else{
		$stu_id = $_GET['stu_id'];
		$id = $_GET['id'];
		$student->connect();
		if (!$student->db_connection->connect_errno) {
			$sql = "SELECT * FROM student
					WHERE id = '".$_GET['id']."';";
			$result = $student->db_connection->query($sql);
			$row = $result->fetch_array();
			$name = $row['name'];
			$address = $row['address'];
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
			$student->db_connection->close();
		}
	}
}

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
	<form method="post" action="student_info.php?id=<?php echo $row['id']; ?>&stu_id=<?php echo $stu_id; ?>" name="editStudentForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Set valid end for student</legend>
			<input value="<?php if(isset($_GET['id'])){ echo $stu_id; } ?>" id="stu_id" size="1" type="hidden" autocomplete="off" name="stu_id" maxlength="12"/>
			<input value="<?php if(isset($_GET['id'])){ echo $id; } ?>" id="id" size="1" type="hidden" autocomplete="off" name="id" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $stu_id; } ?>" size="1" type="text" autocomplete="off" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $name; } ?>" size="14" type="text" autocomplete="off" maxlength="30"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $address; } ?>" size="14" type="text" autocomplete="off" maxlength="30"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $validStart; } ?>" autocomplete="off" type="text" class="tcal" size="14" placeholder="Valid start" maxlength="12"/>
			<input autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end"/>
		</fieldset>

		<fieldset id="fieldset">
		<legend>Insert new info about student</legend>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $stu_id; } ?>" size="1" type="text" autocomplete="off" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $name; } ?>" size="14" type="text" autocomplete="off" maxlength="12"/>
			<input value="" id="new_address" size="14" type="text" pattern="[a-zA-Z0-9\s\u00a1-\uffff]{2,30}" name="new_address" autocomplete="off" placeholder="New address" maxlength="12"/>
			<input value="" autocomplete="off" type="text" name="new_validStart" class="tcal" id="new_validStart" size="14" placeholder="Valid start" maxlength="12"/>
			<input value="" autocomplete="off" type="text" name="new_validEnd" class="tcal" id="new_validEnd" size="14" placeholder="Valid end" maxlength="12"/>
		</fieldset>
		<p align="right"> <input type="submit" class="pure-button pure-button-primary" name="editStudent" value="Edit / Insert" /> </p>
	</form>

	<form method="post" action="student_info.php?id=<?php echo $row['id']; ?>&stu_id=<?php echo $stu_id; ?>&find=1" name="findStudentForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Find address</legend>
			<input autocomplete="off" type="text" name="findDateStudent" class="tcal" id="findDateStudent" size="30" placeholder="Date" maxlength="12"/>
			<input type="submit" class="pure-button pure-button-primary" name="findStudent" value="Find" />
		</fieldset>
	</form>

	<form method="post" action="" onClick="window.location.reload()">
		<p align="right"> <input type="button" value="Refresh page" class="pure-button pure-button-primary"> </p>
	</form>
	
	<fieldset id="fieldset">
		<legend>Results of student</legend>
		<div>
		<table id="table1">
			<tr>
				<th>ID</th>
				<th>ID&nbsp;student</th>
				<th>Name</th>
				<th>Address</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
			</tr>
			<?php
			$student->connect();
			if (!$student->db_connection->connect_errno) {
				if ($_SESSION['user_type']=="admin") {
					$sql = "SELECT * FROM student
							WHERE student_id = '".$stu_id."'
							HAVING read_level LIKE '%admin%'
							ORDER BY valid_start, trans_end DESC";
				}elseif ($_SESSION['user_type']=="student") {
					$sql = "SELECT * FROM student
							WHERE student_id = '".$stu_id."'
							HAVING read_level LIKE '%student%'
							ORDER BY valid_start, trans_end DESC";
				}else{
					$sql = "SELECT * FROM student
							WHERE student_id = '".$stu_id."'
							HAVING read_level LIKE '%secretary%'
							ORDER BY valid_start, trans_end DESC";
				}
				if(isset($_GET['find']) && $_POST['findDateStudent']!=""){
					$sql = $student->findStudentForm();
				}
				echo $sql;
				$result = $student->db_connection->query($sql);
				$even = 0;
				while( $row = $result->fetch_array() ){
					if($row['valid_end']==null && $row['trans_end']==null){
						$style = "\"font-weight:bold; color:rgb(0, 120, 231);\"";
					}else{
						$style = "";
					}
					if($even==0){ ?>
						<tr style=<?php echo $style; ?>>
					<?php	$even=1;
					}else{ ?>
						<tr class="even" style=<?php echo $style; ?>>
					<?php	$even=0;
					}?>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['student_id']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['address']; ?></td>
						<td><?php echo $student->displayDateStudent($row['valid_start'], "valid"); ?></td>
						<td><?php echo $student->displayDateStudent($row['valid_end'], "valid"); ?></td>
						<td><?php echo $student->displayDateStudent($row['trans_start'], "trans"); ?></td>
						<td><?php echo $student->displayDateStudent($row['trans_end'], "trans"); ?></td> 
					</tr>
			<?php }
				$result->free();
				$student->db_connection->close();
			}else{
			} ?>
		</table>
		
		</div>
	</fieldset>
</td>
</tr>
<?php }else{
	echo "You have no authority to be here!!!";
} ?>
</table>

</body>
</html>
