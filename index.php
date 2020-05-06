<?php 

session_start();
if(!isset($_SESSION['use']))   // Checking whether the session is already there or not if 
    // true then header redirect it to the home page directly 
{
header("Location:login.php"); 
} 

require 'DB.php';
$name = $_SESSION['use'];
//$s = score_r($name);
//echo $s;
//upd_leaderboard($name, $s);
$score = 0;
//echo $score;
$file = fopen('leaderboard_data.txt', 'r');
$good=false;
/*while(!feof($file)){
    $line = fgets($file);
    $array = explode(";",$line);
    if(trim($array[0]) == $name && trim($array[1]) != "" ){
        $score = trim($array[1]);
        break;
    }
}
fclose($file);*/
function score_r($data){
    $file = fopen('U_scorefiles/levelscore_data'.$data.'.txt', 'r');
    
    $line = fgets($file);
    $array = explode(";",$line);
    //fputs($file,$data.";"."\r\n");
    fclose($file);
    //echo "jjjj".$array[0];
    return (int)$array[0];
}
function upd_leaderboard($user,$data){
    $reading  = fopen('leaderboard_data.txt','r');
    $writing = fopen('leaderboard_data_tmp.txt', 'w'); /// session name need to be used
    while(!feof($reading)){
        $line = fgets($reading);
        $array = explode(";",$line);
        if($array[0] == $user){    //// update with session
            //echo $user;
            if((int)$array[1] < (int)$data){
              //  echo "hi";
                $array[1] = $data;
                $line = $array[0].";".$array[1]."\r\n";
                $replaced = true;
            }
        }  
        fputs($writing,$line); 

    }
    fclose($reading);fclose($writing);
    if ($replaced){
        rename('leaderboard_data_tmp.txt', 'leaderboard_data.txt');
    }else{unlink('leaderboard_data_tmp.txt');}

   /* $file = fopen('leaderboard_data.txt', 'a');
    while(!feof($file)){
        $line = fgets($file);
        $array = explode(";",$line);
        if($array[0] == $_SESSION['usr']){
            $array[1] = $data;
            break;
        }
    break;
    }*/
}


?>



<html>
<head>
<style>
.flex-container{
  display: flex;
  
  
  margin:10px;
    padding:20px;
 
}
.flex-container1{
  display: flex;
  border: 2px solid black;
  width:45%;
  float:right;
  background:transparent;
  margin:10px;
    padding:20px;
 
}
.profile{
    width:40%;
    border:transparent;
    border:2px solid transparent;
    background-color:white;
    margin:10px;
    padding:20px;
    border-radius:10px;
}
.leaderboard{
    width:60%;
   border:transparent;
    background-color:white;
    margin:10px;
    padding:20px;
    border-radius:10px;
}

.bars{
    background-color:#d7dfe9;
    color:white;
    width:90%;
    padding:10px;
    margin:auto;
}

    td{
        width:5%;
        text-align:center;
        padding:5px;
        margin:20px auto;
        color:#707070;

    }


body{
font-family:  sans-serif;
background: -webkit-linear-gradient(110deg, #a60af3 40%, rgba(0, 0, 0, 0) 30%), -webkit-radial-gradient(farthest-corner at 0% 0%, #7a00cc 70%, #c03fff 70%);
    background: -o-linear-gradient(110deg, #a60af3 40%, rgba(0, 0, 0, 0) 30%), -o-radial-gradient(farthest-corner at 0% 0%, #7a00cc 70%, #c03fff 70%);
    background: -moz-linear-gradient(110deg, #a60af3 40%, rgba(0, 0, 0, 0) 30%), -moz-radial-gradient(farthest-corner at 0% 0%, #7a00cc 70%, #c03fff 70%);
    background: linear-gradient(110deg, #a60af3 40%, rgba(0, 0, 0, 0) 30%), radial-gradient(farthest-corner at 0% 0%, #7a00cc 70%, #c03fff 70%);

/*background: -webkit-linear-gradient(70deg, #fff810  30%, rgba(0,0,0,0) 30%), -webkit-linear-gradient(30deg, #63e89e 60%, #ff7ee3 60%);
    background: -o-linear-gradient(70deg, #fff810  30%, rgba(0,0,0,0) 30%), -o-linear-gradient(30deg, #63e89e 60%, #ff7ee3 60%);
    background: -moz-linear-gradient(70deg, #fff810  30%, rgba(0,0,0,0) 30%), -moz-linear-gradient(30deg, #63e89e 60%, #ff7ee3 60%);
    background: linear-gradient(70deg, #fff810  30%, rgba(0,0,0,0) 30%), linear-gradient(30deg, #63e89e 60%, #ff7ee3 60%);
*/
}
.leaderboardh1{
    text-align:center;
}
.imgp{
    margin:auto;
    
}
.button{
    background-color: darkblue; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}
.button:hover {
  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
}
a:link, a:visited {
  
  color: white;
  background: darkblue;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-family:  sans-serif;
  margin: auto;
  
 
}

a:hover, a:active {
  
  align-content:  center;
}
.h4{
    padding:10px;
}
</style>
<title>Game Profile</title>

</head>
<body>

<div class="flex-container">
 <div class="profile">   
     <img src = "images/profile.png" class='imgp'>
<h1>Hi <?php echo $_SESSION['use']; ?></h1>
<h1>Your Highest Score : <?php echo $score; ?></h1>
<h4 > <a href='index_rules.html' class='h4'>See the Game Rules </a></h4>
<button onclick="location.href = 'game.php';" class="button">Let's Start the Game</button>
<button class='button'>
<a href="logout.php" target="">Logout</a></button>
</div>

<div class="leaderboard">
    <h1 class='leaderboardh1'> Leader board</h1>
    <div class="bars">
    <table>
    <tr>
    <td>
        S. NO
</td>
<td>
        User_Name
</td>
<td>
        Time-Stamp
</td>
</tr>
</table>
</div><br>
    <?php
    $user_data = read();
    while($row = mysqli_fetch_assoc($user_data)){
        
        echo "<div class= 'bars'>
        <table class='table'>
        <tr>
        <td>";
        echo $row['id'] ;echo"
        </td> 
        <td width='300%'>";
        echo $row['username'] ; echo "
        </td>
        <td>";
        echo $row['time'] ;  echo "
        </td>
        
        </tr>
        </table>
        
        
        </div><br>";
        
        
        }
    

            
?>
</div>
</div>
</div>

</body>
</html>