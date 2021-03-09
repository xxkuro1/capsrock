$(document).ready(function(){

    $('#btn_update_attendance').hide();

     // DataTable
     var attendanceDataTable = $('#attendanceTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'crud_attendance.php'
        },
        'columns': [
            { data: 'emp_id' },
            { data: 'timein_am' },
            {data: 'timeout_am'},
            {data: 'timein_pm'},
            {data: 'timeout_pm'},
            {data: 'total_hrs'},
            {data: 'action'},
        ]
    });

     // fetch attendance record
     $('#attendanceTable').on('click','.updateUser',function(){
        $('#btn_update_attendance').show();
        $('#btn_save_attendance').hide();
        var id = $(this).data('id');
        
        $('#txt_userid').val(id);
        
        // ajax
        $.ajax({
            
            url: 'crud_attendance.php',
            type: 'post',
            data: 
            {
                request: 2, 
                id: id
            },
            dataType: 'json',
            success: function(response){
               
                if(response.status == 1){
                   
                    $('#emp_id').val(response.data.emp_id);
                    $('#timein_am').val(response.data.timein_am);
                    $('#timeout_am').val(response.data.timeout_am);
                    $('#timein_pm').val(response.data.timein_pm);
                    $('#timeout_pm').val(response.data.timeout_pm);
                    $("#attendanceModal").removeData("modal");
                }else{
                    alert("Invalid ID.");
                }
            }
        });
        
    });//end  tag for fetch attendance

    // update attendance
    $('#btn_update_attendance').click(function(){
        var id = $('#txt_userid').val();
        var timein_am = $('#timein_am').val().trim();
        var timeout_am = $('#timeout_am').val().trim();
        var timein_pm = $('#timein_pm').val().trim();
        var timeout_pm = $('#timeout_pm').val().trim();
        if(timein_am !='' && timeout_am != ''
           && emp_id !='' && timein_pm != ''
           && timeout_pm != ''
        ){

            // ajax
            $.ajax({
                url: 'crud_attendance.php',
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
                        $('#emp_id','#timein_am','#timeout_am','#timein_pm','#timeout_pm').val('');
                        
                        $('#txt_userid').val(0);

                        // Reload DataTable
                        attendanceDataTable.ajax.reload();

                        // Close modal
                        $('#attendanceModal').modal('toggle');
                       
                    }else{
                        alert(response.message);
                    }
                }
            });

        }else{
            alert('Please fill all fields.');
        }
    });//end  tag for update


// Delete attendance
    $('#attendanceTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // ajax
            $.ajax({
                url: 'crud_attendance.php',
                type: 'post',
                data: { 
                    request: 4,
                     id: id
                    },
                success: function(response){

                    if(response == 1){
                        alert("Record deleted.");

                        // Reload DataTable
                        attendanceDataTable.ajax.reload();
                    }else{
                        alert("Invalid ID.");
                    }
                    
                }
            });
        } 
        
    });

//save attendance
$('#btn_save_attendance').on('click',function(){
        
    //validation
    if( $('#emp_id_attendance').val() == ""|| 
        $('#timein_am').val() == "" ||
        $('#timeout_am').val() == "" ||
        $('#timein_pm').val() == "" ||
        $('#timeout_pm').val() == ""       
        ){
            alert("Please fill in all fields")
    }
     else{
    //get data
    $('#btn_update_attendance').hide();
    var emp_id = $('#emp_id').val();
    var timein_am = $('#timein_am').val();
    var timeout_am = $('#timeout_am').val();
    var timein_pm = $('#timein_pm').val();
    var timeout_pm = $('#timeout_pm').val();
    
 
    
    //ajax
    $.ajax({

        url:'crud_attendance.php',
        type:'POST',
        data: {
            request:5,
           emp_id:emp_id,
           timein_am:timein_am,
           timeout_am:timeout_am,
           timein_pm:timein_pm,
           timeout_pm:timeout_pm
        },
        success: function(){
            $('#emp_id_attendance').val();
            $('#timein_am').val();
            $('#timeout_am').val();
            $('#timein_pm').val();
            $('#timeout_pm').val();
            
            alert("Data added successfully")
            
           attendanceDataTable.ajax.reload();
            //clear data
            $('#emp_id_attendance').val('');
            $('#timein_am').val('');
            $('#timeout_am').val('');
            $('#timein_pm').val('');
            $('#timeout_pm').val('');
            // Close modal
            $('#attendanceModal').modal('toggle');
           
        }
    });// end tag for ajax


}

});//end tag for save attendance


});//end tag 