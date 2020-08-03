<?php
session_start();
$error=-1;
if(isset($_POST['submit']))
{
    require 'connect.php';
    $email= $_POST['email'];
    $password= $_POST['password'];
    $result="";
    $result = mysqli_query($con,'select * from user where email="'.$email.'" and password="'.$password.'"');
    if (mysqli_num_rows($result) == 1)
    {
        $_SESSION['email']= $email;
        header('Location: user.php');
    }
    else
    {
        $error=0;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" href="stand.png" type="image/gif" sizes="16x16">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
        <title>HomePage</title>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <?php
        if($error==0)
        {?>
            <script type="text/javascript">
                swal("Sorry!", "Invalid Username or Password!", "error");
            </script>
        <?php
            $error=-1;
        }
        ?>
        <div class="container">
            <header>Login Area</header>
            <form action="" method="POST">
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <div class="button">
                    <div class="inner"></div>
                    <button name="submit">LOGIN</button>
                </div>
            </form>
            <div class="SignUp">
                Password? <a href="forgot.php">Forgot</a><br>
                Not a member? <a href="Signup.php">Sign up Now</a><br>
                <a href="home.php">Back To Home</a>
            </div>
        </div>
    </body>
</html>