<?php
session_start();
error_reporting(0);
include('../../connect.php');

if(strlen($_SESSION['email'])=="")
    {   
    header("Location: ../login.php"); 
    }
    else{
	}
      
$email = $_SESSION["email"];

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');



$sql = "select * from users where email='$email'"; 
$result = $conn->query($sql);
$rowaccess = mysqli_fetch_array($result);
$plan=$rowaccess['investment_plan'];
$balance=$rowaccess['balance'];


//Get Due Date and Interest Rate
$sql = "select * from settings where uniqueid='$plan'"; 
$result = $conn->query($sql);
$row_plan = mysqli_fetch_array($result);
$due_date=$row_plan['days'];
$rate=$row_plan['int_rate'];
$amt_from=$row_plan['amt_from'];
$amt_to=$row_plan['amt_to'];



if(isset($_POST["btnpay"])){
$amt = mysqli_real_escape_string($conn,$_POST['txtamt']);

 //Generate Reference ID
function referenceID() {
    $alphabet = "abxXZ012GFHY3456789";
    $refID = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
       $refID[] = $alphabet[$n];
    }
    return implode($refID); //turn the array into a string
}
$ref = referenceID();

$duedate=date('Y-m-d H:i:s', strtotime($current_date. " + $due_date days"));
$dueamt= ($amt + ($amt/100) * $rate);


