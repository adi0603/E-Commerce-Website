<?php
session_start();
if($_SESSION['email'] == "")
{
  header('Location: AdminLogin.php');
}
require 'connect.php';
$email=$_SESSION['email'];
$error=-1;
$result = mysqli_query($con,'select * from admin where email="'.$email.'"');
$fetch=mysqli_fetch_array($result);

$emailteam="";
$name="";
$email="";
$mobile="";
$address="";
if(isset($_POST['selectmember']))
{
    $emailteam= $_POST['id'];
    $result1 = mysqli_query($con,'select * from team where email="'.$emailteam.'"');
    $fetch1=mysqli_fetch_array($result1);
    $name=$fetch1['name'];
    $mobile=$fetch1['mobile'];
    $address=$fetch1['address'];
    $_SESSION['emailteam']=$emailteam;
}
if(isset($_POST['modify']))
{
    $email1=$_SESSION['emailteam'];
    $name=$_POST['name'];
    $mobile=$_POST['mobile'];
    $address=$_POST['address'];
    $result5 = mysqli_query($con,'update team set name="'.$name.'",mobile="'.$mobile.'",address="'.$address.'" where email="'.$email1.'"');
    $name="";
    $mobile="";
    $address="";
    $error=1;
}
if(isset($_POST['remove']))
{
  $email1=$_SESSION['emailteam'];
  $result6 = mysqli_query($con,'delete from team where email="'.$email1.'"');
  $error=2;
  $name="";
  $mobile="";
  $address="";
}

if(isset($_POST['logout']))
{
  session_destroy();
  header('Location: AdminLogin.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>GLA Waste & Reselling Management System</title>
        <link rel="icon" href="stand.png" type="image/gif" sizes="16x16">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ab99e84824.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css">
    <script type="text/javascript" src="js/printlist.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
   <style type="text/css">
    .labs select {
  border: 0 !important;  
  background-color : green;
  border-radius: 20px;
  width: 170px; 
  text-decoration: none;
  font-weight: bold;
  letter-spacing: 0.1px; 

  color: white;
  
  padding: 8px;
  border:1px solid gray !important;
}
.labs select:focus {
  outline: none;
}
  </style>
  </head>
  <body>
    <?php
    if ($error==1)
    {?>
      <script type="text/javascript">
            swal("Congrats!", "Team Member data has been modified successfully!", "success");
          </script>
      <?php
      $error=-1;
    }
    elseif ($error==2) {
      ?>
      <script type="text/javascript">
            swal("Congrats!", "Team Member data has been deleted successfully!", "success");
          </script>
      <?php
      $error=-1;
    }
    ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">GLA WARMS</a>
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item active">
            <a class="nav-link" href="admin.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="userlist.php">User</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="adminelectronics.php">Electronics</a>
              <a class="dropdown-item" href="adminnonelectronics.php">Non Electronics</a>
            </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="adminsold.php">Sold Product</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="adminabout.php">About</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="adminteam.php">Team</a>
          </li>
        </ul>
            <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='admininfo.php'"><i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $fetch['name'];?></button>&nbsp;
        <form method="POST">
         <button class="btn btn-outline-success my-2 my-sm-0" name="logout"><i class="fas fa-sign-out-alt"></i>&nbsp;Logout</button>
        </form>
        </div>
        </nav>
        <div class="wrapper">
            <main class="page-main">
        <div class="container">
          <table>
            <tbody>
              <tr>
                <th colspan="3">Remove / Modify Team Members</th>
              </tr>
              <form method="POST">
                <th>Select member email</th>
                <th>
              <div class="labs">
                
              <select name="id">
                <?php
                  $result3 = mysqli_query($con,'select * from team');
                  if (mysqli_num_rows($result3) > 0) {
                    while($row = mysqli_fetch_array($result3)) {
                      ?>
                        <option value="<?php echo $row['email'];?>"><?php echo $row['email'];?></option>
                      <?php
                    }
                }?>
              </select>
            
            </div>
            </th>
            <th>
            <div class="logout">
              
              <input type="submit" name="selectmember" value="Select">                  
            </div>
          </th>
            </form>
              <form method="POST">
                <tr>
                  <td>Name</td>
                  <td colspan="2">
                    <div class="textbox">
                      <input type="text" name="name" class="nice" value="<?php echo $name;?>" required>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td colspan="2">
                    <div class="textbox">
                      <input type="email" name="email" class="nice" value="<?php echo $emailteam;?>"  disabled>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Mobile</td>
                  <td colspan="2">
                    <div class="textbox">
                      <input type="number" name="mobile" class="nice" value="<?php echo $mobile;?>" required>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Address</td>
                  <td colspan="2">
                    <div class="textbox">
                      <input type="text" name="address" class="nice" value="<?php echo $address;?>" required>
                    </div>
                  </td>
                </tr>
                <td colspan="3">
                  <div class="logout">
                    <input type="submit" name="modify" value="Modify">&nbsp;
                    <input type="submit" name="remove" value="Remove">         
                  </div>
                </td>
              </form>
            </tbody>
          </table>
        </div>
      </main>
    </div>
    </body>
</html>