<?php
require 'connect.php';
session_start();
$email=$_SESSION['email'];
$error=0;
$questions = array('1'=>'What is your nick name','2'=>'What is your birth place','3'=>'Who is your best friend','4'=>'Where is your school');
if(isset($_POST['submit']))
{
    $Q1= $_POST['Q1'];
    $Q2= $_POST['Q2'];
    $Q3= $_POST['Q3'];
    $Q4= $_POST['Q4'];
    $result = mysqli_query($con,"INSERT into forget (email,Q1,Q2,Q3,Q4) values ('$email','$Q1','$Q2','$Q3','$Q4')");
        header('Location: user.php');
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
        if($error==3) 
        {?>
            <script type="text/javascript">
                swal("Oops!", "Unexpected error Occured!", "error");
            </script>
        <?php
        }
        $error=-1;
        ?>
        <div class="container">
            <header>Security Question</header>
            <form action="" method="POST">
                <div class="input-field">
                    
                    <input type="Name" name="Q1" required>
                    <label><?php echo $questions['1'];?></label>
                </div>
                <div class="input-field">
                    
                    <input type="Name" name="Q2" required>
                    <label><?php echo $questions['2'];?></label>
                </div>
                <div class="input-field">
                    
                    <input type="Name" name="Q3" required>
                    <label><?php echo $questions['3'];?></label>
                </div>
                <div class="input-field">
                    
                    <input type="Name" name="Q4" required>
                    <label><?php echo $questions['4'];?></label>
                </div>
                <div class="button">
                    <div class="inner"></div>
                    <button name="submit">Submit</button>
                </div>
            </form>
        </div>
    </body>
</html>