if ( in_array($amt, range($amt_from,$amt_to)) ) {
// echo "You can be sure that $amt_from <= $amt <= $amt_to";

//save deposit details
$sql = "INSERT INTO tbltransaction(email,referenceID,amt_invested,due_date,due_amt,date_transaction,updated_status,status)VALUES ('$email', '$ref','$amt','$duedate', '$dueamt','$current_date','No','Running')";

 if ($conn->query($sql) === TRUE) {
 
//update balance

// $q1="UPDATE `users` SET `balance`=('$balance' + $dueamt) where email = '$email'";
  //$query1=$conn->query($q1);
 
//if ($conn->query($q1) === TRUE) {

//session variables
$_SESSION["amt-invested"]=$amt;
$_SESSION["due-date"]=$duedate;
$_SESSION["due-amt"]=$dueamt;
$_SESSION["rate"]=$rate;


//Get current balance
$sql1 = "select * from users WHERE email='$email'"; 
$result1 = $conn->query($sql1);
$row = mysqli_fetch_array($result1);

$bal2= $row['balance'];

 //send verication link via email
$to = $email;
			$subject = "Deposit Receipt from Daily Earning";
			$message = "
				<html>
				<head>
				<title>Deposit Receipt from Daily Earning</title>
				</head>
				<body>
				 <img src=\"https://www.dailyearnings.org/c/images/logo.svg\">
				<p>Hello ,</p>
                            <p>Thank you for Investing with Daily Earnings, Your Deposited was Received Successfully.</p>
							
							<p>Kindly Note that our Current Interest Rate is  <h2>: $rate </h2> and your due Date for Withdrawal is $duedate</p>
								 <p><h2>Balance : N".$bal2."</h2>
							
                            <p>&nbsp;</p>
					
							
                            <p>If you have questions or issues with this payment, </p>                 
						<p> contact Daily Earnings at info@dailyearnings.org </p> 
						<p> Or simply reply to this Email </p> 
						
						
						   <p>Regards,</p>                 
						 <p>Daily Earnings Team.</p>     
				</body>
				</html>
				";
			 //dont forget to include content-type on header if your sending html
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= "From: info@dailyearnings.org". "\r\n" ;
		mail($to,$subject,$message,$headers);
	
header("Location: invest-success.php"); 
}else{
$error_msg =' Sorry, You can Not Invest This Amount. Check what is Applicable to your Package ';
header("Location: deposit.php"); 
}
}
}
//}
?>
		   
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daily Earnings| Deposit</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="../css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="../js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href=../"css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
<link rel="icon" type="image/png" sizes="16x16" href="../images/logo.svg">
<style type="text/css">
<!--
.style1 {color: #000000}
.style2 {color: #000066; }
.style4 {color: #FF0000}
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
                    <span class="m-r-sm text-muted welcome-message">Welcome to Daily Earnings DASHBOARD</span>
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
            <div class="wrapper wrapper-content">
			<h3>How Much Bitcoin do you Want to invest?</h3>
			<p>&nbsp;</p>
			<h3 align="center" class="style2">&nbsp;</h3>
			<h4>&nbsp;</h4>  
			</p>
</p>
			<div class="row">
			 <div class="col-lg-9">
		   
               <div class="ibox float-e-margins">
                            <div class="ibox-title">
						
                           
                               <h5><span class="label label-success pull-right">Cryptocurrency Transfer</span></h5>
                            </div>
<div class="ibox-content">
                                <h3 class="no-margins">&nbsp;
                                  <p><img src="../../images/bitcoin-investing-in-bitcoin-1-638.jpg" alt="pay" width="305" height="142"></p>
                                  <p><?php echo "<p> <font color=red font face='arial' size='2pt'>$error_msg</font> </p>"; ?></p>
								   <p class="style4">Note: Your Maximum Withdrawal is  $<?php echo $amt_from ; ?> and Minimum Withdrawal is $<?php echo $amt_to ; ?> [<?php echo $plan ; ?> Plan]								   </p>
								   <p class="style4">&nbsp;</p>
								   <form  method="post" action="" >
                                  <p><strong><input type="number" size="111" name="txtamt"  placeholder="Enter Amount to Invest" class="form-control" required="">
                                    </div>			</h3>
                                                            
                                <h3 class="no-margins">
                                  <div>
                                    
                                    </p>
                                  <button name="btnpay" class="btn btn-primary btn-block m"><i class="fa fa-bank"></i> Invest</button>
							  </form >
               </div>
                                </h3>
                      	    </div>
              </div>
          </div>
          
                                     <div class="row">
          <div class="col-lg-12"> 
            <p class="style1">&nbsp;</p>
            <p>&nbsp;</p>
          <div class="row"></p>
          </div>
          </div>
          </div>
            <div class="footer">
            
            <div>
<?php include('../footer.php');  ?>            </div>
        </div>
        </div>
</div>
    <!-- Mainly scripts -->
    <script src="../js/jquery-2.1.1.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="../js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="../js/plugins/flot/jquery.flot.js"></script>
    <script src="../js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="../js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="../js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="../js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="../js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="../js/plugins/flot/jquery.flot.time.js"></script>

    <!-- Peity -->
    <script src="../js/plugins/peity/jquery.peity.min.js"></script>
    <script src="../js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="../js/inspinia.js"></script>
    <script src="../js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
    <script src="../js/plugins/jquery-ui/jquery-ui.min.js"></script>

    <!-- Jvectormap -->
    <script src="../js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- EayPIE -->
    <script src="../js/plugins/easypiechart/jquery.easypiechart.js"></script>

    <!-- Sparkline -->
    <script src="../js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <!-- Sparkline demo data  -->
    <script src="../js/demo/sparkline-demo.js"></script>

    <script>
        $(document).ready(function() {
            $('.chart').easyPieChart({
                barColor: '#f8ac59',
//                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            $('.chart2').easyPieChart({
                barColor: '#1c84c6',
//                scaleColor: false,
                scaleLength: 5,
                lineWidth: 4,
                size: 80
            });

            var data2 = [
                [gd(2012, 1, 1), 7], [gd(2012, 1, 2), 6], [gd(2012, 1, 3), 4], [gd(2012, 1, 4), 8],
                [gd(2012, 1, 5), 9], [gd(2012, 1, 6), 7], [gd(2012, 1, 7), 5], [gd(2012, 1, 8), 4],
                [gd(2012, 1, 9), 7], [gd(2012, 1, 10), 8], [gd(2012, 1, 11), 9], [gd(2012, 1, 12), 6],
                [gd(2012, 1, 13), 4], [gd(2012, 1, 14), 5], [gd(2012, 1, 15), 11], [gd(2012, 1, 16), 8],
                [gd(2012, 1, 17), 8], [gd(2012, 1, 18), 11], [gd(2012, 1, 19), 11], [gd(2012, 1, 20), 6],
                [gd(2012, 1, 21), 6], [gd(2012, 1, 22), 8], [gd(2012, 1, 23), 11], [gd(2012, 1, 24), 13],
                [gd(2012, 1, 25), 7], [gd(2012, 1, 26), 9], [gd(2012, 1, 27), 9], [gd(2012, 1, 28), 8],
                [gd(2012, 1, 29), 5], [gd(2012, 1, 30), 8], [gd(2012, 1, 31), 25]
            ];

            var data3 = [
                [gd(2012, 1, 1), 800], [gd(2012, 1, 2), 500], [gd(2012, 1, 3), 600], [gd(2012, 1, 4), 700],
                [gd(2012, 1, 5), 500], [gd(2012, 1, 6), 456], [gd(2012, 1, 7), 800], [gd(2012, 1, 8), 589],
                [gd(2012, 1, 9), 467], [gd(2012, 1, 10), 876], [gd(2012, 1, 11), 689], [gd(2012, 1, 12), 700],
                [gd(2012, 1, 13), 500], [gd(2012, 1, 14), 600], [gd(2012, 1, 15), 700], [gd(2012, 1, 16), 786],
                [gd(2012, 1, 17), 345], [gd(2012, 1, 18), 888], [gd(2012, 1, 19), 888], [gd(2012, 1, 20), 888],
                [gd(2012, 1, 21), 987], [gd(2012, 1, 22), 444], [gd(2012, 1, 23), 999], [gd(2012, 1, 24), 567],
                [gd(2012, 1, 25), 786], [gd(2012, 1, 26), 666], [gd(2012, 1, 27), 888], [gd(2012, 1, 28), 900],
                [gd(2012, 1, 29), 178], [gd(2012, 1, 30), 555], [gd(2012, 1, 31), 993]
            ];


            var dataset = [
                {
                    label: "Number of orders",
                    data: data3,
                    color: "#1ab394",
                    bars: {
                        show: true,
                        align: "center",
                        barWidth: 24 * 60 * 60 * 600,
                        lineWidth:0
                    }

                }, {
                    label: "Payments",
                    data: data2,
                    yaxis: 2,
                    color: "#464f88",
                    lines: {
                        lineWidth:1,
                            show: true,
                            fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.2
                            }, {
                                opacity: 0.2
                            }]
                        }
                    },
                    splines: {
                        show: false,
                        tension: 0.6,
                        lineWidth: 1,
                        fill: 0.1
                    },
                }
            ];


            var options = {
                xaxis: {
                    mode: "time",
                    tickSize: [3, "day"],
                    tickLength: 0,
                    axisLabel: "Date",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 10,
                    color: "#d5d5d5"
                },
                yaxes: [{
                    position: "left",
                    max: 1070,
                    color: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: 'Arial',
                    axisLabelPadding: 3
                }, {
                    position: "right",
                    clolor: "#d5d5d5",
                    axisLabelUseCanvas: true,
                    axisLabelFontSizePixels: 12,
                    axisLabelFontFamily: ' Arial',
                    axisLabelPadding: 67
                }
                ],
                legend: {
                    noColumns: 1,
                    labelBoxBorderColor: "#000000",
                    position: "nw"
                },
                grid: {
                    hoverable: false,
                    borderWidth: 0
                }
            };

            function gd(year, month, day) {
                return new Date(year, month - 1, day).getTime();
            }

            var previousPoint = null, previousLabel = null;

            $.plot($("#flot-dashboard-chart"), dataset, options);

            var mapData = {
                "US": 298,
                "SA": 200,
                "DE": 220,
                "FR": 540,
                "CN": 120,
                "AU": 760,
                "BR": 550,
                "IN": 200,
                "GB": 120,
            };

            $('#world-map').vectorMap({
                map: 'world_mill_en',
                backgroundColor: "transparent",
                regionStyle: {
                    initial: {
                        fill: '#e4e4e4',
                        "fill-opacity": 0.9,
                        stroke: 'none',
                        "stroke-width": 0,
                        "stroke-opacity": 0
                    }
                },

                series: {
                    regions: [{
                        values: mapData,
                        scale: ["#1ab394", "#22d6b1"],
                        normalizeFunction: 'polynomial'
                    }]
                },
            });
        });
    </script>
</body>
</html>
