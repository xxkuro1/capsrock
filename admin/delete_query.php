<?php
    include('database/db_connect.php');
    
    $id = $_POST['id'];
    
    $conn->query("DELETE FROM employees WHERE id = '$id'");
?>