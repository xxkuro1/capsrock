<?php
    include('header.php');
    //call database
    include('database/db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/validation.min.js"></script>
    <script src="js/script.js"></script>
    <script src="./js/datatables.net/js/jquery.dataTables.min.js" defer></script>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<div class="container">
		
        <form class="form-login" method="post" id="login-form">
            <h2 class="form-login-heading"><center>Admin</center></h2><hr />
            <div id="error">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" id="username" />
                <span id="check-e"></span>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" id="password" />
            </div>
            <hr />
            <div class="form-group">
                <button type="submit" class="btn btn-default" name="login_button" id="login_button">
                <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                </button> 
            </div> 
        </form>		
                
        </div>		
    </div>
</body>
</html>