<?php

require 'DB.php';
$message = "";
$regsuccess = "";
$nameErr = $passErr = $emailErr = "";
$name = $pass = $email = "";

// $baseurl = 'http://codd.cs.gsu.edu/~vmalapati1/Project-2-phpgame/';
if(isset($_POST["user"]) && isset($_POST["pass"]) && isset($_POST["email"]))
{
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
      } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
      }
  if (empty($_POST["user"])) 
  {
    $nameErr = "Name is required";
  } else
   {
    $name = test_input($_POST["user"]);
    if (!preg_match('/^[a-zA-Z0-9]*$/',$name)) 
    {
      $nameErr = "Only letters,Numbers and white space allowed";
    }
  }

  if (empty($_POST["pass"]))
    {
       $passErr = "password is required";
    }
  else
  {
    $pass = test_input($_POST["pass"]);
    $uppercase = preg_match('@[A-Z]@', $pass);
    $lowercase = preg_match('@[a-z]@',$pass);
    $number    = preg_match('@[0-9]@', $pass);

  if(!$uppercase || !$lowercase || !$number) 
  {
  // tell the user something went wrong
      $passErr = "Password should contain lowercase,uppercase,interger";
  }
  else
      {
        $passErr = "";
      }
    }

  if($passErr == "" && $nameErr == "" &$emailErr == "")
  {
    // check if user exist.
      $msg = User_exists($_POST["user"]);
      
      $finduser = false;
      if ($msg){
        $finduser=true;
      }
      
      

      // register user or pop up message
      if( $finduser )
      {
          //echo $_POST["user"];
          //echo ' existed!\r\n';
          $message = "user already exits try another name";
          //include 'register.php';
      }
      else
      {
        $msg1 = write($_POST['user'],md5($_POST['pass']),$_POST['email']);
        if ($msg1)
        {
          //echo $_POST["user"];
          $regsuccess = "registered sucessfullly";
        }
          //echo " registered successfully!";r
          /*
          $file  = fopen("leaderboard_data.txt","a");
          fputs($file,$_POST["user"].";"."0"."\r\n");
          fclose($file);    */ 
      }
   } 
}


function test_input($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
<title> Reg Page   </title>
<style>
.error {color: #FF0000;}


</style>
<link rel="stylesheet" type="text/css" href="css/login_style.css">
</head>
<body><div class="form-style-5">
<h1 class="h1"> Register Here!!!!</h1>
<img src="images/register_logo.jpeg" alt="Registration">
<br>
<form action="" method="post">
    
  
    <label class='label'>  UserName</label>
    <span class="error">* <?php echo $nameErr;?></span>
     <input type="text" name="user" > 
    <label class='label'>PassWord  </label>
    <span class="error">* <?php echo $passErr;?></span>
   <input type="password" name="pass">
   <label class='label'>  Email</label>
   
   <span class="error">* <?php echo $emailErr;?></span>
     <input type="text" name="email" > 
    
  
   <input type="submit" name="reg" value="REG"></td>
    
  
<?php if($message!="") { echo $message; } 
//echo "<br>";
if($regsuccess!=""){ echo "<a href = 'login.php'>login</a>";echo "click to login";
}?>
</form>
</div>


</body>
</html>