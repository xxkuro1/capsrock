$(document).ready(function(){
   
     // DataTable 
     
    
   /*
     var payrollDataTable = $('#payrollTable').DataTable({
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'payroll_generate.php',   
           
        },
    

        'columns': [
            
            
            { data: 'emp_id' },
            { data: 'firstname'},
            { data: 'lastname'},
            {data: 'Gross'},
            {data:'netPay'},
           
        ],
    

    }); 
*/


    //apply date from and to 
    
    $('#btn_apply').on('click',function(){

        //validation
        if($('#from').val() == "" ||
        $('#to').val() == ""
        ){
            alert("Please fill in all fields");
        }
        else{
            //get data
            var from = $('#from').val();
            var to  = $('#to').val();
        }

        $.ajax({

            url: 'payroll_generate.php',
            type:'POST',
            data: {
                request:2,
                from: from,
                to: to
            },
            success:function(){
                $('#from').val();
                $('#to').val();
                DisplayData();
        
               
              
        }

    });
    //end  tag apply

    
});
function DisplayData(page, query = ''){
    var from = $('#from').val();
     var to  = $('#to').val();
    $.ajax({
        url:'payroll_generate.php',
        type: 'POST',
        data: {
            request:1,
            from: from,
            to: to,
            page:page, 
            query:query
        },
        success:function(response){
            $('#response').html(response);
        }
    })


   }
   

   

    $.datepicker.formatDate('Y/m/d', new Date());



})//end tag