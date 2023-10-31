<?php
session_start();
error_reporting(0);
include('../connect.php');
if(strlen($_SESSION['admin-username'])=="")
    {   
    header("Location: login.php"); 
    }
    else{
	
$username=$_SESSION['admin-username'];
date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

 // for Block User   	
if(isset($_GET['id']))
{
$id=intval($_GET['id']);


mysqli_query($conn,"update admin set status='Inactive' where ID='$id'");
header("location: admin-record.php");
}

// for unBlock user
if(isset($_GET['uid']))
{
$uid=intval($_GET['uid']);

mysqli_query($conn,"update admin set status='Active' where ID='$uid'");
header("location: admin-record.php");

}
}
?>