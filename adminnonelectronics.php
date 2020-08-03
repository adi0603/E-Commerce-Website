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
if(isset($_POST['logout']))
{
  session_destroy();
  header('Location: AdminLogin.php');
}
if (isset($_POST['view'])) {
  $view=$_POST['view1'];
  $_SESSION['view']=$view;
  header('Location: productview.php');
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
              <tr><th colspan="7">Non-Electronics Product List</th></tr>
              <th>Product</th>
              <th>Title</th>
              <th>Discription</th>
              <th>Price</th>
              <th>Category</th>
              <th>User Name</th>
              <th>View</th>
              <?php
              $result1 = mysqli_query($con,"Select * from product where price>0 and type='Non-Electronics'");
                if (mysqli_num_rows($result1) > 0) {
                  while($row = mysqli_fetch_array($result1)) {
                    $email=$row['useremail'];
                    $result2 = mysqli_query($con,"Select name from user where email='$email'");
                    $fetch2=mysqli_fetch_array($result2);
                    ?>
                    <form method="POST">
                    <tr>
                      <td>
                        <img src="image/shop/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" style="border-radius: 10%;width:100px;height: 100px;">
                      </td>
                      <td><?php echo $row["product_name"];?></td>
                      <td><?php echo $row["discription"];?></td>
                      <td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $row["price"];?>.00</td>
                      <td><?php echo $row["type"];?></td>
                      <td><?php echo $fetch2["name"];?></td>
                      <td>
                        <div class="logout">
                          <input type="submit" name="view" value="View">
                          <input type="hidden" name="view1" value="<?php echo $row["product_id"];?>">
                        </div>
                      </td>
                    </tr>
                  </form>
                    <?php
                  }
                }
                else
                {
                  ?>
                  <tr>
                    <th colspan="7">No Product Found</th>
                  </tr>
                  <?php
                }
              ?>
            </tbody>
          </table>
        </div>
      </main>
	</body>
</html>