$(document).ready(function(){
     // DataTable
     var payrollDataTable = $('#payrollTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'payroll_generate.php'
        },
        'columns': [
            { data: 'emp_id' },
            { data: 'firstname'},
            { data: 'lastname'},
            {data: 'Gross'}
        ]
    });



})//end tag