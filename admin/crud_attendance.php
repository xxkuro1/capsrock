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
        $searchQuery = " and (emp_id like '%".$searchValue."%') ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from attendance");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from attendance WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from attendance WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['id']."' data-toggle='modal' data-target='#attendanceModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
            "emp_id"=>$row['emp_id'],
            "date"=>$row['date'],
    		"timein_am"=>$row['timein_am'],
            "timeout_am"=>$row['timeout_am'],
            "timein_pm"=>$row['timein_pm'],
            "timeout_pm"=>$row['timeout_pm'],
            "total_hrs"=>$row['total_hrs'],
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

// Fetch attendance
if($request == 2){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM attendance WHERE id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "emp_id" => $row['emp_id'],
            "timein_am" => $row['timein_am'],
            "timeout_am" => $row['timeout_am'],
            "timein_pm" => $row['timein_pm'],
            "timeout_pm" => $row['timeout_pm'],
        );

        echo json_encode( array("status" => 1,"data" => $response) );
        exit;
    }else{
        echo json_encode( array("status" => 0) );
        exit;
    }
}//end tag for attendance

// Update attendance
if($request == 3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM attendance WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $timein_am = $_POST['timein_am'];
        $timein_am = date('H:i:s', strtotime($timein_am));
        $timein_am_converted =  strtotime($timein_am);
        $timeout_am = $_POST['timeout_am'];
        $timeout_am = date('H:i:s', strtotime($timeout_am));
        $timeout_am_converted = strtotime($timeout_am);
        $timein_pm = $_POST['timein_pm'];
        $timein_pm = date('H:i:s', strtotime($timein_pm));
        $timein_pm_converted =  strtotime($timein_pm);
        $timeout_pm = $_POST['timeout_pm'];
        $timeout_pm = date('H:i:s', strtotime($timeout_pm));
        $timeout_pm_converted =  strtotime($timeout_pm);
        $total_am=  abs($timeout_am_converted - $timein_am_converted)/3600;
        $total_pm=  abs($timeout_pm_converted - $timein_pm_converted)/3600;
        $total_hrs = $total_am + $total_pm;

        if( $timein_am != '' && $timeout_am != '' && $timein_pm != '' && $timeout_pm != '' ){

            mysqli_query($conn,"UPDATE `attendance` SET `timein_am`='".$timein_am."',`timeout_am`='".$timeout_am."',`timein_pm`='".$timein_pm."',`timeout_pm`='".$timeout_pm."',`total_hrs`='".$total_hrs."' WHERE `id`=".$id);

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
}//end tag for update attendance

//delete attendance
if($request == 4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM attendance WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"DELETE FROM attendance WHERE id=".$id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}


//save attendance
if($request ==5){
    $emp_id = $_POST['emp_id'];
    $timein_am = $_POST['timein_am'];
    $timein_am = date('H:i:s', strtotime($timein_am));
    $timein_am_converted =  strtotime($timein_am);
    $timeout_am = $_POST['timeout_am'];
    $timeout_am = date('H:i:s', strtotime($timeout_am));
    $timeout_am_converted = strtotime($timeout_am);
    $timein_pm = $_POST['timein_pm'];
    $timein_pm = date('H:i:s', strtotime($timein_pm));
    $timein_pm_converted =  strtotime($timein_pm);
    $timeout_pm = $_POST['timeout_pm'];
    $timeout_pm = date('H:i:s', strtotime($timeout_pm));
    $timeout_pm_converted =  strtotime($timeout_pm);
    $total_am=  abs($timeout_am_converted - $timein_am_converted)/3600;
    $total_pm=  abs($timeout_pm_converted - $timein_pm_converted)/3600;
    $total_hrs = $total_am + $total_pm;
    

    
    $conn->query("INSERT INTO `attendance`(`emp_id`,`timein_am`,`timeout_am`,`timein_pm`,`timeout_pm`,`total_hrs`)VALUES 
    ('$emp_id','$timein_am','$timeout_am','$timein_pm','$timeout_pm','$total_hrs')");

    // $total_am=  abs($timeout_am - $timein_am)/3600;
   // $total_pm= strtotime($timeout_pm)-strtotime($timein_pm);
   // $total_hrs= strtotime($total_am)+strtotime($total_pm);
    /* $from = new DateTime('08:00:00');
    $to = new DateTime('12:00:00');
    echo $from->diff($to)->format('%h.%i');
    echo "<br>";
    $from_pm = new DateTime('13:00:00');
    $to_pm = new DateTime('16:00:00');
    echo $from_pm->diff($to_pm)->format('%h.%i'); */
}