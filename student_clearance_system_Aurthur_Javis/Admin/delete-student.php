<?php 
error_reporting(0);
 include('../connect2.php');

$id= $_GET['id'];        
$sql = "DELETE FROM students WHERE ID=?";
$stmt= $dbh->prepare($sql);
$stmt->execute([$id]);

header("Location: student-record.php"); 
 ?>