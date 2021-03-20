<?php
include ('database/db_connect.php');

 /*$request = 0;
if(isset($_POST['request'])){
    $request = $_POST['request'];
} */

// DataTable data 
/*
if($request == 1){
    ## Read value
    $from  = $_POST['from'];
    $to = $_POST ['to'];
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
    ON a.emp_id = e.employee_id ".$searchQuery." INNER JOIN position p ON e.position_id = p.id 
     WHERE date GROUP BY a.emp_id";
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
*/

//apply filter date 
/*
if($request=2){
    $from  = $_POST['from'];
    $to = $_POST ['to'];
    $query = "SELECT a.emp_id,e.firstname,e.lastname,SUM(total_hrs) * p.rate 'Gross' FROM attendance a LEFT JOIN employees e 
    ON a.emp_id = e.employee_id INNER JOIN position p ON e.position_id = p.id
     WHERE date BETWEEN '$from' AND '$to' GROUP BY a.emp_id";
    $empquery = mysqli_query($conn, $query);
    $data = array();
    
    while ($row = mysqli_fetch_assoc($empquery)) {
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
        "aaData" => $data
    );

    echo json_encode($response);
    exit;

}//end tag   
*/

if (isset($_POST['request'])) {
    $request = $_POST['request'];
    $from  = $_POST['from'];
    $to = $_POST ['to'];
    /*$query = $conn->query("SELECT a.emp_id,e.firstname,e.lastname,SUM(total_hrs) * p.rate 'Gross' FROM attendance a LEFT JOIN employees e 
    ON a.emp_id = e.employee_id INNER JOIN position p ON e.position_id = p.id
     WHERE date BETWEEN '$from' AND '$to' GROUP BY a.emp_id");
*/
    $query =  $conn->query("SELECT a.emp_id,e.firstname,e.lastname,SUM(total_hrs) * p.rate 'Gross' FROM attendance a LEFT JOIN employees e 
    ON a.emp_id = e.employee_id INNER JOIN position p ON e.position_id = p.id 
     WHERE date BETWEEN '$from' AND '$to' GROUP BY a.emp_id");
    while($fetch = $query->fetch_array()){
         //deductions
         $empQuery2 ="SELECT SUM(amount) AS 'amount' from deductions";
         $empDeductions = $conn->query($empQuery2);
         $empDeduc = $empDeductions->fetch_assoc();
         $netPay = $fetch['Gross'] - $empDeduc['amount'];

        echo"
        <tr>
            <td>".$fetch['emp_id']."</td>
            <td>".$fetch['firstname']."</td>
            <td>".$fetch['lastname']."</td>
            <td>".$fetch['Gross']."</td>
            <td>".number_format($netPay)."</td>
            
            </tr>
        ";

    }

}


?>