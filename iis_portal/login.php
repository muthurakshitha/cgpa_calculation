<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $ureg = $_POST["ureg"];

  $_SESSION["ureg"] = $ureg;
 

}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <form method="post" >

      
        <div class="container">
          <label for="ureg"><b>Reg no</b></label>
          <input type="text" placeholder="Enter Reg no" name="ureg" required>
      
      
          <a href="firstpage.php"><button type="submit"  href="firstpage.php">Submit</button></a>
        
        </div>
      
        <div class="container" style="background-color:#f1f1f1">
          <button type="button" class="cancelbtn">Cancel</button>
          <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
      </form>
    </body>
    </html>



