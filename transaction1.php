<?php
session_start();
ob_start();
include 'header.php';
if(!(isset($_SESSION["authuser"])) && !(isset($_SESSION["user"])))
  {
      $_SESSION["notlogged"]=1;
      header("Location: index.php");
      exit();
  }
	 $conn=mysqli_connect("localhost","root","devansh2497","library");
	 if(!$conn)
	      die("Connection Error: ").mysqli_connect_error();
?>
	<head>
		<link rel='shortcut icon' type='image/ico' href='favicon.ico'>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="HandheldFriendly" content="true">
		<link rel="stylesheet" type="text/css" href="goback.css">
		<h3 style="text-align:center;color:#fff"> View the currently borrowed books!</h3>
	</head>
	<style type="text/css">
	#a{
		text-align: center;
	}
	</style>
	<body>
		<div class='cover'></div>
		<div class='tbl-header'>
		<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th>User Id</th>
				<th>User Name</th>
				<th>Book Id</th>
				<th>Book Name</th>
			</tr>
		</table>
	</div>
	<div class='tbl-content'>
		<table cellpadding="0" cellspacing="0" border="0">
			<?php
			     $sql="SELECT * from transaction";
			     $res=mysqli_query($conn,$sql);
			     while($row=mysqli_fetch_assoc($res))
			        {
			        	echo "<tr>";
			        	$uid=$row['user_id'];
			        	$bq=mysqli_fetch_assoc(mysqli_query($conn,"select * from user where id='$uid'"));
			        	$name=$bq['name'];
			        	echo "<td>".$uid."</td>";
			        	echo "<td>".$name."</td>";
			        	$bid=$row['book_id'];
			        	echo "<td>".$bid."</td>";
			        	$b=mysqli_fetch_assoc(mysqli_query($conn,"select * from book where id='$bid'"));
			        	$bname=$b['name'];
			        	echo "<td>".$bname."</td>";
			        	echo "</tr>";
			        }
			     ?>
		</table>
	</div><div class='goBack' id="go">
		<?php
		echo '<input type="button" id="go" value="Go Back!" onclick="back()">';
		ob_flush();
		?>
	</div>
	</body>
</html>