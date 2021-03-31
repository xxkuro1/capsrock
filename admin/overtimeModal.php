<?php 
  include('database/db_connect.php');
?>
            <!--addovertime Modal -->

            <div id="overtimeModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                       
                            <div class="form-group">
                               
                                <input type="text" class="form-control" id="emp_id" placeholder="Enter Employee ID" required>            
                            </div>
                            <div class="form-group">
                                 
                                <input type="number" class="form-control" id="hours"  placeholder="Enter Hours">                          
                            </div>    
                            <div class="modal-footer">
                            <input type="hidden" id="txt_userid" value="0">
                            <button type="button" class="btn btn-success btn-sm" id="btn_update_overtime">Update</button>
                            <button type="button" class="btn btn-success btn-sm" id="btn_save_overtime">Save</button>
                            <button type="button" onclick="resetModal()" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                        </div>
                         

                </div>
            </div>

            <script>
        //reset modal
        function resetModal (){
                $('#position').val('');
                $('#rate').val('');
                $('#btn_update_position').hide();
                $('#btn_save_position').show();
               
  }
      </script>