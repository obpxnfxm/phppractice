<?php
    session_start();

    	if( isset($_POST['userid']) && isset($_POST['password']) )
    	{
    		// if the user has just tried to log in
    		$userid = $_POST['userid'];
    		$password = $_POST['password'];
    		$password_md5 = md5($password);

    		$db_conn = new mysqli('localhost', 'leo', '402', 'webuser');

    		if(mysqli_connect_errno()){
    			echo 'Connection to database failed:'.mysqli_connect_error();
    			exit();
    		}

    		$query = "select id from auth_users ".
    		         "where user='$userid' ".
    		         "and password='$password_md5'";
    		//print_r($query);
    		$result = $db_conn->query($query);
    		if ($result->num_rows){
    			// if they are in the database register the user_id
    			$_SESSION['valid_user'] = $userid;
    		}
    		$db_conn->close();
    	}
    ?>

<html>
<body>
    <h1>Home Page</h1>
    <?php
    	if(isset($_SESSION['valid_user']))
    	{
    		echo 'You are logged in as '.$_SESSION['valid_user'].'<br />';
    		echo '<a href="logout.php">Log out</a><br />';
    	} else {
    		if(isset($userid)){
    			// if they've tried and failed to log in
    			echo 'Could not log you in.<br />';
    		} else {
    			// they have not tried to log in yet or have logged out
    			echo 'You are not logged in.<br />';
    		}

    		// provide form to log in
    		echo '<form method="post" action="authmain.php">';
    		echo '<table>';
    		echo '<tr><td>Userid:</td>';
    		echo '<td><input type="text" name="userid" /></td></tr>';
    		echo '<tr><td>Password:</td>';
    		echo '<td><input type="password" name="password" /></td></tr>';
    		echo '<tr><td colspan="2" align="center"><input type="submit" value="Log in" /></td></tr>';
    		echo '</table></form>';
    	}
    ?>
    <br />
    <a href="members_only.php">Members section</a>
</body>
</html>