<?php
	session_start();
	if(isset($_SESSION['user_session'])){
	
	}
	else{
		header("location: index.php");

	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

 <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/position.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
    <script src="./js/datatables.net/js/jquery.dataTables.min.js" defer></script>
    
    
    
</head>
<body>
<div class="d-flex" id="wrapper">

<!-- Sidebar -->
<div class="bg-light border-right" id="sidebar-wrapper">

  <div class="sidebar-heading">Admin </div>
  <div class="list-group list-group-flush">
    <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
    <a href="attendance.php" class="list-group-item list-group-item-action bg-light">Attendance</a>
    <div class="dropdown show">
      <a class="list-group-item list-group-item-action bg-light" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Employee
      </a>

      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="employee.php">Employee List</a>
    <a class="dropdown-item" href="position.php">Position</a>
    <a class="dropdown-item" href="schedule.php">Schedule</a>
  </div>
    </div>
  <div class="dropdown show">
      <a class="list-group-item list-group-item-action bg-light" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Payroll
      </a>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
    <a class="dropdown-item" href="payroll.php">Payroll List</a>
    <a class="dropdown-item" href="deductions.php">Deductions</a>
    <a class="dropdown-item" href="cashadvance.php">Cash Advance</a>
</div>
</div>
   
    <a href="logout.php" class="list-group-item list-group-item-action bg-light">Logout</a>
  </div>
</div>

<!-- /#sidebar-wrapper -->


<!-- Page Content -->
<div id="page-content-wrapper">

  <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <button class="btn" id="menu-toggle"> <span class="navbar-toggler-icon"></span></button>


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    
  </nav>


        <div class="container-fluid">
          
            <h1 class="mt-4">Position</h1>
            <button type="button" class="btn btn-info btn-lg"  data-toggle="modal" data-target="#positionModal">Add</button>
         
        </div>
        &nbsp;
        
        <table id='positionTable' class='display dataTable' width='100%'>
          <thead>
            <tr>
                <th>Position</th>
                <th>Rate</th>
                <th>Action</th>
                  
            </tr>

          </thead>
         
              
        </table>
       
        </div>
        <!-- /#page-content-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Menu Toggle Script -->
        <script>
        

        $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        });


        //load employee.php
        function myEmployee() {
        location.replace("./employee.php")
      }
    
        </script>
        <?php include('positionModal.php'); ?>
        
</body>
</html> 