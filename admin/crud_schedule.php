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
        $searchQuery = " and (timein_am like '%".$searchValue."%' or 
        timein_pm like '%".$searchValue."%') ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from schedules");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from schedules WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from schedules WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['id']."' data-toggle='modal' data-target='#scheduleModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
            "timein_am"=>$row['timein_am'],
            "timeout_am"=>$row['timeout_am'],
            "timein_pm"=>$row['timein_pm'],
            "timeout_pm"=>$row['timeout_pm'],
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

// Fetch schedule
if($request == 2){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM schedules WHERE id=".$id);

    $response = array();

    if(mysqli_num_rows($record) > 0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
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
}//end tag for position

// Update position
if($request == 3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM schedules WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        $timein_am = mysqli_escape_string($conn,trim($_POST['timein_am']));
        $timeout_am = mysqli_escape_string($conn,trim($_POST['timeout_am']));
        $timein_pm = mysqli_escape_string($conn,trim($_POST['timein_pm']));
        $timeout_pm = mysqli_escape_string($conn,trim($_POST['timeout_pm']));

        if( $timein_am != '' && $timeout_am != '' && $timein_pm != '' && $timeout_pm != '' ){

            mysqli_query($conn,"UPDATE `schedules` SET `timein_am`='".$timein_am."',`timeout_am`='".$timeout_am."',`timein_pm`='".$timein_pm."',`timeout_pm`='".$timeout_pm."' WHERE `id`=".$id);

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
//delete schedule
if($request == 4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM schedules WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"DELETE FROM schedules WHERE id=".$id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}
//save position
if($request ==5){
    $timein_am = $_POST['timein_am'];
    $timeout_am = $_POST['timeout_am'];
    $timein_pm = $_POST['timein_pm'];
    $timeout_pm = $_POST['timeout_pm'];
    
    $conn->query("INSERT INTO `schedules`(`timein_am`, `timeout_am`,`timein_pm`,`timeout_pm`) VALUES ('$timein_am','$timeout_am','$timein_pm','$timeout_pm')");
    

}