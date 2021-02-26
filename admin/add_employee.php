<?php 
  include('database/db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

 <!-- Custom styles for this template -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/script.js"></script>
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
    <a href="#" class="list-group-item list-group-item-action bg-light">Payroll</a>
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
          
            <h1 class="mt-4"><center>Employee Information</center></h1>
        
            <div class="modal-body">
                     <div class="form-group">
                     <label> Image </label>
                                <input type="file" name="photo" id="photo"/>  
                        </div>        
                                 
                            
                            <div class="form-group">
                               
                                <input type="text" class="form-control" id="firstname" placeholder="Enter name" required>            
                            </div>
                            <div class="form-group">
                                 
                                <input type="text" class="form-control" id="lastname"  placeholder="Enter lastname">                          
                            </div>    
                            <div class="form-group">
                                
                                <input type="text" class="form-control" id="address"  placeholder="Address">                          
                            </div>      
                            
                            <div class="form-group">
                                
                                <input type="number" class="form-control" id="contact"  placeholder="Contact">                          
                            </div>

                            <div class="form-group">
                                
                                <input type="number" class="form-control" id="pagibig"  placeholder="Pag-ibig #">                          
                            </div>

                            <div class="form-group">
                                
                                <input type="number" class="form-control" id="sss"  placeholder="SSS #">                          
                            </div>

                            <div class="form-group">
                                
                                <input type="number" class="form-control" id="philhealth"  placeholder="Philhealth #">                          
                            </div>
                            <div class="form-group">
                                <label for="birthdate" >Birthdate</label>    
                                <input type="date" class="form-control" id="birthdate" placeholder="Address">                          
                            </div>      
                            <div class="form-group">
                                <label for="gender" >Gender</label>
                                <select id="gender" class="form-control">
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>              
                            </div>   

                            <div class="form-group">
                            <label for="position" >Position</label> 
                                <select id='position' class="form-control">
                                
                                    <option value="">- Select Position-</option>
                                    <?php 
                                    // Fetch position
                                   $sql = "SELECT * FROM position";
                                    $position_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($position_data) ){
                                        $id = $row['id'];
                                        $position = $row['position'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$position."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                            </div> 

                            <label for="schedule" >Schedule</label> 
                                    
                            <div class="form-group">
                            <label for="am" >AM</label> 
                                <select id="schedule_am" name="schedule_am" class="form-control">
                                
                                    <option value="">- Select Schedule-</option>
                                    <?php 
                                    // Fetch schedule
                                    $sql = "SELECT * FROM schedules";
                                    $schedule_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($schedule_data) ){
                                        $id = $row['id'];
                                        $timein_am = $row['timein_am'];
                                        $timeout_am = $row['timeout_am'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$timein_am."-".$timeout_am."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                            </div>
                            <div class="form-group">
                            <label for="pm" >PM</label> 
                                <select id="schedule_pm" name="schedule_pm" class="form-control">
                                
                                    <option value="">- Select Schedule-</option>
                                    <?php 
                                    // Fetch schedule
                                    $sql = "SELECT * FROM schedules";
                                    $schedule_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($schedule_data) ){
                                        $id = $row['id'];
                                        $timein_pm = $row['timein_pm'];
                                        $timeout_pm = $row['timeout_pm'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$timein_pm."-".$timeout_pm."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                            </div>

               
                   
        </div>
      

        <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                          
                            <button type="button" class="btn btn-success btn-m" id="btn_save">Save</button>
                            
                        </div>
        &nbsp;
        
       
        
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
        <?php include('myModal.php'); ?>
        
</body>
</html> 