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
    //$empQuery = "select * from attendance WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;
    $empQuery = "SELECT a.emp_id,e.firstname,e.lastname,SUM(total_hrs) * p.rate 'Gross' FROM attendance a LEFT JOIN employees e 
    ON a.emp_id = e.employee_id ".$searchQuery." INNER JOIN position p ON e.position_id = p.id GROUP BY a.emp_id";
    $empRecords = mysqli_query($conn, $empQuery);
    $data = array();
    
    
    while ($row = mysqli_fetch_assoc($empRecords)) {
        //deductions
        $empQuery2 ="SELECT SUM(amount) AS 'amount' from deductions";
        $empDeductions = $conn->query($empQuery2);
        $empDeduc = $empDeductions->fetch_assoc();
        $netPay = $row['Gross'] - $empDeduc['amount'];
         

        $data[] = array(
            "emp_id"=>$row['emp_id'],
            "firstname"=>$row['firstname'],
    		"lastname"=>$row['lastname'],
            "Gross"=>$row['Gross'],
            "netPay"=>[$netPay]
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


?>