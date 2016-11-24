<?php
session_start();
echo <<<theEnd
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="../css/main.css" />
	<title>项目列表</title>
</head>	
<body>
theEnd;

	if(!$_SESSION['valid_user']){
		echo "<p>您尚未登录，无权访问此页！</p>";
		echo "<p>3 秒后自动跳转</p>";
		echo '<script type="text/javascript">setTimeout("window.location.href=\"index.php\"",3000);</script>';
		echo '</body></html>';
	} else {
		echo <<<theEnd
		<h1>Leo's Project</h1>
		<div align="center">(项目地址：<a href="https://github.com/obpxnfxm/phppractice">https://github.com/obpxnfxm/phppractice</a>)</div>
		<div class="projadd">
			<a href="addform.php">添加项目 | </a>
			<a href="index.php">返回后台主页 | </a>
			<a href="logout.php">退出</a>
		</div>
		<table class="projadmintbl">
			<tr>
				<th class="projadminno">编号</th>
				<th class="projadminname">项目名称</th>
				<th class="projadminintro" >简介</th>
				<th class="projadminfiles">项目文件</th>
				<th class="projadminaddtime">添加时间</th>
				<th class="projadminmodtime">最后修改</th>
				<th class="projadminop">操作</th>
			</tr>
theEnd;
			$dsn = "mysql:dbname=webuser;host=localhost;charset=utf8";
			$user = "leo";
			$password = "402";

			try{
				$dbh = new PDO($dsn, $user, $password);
			} catch (PDOException $e) {
				echo "Connection failed: ". $e->getMessage();
				exit;
			}

			$query = "select id, name, intro, time, mtime from project order by time desc";
					// $result = $dbh->query($query);
					// $count = $result->rowCount();
					// var_dump($result);
			$no=1;
			$rowcolor = array('rowcolor0', 'rowcolor1');
			$result=$dbh->query($query);
			$data = $result->fetchAll();
			foreach ( $data as $row){
				$name = stripslashes($row['name']);
						//$name = htmlentities($name_d);
				$intro = nl2br(stripslashes($row['intro']));
				$time = date("Y-m-d", $row['time'])."<br />".date("H:i:s", $row['time']);
				$mtime = date("Y-m-d", $row['mtime'])."<br />".date("H:i:s", $row['mtime']);
				$strid = sprintf("%03d",count($data) - $no + 1);

						// get files in project
				$projectpath = "../projects/".$name;

						//若不是目录，超链接为空	
				if(!is_dir($projectpath)){
					$projectpath="#";
					$projectfiles="错误：项目不存在!!!";
				} else {
					$projectfiles = getprojectfiles($projectpath);
				}

				echo "<tr class=\"".$rowcolor[$no++%2]."\">\n";
				echo "<td>".$strid."</td>\n";
				echo "<td><a href=\"".$projectpath."\">".$name."</a></td>\n";
				echo "<td class=\"alignleft\">".$intro."</td>\n";
				echo "<td class=\"alignleft\">".$projectfiles."</td>\n";
				echo "<td>".$time."</td>\n";
				echo "<td>".$mtime."</td>\n";
				echo "<td><a class=\"smallfont\" href=\"delete.php?id=".$row['id']."\">删除</a><br /><a href=\"modifyform.php?id=".$row['id']."\">修改</a></td>";
				echo "</tr>\n";
			}
			echo "</table></body></html>";
}

function getprojectfiles($path)
{
	$returninfo = $dir = $path.'/';
	$returninfo = '<div class="projectpath">'.$returninfo.':<br /></div>';
	$files = scandir($dir);

	foreach ($files as $file) 
	{
		if ($file != "." && $file != "..") 
		{
								// 目录后加 '/'
			if(is_dir($dir.$file)){
				$file .= '/';
			}
			$returninfo .= $file."<br />";
		}
	}
	return $returninfo;
}
