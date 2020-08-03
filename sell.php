<?php
session_start();
if(isset($_SESSION['email']) && $_SESSION['email'] != "")
{
  $error=-1;
  require 'connect.php';
  $email=$_SESSION['email'];
  $result = mysqli_query($con,'select * from user where email="'.$email.'"');
  $fetch=mysqli_fetch_array($result);
  $error=-1;
  if(isset($_POST['logout']))
  {
    session_destroy();
    header('Location: home.php');
  }
  if(isset($_POST['upload']))
  {
    $category=$_POST['id'];
    $image= $_POST['image'];
    $name=$_POST['productname'];
    $discription=$_POST['discription'];
    $price=$_POST['price'];
    $result2 = mysqli_query($con,"select price from product where image='$image'");
    $fetch2=mysqli_fetch_array($result2);
    if($fetch2['price']==0)
    {
      $result1 = mysqli_query($con,"Update product set product_name='$name', discription='$discription', price='$price', type='$category', useremail='$email' where image='$image'");
      $error=1;
    }
    else
    {
      $error=0;
    }
  }
}
else
{
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
            swal("Congrats!", "Product uploaded successfully!", "success");
          </script>
      <?php
      $error=-1;
    }
    elseif ($error==0) {
      ?>
      <script type="text/javascript">
            swal("Oops!", "Product already exists!", "error");
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
    <main class="page-main">
      <div class="container">
          <table>
            <tbody>
              <form method="POST" enctype="multiport/form-data">
              <th colspan="2">Upload Product</th>
              <tr>
                <td>Product Name</td>
                <td>
                  <div class="textbox">
                      <input type="text" name="productname" placeholder="Product Name" class="nice" required>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Product discription</td>
                <td>
                  <div class="textbox">
                    <textarea name="discription" class="nice" rows="5" cols="50" style="resize: none;" data-role="none" placeholder="Write Something about your product...." required></textarea>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Upload Product Image</td>
                <td>
                  <input type="file" name="image"  required>
                </td>
              </tr>
              <tr>
                <td>Category</td>
                <td>
                  <div class="labs">
                    <select name="id">
                      <option value="Electronics">Electronics</option>
                      <option value="Non-Electronics">Non-Electronics</option>
                    </select>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Product Price (In Rs.)</td>
                <td>
                  <div class="textbox">
                      <input type="number" name="price" placeholder="Price in Rs." class="nice" required min="1">
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <div class="logout">
                    <input type="submit" name="upload" value="Upload">
                  </div>
                </td>
              </tr>
            </form>
            </tbody>
          </table>
          <center>
            <div class="logout">
              <input type="submit" onclick="location.href='viewuploaded.php'" value="View Uploaded Product">
            </div>
          </center>
        </div>
      </main>
	</body>
</html>