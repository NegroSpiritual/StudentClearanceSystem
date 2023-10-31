<?php
session_start();
error_reporting(1);
include('connect2.php');

if(isset($_POST['btnlogin']))
{
if($_POST['txtmatric_no'] != "" || $_POST['txtpassword'] != ""){

$matric_no =$_POST['txtmatric_no'];
$password = $_POST['txtpassword'];

$sql = "SELECT * FROM `students` WHERE `matric_no`=? AND `password`=? ";
			$query = $dbh->prepare($sql);
			$query->execute(array($matric_no,$password));
			$row = $query->rowCount();
			$fetch = $query->fetch();
			if($row > 0) {
			
      //  $_SESSION['matric_no'] = $fetch['matric_no'];
      //$_SESSION['dept'] = $fetch['dept'];
			//$_SESSION['faculty'] = $fetch['faculty'];
		//	$_SESSION['session'] = $fetch['session'];
		//	$_SESSION['ID'] = $fetch['ID'];
				
				//Get Get all session value
    foreach($fetch as $items => $v){
      if(!is_numeric($items))
      $_SESSION[$items] = $v;
  }

		header("Location: index.php");

} else{
$_SESSION['error']=' Invalid Matric No/Password';
}
}else{
$_SESSION['error']=' Must Fill-in All Fields';

}
}

?>



<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>login Form| online Clearance system</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
 <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
 <style type="text/css">
<!--
.style3 {
	color: #FF0000;
	font-weight: bold;
	font-size: 24px;
}
.style4 {color: #FF0000}
-->

</style>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h5 class="style3">Online Student Clearance system..</h5>
                <h1 class="logo-name"><a href="index.php"><img src="images/logo.png" alt="onlineclearance" width="246" height="111" border="0"></a></h1>
            </div>
           
            <form class="m-t" role="form" method= "POST" action="">
                <div class="form-group">
                    <input type="text" name="txtmatric_no" class="form-control" placeholder="Matric No" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="txtpassword" class="form-control" placeholder="Password" required="">
                </div>

                <button type="submit" name="btnlogin" class="btn btn-primary block full-width m-b">Login</button>




                <a href="#"><small>Forgot password?</small></a>
			
				
                <p class="text-muted text-center">&nbsp;</p>
          </form>
            <p class="m-t"></p>
			
        </div>
    </div>
	
<?Php include('footer.php');?>
    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
<link rel="stylesheet" href="popup_style.css">
<?php if(!empty($_SESSION['success'])) {  ?>
<div class="popup popup--icon -success js_success-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Success</strong> 
    </h1>
    <p><?php echo $_SESSION['success']; ?></p>
    <p>
      <button class="button button--success" data-for="js_success-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["success"]);  
} ?>
<?php if(!empty($_SESSION['error'])) {  ?>
<div class="popup popup--icon -error js_error-popup popup--visible">
  <div class="popup__background"></div>
  <div class="popup__content">
    <h3 class="popup__content__title">
      <strong>Error</strong> 
    </h1>
    <p><?php echo $_SESSION['error']; ?></p>
    <p>
      <button class="button button--error" data-for="js_error-popup">Close</button>
    </p>
  </div>
</div>
<?php unset($_SESSION["error"]);  } ?>
    <script>
      var addButtonTrigger = function addButtonTrigger(el) {
  el.addEventListener('click', function () {
    var popupEl = document.querySelector('.' + el.dataset.for);
    popupEl.classList.toggle('popup--visible');
  });
};

Array.from(document.querySelectorAll('button[data-for]')).
forEach(addButtonTrigger);
    </script>
</body>

</html>
