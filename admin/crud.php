<?php
include ('database/db_connect.php');

$request = 1;
if(isset($_POST['request'])){
    $request = $_POST['request'];
}

// DataTable data
if($request == 1){
    ## Read value
    $draw = $_POST['draw'];
    $row = $_POST['start'];
    $rowperpage = $_POST['length']; // Rows display per page
    $columnIndex = $_POST['order'][0]['column']; // Column index
    $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
    $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc

    $searchValue = mysqli_escape_string($conn,$_POST['search']['value']); // Search value

    ## Search 
    $searchQuery = " ";
    if($searchValue != ''){
        $searchQuery = " and (address like '%".$searchValue."%' or 
            firstname like '%".$searchValue."%' or 
            lastname like'%".$searchValue."%' ) ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from employees");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from employees WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from employees WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['id']."' data-toggle='modal' data-target='#updateModal' >Update</button>";

        $positionAndSched  ="<button class='btn btn-sm btn-info changeUser' data-id='".$row['id']."' data-toggle='modal' data-target='#changeModal'>Change</button>";
        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton." ".$positionAndSched;

        $data[] = array(
            "employee_id"=>$row['employee_id'],
    		"firstname"=>$row['firstname'],
    		"lastname"=>$row['lastname'],
            "contact"=>$row['contact'],
                "action" => $action
            );
    }

    ## Response
    $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
    );

    echo json_encode($response);
    exit;
}

// Fetch user details
if($request == 2){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    //$record = mysqli_query($conn,"SELECT * FROM employees LEFT JOIN position ON employees.position_id = position.id");
    $record = mysqli_query($conn,"SELECT employees.employee_id,employees.firstname,employees.lastname,employees.address,employees.birthdate,employees.contact,employees.pagibig,employees.sss,employees.philhealth,employees.gender,position.position,s.timein_am,s.timeout_am,s.timein_pm,s.timeout_pm 
    FROM employees LEFT JOIN position ON employees.position_id = position.id INNER JOIN schedules s 
    ON employees.schedule_id = s.id WHERE employees.id=".$id); 
    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "employee_id" => $row['employee_id'],
            "update_firstname" => $row['firstname'],
            "update_lastname" => $row['lastname'],
            "update_address" => $row['address'],
            "update_birthdate" => $row['birthdate'],
            "update_contact" => $row['contact'],
            "update_pagibig" => $row['pagibig'],
            "update_sss" => $row['sss'],
            "update_contact" => $row['contact'],
            "update_philhealth" => $row['philhealth'],
            "update_gender" => $row['gender'],
            "update_position" => $row['position'],
            "timein_am" => $row['timein_am'],
            "timeout_am" => $row['timeout_am'],
            "timein_pm" => $row['timein_pm'],
            "timeout_pm" => $row['timeout_pm']
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{  
        echo json_encode( array("status" => 0) );
        exit;
    }
}

// Update user
if($request == 3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM employees WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        $firstname = mysqli_escape_string($conn,trim($_POST['firstname']));
        $lastname = mysqli_escape_string($conn,trim($_POST['lastname']));
        $address = mysqli_escape_string($conn,trim($_POST['address']));
        $birthdate = mysqli_escape_string($conn,trim($_POST['birthdate']));
        $contact = mysqli_escape_string($conn,trim($_POST['contact']));
        $gender = mysqli_escape_string($conn,trim($_POST['gender']));

        if( $firstname != '' && $lastname != '' && $gender != '' && $birthdate != '' ){

            mysqli_query($conn,"UPDATE `employees` SET `firstname`='".$firstname."',`lastname`='".$lastname."',`address`='".$address."',`birthdate`='".$birthdate."',`contact`='".$contact."',`gender`='".$gender."' WHERE `id`=".$id);

            echo json_encode( array("status" => 1,"message" => "Record updated.") );
            exit;
        }else{
            echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
            exit;
        }
        
    }else{
        echo json_encode( array("status" => 0,"message" => "Invalid ID.") );
        exit;
    }
}

//update position and schedule

if($request ==6){
    $id = 0;
    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }
    
    $record = mysqli_query($conn,"SELECT id from employees WHERE id =".$id);
    if(mysqli_num_rows($record) > 0){
        $position = mysqli_escape_string($conn,$_POST['position']);
        $am_schedule=mysqli_escape_string($conn,$_POST['am_schedule']);
       

        if($position !='' || $am_schedule != '' || $pm_schedule != ''){
            mysqli_query($conn,"UPDATE `employees` SET `position_id`='".$position."', `schedule_id`='".$am_schedule."' WHERE `id` =".$id);
            echo json_encode( array("status" => 1,"message" => "Record updated.") );
            exit;
        }
        else{
            echo json_encode( array("status" => 0,"message" => "Please fill all fields.") );
            exit;
        }
       
    }
}


// Delete User
if($request == 4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM employees WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"DELETE FROM employees WHERE id=".$id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}
//save user
if($request ==5){
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $birthdate = $_POST['birthdate'];
    $contact = $_POST['contact'];
    $pagibig = $_POST['pagibig'];
    $sss = $_POST['sss'];
    $philhealth = $_POST['philhealth'];
    $gender = $_POST['gender'];
    $schedule_am = $_POST['schedule_am'];
    $position = $_POST['position'];
    $file =$_POST['photo'];
    

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

    
    $conn->query("INSERT INTO `employees`(`employee_id`,`photo`,`firstname`, `lastname`, `address`, `birthdate`, `contact`,`pagibig`,`sss`,`philhealth`,`gender`,`position_id`,`schedule_id`) VALUES
     ('$employee_id','$file','$firstname','$lastname','$address','$birthdate','$contact','$pagibig','$sss','$philhealth','$gender','$position','$schedule_am')");
    

}







