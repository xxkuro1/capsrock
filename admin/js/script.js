$(document).ready(function(){
    $('#btn_update').hide();
    $('#btn_update_position').hide();
    
    // DataTable
    var userDataTable = $('#userTable').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        destroy:true,
        'ajax': {
            'url':'crud.php'
        },
        'columns': [
            { data: 'employee_id' },
            { data: 'firstname' },
            { data: 'lastname' },
            { data: 'address' },
            { data: 'birthdate' },
            { data: 'contact' },
            { data: 'gender' },
            {data: 'action'}
        ]
    });


    // fetch record
    $('#userTable').on('click','.updateUser',function(){
        $('#btn_update_edit').show();
        $('#btn_save_edit').hide();
        var id = $(this).data('id');
        
        $('#txt_userid').val(id);
        
        // ajax
        $.ajax({
            
            url: 'crud.php',
            type: 'post',
            data: 
            {
                request: 2, 
                id: id
            },
            dataType: 'json',
            success: function(response){
               
                if(response.status == 1){
                   
                    $('#employee_id').val(response.data.employee_id);
                    $('#update_firstname').val(response.data.update_firstname);
                    $('#update_lastname').val(response.data.update_lastname);
                    $('#update_address').val(response.data.update_address);
                    $('#update_birthdate').val(response.data.update_birthdate);
                    $('#update_contact').val(response.data.update_contact);
                    $('#update_pagibig').val(response.data.update_pagibig);
                    $('#update_sss').val(response.data.update_sss);
                    $('#update_philhealth').val(response.data.update_philhealth);
                    $('#update_gender').val(response.data.update_gender);
                    $('#position_val').val(response.data.position_val);
                    $("#updateModal").removeData("modal");
                }else{
                    alert("Invalid ID.");
                }
            }
        });
        
    });//end  tag for fetch record


    // update user 
    $('#btn_update_edit').click(function(){
        var id = $('#txt_userid').val();
       
        var firstname = $('#update_firstname').val().trim();
        var lastname = $('#update_lastname').val().trim();
        var address = $('#update_address').val().trim();
        var birthdate = $('#update_birthdate').val().trim();
        var contact = $('#update_contact').val().trim();
        var gender = $('#update_gender').val().trim();

        if(firstname !='' && lastname != '' && address != ''){

            // ajax
            $.ajax({
                url: 'crud.php',
                type: 'post',
                data: {request: 3, id: id,
                    firstname: firstname,
                     lastname: lastname,
                      address: address, 
                      birthdate: birthdate,
                      contact: contact,
                      gender: gender,
                    },
                dataType: 'json',
                success: function(response){
                    if(response.status == 1){
                        alert(response.message);

                        // Empty the fields
                        $('#update_firstname','#update_lastname','#update_address','#update_birthdate','#update_contact').val('');
                        $('#update_gender').val('');
                        $('#txt_userid').val(0);

                        // Reload DataTable
                        userDataTable.ajax.reload();

                        // Close modal
                        $('#updateModal').modal('toggle');
                       
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
    $('#userTable').on('click','.deleteUser',function(){
        var id = $(this).data('id');

        var deleteConfirm = confirm("Are you sure?");
        if (deleteConfirm == true) {
            // ajax
            $.ajax({
                url: 'crud.php',
                type: 'post',
                data: {
                    request: 4,
                     id: id
                    },
                success: function(response){

                    if(response == 1){
                        alert("Record deleted.");

                        // Reload DataTable
                        userDataTable.ajax.reload();
                    }else{
                        alert("Invalid ID.");
                    }   
                    
                }
            });
        } 
        
    });
    

    //save user
    $('#btn_save').on('click',function(){
        //validation
        if($('#firstname').val() == "" || 
            $('#lastname').val() == "" ||
            $('#address').val() == "" || 
            $('#birthdate').val()=="" ||
            $('#contact').val()==""||
            $('#pagibig').val()==""||
            $('#sss').val()==""||
            $('#philhealth').val()==""||
            $('#gender').val() == "" ||
            $('#schedule_am').val() == ""||
            $('#position').val() == "" ||
            $('#photo').val() == ""  
          
            ){
                alert("Please fill in all fields")
        }
         else{
        //get data
        $('#btn_update').hide();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var address = $('#address').val();
        var birthdate = $('#birthdate').val();
        var contact = $('#contact').val();
        var pagibig = $('#pagibig').val();
        var sss = $('#sss').val();
        var philhealth = $('#philhealth').val();
        var gender = $('#gender').val();
        var schedule_am = $('#schedule_am').val();    
        var position = $('#position').val();
        var photo = $('#photo').val();
        
        //ajax
        $.ajax({

            url:'crud.php',
            type:'POST',
            data: {
                request:5,
                firstname: firstname,
                lastname: lastname,
                address: address,
                birthdate: birthdate,
                contact: contact,
                pagibig: pagibig,
                sss: sss,
                philhealth: philhealth,
                gender: gender,
                schedule_am: schedule_am,
                position: position,
                photo: photo
            },
            success: function(){
                $('#firstname').val();
                $('#lastname').val();
                $('#address').val();
                $('#birthdate').val();
                $('#contact').val();
                $('#pagibig').val();
                $('#sss').val();
                $('#philhealth').val();
                $('#gender').val();
                $('#schedule_am').val();
                $('#position').val();
                $('#photo').val();
                alert("Data added successfully")
                userDataTable.ajax.reload();
                //clear data
                $('#firstname').val('');
                $('#lastname').val('');
                $('#address').val('');
                $('#birthdate').val('');
                $('#contact').val('');
                $('#pagibig').val('');
                $('#sss').val('');
                $('#philhealth').val('');
                $('#gender').val('');
                $('#schedule_am').val('');
                $('#position').val('');
                $('#photo').val('');
               alert(photo);
            }
        });// end tag for ajax
    
    
    }

    });//end tag for save data

   


    //form validation
    $('#login-form').validate({
        
        rules: {

            password:{
                required: true,
            },
            username: {
                required: true,
            
            },

        },
        messages:{
            
            password:{
                required: "Please enter your password"
            },
            username:{
                required: "Please enter your username",
            }
        },
        submitHandler: submitForm
    }); //end tag for form validation


    //login function
    function submitForm(){
        //declare variable
        var data= $("#login-form").serialize();
        
        //ajax
        $.ajax({
            type: 'POST',
            url: 'login.php',
            data: data,
            beforeSend: function(){
                $("#error").fadeOut();
                $("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
                
            },
           
            success: function(response){
                if(response == "ok" ){
                    $("#login_button").html('<img src="ajax-loader.gif" /> &nbsp; Signing In ...');
                    setTimeout('window.location.href = "welcome.php";',4000);
                }else{
                    $("#error").fadeIn(1000,function(){

                 
                    $("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
                    $("#login_button").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
                });
                }


            }
        });//end  tag for ajax
        return false;
    }//end tag for submit form
});