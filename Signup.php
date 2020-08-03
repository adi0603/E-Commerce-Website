<?php
session_start();
require 'connect.php';
$error=-1;
if(isset($_POST['submit']))
{
    $name= $_POST['name'];
    $email= $_POST['email'];
    $mobile=$_POST['mobile'];
    $password= $_POST['password'];
    $password1=$_POST['password1'];
    $word="@gla.ac.in";
    if (($password!=$password1) || (strpos($email, $word) == false)) 
    {
        $error=1;
    }
    else
    {
        $result = mysqli_query($con,'select * from user where email="'.$email.'"');
        if(mysqli_num_rows($result)==0)
        {
            $result = mysqli_query($con,"INSERT into user (name,email,mobile,password) values ('$name','$email','$mobile','$password')");
        $_SESSION['email']=$email;
        //header('Location: question.php');
        }
        else
        {
            $error=0;
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="stand.png" type="image/gif" sizes="16x16">
        <title>HomePage</title>
        <link rel="stylesheet" href="css/login.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    </head>
    <body>
        <?php
        if($error==0)
        {?>
            <script type="text/javascript">
                swal("Sorry!", "You already have an account! Please login.", "error");
            </script>
        <?php
        }
        elseif($error==1) 
        {?>
            <script type="text/javascript">
                swal("Oops!", "Password mismatched!", "error");
            </script>
        <?php
        }
        ?>
        <div class="container">
            <header>Sign up Area</header>
            <form action="" method="POST">
                <div class="input-field">
                    <input type="Name" name="name" required>
                    <label>Name</label>
                </div>
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-field">
                    <input type="number" name="mobile" required>
                    <label>Mobile Number</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password1" required>
                    <label>Confirm Password</label>
                </div>
                <div class="button">
                    <div class="inner"></div>
                    <button name="submit">Sign up</button>
                </div>
            </form>
            <div class="Login">
                Already member? <a href="Start.php">Login</a><br>
                <a href="home.php">Back To Home</a>
            </div>
        </div>
    </body>
</html>