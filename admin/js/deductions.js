 $(document).ready(function(){

    $('#btn_update_deductions').hide();
 
    // DataTable
    var deductionsDataTable = $('#deductionsTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'crud_deductions.php'
        },
        'columns': [
            { data: 'description' },
            { data: 'amount' },
            {data: 'action'},
        ]
    });

     // fetch record
     $('#deductionsTable').on('click','.updateUser',function(){
        $('#btn_update_deductions').show();
        $('#btn_save_deductions').hide();
        var id = $(this).data('id');
        
        $('#txt_userid').val(id);
        
        // ajax
        $.ajax({
            
            url: 'crud_deductions.php',
            type: 'post',
            data: 
            {
                request: 2, 
                id: id
            },
            dataType: 'json',
            success: function(response){
               
                if(response.status == 1){
                   
                    $('#description').val(response.data.description);
                    $('#amount').val(response.data.amount);
                    $("#deductionsModal").removeData("modal");
                }else{
                    alert("Invalid ID.");
                }
            }
        });
        
    });//end  tag for fetch deductions

     // update deductions
     $('#btn_update_deductions').click(function(){
        var id = $('#txt_userid').val();
       
        var description = $('#description').val().trim();
        var amount = $('#amount').val().trim();
       
        if(description !='' && amount != ''){

            // ajax
            $.ajax({
                url: 'crud_deductions.php',
                type: 'post',
                data: {request: 3, id: id,
                    description: description,
                     amount: amount
                     
                    },
                dataType: 'json',
                success: function(response){
                    if(response.status == 1){
                        alert(response.message);

                        // Empty the fields
                        $('#description','#amount').val('');
                        
                        $('#txt_userid').val(0);

                        // Reload DataTable
                        deductionsDataTable.ajax.reload();

                        // Close modal
                        $('#deductionsModal').modal('toggle');
                       
                    }else{
                        alert(response.message);
                    }
                }
            });

        }else{
            alert('Please fill all fields.');
        }
    });//end  tag for update

    // Delete record
    $('#deductionsTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // ajax
            $.ajax({
                url: 'crud_deductions.php',
                type: 'post',
                data: { 
                    request: 4,
                     id: id
                    },
                success: function(response){

                    if(response == 1){
                        alert("Record deleted.");

                        // Reload DataTable
                        deductionsDataTable.ajax.reload();
                    }else{
                        alert("Invalid ID.");
                    }
                    
                }
            });
        } 
        
    });


 
 
 
 //save position
 $('#btn_save_deductions').on('click',function(){
        
    //validation
    if($('#deductions').val() == ""|| 
        $('#amount').val() == "" 
        
        ){
            alert("Please fill in all fields")
    }
     else{
    //get data
    $('#btn_update_deductions').hide();
    var description = $('#description').val();
    var amount = $('#amount').val();
   
    
    
    //ajax
    $.ajax({

        url:'crud_deductions.php',
        type:'POST',
        data: {
            request:5,
            description: description,
            amount: amount
            
        },
        success: function(){
            $('#description').val();
            $('#amount').val();
            
            alert("Data added successfully")
            deductionsDataTable.ajax.reload();
            //clear data
            $('#description').val('');
            $('#amount').val('');
           
        }
    });// end tag for ajax


}

});//end tag for save data



});//end tag 