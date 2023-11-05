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
    <title>Arthur Jarvis University Student</title>

    <style>
        /* Custom CSS for color */
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
        .details-page{
          display: flex;
        }
        .image-page{
           display: flex;

        }
        .span-text{
           text-align: left;
        }
    </style>
</head>
<body>
   <div class="profile-page"> 
        <form id="form-profile" class="form-page">
        <span>
            <div class="image-page">
        <img src="<?php echo $rowaccess['photo']; ?>" alt="image" width="150" height="175" class="img-circle" />
       </span> 
       </div>
     <div id= "details-profile" class ="details-page">
          <span class="span-text">
          <p class="custom-green">NAME OF STUDENT: <?php echo $rowaccess['fullname'] . "<br>"; ?></p>
            <p class="custom-green">MATRIC NUMBER: <?php echo $rowaccess['matric_no'] . "<br>"; ?> </p>
            <p class="custom-green">FACULTY: <?php echo $rowaccess['faculty'] . "<br>"; ?> </p>
            <p class="custom-green">DEPARTMENT: <?php echo $rowaccess['dept'] . "<br>"; ?> </p>
            <p class="custom-green">PHONE NUMBER: <?php echo $rowaccess['phone'] . "<br>"; ?> </p>
          </span>        
     </div>
        </form>
  </div>
</body>
</html>

