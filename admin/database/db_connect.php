<?php

     $conn = new mysqli('localhost', 'root', '123456', 'capsrock');
	
     if(!$conn){
         die("Error: Cannot connect to the database");
     }

?>