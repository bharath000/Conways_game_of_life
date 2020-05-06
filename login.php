<?php session_start();?>
<?php

require 'DB.php';
$message = "";

if(isset($_SESSION['use']))   // Checking whether the session is already there or not if 
  {
    header("Location:index.php"); 
  }
  $servername = "localhost";
  $username = "vmalapati1";
  $password = "vmalapati1";
  $dbname = "vmalapati1";
  $msg = "";

// Create connection
  $conn = mysqli_connect($servername, $username, $password,$dbname);


// Check connection
  if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
  $msg = "not connected";
  }
  else{
  $msg = "Connected successfully";
  }
  
  //return $conn;
$nameErr = $passErr = $emailErr = "";
$name = $pass = $email = "";
if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
{
  if (empty($_POST["user"])) 
    {
        $nameErr = "Name is required";
    } 
  if (empty($_POST["pass"]))
  {
      $passErr = "Password is required";
    }
  if($passErr == "" && $nameErr == "")
  {
      echo "no errors in first checkpoint";
      $msg = False;
      $user = $_POST['user'];
      $pass = $_POST['pass'];
      // comparison of user profiles
      if(isset($_POST["user"]) && isset($_POST["pass"]))
      {
        echo "no errors in second checkpoint";
        echo "value of msg".$msg;
        $msg = read_password_by($user,$pass,$conn);
        echo "value of msg after read_password_by".$msg;
        //echo $msg;
        $good=False;
        if ( $msg == "True"){
          echo "\n erorr equals to true";
        $good = True;
    }
      if($good)
      {
       $msg1 = check_admin($user);
       
       if($msg1){
        $_SESSION['user_type'] = 'admin';

       }
          $_SESSION['use'] = $user;
          // echo '<script type="text/javascript"> window.open("home.php","_self");</script>';  
          header("Location:index.php");
        }
      else
      {
          $message =  "Invalid UserName or Password Please Retry";
         // echo "Invalid UserName or Password";
        } 
     // fclose($file);
      }
  }
}
?>



<html>
<head>
<title> Login Page   </title>
<style>
.error {color: #FF0000;}
</style>
<link rel="stylesheet" type="text/css" href="css/login_style.css">
</head>
<body><div class="form-style-5">
<h1 class="h1"> Login Here </h1>
<img src="images/login.png" alt="Registration">
<br><br>
<form action="./login.php" method="post">
    <label class='label'>Username</label>
    <span class="error">* <?php echo $nameErr;?></span>
    <input type="text" name="user" > 
    
    <label class='label'>Password</label>
    <span class="error">* <?php echo $passErr;?></span>
    <input type="password" name="pass">
    

   <input type="submit" name="login" value="LOGIN">
  

<a href = 'register.php'>Register/Signup</a>
<p><?php if($message!="") {
  
  echo '<h4 class = "error">'.$message.'</h4>'; 
  
  
  } ?></p>
</form>
