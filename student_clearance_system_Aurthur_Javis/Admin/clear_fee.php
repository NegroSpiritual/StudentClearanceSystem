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

 // clear student 	
if(isset($_GET['id']))
{
$id=intval($_GET['id']);


mysqli_query($conn,"update students set is_hostel_approved='1' where ID='$id'");
header("location: student-clearance.php");
}

}
?>