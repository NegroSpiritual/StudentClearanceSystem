<?php
session_start();
error_reporting(0);
include('../../connect.php');

if(strlen($_SESSION['amt-invested'])=="")
    {   
    header("Location: upload-payment.php"); 
    }
   $email = $_SESSION["email"];

	 ?>
	 <?php            
$sql = "select * from users where email='$email'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daily Earnings| Success</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="../css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="../js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="16x16" href="../images/logo.svg">
<style type="text/css">
<!--
.style2 {color: #0000FF}
-->
</style>
</head>

<body>
    <div id="wrapper">

    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img src="../../<?php echo $rowaccess['photo'];  ?>" alt="image" width="142" height="153" class="img-circle" />
                             </span>
  
   
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"><span class="text-muted text-xs block"><?php echo $rowaccess['email'];  ?> <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
  </div>	
			   <?php
			   include('sidebar.php');
			   
			   ?>
			   
	       </ul>

        </div>
    </nav>

        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>

				<span class="m-r-sm text-muted welcome-message">Welcome to Daily Earnings Dashboard</span>

                </li>
                <li class="dropdown">
                   
                    


                <li>
                    <a href="../logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
               
            </ul>

        </nav>
</div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>&nbsp;</h2>
      </div>
    <div class="col-lg-2">

    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
              <div class="ibox-content text-center p-md">

                  <h2> Your Deposited is pending and will be review soon.</h2>
                  <p>&nbsp;</p>
                  <h4 class="style2">&nbsp;</h4>
                  <p class="style2"><a href="../upload-payment.php">Upload Again &gt;&gt; </a></p>
              </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6"></div>

        <div class="col-lg-6"></div>


    </div>
    <div class="row"></div>


</div>
<div class="footer" >
    <div class="pull-right">.    </div>
    <div>
        <strong><?php include('../footer.php');  ?></strong>
    </div>
</div>

</div>
</div>



<!-- Mainly scripts -->
<script src="../js/jquery-2.1.1.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="../js/inspinia.js"></script>
<script src="../js/plugins/pace/pace.min.js"></script>

<script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>


<script>
    $(document).ready(function(){


    });
</script>


</body>

</html>
