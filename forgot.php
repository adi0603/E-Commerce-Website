<?php
session_start();
require 'connect.php';
$error="";
$success=-1;
$questions = array('1'=>'What is your nick name ?','2'=>'What is your birth place ?','3'=>'Who is your best friend ?','4'=>'Where is your school ?');
$randomnumber=0;
if(isset($_POST['submit']))
{
    $email= $_POST['email'];
    $answer= $_POST['answer'];
    $random= $_POST['ran'];
    $result = mysqli_query($con,"select * from forget where email='".$email."'");
    if(mysqli_num_rows($result)==1)
    {   $Q='Q'.$random;
        $fetch=mysqli_fetch_array($result);
        if($fetch[$Q]==$answer)
        {
            $result = mysqli_query($con,"select * from user where email='".$email."'");
            $fetch=mysqli_fetch_array($result);
            $error="Your Password is '' ".$fetch['password']." ''. Please reset your Password after login";
            $success=1;
        }
        else
        {
            $error="Wrong answer";
            $success=0;
        }
    }
    else
        {
            $error="User email not Found";
            $success=0;
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
        if ($success==1)
        {?>
            <script type="text/javascript">
                swal("Congrats!","<?php echo($error) ?>", "success");
            </script>
            <?php
        }
        elseif($success==0)
        {?>
            <script type="text/javascript">
                swal("Sorry!","<?php echo($error) ?>", "error");
            </script>
        <?php
        }
        ?>
        <div class="container">
            <header>Forgot Area</header>
            <form action="" method="POST">
                <?php $randomnumber=rand(1,4);?>
                <div class="input-field">
                    <input type="email" name="email" required>
                    <label>Email</label>
                </div>
                <div class="input-field">
                    <input type="text" name="answer" required>
                    <label><?php echo $questions[$randomnumber];?></label>
                </div>
                <input type="hidden" id="ran" name="ran" value="<?php echo $randomnumber; ?>">
                <div class="button"> 
                    <div class="inner"></div>
                    <button name="submit">SUBMIT</button>
                </div>
            </form>
            <div class="Forgot">
                Back To <a href="Start.php">Login</a><br>
                <a href="home.php">Back To Home</a>
            </div>
        </div>
    </body>
</html>