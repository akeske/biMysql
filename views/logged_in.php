<!-- if you need user information, just put them into the $_SESSION variable and output them here -->
Hey, <b><?php echo $_SESSION['user_name']; ?></b>. <br>
Your privileges is <b><?php echo $_SESSION['user_type']; ?></b>.<br><br>

<!-- because people were asking: "index.php?logout" is just my simplified form of "index.php?logout=true" -->
<a href="index.php?logout">Logout</a>
