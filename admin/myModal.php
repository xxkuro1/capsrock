<?php 
  include('database/db_connect.php');
?>
 
 
 <link href="css/style.css" rel="stylesheet">
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add New Employee</h4>
                            <button type="button" class="close" onclick="resetModal()" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                       
                          
                               
                                <input type="text" class="form-data" id="firstname" placeholder="Enter name" required>            
                           
                         
                                 
                                <input type="text" class="form-data" id="lastname"  placeholder="Enter lastname">                          
                        
                           
                                
                                <input type="text" class="form-data" id="address"  placeholder="Address">                          
                          
                            
                          
                                
                                <input type="number" class="form-data" id="contact"  placeholder="Contact">                          
                            

                            
                            
                                
                                <input type="number" class="form-data" id="pagibig"  placeholder="Pag-ibig #">                          
                      

                      
                                
                                <input type="number" class="form-data" id="sss"  placeholder="SSS #">                          
                     

                      
                                
                                <input type="number" class="form-data" id="philhealth"  placeholder="Philhealth #">                          
                       
                         
                              
                                <input type="date" class="form-data" id="birthdate" placeholder="birthdate">                          
                        
                            
                                
                                <select id="gender" class="form-data">
                                     <option value="">- Select Gender-</option>
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>              
                         

                         
                                
                                <select id='position' class="form-data">
                                
                                    <option value="">- Select Position-</option>
                                    <?php 
                                    // Fetch position
                                   $sql = "SELECT * FROM position";
                                    $position_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($position_data) ){
                                        $id = $row['id'];
                                        $position = $row['position'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$position."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                            

                            
                                    
                            
                          
                                <select id="schedule_am" name="schedule_am" class="form-data">
                                
                                    <option value="">- Select Schedule for AM-</option>
                                    <?php 
                                    // Fetch schedule
                                    $sql = "SELECT * FROM schedules";
                                    $schedule_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($schedule_data) ){
                                        $id = $row['id'];
                                        $timein_am = $row['timein_am'];
                                        $timeout_am = $row['timeout_am'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$timein_am."-".$timeout_am."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                          

                            
                             
                                <select id="schedule_pm" name="schedule_pm" class="form-data">
                                
                                    <option value="">- Select Schedule for PM-</option>
                                    <?php 
                                    // Fetch schedule
                                    $sql = "SELECT * FROM schedules";
                                    $schedule_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($schedule_data) ){
                                        $id = $row['id'];
                                        $timein_pm = $row['timein_pm'];
                                        $timeout_pm = $row['timeout_pm'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$timein_pm."-".$timeout_pm."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_update">Update</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_save">Save</button>
                            <button type="button" onclick="resetModal()" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>

         <!-- updateModal -->
<div id="updateModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Employee Details</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                       
                                <input type="text" class="form-data" id="update_firstname" placeholder="Enter name" required>            
                       
                                <input type="text" class="form-data" id="update_lastname"  placeholder="Enter lastname">                          
                        
                                <input type="text" class="form-data" id="update_address"  placeholder="Address">                          
                           
                                <input type="number" class="form-data" id="update_contact"  placeholder="Contact"> 
                                
                                <input type="number" class="form-data" id="update_pagibig"  placeholder="Pag-ibig #">                          
                      
                                <input type="number" class="form-data" id="update_sss"  placeholder="SSS #">                          
                    
                                <input type="number" class="form-data" id="update_philhealth"  placeholder="Philhealth #">     
                        
                                <input type="date" class="form-data" id="update_birthdate">                          
                          
                   
                                <select id="update_gender" class="form-data">
                                    
                                    <option value='male'>Male</option>
                                    <option value='female'>Female</option>
                                </select>              
                        

                          
                            
                                <select id='update_position' class="form-data">
                                
                                    <option selected id="position_val"></option>
                                      <?php 
                                    // Fetch position
                                   $sql = "SELECT * FROM position";
                                    $position_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($position_data) ){
                                        $id = $row['id'];   
                                        $position = $row['position'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$position."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                          

                           
                                    
                            
                         
                                <select id="update_schedule_am" name="schedule_am" class="form-data">
                                
                                    <option value="">- Select Schedule for AM-</option>
                                    <?php 
                                    // Fetch schedule
                                    $sql = "SELECT * FROM schedules";
                                    $schedule_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($schedule_data) ){
                                        $id = $row['id'];
                                        $timein_am = $row['timein_am'];
                                        $timeout_am = $row['timeout_am'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$timein_am."-".$timeout_am."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                    

                 
                          
                                <select id="update_schedule_pm" name="schedule_pm" class="form-data">
                                
                                    <option value="">- Select Schedule for PM-</option>
                                    <?php 
                                    // Fetch schedule
                                    $sql = "SELECT * FROM schedules";
                                    $schedule_data = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($schedule_data) ){
                                        $id = $row['id'];
                                        $timein_pm = $row['timein_pm'];
                                        $timeout_pm = $row['timeout_pm'];
                                        
                                        // Option
                                        echo "<option value='".$id."' >".$timein_pm."-".$timeout_pm."</option>";
                                    }
                                    ?>
                                                                        
                                </select>              
                        


                            
                        
                        <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_update_edit">Update</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_save_edit">Save</button>
                            <button type="button" onclick="resetModal()" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>                           

      <script>
        //reset modal
        function resetModal (){
                $('#firstname').val('');
                $('#lastname').val('');
                $('#address').val('');
                $('#birthdate').val('');
                $('#contact').val('');
                $('#gender').val('');
                $('#position').val('');
                $('#btn_update').hide();
                $('#btn_save').show();
                $('#schedule_am').val('');
                $('#schedule_pm').val('');
  }
      </script>