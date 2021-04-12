$(document).ready(function(){

    //form validation
    $('#login-form').validate({
        
        rules: {

            password:{
                required: true,
            },
            emp_id: {
                required: true,
            
            },

        },
        messages:{
            
            password:{
                required: "Please enter your password"
            },
            emp_id:{
                required: "Please enter your Employee Id",
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
                    $("#login_button").html('<img src="admin/ajax-loader.gif" /> &nbsp; Signing In ...');
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

})//end tag