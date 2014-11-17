
<?php
session_start();
require_once("config/db.php");
require_once("classes/Musician.php");
$musician = new Musician();
if (isset($musician)) {
    if ($musician->errors) {
        foreach ($musician->errors as $error) {
            echo $error;
        }
    }
    if ($musician->messages) {
        foreach ($musician->messages as $message) {
            echo $message;
        }
    }
}
if(isset($_GET['id'])){
	$mus_id = $_GET['mus_id'];
	$id = $_GET['id'];
	$musician->connect();
	if (!$musician->db_connection->connect_errno) {
		$sql = "SELECT * FROM musician
				WHERE id = '".$_GET['id']."';";
		$result = $musician->db_connection->query($sql);
		$row = $result->fetch_array();
		$id_musician = $row['musician_id'];
		$name = $row['name'];
		$telephone = $row['telephone'];
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
		$musician->db_connection->close();
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
	<form method="post" action="musician_info.php?id=<?php echo $row['id']; ?>&mus_id=<?php echo $row['musician_id']; ?>" name="editMucisianForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Set valid end for musician</legend>
			<input value="<?php if(isset($_GET['id'])){ echo $mus_id; } ?>" id="mus_id" size="1" type="hidden" autocomplete="off" name="mus_id" maxlength="12"/>
			<input value="<?php if(isset($_GET['id'])){ echo $id; } ?>" id="id" size="1" type="hidden" autocomplete="off" name="id" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $mus_id; } ?>" size="1" type="text" autocomplete="off" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $name; } ?>" size="14" type="text" autocomplete="off" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $telephone; } ?>" size="14" type="text" autocomplete="off" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $validStart; } ?>" autocomplete="off" type="text" class="tcal" size="14" placeholder="Valid start" maxlength="12"/>
			<input value="<?php if(isset($validEnd)){ echo $validEnd; } ?>" autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end"/>
		</fieldset>

		<fieldset id="fieldset">
		<legend>Insert new info about musician</legend>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $mus_id; } ?>" size="1" type="text" autocomplete="off" maxlength="12"/>
			<input disabled value="<?php if(isset($_GET['id'])){ echo $name; } ?>" size="14" type="text" autocomplete="off" maxlength="12"/>
			<input value="" id="new_telephone" size="14" type="text" name="new_telephone" autocomplete="off" placeholder="New Telephone" maxlength="12"/>
			<input value="" autocomplete="off" type="text" name="new_validStart" class="tcal" id="new_validStart" size="14" placeholder="Valid start" maxlength="12"/>
			<input value="" autocomplete="off" type="text" name="new_validEnd" class="tcal" id="new_validEnd" size="14" placeholder="Valid end" maxlength="12"/>
		</fieldset>
		<p align="right"> <input type="submit" class="pure-button pure-button-primary" name="editMusician" value="Edit / Insert" /> </p>
	</form>

	<form method="post" action="musician_info.php?id=<?php echo $row['id']; ?>&mus_id=<?php echo $row['musician_id']; ?>&find=1" name="findMucisianForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Find telephone number</legend>
			<input autocomplete="off" type="text" name="findDateMusician" class="tcal" id="findDateMusician" size="30" placeholder="Date" maxlength="12"/>
			<input type="submit" class="pure-button pure-button-primary" name="findMusician" value="Find" />
		</fieldset>
	</form>

	<form method="post" action="" onClick="window.location.reload()">
		<p align="right"> <input type="button" value="Refresh page" class="pure-button pure-button-primary"> </p>
	</form>
	
	<fieldset id="fieldset">
		<legend>Results of musician</legend>
		<div>
		<table id="table1">
			<tr>
				<th>ID</th>
				<th>ID&nbsp;musician</th>
				<th>Name</th>
				<th>Telephone</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
			</tr>
			<?php
			$musician->connect();
			if (!$musician->db_connection->connect_errno) {
				if ($_SESSION['user_type']=="admin") {
					$sql = "SELECT * FROM musician
							WHERE musician_id = '".$mus_id."'
							HAVING read_level LIKE '%admin%'
							ORDER BY valid_start, trans_end DESC";
				}elseif ($_SESSION['user_type']=="student") {
					$sql = "SELECT * FROM musician
							WHERE musician_id = '".$mus_id."'
							HAVING read_level LIKE '%student%'
							ORDER BY valid_start, trans_end DESC";
				}else{
					$sql = "SELECT * FROM musician
							WHERE musician_id = '".$mus_id."'
							HAVING read_level LIKE '%secretary%'
							ORDER BY valid_start, trans_end DESC";
				}
				if(isset($_GET['find']) && $_POST['findDateMusician']!=""){
					$sql = $musician->findMucisianForm();
				}
				echo $sql;
				$result = $musician->db_connection->query($sql);
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
						<td><?php echo $row['musician_id']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['telephone']; ?></td>
						<td><?php echo $musician->displayDate($row['valid_start'], "valid"); ?></td>
						<td><?php echo $musician->displayDate($row['valid_end'], "valid"); ?></td>
						<td><?php echo $musician->displayDate($row['trans_start'], "trans"); ?></td>
						<td><?php echo $musician->displayDate($row['trans_end'], "trans"); ?></td> 
					</tr>
			<?php }
				$result->free();
				$musician->db_connection->close();
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
