<?php
session_start();
error_reporting(0);
include('../connect.php');

if(strlen($_SESSION['admin-username'])=="")
    {   
    header("Location: login.php"); 
    }
    else{
	}
      
$username = $_SESSION["admin-username"];
$id=$_GET['id'];

date_default_timezone_set('Africa/Lagos');
$current_date = date('Y-m-d H:i:s');

$sql = "select * from admin where username='$username'"; 
$result = $conn->query($sql);
$rowaccess= mysqli_fetch_array($result);

if (isset($_GET['edit']) && $_GET['edit'] == 1) {
 if (isset($_GET['edit']) && $_GET['edit'] == 1) {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $student_id = $_GET['id'];

        // Fetch student information from the database based on the provided student ID
        $sql = "SELECT * FROM students WHERE ID = $student_id";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $fullname = $row['fullname'];
            $matric_no = $row['matric_no'];
            $password = $row['password'];
            $session = $row['session'];
            $faculty = $row['faculty'];
            $dept = $row['dept'];
            $phone = $row['phone'];
        } else {
            // Handle the case where the student with the provided ID doesn't exist
            echo "Student not found. Please check the student ID.";
        }
    }
}
}

// Now, outside of the retrieval logic, handle the form submission and update
if (isset($_POST['edit-student'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['txtfullname']);
    $matric_no = mysqli_real_escape_string($conn, $_POST['txtmatric']);
    $password = mysqli_real_escape_string($conn, $_POST['txtpassword']);
    $session = mysqli_real_escape_string($conn, $_POST['txtsession']);
    $faculty = mysqli_real_escape_string($conn, $_POST['txtfaculty']);
    $dept = mysqli_real_escape_string($conn, $_POST['txtdept']);
    $phone = mysqli_real_escape_string($conn, $_POST['txtphone']);

    // Update the student's information in the database
    $updateSql = "UPDATE students SET fullname='$fullname', matric_no='$matric_no', password='$password', session='$session', faculty='$faculty', dept='$dept', phone='$phone' WHERE ID = $student_id";

    if (mysqli_query($conn, $updateSql)) {
        // Redirect to the student record page after successful update
        header("Location: student-record.php");
    } else {
        echo "Update failed: " . mysqli_error($conn);
    }
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Student Details|Admin Dashboard</title>
 <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Home</a>      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
 
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../images/logo.png" alt=" Logo"  width="200" height="111" class="" style="opacity: .8">
	  <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../<?php echo $rowaccess['photo'];    ?>" alt="User Image" width="220" height="192" class="img-circle elevation-2">        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $rowaccess['fullname'];  ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
         
		 <?php
			   include('sidebar.php');
			   
			   ?>
		 
		 
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">&nbsp;</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Student Details </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
        
		 <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Student details </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="" method="POST" enctype="multipart/form-data">
    <div class="card-body">
        <div class="form-group">
            <label for="txtID">Student ID</label>
            <input type="text" class="form-control" name="txtID" id="txtID" size="77" value="<?php echo $row['ID']; ?>" placeholder="Student ID" readonly>
        </div>
        <div class="form-group">
            <label for="txtfullname">Fullname</label>
            <input type="text" class="form-control" name="txtfullname" id="txtfullname" size="77" value="<?php echo $row['fullname']; ?>" placeholder="Edit Fullname">
        </div>
        <div class="form-group">
            <label for="txtmatric">Matric No</label>
            <input type="text" class="form-control" name="txtmatric" id="txtmatric" size="77" value="<?php echo $row['matric_no']; ?>" placeholder="Edit Matric No">
        </div>
        <div class="form-group">
            <label for="txtpassword">Password</label>
            <input type="password" class="form-control" name="txtpassword" id="txtpassword" size="77" value="<?php echo $row['password']; ?>" placeholder="Enter Password">
        </div>
        <div class="form-group">
            <label for="txtsession">Session</label>
            <input type="text" class="form-control" name="txtsession" id="txtsession" size="77" value="<?php echo $row['session']; ?>" placeholder="Enter Session">
        </div>
          <div class="form-group">
    <label for="txtfaculty">Faculty</label>
    <select name="txtfaculty" class="form-control">
        <option value="Select faculty">Select faculty</option>
        <option value="Science"<?php if ($row['faculty'] === 'Science') echo ' selected'; ?>>Science</option>
        <option value="Engineering"<?php if ($row['faculty'] === 'Engineering') echo ' selected'; ?>>Engineering</option>
        <option value="Social Science"<?php if ($row['faculty'] === 'Social Science') echo ' selected'; ?>>Social Science</option>
        <!-- Add more faculty options as needed -->
    </select>
</div>

<div class="form-group">
    <label for="txtdept">Department</label>
    <select name="txtdept" class="form-control">
        <option value="Select Department">Select Department</option>
        <option value="Computer Science"<?php if ($row['dept'] === 'Computer Science') echo ' selected'; ?>>Computer Science</option>
        <option value="Electrical Engineering"<?php if ($row['dept'] === 'Electrical Engineering') echo ' selected'; ?>>Electrical Engineering</option>
        <option value="Business Management"<?php if ($row['dept'] === 'Business Management') echo ' selected'; ?>>Business Management</option>
        <option value="Information Technology"<?php if ($row['dept'] === 'Information Technology') echo ' selected'; ?>>Information Technology</option>
        <!-- Add more department options as needed -->
    </select>
</div>
        <div class="form-group">
            <label for="txtphone">Phone</label>
            <input type="text" class="form-control" name="txtphone" id="txtphone" size="77" value="<?php echo $row['phone']; ?>" placeholder="Enter Phone">
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
                <button type="submit" name="edit-student" class="btn btn-primary">Update</button>
    </div>
</form>

            </div>
		
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col --><!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)--><!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <?php include('../footer.php');  ?>
    <div class="float-right d-none d-sm-inline-block">
      
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
	
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
