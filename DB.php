<?php



function connection(){
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
    
    return $conn;

}


//$test = connection();
//echo $test;


function write($user_name,$user_password,$user_email){
    $msg ="";
   $conn = connection();
    if ($conn){
        $sql = "INSERT INTO users (username, password, email) VALUES ('$user_name','$user_password','$user_email')";
        if (mysqli_query($conn, $sql)) {
            $msg =  True;
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }

    return $msg;

}

function read(){
    $msg ="";
    $conn = connection();
    if ($conn){
        $sql = "SELECT id, username, time, email FROM users";
        $result = mysqli_query($conn, $sql);
        
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            mysqli_close($conn);
           return $result;
        } else {
            mysqli_close($conn);
            $msg = False;
            return $msg;
        }
        
        
   
   
    }

}
function User_exists($username){
    $msg ="";
    $conn = connection();
    if ($conn){
        $sql = "SELECT id, username, password FROM users WHERE username ='$username'";
        $result = mysqli_query($conn, $sql);
        
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            mysqli_close($conn);
            $msg = True;
           return $msg;
        } else {
            mysqli_close($conn);
            $msg = False;
            return $msg;
        }
        
        
       }
}
function read_password_by($username,$password,$conn){
    $msg ="";
   // $conn = connection();
    if ($conn){
        $md5_password = md5($password);
        $sql = "SELECT id, username, password FROM users WHERE username ='$username' and password = '$md5_password'";
        $result = mysqli_query($conn, $sql);
        
        
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            // $row = mysqli_fetch_assoc($result);

            mysqli_close($conn);
                 
                 $msg = True;
            return $msg;
            // if (md5($password) == $row['password']){
            //         mysqli_close($conn);
                 
            //      $msg = True;
            // return $msg;
            // }
            // else{
            //     mysqli_close($conn);
            //     //echo "llll";
            //     $msg = False;
            // return $msg;

            // }
        } else {
            mysqli_close($conn);
            $msg = 'error';
            return $msg;
            
        }
        
        
       }
}

function check_admin($user){
    $msg = "";
    $conn = connection();
    if($conn){
        $sql = "SELECT user_type FROM users WHERE username = '$user'";

        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $row = mysqli_fetch_assoc($result);
            if ($row['user_type'] == 'admin'){
                    mysqli_close($conn);
                 
                 $msg = True;
            return $msg;
            }
            else{
                mysqli_close($conn);
                //echo "llll";
                $msg = False;
            return $msg;

            }

    }
}
}

function time_stamp($time,$user){
    $msg = "";
    $conn = connection();
    if($conn){
        $sql = "UPDATE users SET time='$time' Where username ='$user' ";
        mysqli_query($conn, $sql);
        
        mysqli_close($conn);

    }

}



//$test = read_by(1);
//$xx = write('john','John1','John@gmail.com');
//echo $xx;
//$test = read();

//print_r(mysqli_num_rows($test));
//print_r(mysqli_fetch_assoc($test));

//$xx = User_exists('john');

//echo $xx;


?>