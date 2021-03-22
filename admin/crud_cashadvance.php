<?php 
    include('database/db_connect.php');

$request = 1;
if(isset($_POST ['request'])){
    $request = $_POST['request'];
}

//dataTable
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
        $searchQuery = " and (firstname like '%".$searchValue."%') ";
    }

    ## Total number of records without filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from cashadvance");
    $records = mysqli_fetch_assoc($sel);
    $totalRecords = $records['allcount'];

    ## Total number of records with filtering
    $sel = mysqli_query($conn,"select count(*) as allcount from cashadvance WHERE 1 ".$searchQuery);
    $records = mysqli_fetch_assoc($sel);
    $totalRecordwithFilter = $records['allcount'];

    ## Fetch records
    $empQuery = "SELECT c.id,c.date_ca,e.employee_id,e.firstname,e.lastname,c.amount FROM cashadvance c LEFT JOIN employees e ON c.emp_id = e.employee_id";
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();

    while ($row = mysqli_fetch_assoc($empRecords)) {

        // Update Button
        $updateButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$row['id']."' data-toggle='modal' data-target='#cashadvanceModal' >Update</button>";

        // Delete Button
        $deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$row['id']."'>Delete</button>";
        
        $action = $updateButton." ".$deleteButton;

        $data[] = array(    
            "date_ca"=>$row['date_ca'],
            "employee_id"=>$row['employee_id'],
    		"firstname"=>$row['firstname'],
            "lastname"=>$row['lastname'],
            "amount"=>$row['amount'],
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

//fetch data
if($request == 2){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    $record = mysqli_query($conn,"SELECT * FROM cashadvance WHERE id=".$id);

    $response = array();
    {
        if(mysqli_num_rows($record) > 0){
            $row = mysqli_fetch_assoc($record);
            $response = array(
                "emp_id"=> $row['emp_id'],
                "amount"=> $row['amount'],
            );
            echo json_encode(array("status" => 1,"data" => $response));
            exit;
        }else{
            echo json_encode(array("status" =>0));
            exit;
        }
    }
}

//update data
if($request ==3){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    //check id
    $record = mysqli_query($conn,"SELECT id FROM cashadvance WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){
        $emp_id = mysqli_escape_string($conn,trim($_POST['emp_id']));
        $amount = mysqli_escape_string($conn,trim($_POST['amount']));
    
    if($emp_id != '' && $amount != ''){
        mysqli_query($conn,"UPDATE `cashadvance` SET `emp_id`='".$emp_id."',`amount`='".$amount."' WHERE `id`=".$id);
        
        echo json_encode(array("status" => 1,"message"=>"Record updated."));
        exit;
    }else{
        echo json_encode(array("status" =>0,"message"=>"Please fill in all fields"));
        exit;
    }
    }
    else{
        echo json_encode(array("status"=>0,"message"=>"Invalid ID"));
        exit;

    }
}//end tag


//delete data
if($request == 4){
    $id = 0;

    if(isset($_POST['id'])){
        $id = mysqli_escape_string($conn,$_POST['id']);
    }

    // Check id
    $record = mysqli_query($conn,"SELECT id FROM cashadvance WHERE id=".$id);
    if(mysqli_num_rows($record) > 0){

        mysqli_query($conn,"DELETE FROM cashadvance WHERE id=".$id);

        echo 1;
        exit;
    }else{
        echo 0;
        exit;
    }
}



//save cash advance
if($request = 5){
    $emp_id_ca = $_POST['emp_id_ca'];
    $amount_ca = $_POST['amount_ca'];

    $conn->query("INSERT INTO `cashadvance`(`emp_id`,`amount`) VALUES('$emp_id_ca','$amount_ca')");
}

?>