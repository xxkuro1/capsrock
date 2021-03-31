$(document).ready(function(){

    $('#btn_update_overtime').hide();
    //dataTable
    var overtimeTable = $('#overtimeTable').DataTable({
        'processing':true,
        'serverSide':true,
        'serverMethod':'post',
        destroy:true,
        'ajax':{
            'url':'crud_overtime.php'
        },
        'columns':[
            {data:'emp_id'},
            {data:'date'},
            {data: 'hours'},
            {data:'action'}
        ]

    })//end tag

    //fetch data
    $('#overtimeTable').on('click','.updateUser',function(){
        $('#btn_update_overtime').show();
        $('#btn_save_overtime').hide();
        var id =$(this).data('id');
        $('#txt_userid').val(id);

        //ajax
        $.ajax({
            url:'crud_overtime.php',
            type:'post',
            data:{
                request: 2,
                id: id
            },
            dataType:'json',
            success: function(response){
                if(response.status ==1){
                    $('#emp_id').val(response.data.emp_id);
                    $('#hours').val(response.data.hours);
                    $('#overtimeModal').removeData("modal");
                }else{
                    alert("Invalid ID");
                }
            }
        })

    })//end tag

    //update overtime
    $('#btn_update_overtime').on('click',function(){
        var id = $('#txt_userid').val();
        var emp_id = $('#emp_id').val();
        var hours = $('#hours').val();
        
        if(emp_id != '' || hours != ''){

            //ajax
            $.ajax({
                url:'crud_overtime.php',
                type:'post',
                data:{
                    request: 3,
                    id: id,
                    emp_id: emp_id,
                    hours: hours
                },
                dataType:'json',
                success: function(response){
                    alert(response.message);
                    //clear textfields
                    $('#emp_id','#hours').val('');
                    $('#txt_userid').val(0);

                    //reload dataTable
                    overtimeTable.ajax.reload();

                    //close modal
                    $('#overtimeModal').modal('toggle');
                }
            })
        }else{
            alert(response.message);
        }

    })//end  tag

    //delete overtime data
    $('#overtimeTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');
        var deleteConfirm = confirm("Are you sure?");
        if(deleteConfirm ==  true){
            //ajax
            $.ajax({
                url: 'crud_overtime.php',
                type:'post',
                data:{
                    request: 4,
                    id: id
                },
                success:function(response){
                    if(response == 1){
                        alert("Record deleted");
                        overtimeTable.ajax.reload();

                    }else{
                        alert("Invalid ID");
                    }
                }
            })
        }
    })

    //save overtime
    $('#btn_save_overtime').on('click',function(){
        //validation
        if($('#emp_id').val()=="" ||
            $('#hours').val()==""){
                alert("Please Fill in all fields");
        }else{
            //get data
            var emp_id = $('#emp_id').val();
            var hours = $('#hours').val();

            //ajax
            $.ajax({
                url:'crud_overtime.php',
                type:'post',
                data:{
                    request: 5,
                    emp_id: emp_id,
                    hours: hours
                },
                success:function(){
                    //clear data
                    alert("Record Added");
                    $('#emp_id').val('');
                    $('#hours').val('');  
                    overtimeTable.ajax.reload();
                }

            })
        }


    });//end tag







})//end tag