<?php
session_start();
error_reporting(0);
include('connect.php');
if(empty($_SESSION['matric_no']))
    {   
    header("Location: login.php"); 
    }
    else{
	}
      

    //get neccesary session details 
    $ID = $_SESSION["ID"];
    $matric_no = $_SESSION["matric_no"];
    $dept = $_SESSION['dept'];
    $faculty = $_SESSION['faculty'];
    $email = $_SESSION['email'];
    $fullname = $_SESSION["fullname"];
    $photo = $_SESSION["photo"];
	
   
    $sql = "select SUM(amount) as tot_fee from fee where faculty='$faculty' AND dept='$dept'"; 
    $result = $conn->query($sql);
    $row_fee = mysqli_fetch_array($result);
    $tot_fee=$row_fee['tot_fee'];
    
    //Get outstanding payment etc
    $sql = "select SUM(amount) as tot_pay from payment where studentID='$ID'"; 
    $result = $conn->query($sql);
    $rowpayment = mysqli_fetch_array($result);
    $tot_pay=$rowpayment['tot_pay'];
    
    $outstanding_fee=$tot_fee-$tot_pay;

$sql = "select * from students where matric_no='$matric_no'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);

$hostel = $rowaccess["is_hostel_approved"];
$sport = $rowaccess['is_sport_approved'];
$stud_affairs = $rowaccess['is_stud_affairs_approved'];

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arthur Jarvis University Student Profile</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
<style type="text/css">
<!--
.style1 {color: #000000}
.style2 {color: #FF0000}
-->
</style>
<style>
        /* Custom CSS for color and layout */
        body {
            background-color: #ffffff;
        }
        .custom-green {
            color: #008000;
        }
        .profile-page {
            text-align: center;
            margin: 0 auto;
            max-width: 500px;
            font-size: large;
            justify-content: space-around;
        }
        .form-page {
            width: 60%px;
            height: 100%;
            padding: 30px;
            border-color: grey;
            border-radius: 10px;
            box-shadow: 10px 10px 5px grey;
            margin: 0 auto;
            display: flex;
            justify-content: space-around;
            align-items: stretch;
        }
        .details-page {
            display: flex;
        }
        .image-page {
            display: flex;
        }
        .span-text {
            text-align: left;
        }
        table {
            width: 100%;
            background-color: #337ab7;
            color: white;
        }
        table, th, td {
            border: 1px solid #337ab7;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #337ab7;
        }
    </style>
</head>
<body>
<div id="wrapper">

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img src="<?php echo $rowaccess['photo'];  ?>" alt="image" width="142" height="153" class="img-circle" />
                         </span>


                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"><span class="text-muted text-xs block">Matric No:<?php echo $rowaccess['matric_no'];  ?> <b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
</div>	
           <?php
           include('sbar.php');
           
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
				
				
                    <span class="m-r-sm text-muted welcome-message">Welcome <?php echo $rowaccess['fullname']; ?></span>
                </li>
                <li class="dropdown">
                   
                    


                <li>
                    <a href="logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
               
            </ul>

        </nav>
        </div>
<div class="wrapper wrapper-content">
<div class="profile-page">
        <form id="form-profile" class="form-page">
          
            <table>
                <tr>
                    <th colspan="2">Student Details</th>
                </tr>
                <tr>
                    <td class="custom-green">Name of Student:</td>
                    <td><?php echo $rowaccess['fullname']; ?></td>
                </tr>
                <tr>
                    <td class="custom-green">Matric Number:</td>
                    <td><?php echo $rowaccess['matric_no']; ?></td>
                </tr>
                <tr>
                    <td class="custom-green">Faculty:</td>
                    <td><?php echo $rowaccess['faculty']; ?></td>
                </tr>
                <tr>
                    <td class="custom-green">Department:</td>
                    <td><?php echo $rowaccess['dept']; ?></td>
                </tr>
                <tr>
                    <td class="custom-green">Phone Number:</td>
                    <td><?php echo $rowaccess['phone']; ?></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>

<?php include ('footer.php'); ?>
