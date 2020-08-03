<?php 
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

session_start();
if($_SESSION['email'] == "")
{
  header('Location: home.php');
}
    header("Pragma: no-cache");
    header("Cache-Control: no-cache");
    header("Expires: 0");

require 'connect.php';
$email=$_SESSION['email'];
$item=$_SESSION['item'];
$result = mysqli_query($con,'select * from user where email="'.$email.'"');
$fetch=mysqli_fetch_array($result);


if(isset($_POST['logout']))
{
  session_destroy();
  header('Location: home.php');
}

// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.

if($isValidChecksum == "TRUE") {
	// echo "<b>Checksum matched and following are the transaction details:</b>" . "<br/>";
	if ($_POST["STATUS"] == "TXN_SUCCESS") {
		$order_id=$_POST["ORDERID"];
		$result2 = mysqli_query($con,"update cart set status='1', order_id='$order_id' where useremail='$email' and product_id='$item'");
    $result3 = mysqli_query($con,"update product set status='3' where product_id='$item'");
    $result4 = mysqli_query($con,"DELETE FROM cart WHERE product_id='$item' and useremail !='$email'");
		//Process your transaction here as success transaction.
		//Verify amount & order id received from Payment gateway with your application's order id and amount.
	}
	else {
		// echo "<b>Transaction status is failure</b>" . "<br/>";
	}

	// if (isset($_POST) && count($_POST)>0 )
	// { 
	// 	foreach($_POST as $paramName => $paramValue) {
	// 			echo "<br/>" . $paramName . " = " . $paramValue;
	// 	}
	// }
	
}
// else {
// 	echo "<b>Checksum mismatched.</b>";
// 	//Process transaction as suspicious.
// }
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
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
	</head>
	<body>
		<?php
    if ($_POST["STATUS"] == "TXN_SUCCESS")
    {?>
      <script type="text/javascript">
            swal("Congrats!", "Your Order is successfully Placed!", "success");
          </script>
      <?php
    }
    else{
      ?>
      <script type="text/javascript">
            swal("Sorry!", "Transaction was unsuccessful!", "error");
          </script>
      <?php
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
                  			?>
                  			<tr>
                      			<td><input type="radio" name="item" value="<?php echo $row["product_id"];?>"></td>
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
                 if ($_POST["STATUS"] == "TXN_SUCCESS") {
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
          </table>
        </div>
      </main>
    </div>
	</body>
</html>