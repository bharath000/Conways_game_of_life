<?php


session_start();

if(!isset($_SESSION['user_type']))   // Checking whether the session is already there or not if 
    // true then header redirect it to the home page directly 
{
header("Location:login.php"); 

} 
$name = $_SESSION['use'];
require 'DB.php';

//echo $_SESSION['user_type'];
?>
<html>


<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>


<body>
<nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="#">The L I F E Game</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
           <!-- <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Page 1-1</a></li>
                  <li><a href="#">Page 1-2</a></li>
                  <li><a href="#">Page 1-3</a></li>
                </ul>
              </li>
              <li><a href="#">Page 2</a></li>
              <li><a href="#">Page 3</a></li>
            </ul>-->
            <ul class="nav navbar-nav navbar-right">
              <li><a class = "nav1" href="index.php"><span class="glyphicon glyphicon-user"></span> <?php echo $name; ?></a></li>
              <li><a class="nav1" href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

<div class ="container">
<?php

$user_data = read();

while($row = mysqli_fetch_assoc($user_data)){
echo    "<div class='row'>
      <div class='col-sm-3'>". $row['id']." </div>
      <div class='col-sm-3'>". $row['username']." </div>
      <div class='col-sm-3'>". $row['email']." </div>
      <div class='col-sm-3'><button type='button' class='btn btn-danger'>Delete</button> </div>


      
    </div><br>

";

}

?>
</div>

</body>
    </html>
