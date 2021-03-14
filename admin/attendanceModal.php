<?php 
  include('database/db_connect.php');
?>
            <!--addAttendance Modal -->

            <div id="attendanceModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                                <label>Emp ID </label>
                                <input type="text" class="form-data" id="emp_id" placeholder="Employee ID" required>            
                       
                                <label>Time in AM</label>
                                <input type="time" class="form-data" id="timein_am" placeholder="Time In" required>            
                        
                            
                                <label>Time out AM</label>
                                <input type="time" class="form-data" id="timeout_am"  placeholder="Time Out">                          
                            
                                <label>Time in PM</label>
                                <input type="time" class="form-data" id="timein_pm" placeholder="Time In" required>            
                            
                           
                                <label>Time out PM</label>
                                <input type="time" class="form-data" id="timeout_pm"  placeholder="Time Out">                          
                             


                            <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_update_attendance">Update</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_save_attendance">Save</button>
                            <button type="button" onclick="resetModal()" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                         

                </div>
            </div>

            <script>
        //reset modal
        function resetModal (){
                $('#emp_id').val('');
                $('#timein_am').val('');
                $('#timeout_am').val('');
                $('#timein_pm').val('');
                $('#timeout_pm').val('');
                $('#btn_update_attendance').hide();
                $('#btn_save_attendance').show();
               
  }
      </script>
        