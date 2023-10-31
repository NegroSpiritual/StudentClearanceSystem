<?php 
error_reporting(0);
 include('../connect.php');
 include('../connect2.php');

$id= $_GET['id'];        
$sql = "DELETE FROM fee WHERE ID=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$id]);

header("Location: add-fee.php"); 
 ?>