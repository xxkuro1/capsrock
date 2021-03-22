$(document).ready(function(){


    $('#btn_update_ca').hide();

    var cashadvanceDatatable= $('#cashadvanceTable').DataTable({
        'processing':true,
        'serverSide':true,
        'serverMethod':'post',
        destroy:true,
        'ajax':{
            'url':'crud_cashadvance.php'
        },
        'columns':[
            {data: 'date_ca'},
            {data: 'employee_id'},
            {data:'firstname'},
            {data:'lastname'},
            {data:'amount'},
            {data:'action'},
        ]
    })

    //save cash advance
    $('#btn_save_ca').on('click',function(){
        if($('#emp_id_ca').val() == "" ||
            $('#amount_ca').val() == ""

        ){
            alert("Please fill in all textfields");
        }else{
            // get values
            var emp_id_ca = $('#emp_id_ca').val();
            var amount_ca = $('#amount_ca').val();


            $.ajax({
                url:'crud_cashadvance.php',
                type:'POST',
                data:{
                    request: 5,
                    emp_id_ca: emp_id_ca,
                    amount_ca: amount_ca
                },
                success:function(){
                    alert("Data added successfully")
                    $('#emp_id_ca').val('');
                    $('#amount_ca').val('');
                    cashadvanceDatatable.ajax.reload();
                }
            })
        }



    }); //end tag for save

    //fetch data
    $('#cashadvanceTable').on('click','.updateUser',function(){
        $('#btn_update_ca').show();
        $('#btn_save_ca').hide();
        var id = $(this).data('id');

        $('#txt_userid').val(id);

        $.ajax({
            url:'crud_cashadvance.php',
            type:'POST',
            data:
            {
                request: 2,
                id: id
            },
            dataType:'json',
                success:function(response){
                    if(response.status == 1){
                        $('#emp_id_ca').val(response.data.emp_id);
                        $('#amount_ca').val(response.data.amount);
                        $('#cashadvanceModal').removeData("modal");
                      
                    }else{
                        alert("Invalid ID");
                    }
                }
        })
      

    })//end tag

    //update data
    $('#btn_update_ca').click(function(){
        var id = $('#txt_userid').val();

        var emp_id = $('#emp_id_ca').val().trim();
        var amount = $('#amount_ca').val().trim();

        if(emp_id !== '' && amount !==''){

            $.ajax({
                url:'crud_cashadvance.php',
                type:'post',
                data: {
                    request: 3,
                    id: id,
                    emp_id: emp_id,
                    amount: amount
                },
                dataType:'json',
                success:function(response){
                    if(response.status ==1){
                        alert(response.message);
                        //alert (amount);
                        //empty fields
                        $('#emp_id_ca').val('');
                        $('#amount_ca').val('');
                        $('#txt_userid').val(0);

                        //reload datatable
                        cashadvanceDatatable.ajax.reload();

                        //close modal
                        $('#cashadvanceModal').modal('toggle');
                    }else{
                        alert(response.message);
                    }
                }
            })
        }
    })//end  tag

    //delete data
    $('#cashadvanceTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // ajax
            $.ajax({
                url:'crud_cashadvance.php',
                type:'post',
                data: { 
                    request: 4,
                     id: id
                    },
                success:function(response){

                    if(response == 1){
                        alert("Record deleted.");

                        // Reload DataTable
                        cashadvanceDatatable.ajax.reload();
                    }else{
                        alert("Invalid ID.");
                        
                    }
                    
                }
            });
        } 
        
    });


})// end  tag