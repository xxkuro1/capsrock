<?php
    session_start();
    include('database/db_connect.php');

    if(isset($_POST['login_button'])){
        //get values
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        //sql statement
        $sql = "SELECT  `id`,`username`,`password` FROM admin where`username`='$username'";    
        $resultset =mysqli_query($conn,$sql) or die ("database error:".mysqli_error($conn));
        $row = mysqli_fetch_assoc($resultset);
        
        //validation
        if($row['password'] ==$password){
            echo "ok";
            $_SESSION['user_session'] = $row['id'];
        }else{
            echo " username or password does not exist";

        }

    }//end of if tag
?>