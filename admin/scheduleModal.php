<?php 
  include('database/db_connect.php');
?>
            <!--addPosition Modal -->

            <div id="scheduleModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        
                        <div class="modal-body">
                            <h3> AM </h3>
                            <div class="form-group">
                            <label>Time In</label>
                                <input type="time" class="form-control" id="timein_am" placeholder="Time In" required>            
                            </div>
                            <div class="form-group">
                            <label>Time Out</label>
                                <input type="time" class="form-control" id="timeout_am"  placeholder="Time Out">                          
                            </div>    

                            <h3> PM </h3>
                            <div class="form-group">
                            <label>Time In</label>
                                <input type="time" class="form-control" id="timein_pm" placeholder="Time In" required>            
                            </div>
                            <div class="form-group">
                            <label>Time Out</label>
                                <input type="time" class="form-control" id="timeout_pm"  placeholder="Time Out">                          
                            </div>    


                            <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_update_schedule">Update</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_save_schedule">Save</button>
                            <button type="button" onclick="resetModal()" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                         

                </div>
            </div>

            <script>
        //reset modal
        function resetModal (){
                $('#timein_am').val('');
                $('#timeout_am').val('');
                $('#timein_pm').val('');
                $('#timeout_pm').val('');
                $('#btn_update_schedule').hide();
                $('#btn_save_schedule').show();
               
  }
      </script>