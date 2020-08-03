<?php
session_start();
if($_SESSION['email'] == "")
{
  header('Location: home.php');
}
require 'connect.php';
$email=$_SESSION['email'];

$result = mysqli_query($con,'select * from user where email="'.$email.'"');
$fetch=mysqli_fetch_array($result);

$display=0;
if(isset($_POST['logout']))
{
  session_destroy();
  header('Location: home.php');
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
            <a class="nav-link" href="user.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="userelectronics.php">Electronics</a>
              <a class="dropdown-item" href="usernonelectronics.php">Non Electronics</a>
            </div>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="sell.php">Sell</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="userabout.php">About</a>
          </li>
        </ul>
        <button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='cart.php'"><i class="fas fa-shopping-cart"></i>&nbsp;&nbsp;Cart</button>&nbsp;
    		<button class="btn btn-outline-success my-2 my-sm-0" onclick="location.href='userinfo.php'"><i class="fas fa-user"></i>&nbsp;&nbsp;<?php echo $fetch['name'];?></button>&nbsp;
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
              <form method="POST" action="TxnStatus.php">
              <tr><th colspan="6">Your Orders</th></tr>
              <th>Select</th>
                <th>Product</th>
                <th>Name</th>
                <th>Discription</th>
                <th>Price</th>
                <th>Order ID</th>
              <?php
                  $result = mysqli_query($con,"select * from cart join product where cart.useremail='$email' and cart.product_id=product.product_id and cart.status='1'");
                  if (mysqli_num_rows($result) > 0) {
                      while($row = mysqli_fetch_array($result)) {
                        $display=1;
                        ?>
                        <tr>
                            <td><input type="radio" name="item" value="<?php echo $row["product_id"];?>" required></td>
                            <td>
                              <img src="image/shop/<?php echo $row['image']; ?>" alt="<?php echo $row['product_name']; ?>" style="border-radius: 10%;width:50px;height: 50px;">
                            </td>
                            <td><?php echo $row["product_name"];?></td>
                            <td><?php echo $row["discription"];?></td>
                            <td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $row["price"];?>.00</td>
                            <td><?php echo $row["order_id"];?></td>
                        </tr>
                        <?php
                      }
                    }
                    else {
                    ?>
                    <tr>
                      <td colspan="6"><?php echo "You haven't ordered yet."; ?></td>
                    </tr>
                   <?php
                 }
                 if ($display==1) {
                  ?>
                  <tr>
                      <td colspan="6">
                          <div class="logout">
                            <input type="submit" name="select" value="Select">
                          </div>
                      </td>
                    </tr>
                  <?php
                 }
                ?>
              </form>
            </tbody>
          </table><br>
        </div>
      </main>
    </div>
	</body>
</html>