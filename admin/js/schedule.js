$(document).ready(function(){
    $('#btn_update_schedule').hide();

      // DataTable
      var scheduleDataTable = $('#scheduleTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'crud_schedule.php'
        },
        'columns': [
            { data: 'timein_am' },
            { data: 'timeout_am' },
            { data: 'timein_pm' },
            { data: 'timeout_pm' },
            {data: 'action'},
        ]
    });

    // fetch schedule
    $('#scheduleTable').on('click','.updateUser',function(){
        $('#btn_update_schedule').show();
        $('#btn_save_schedule').hide();
        var id = $(this).data('id');
        
        $('#txt_userid').val(id);
        
        // ajax
        $.ajax({
            
            url: 'crud_schedule.php',
            type: 'post',
            data: 
            {
                request: 2, 
                id: id
            },
            dataType: 'json',
            success: function(response){
               
                if(response.status == 1){
                   
                    $('#timein_am').val(response.data.timein_am);
                    $('#timeout_am').val(response.data.timeout_am);
                    $('#timein_pm').val(response.data.timein_pm);
                    $('#timeout_pm').val(response.data.timeout_pm);
                    $("#scheduleModal").removeData("modal");
                }else{
                    alert("Invalid ID.");
                }
            }
        });
        
    });//end  tag for fetch record

     // update schedule
     $('#btn_update_schedule').click(function(){
        var id = $('#txt_userid').val();
       
        var timein_am = $('#timein_am').val().trim();
        var timeout_am = $('#timeout_am').val().trim();
        var timein_pm = $('#timein_pm').val().trim();
        var timeout_pm = $('#timeout_pm').val().trim();
        if(timein_am !='' && timeout_am != ''){

            // ajax
            $.ajax({
                url: 'crud_schedule.php',
                type: 'post',
                data: {request: 3, id: id,
                    timein_am: timein_am,
                    timeout_am: timeout_am,
                    timein_pm: timein_pm,
                    timeout_pm: timeout_pm
                     
                    },
                dataType: 'json',
                success: function(response){
                    if(response.status == 1){
                        alert(response.message);

                        // Empty the fields
                        $('#timein_am','#timeout_am','#timein_pm','#timeout_pm').val('');
                        
                        $('#txt_userid').val(0);

                        // Reload DataTable
                        scheduleDataTable.ajax.reload();

                        // Close modal
                        $('#scheduleModal').modal('toggle');
                       
                    }else{
                        alert(response.message);
                    }
                }
            });

        }else{
            alert('Please fill all fields.');
        }
    });//end  tag for update

    // Delete schedule
    $('#scheduleTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // ajax
            $.ajax({
                url: 'crud_schedule.php',
                type: 'post',
                data: { 
                    request: 4,
                     id: id
                    },
                success: function(response){

                    if(response == 1){
                        alert("Record deleted.");

                        // Reload DataTable
                        scheduleDataTable.ajax.reload();
                    }else{
                        alert("Invalid ID.");
                    }
                    
                }
            });
        } 
        
    });

     //save schedule
     $('#btn_save_schedule').on('click',function(){
        
        //validation
        if($('#timein_am').val() == ""|| 
            $('#timeout_am').val() == ""  ||
            $('#timeout_pm').val() == ""  ||
            $('#timeout_pm').val() == ""  
            
            ){
                alert("Please fill in all fields")
        }
         else{
        //get data
        $('#btn_update_schedule').hide();
        var timein_am = $('#timein_am').val();
        var timeout_am = $('#timeout_am').val();
        var timein_pm = $('#timein_pm').val();
        var timeout_pm = $('#timeout_pm').val();
        //ajax
        $.ajax({

            url:'crud_schedule.php',
            type:'POST',
            data: {
                request:5,
                timein_am: timein_am,
                timeout_am: timeout_am,
                timein_pm: timein_pm,
                timeout_pm: timeout_pm
                
            },
            success: function(){
                $('#timein_am').val();
                $('#timeout_am').val();
                $('#timein_pm').val();
                $('#timeout_pm').val();
                
                alert("Data added successfully")
                scheduleDataTable.ajax.reload();
                //clear data
                $('#timein_am').val('');
                $('#timeout_am').val('');
                $('#timein_pm').val('');
                $('#timeout_pm').val('');
               
            }
        });// end tag for ajax
    
    
    }

    });//end tag for save data



});//end tag 


