$(document).ready(function(){

    $('#btn_update_position').hide();

    // DataTable
    var positionDataTable = $('#positionTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'crud_position.php'
        },
        'columns': [
            { data: 'position' },
            { data: 'rate' },
            {data: 'action'},
        ]
    });

      // fetch record
      $('#positionTable').on('click','.updateUser',function(){
        $('#btn_update_position').show();
        $('#btn_save_position').hide();
        var id = $(this).data('id');
        
        $('#txt_userid').val(id);
        
        // ajax
        $.ajax({
            
            url: 'crud_position.php',
            type: 'post',
            data: 
            {
                request: 2, 
                id: id
            },
            dataType: 'json',
            success: function(response){
               
                if(response.status == 1){
                   
                    $('#position').val(response.data.position);
                    $('#rate').val(response.data.rate);
                    $("#positionModal").removeData("modal");
                }else{
                    alert("Invalid ID.");
                }
            }
        });
        
    });//end  tag for fetch position

     // update position
     $('#btn_update_position').click(function(){
        var id = $('#txt_userid').val();
       
        var position = $('#position').val().trim();
        var rate = $('#rate').val().trim();
       
        if(position !='' && rate != ''){

            // ajax
            $.ajax({
                url: 'crud_position.php',
                type: 'post',
                data: {request: 3, id: id,
                    position: position,
                     rate: rate
                     
                    },
                dataType: 'json',
                success: function(response){
                    if(response.status == 1){
                        alert(response.message);

                        // Empty the fields
                        $('#position','#rate').val('');
                        
                        $('#txt_userid').val(0);

                        // Reload DataTable
                        positionDataTable.ajax.reload();

                        // Close modal
                        $('#positionModal').modal('toggle');
                       
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
    $('#positionTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // ajax
            $.ajax({
                url: 'crud_position.php',
                type: 'post',
                data: { 
                    request: 4,
                     id: id
                    },
                success: function(response){

                    if(response == 1){
                        alert("Record deleted.");

                        // Reload DataTable
                        positionDataTable.ajax.reload();
                    }else{
                        alert("Invalid ID.");
                    }
                    
                }
            });
        } 
        
    });


     //save position
     $('#btn_save_position').on('click',function(){
        
        //validation
        if($('#position').val() == ""|| 
            $('#rate').val() == "" 
            
            ){
                alert("Please fill in all fields")
        }
         else{
        //get data
        $('#btn_update_position').hide();
        var position = $('#position').val();
        var rate = $('#rate').val();
       
        
        
        //ajax
        $.ajax({

            url:'crud_position.php',
            type:'POST',
            data: {
                request:5,
                position: position,
                rate: rate
                
            },
            success: function(){
                $('#position').val();
                $('#rate').val();
                
                alert("Data added successfully")
                positionDataTable.ajax.reload();
                //clear data
                $('#position').val('');
                $('#rate').val('');
               
            }
        });// end tag for ajax
    
    
    }

    });//end tag for save data



});//end tag 