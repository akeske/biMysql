
<?php

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

function displayDate($date){
$parts1 = explode (' ' , $date);
$parts = explode ('-' , $parts1[0]);
	$day=$parts[2];
	$month=$parts[1];
	$year=$parts[0];
return $day."/".$month."/".$year;
}
?>

<table id="table2">
<tr>
<td>
	<form method="post" action="index.php" name="insertMucisianForm" class="pure-form">
		<fieldset id="fieldset">
		<legend>Insert new musician</legend>
			<input id="name" size="15" class="login_input" type="text" placeholder="Musician name" pattern="[a-zA-Z0-9]{2,64}" autocomplete="on" name="name" required />
			<input id="telephone" size="8" class="login_input" type="text" name="telephone" required autocomplete="on" placeholder="Telephone" required />
			<input autocomplete="off" type="text" name="validStart" class="tcal" id="validStart" size="14" placeholder="Valid start" required/>
			<input autocomplete="off" type="text" name="validEnd" class="tcal" id="validEnd" size="14" placeholder="Valid end"/>
			<input type="submit" class="pure-button pure-button-primary" name="insertMusician" value="Insert" />
		</fieldset>
	</form>

	<form method="post" action="index.php" name="musicialSqlForm" class="pure-form">
		<fieldset id="fieldset">
			<legend>Your SQL command</legend>
			Table name: musician
			<br>
			Fields: id , musician_id , name, telephone , valid_start , valid_end , trans_start , trans_end
			<br>
			<input id="musicianSql" name="musicianSql" type="text" placeHolder="Please insert your desirable SQL script" class="login_input" size="60"/>
			<input type="submit" class="pure-button pure-button-primary" name="musicianSqlSubmit" value="Exec" />
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
				<th>Valid&nbsp;Start</th>
				<th>Valid&nbsp;End</th>
				<th>Trans&nbsp;Start</th>
				<th>Trans&nbsp;End</th>
				<th>Edit</th>
			</tr>
			<?php
			$musician->connect();
			if (!$musician->db_connection->connect_errno) {
				if(isset($_POST['musicianSqlSubmit']) && $_POST['musicianSql']!=null){
					$sql = $_POST['musicianSql'];
				}else{
					$sql = "SELECT * FROM musician
							ORDER BY name, valid_start, trans_end";
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
						<td><?php
 echo displayDate($row['valid_start']); ?></td>
						<td><?php echo displayDate($row['valid_end']); ?></td>
						<td><?php echo $row['trans_start']; ?></td>
						<td><?php echo $row['trans_end']; ?></td> 
						<?php if($row['valid_end']==null){ ?>
						<td><a class="fancybox fancybox.iframe" href="views/mucisian_info.php?id=<?php echo $row['id']; ?>">Edit</a></td>
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

