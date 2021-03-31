<?php 
include('database/db_connect.php');

$request = 1;
if(isset($_POST['request'])){
    $request = $_POST['request'];
}
//datatable
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
    $sel = mysqli_query($conn,"select count(*) as allcount from overtime");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from overtime WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "select * from overtime WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['id']."' data-toggle='modal' data-target='#overtimeModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(
            "date"=>$row['date'],
            "emp_id"=>$row['emp_id'],
    		"hours"=>$row['hours'],
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

//fetch overtime data
if($request ==2){
    $id =0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }
    $record = mysqli_query($conn,"SELECT * FROM overtime WHERE id = ".$id);
    $response = array();

    if(mysqli_num_rows($record)>0){
        $row = mysqli_fetch_assoc($record);
        $response = array(
            "emp_id"=>$row['emp_id'],
            "hours"=>$row['hours']
        );

        echo json_encode(array("status"=>1,"data"=>$response));
        exit;
    }else{
        echo json_encode(array("status"=>0));
        exit;
    }
}

//update overtime data
if($request == 3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }
    //check id
    $record = mysqli_query($conn,"SELECT * FROM overtime WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $emp_id = mysqli_escape_string($conn,($_POST['emp_id']));
        $hours = mysqli_escape_string($conn,($_POST['hours']));

        //validate
        if($emp_id != '' || $hours != ''){
            mysqli_query($conn,"UPDATE overtime SET `emp_id` ='".$emp_id."',`hours` = '".$hours."' WHERE id =".$id);
            echo json_encode(array("status"=>1,"message"=>"Record Updated"));
            exit;
        }else{
            echo json_encode(array("statuss"=>0,"message"=>"Please fill in all fields"));
            exit;
        }

    }else{
        echo json_encode(array("status"=>0,"message"=>"Invalid ID"));
    }
}

//delete overtime data
if($request ==4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }
    //check id
    $record = mysqli_query($conn,"SELECT id FROM overtime WHERE id =".$id);
    if(mysqli_num_rows($record)>0){
        mysqli_query($conn,"DELETE  FROM overtime WHERE id = ".$id);
        echo 1;
        exit;
    }else{
        echo 2;
        exit;
    }
}

//save overtime
if($request ==5){
    //get data
    $emp_id = $_POST['emp_id'];
    $hours = $_POST['hours'];

    $conn->query("INSERT INTO `overtime`(`emp_id`,`hours`) VALUES('$emp_id','$hours')");
}

?>