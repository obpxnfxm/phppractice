<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />
	</head>
	<body>
		<h1>Leo's Project</h1>
		<div class="mainpage">
			<a href="admin">后台管理</a>
		</div>
		<table>
			<tr>
				<th width="10%">编号</th>
				<th width="20%">项目名称</th>
				<th>简介</th>
			</tr>
            <?php
            	$dsn = "mysql:dbname=webuser;host=localhost;charset=utf8";
            	$user = "leo";
            	$password = "402";
            	
            	try{
					$dbh = new PDO($dsn, $user, $password);
				} catch (PDOException $e) {
						echo "Connection failed: ". $e->getMessage();
						exit;
				}
				$id=1;
				$rowcolor = array('rowcolor0', 'rowcolor1');
				$query = "select name, intro from project order by time desc";
				$result = $dbh->query($query);
				$data = $result->fetchAll();
				$dataNum = count($data);

				foreach ( $data as $row){
					$name = stripslashes($row['name']);
					$intro = nl2br(stripslashes($row['intro']));
					
					// get files in project
					$projectpath = "projects/".$name;

					//若不是目录，超链接为空	
					if(!is_dir($projectpath)){
						$projectpath="#";
					} 
					
					echo "<tr class=\"".$rowcolor[$id%2]."\">\n";
					echo "<td>".($dataNum-$id+1)."</td>\n";
					echo "<td><a href=\"".$projectpath."\">".$name."</a></td>\n";
					echo "<td class=\"alignleft\">".$intro."</td>\n";
					echo "</tr>\n";
					$id++;
				}
            ?>
		</table>
	</body>
</html>
