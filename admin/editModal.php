
<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
          	<div class="modal-header">
            	
      
              <h4 class="modal-title"><b>Add</b></h4>
              
          	</div>
          	<div class="modal-body">
            	<form id="update" class="form-horizontal" method="POST">
          		  <div class="form-group">
                  
						
                  	<div class="col-sm-9">
            <input type="text" class="form-control" id="fn" required placeholder="Firstname">
              <span id="error_first_name" class="text-danger" ></span>
					
                  	</div>
                </div>
                <div class="form-group">
                  	

                  	<div class="col-sm-9">
                    	<input type="text" class="form-control" id="ln" required placeholder="Lastname">
                       <span id="error_last_name" class="text-danger" ></span>
                  	</div>
                </div>
                <div class="form-group">
                  	
					 
                  	<div class="col-sm-9">
					  
                      <input type="text" class="form-control" id="addr" required placeholder="Address">
		
                  	</div>
					  
                </div>
                
                <div class="form-group">
                    

                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="con" required placeholder="Contact"> 
                         <span id="error_contact" class="text-danger" ></span>
                    </div>
                </div>
               
                <div class="form-group">
                    

                    <div class="col-sm-9"> 
                      <select class="form-control" id="gen" required>
                        <option value="" selected>- Gender -</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                      <span id="error_gender" class="text-danger" ></span>
                    </div>
        </div>
        <div class="form-group">
                  	<label for="datepicker_add" class="col-sm-3 control-label">Birthdate</label>

                  	<div class="col-sm-9"> 
                      <div class="date">
                        <input type="date" class="form-control" id="dob" required>
                         <span id="error_birth_date" class="text-danger"  ></span>
                      </div>
                  	</div>
                </div>
				<div class="modal-footer">
			<button type="button" class="btn btn-success" id="Update" >Update</button>
			<button type="button" onclick="resetModal()" class="btn btn-danger" data-dismiss="modal">Close</button>
      </form>


</div>
</div>
</div>
</div>
