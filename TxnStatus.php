<?php
	header("Pragma: no-cache");
	header("Cache-Control: no-cache");
	header("Expires: 0");

	// following files need to be included
	require_once("./lib/config_paytm.php");
	require_once("./lib/encdec_paytm.php");

	session_start();
if($_SESSION['email'] == "")
{
  header('Location: home.php');
}
require 'connect.php';
$email=$_SESSION['email'];
$product_id=$_POST["item"];
$result = mysqli_query($con,'select * from user where email="'.$email.'"');
$fetch=mysqli_fetch_array($result);

$result1 = mysqli_query($con,"select * from cart join product where cart.useremail='$email' and cart.product_id='$product_id' and product.product_id='$product_id' and cart.status='1'");
$fetch1=mysqli_fetch_array($result1);
$orderid=$fetch1["order_id"];


if(isset($_POST['logout']))
{
  session_destroy();
  header('Location: home.php');
}

	$ORDER_ID = $orderid;
	$requestParamList = array();
	$responseParamList = array();

		// In Test Page, we are taking parameters from POST request. In actual implementation these can be collected from session or DB. 
		$ORDER_ID = $orderid;

		// Create an array having all required parameters for status query.
		$requestParamList = array("MID" => PAYTM_MERCHANT_MID , "ORDERID" => $ORDER_ID);  
		
		$StatusCheckSum = getChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY);
		
		$requestParamList['CHECKSUMHASH'] = $StatusCheckSum;

		// Call the PG's getTxnStatusNew() function for verifying the transaction status.
		$responseParamList = getTxnStatusNew($requestParamList);	
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
              <tr><th colspan="4">Customer Invoice Copy</th></tr>
              <tr>
              	<td colspan="2" style="text-align: left;">Order Id &nbsp; : &nbsp; <?php echo $fetch1["order_id"]; ?></td>
              	<td colspan="2" style="text-align: right;">
              		Ordered Through<br>
              		GLA WARMS
              	</td>
              </tr>
              <tr>
              	<td colspan="2" style="text-align: left;">
              		GLA WARMS<br>
              		GLA University, Mathura<br>
              		281406
              	</td>
              	<td colspan="2" style="text-align: left;">
              		BANKTXN ID &nbsp; :&nbsp; <?php echo $responseParamList["BANKTXNID"]; ?><br>
              		GATEWAY NAME &nbsp; :&nbsp; <?php echo $responseParamList["GATEWAYNAME"]; ?><br>
              		BANK NAME &nbsp; :&nbsp; <?php echo $responseParamList["BANKNAME"]; ?><br>
              		PAYMENT MODE &nbsp; :&nbsp; <?php echo $responseParamList["PAYMENTMODE"]; ?><br>
              		DATE & Time &nbsp; :&nbsp; <?php echo $responseParamList["TXNDATE"]; ?><br>
              	</td>
              </tr>
              <tr>
              	<td colspan="2" style="text-align: left;">
              		Shipping Address<br>
              		<?php echo $fetch["name"]; ?><br>
              		<?php echo $fetch["address"]; ?><br>
              		<?php echo $fetch["mobile"]; ?>
              	</td>
              	<td colspan="2" style="text-align: left;">
              		Billing Address<br>
              		<?php echo $fetch["name"]; ?><br>
              		<?php echo $fetch["address"]; ?>
              	</td>
              </tr>
              <tr>
              	<th>Product</th>
              	<th>Quantity</th>
              	<th>Price</th>
              	<th>Total</th>
              </tr>
              <tr >
              	<td><?php echo $fetch1["product_name"]; ?><br><br><br><br></td>
              	<td>1<br><br><br><br></td>
              	<td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $fetch1["price"]; ?><br><br><br><br></td>
              	<td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $fetch1["price"]; ?><br><br><br><br></td>
              </tr>
              <tr>
              	<th>Total</th>
              	<td>1</td>
              	<td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $fetch1["price"]; ?></td>
              	<td><i class="fas fa-rupee-sign"></i>&nbsp;<?php echo $fetch1["price"]; ?></td>
              </tr>
            </tbody>
          </table>
          <center><button onclick="printPage();" title="Print this table">Print Invoice</button></center>
        </div>
      </main>
    </div>
	</body>
</html>