<?php
    session_start();
    include('admin/database/db_connect.php');

    if(isset($_POST['login_button'])){
        //get values
        $emp_id = trim($_POST['emp_id']);
        $password = trim($_POST['password']);
        
        //sql statement
        $sql = "SELECT  `id`,`employee_id`,`password` FROM employees where`employee_id`='$emp_id'";    
        $resultset =mysqli_query($conn,$sql) or die ("database error:".mysqli_error($conn));
        $row = mysqli_fetch_assoc($resultset);
        
        //validation
        if($row['password'] ==$password){
            echo "ok";
            $_SESSION['user_session'] = $row['id'];
        }else{
            echo " Employee Id or password does not exist";

        }

    }//end of if tag
?>