<?php
session_start();
if($_SESSION['email'] == "")
{
  header('Location: AdminLogin.php');
}
require 'connect.php';
$email=$_SESSION['email'];

$result = mysqli_query($con,'select * from admin where email="'.$email.'"');
$fetch=mysqli_fetch_array($result);
$view=$_SESSION['view'];
$result1 = mysqli_query($con,"select * from product where product_id='$view'");
$fetch1=mysqli_fetch_array($result1);
if(isset($_POST['logout']))
{
  session_destroy();
  header('Location: AdminLogin.php');
}
if (isset($_POST['update'])) {
  $status=$_POST['id'];
  $result2 = mysqli_query($con,"update product set status='$status' where product_id='$view'");
  header('Location: admin.php');
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
    <main class="page-main">
      <div class="container">
          <table>
            <tbody>
              <tr><th colspan="5">Product View</th></tr>
              <form method="POST">
              <tr>
                <td colspan="3" rowspan="2">
                  <img src="image/shop/<?php echo $fetch1['image']; ?>" alt="<?php echo $fetch1['product_name']; ?>" style="border-radius: 10%;width:300px;height: 300px;">
                </td>
                <td><?php echo $fetch1['product_name']; ?></td>
                <td></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo $fetch1['discription']; ?></td>
              </tr>
              <tr>
                <td>Price</td>
                <td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $fetch1["price"];?>.00</td>
                <td colspan="1">Category</td>
                <td colspan="2"><?php echo $fetch1["type"];?></td>
              </tr>
              <tr>
                <td colspan="2">Status</td>
                <td colspan="2">
                  <div class="labs">
                    <select name="id">
                      <option value="1">Approve</option>
                      <option value="2">Reject</option>
                    </select>
                  </div>
                </td>
                <td>
                  <div class="logout">
                    <input type="submit" name="update" value="Update Status">
                  </div>
                </td>
              </tr>
            </form>
            </tbody>
          </table>
          <center>
            <a href="admin.php"> <&nbsp;Back </a>
          </center>
        </div>
      </main>
	</body>
</html>