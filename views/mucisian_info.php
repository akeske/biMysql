
<?php

require_once("classes/Musician.php");
	$musician = new Musician();
echo "fsd";
if(isset($_GET['id'])){
	$musician->connect();
	if (!$musician->db_connection->connect_errno) {
		$sql = "SELECT * FROM musician
				WHERE id = '".$_GET['id']."';";
		$result = $musician->db_connection->query($sql);
		$row = $result->fetch_array();
		$id_musician = $row['id_musician'];
		$name = $row['name'];
		$telephone = $row['telephone'];
		$salary = $row['salary'];
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
		
	<link rel="stylesheet" type="text/css" href="css/tcal.css" />
	<script type="text/javascript" src="js/tcal.js"></script>
</head>
<body>

<table id="table2" border="0">
<tr>
<td>
	<form method="post" action="mucisian_info.php" name="editMucisianForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Edit musician</legend>
			<input value="<?php if(isset($_GET['id'])){ echo $name; } ?>" id="name" size="15" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9]{2,64}" autocomplete="on" name="name" required />
			<input value="<?php if(isset($_GET['id'])){ echo $telephone; } ?>" id="telephone" size="8" class="login_input" type="text" name="telephone" required autocomplete="on" placeholder="Telephone" required />
			<input value="<?php if(isset($_GET['id'])){ echo $validStart; } ?>" autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required/>
			<input value="<?php if(isset($validEnd)){ echo $validEnd; } ?>" autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end"/>
			<input type="submit" class="pure-button pure-button-primary" name="editMucisian" value="Edit" />
		</fieldset>
	</form>
	
	<fieldset id="fieldset">
		<legend>Activity of mucisian</legend>
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
				<th>Edit</th>
			</tr>
			<?php
			$musician->connect();
			if (!$musician->db_connection->connect_errno) {
				if(isset($_POST['musicianSqlSubmit']) && $_POST['nusicialSql']!=null){
					$sql = $_POST['nusicialSql'];
				}else{
					$sql = "SELECT * FROM musician
							ORDER BY id, musician_id, valid_start;";
				}
				echo $sql;
				$result = $musician->db_connection->query($sql);
				$even = 0;
				while($row = $result->fetch_array() ){
					if($even==0){ ?>
						<tr>
					<?php	$even=1;
					}else{ ?>
						<tr class="even">
					<?php	$even=0;
					}?>
						<td><?php echo $row['id']; ?></td>
						<td><?php echo $row['musician_id']; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['telephone']; ?></td>
						<td><?php echo $row['valid_start']; ?></td>
						<td><?php echo $row['valid_end']; ?></td>
						<td><?php echo $row['trans_start']; ?></td>
						<td><?php echo $row['trans_end']; ?></td> 
						<?php if($row['trans_end']==null){ ?>
						<td><a id="edit" href="views\mucisian_info.php?id=<?php echo $row['id']; ?>">Edit</a></td>
						<?php } ?>
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
</table>

</body>
</html>
