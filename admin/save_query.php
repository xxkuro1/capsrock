<?php
    include('database/db_connect.php');
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];

    //create employee id
    $letters = '';
    $numbers = '';

    foreach(range('A','Z')as $char){
        $letters .=$char;
    }
    for ($i=0; $i < 10; $i++) { 
        $numbers .=$i;
    }
    $employee_id = substr(str_shuffle($letters),0,3).substr(str_shuffle($numbers),0,9);

    
    $conn->query("INSERT INTO `employees`(`employee_id`, `firstname`, `lastname`, `address`, `birthdate`, `contact`, `gender`) VALUES ('$employee_id','$firstname','$lastname','$address','$birthdate','$contact','$gender')");
    