<?php  
include('connect.php');
session_start(); //to ensure you are using same session
error_reporting(0);


date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

session_destroy(); //destroy the session
?>

<script>
window.location="login.php";
</script>
<?php
//to redirect back to "index.php" after logging out
  exit;
?>