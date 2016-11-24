<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>FTP 下载</title>
</head>
<body>
	<h1>镜像更新</h1>
	<?php
		
		// set up variables -- change these to suit application
		$host =  "210.34.246.224";
		$user = "teacher";
		$password = "22693529";
		$remotefile = "/teach/cxg/Office2013.pdf";
		$localfile = "./tmp/Office2013.pdf";

		// connect to host
		$conn = ftp_connect($host);
		if (!$conn){
			echo 'Error: Could not connect to ftp server<br />';
			exit;
		}
		echo "Connected to $host.<br />";

		// log in to host
		$result = @ftp_login($conn, $user, $password);
		if (!$result) {
			echo "Error: Could not log on as $user<br />";
			ftp_quit($conn);
			exit;
		}
		echo "Logged in as $user<br />";

		// check file times to see if an update is required
		echo 'Checking file time...<br />';
		if (file_exists($localfile)){
			$localtime = filemtime($localfile);
			echo 'Local file last updated ';
			echo date('G:i j-M-Y', $localtime);
			echo '<br />';
		} else {
			echo "Local file does not exist. <br />";
			$localtime = 0;
		}

		$remotetime = ftp_mdtm($conn, $remotefile);
		if( !($remotetime >= 0) ){
			//server my not support mod time
			echo 'Can\'t access remote file time.<br />';
			$remotetime = $localtime + 1; // make sure of an update
		} else {
			echo 'Remote file last updated ';
			echo date('G:i j-M-Y', $remotetime);
			echo '<br />';
		}

		if (!($remotetime > $localtime)){
			echo 'Local copy is up to date.<br />';
			exit;
		} 

		// download file
		echo 'Getting file from server...<br />';
		$fp = fopen($localfile, 'w');
		if(!$success = ftp_fget($conn, $fp, $remotefile, FTP_BINARY) ){
			echo 'Error: Could not download file';
			ftp_quit($conn);
			exit;
		}
		fclose($fp);
		echo 'File downloaded successfully';

		// close connection to host
		ftp_quit($conn);
	?>
</body>
</html>