<?php
session_start();
include 'header.php';
if(!isset($_SESSION["user"]) && !isset($_SESSION["authuser"]))
{
$_SESSION["notlogged"]=1;
      header("Location: index.php");
      exit();
}
$conn = mysqli_connect("localhost", "root", "devansh2497","library");
if (!$conn) 
{
    die("Connection failed: " . mysqli_connect_error());
}
$id=$_POST["id"];
$pass=$_POST["password"];
$c=mysqli_query($conn,"SELECT * from user WHERE password='$pass'");
if(mysqli_num_rows($c)==0)
{
	$_SESSION["wrong"]=1;
	header("Location: borrow.php");
	exit();
}
$res=mysqli_query($conn,"SELECT * from book WHERE id='$id'");
if(mysqli_num_rows($res)==0)
{
	$_SESSION["wrong"]=1;
	header("Location: borrow.php");
	exit();
}
while($row=mysqli_fetch_assoc($res))
$onstack=$row['stack'];
if($onstack==0)
{
	$_SESSION["nocop"]=1;
	header("Location: borrow.php");
	exit();
}
$onstack-=1;
$res=mysqli_query($conn,"UPDATE book SET stack='$onstack' WHERE id='$id'");
if(!$res)
	exit("Error Encountered: Connection Problems");
$row=mysqli_fetch_assoc($c);
$iss=$row['books_issued'];
$iss++;
if($iss>4)
{
	$_SESSION["four"]=1;
	header("Location: borrow.php");
	exit();
}
$res2=mysqli_query($conn,"UPDATE user SET books_issued='$iss' WHERE password='$pass'");
if(!$res2)
	exit("Error Encountered: Connection Problems");
$_SESSION["succ"]=1;
header("Location: borrow.php");
exit();
?>
