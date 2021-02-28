<?php

     $conn = new mysqli('localhost', 'root', '', 'capsrock');
	
     if(!$conn){
         die("Error: Cannot connect to the database");
     }

?>