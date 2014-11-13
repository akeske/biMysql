
<?php
require_once("./classes/Musician.php");
$musician = new Musician();
$musician->connect();

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
	$musician->connect();
	if (!$musician->db_connection->connect_errno) {
		$sql = "SELECT * FROM musician
				WHERE id = '".$_GET['id']."';";
		$result = $musician->db_connection->query($sql);
		$row = $result->fetch_array();
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

<table id="table2" border="1">
<tr>
<td>
	<form method="post" action="index.php" name="registerform" class="pure-form">
		<fieldset id="fieldset">
		<legend>Insert / Edit musician</legend>
			<input text="text" id="id" class="id" size="2" value="<?php if(isset($_GET['id'])){ echo $_GET['id']; } ?>" />
			<input value="<?php if(isset($_GET['id'])){ echo $name; } ?>" id="name" size="15" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9]{2,64}" name="name" required />
			<input value="<?php if(isset($_GET['id'])){ echo $telephone; } ?>" id="telephone" size="8" class="login_input" type="text" name="telephone" required autocomplete="off" placeholder="Telephone" required />
			<input value="<?php if(isset($_GET['id'])){ echo $salary; } ?>" id="salary" size="8" class="login_input" type="text" name="salary" autocomplete="off" placeholder="Salary" required />
			<input value="<?php if(isset($_GET['id'])){ echo $validStart; } ?>" autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required/>
			<input value="<?php if(isset($validEnd)){ echo $validEnd; } ?>" autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end" required/>
			<input type="submit" class="pure-button pure-button-primary" name="insertMusician" value="Insert / Edit" />
		</fieldset>
	</form>

	<form method="post" action="index.php" name="musicialSqlForm" class="pure-form">
		<fieldset id="fieldset">
			<legend>Your SQL command</legend>
			Table name: musician
			<br>
			Fields: id , musician_id , name, telephone , valid_start , valid_end , trans_start , trans_end
			<br>
			<input id="musicianSql" name="nysicialSql" type="text" placeHolder="Please insert your desirable SQL script" class="login_input" size="100"/>
			<input type="submit" class="pure-button pure-button-primary" name="musicianSqlSubmit" value="Insert" />
		</fieldset>
	</form>
	
	<fieldset id="fieldset">
		<legend>List of musicians</legend>
		<div>
		<table id="table1">
			<tr>
				<th>ID</th>
				<th>ID&nbsp;musician</th>
				<th>Name</th>
				<th>Telephone</th>
				<th>Salary</th>
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
				<th>Edit</th>
			</tr>
			<?php
			$musician->connect();
			if (!$musician->db_connection->connect_errno) {
				if(isset($_POST['musicianSqlSubmit']) && $_POST['nysicialSql']!=null){
					$sql = $_POST['nysicialSql'];
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
						<td><?php echo $row['salary']; ?></td>
						<td><?php echo $row['valid_start']; ?></td>
						<td><?php echo $row['valid_end']; ?></td>
						<td><?php echo $row['trans_start']; ?></td>
						<td><?php echo $row['trans_end']; ?></td> 
						<?php if($row['trans_end']==null){ ?>
						<td><a href="index.php?id=<?php echo $row['id']; ?>">Edit</a></td>
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