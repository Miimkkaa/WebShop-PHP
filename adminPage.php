<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin page</title>
    <h1>Admin can add and update products</h1>
    <form action="logoutPage.php" method="post">
        <input  type="submit" value="Logout">
    </form>
</head>
<link rel="stylesheet" href="./register.css" type="text/css">
<style>
    table, th, td, tr {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td, tr {
        padding: 5px;
        text-align: left;
    }
</style>

<body style="width: 100%">
<div class="container">
<form action="adminPage.php" method="post" style="border:1px solid #ccc; width: 30%; margin-left: 35%">
    <legend style="text-align: center"><b>Add products:</b></legend>
    <p style="width: 90%;"><b>Product name: <input placeholder="Enter product name" name="name" type="text" size="60" maxlength="100" required></p>
    <p style="width: 90%;"><b>Product description: <input  placeholder="Enter product description" name="desc" type="text" size="60" maxlength="100" required></p>
    <p style="width: 90%;"><b>Product price: <input placeholder="Enter product price" name="price" type="text" size="60" maxlength="100" required></p>
    <p style="width: 90%;"><b>Product image: <input placeholder="Enter image path" name="image" type="text" size="60" maxlength="100" required></p>
    <input style="background-color: #4CAF50; color: white; margin-left: 40%;" name="add" type="submit" value="Add product">
</form>
</div>
</body>
</html>

<?php
// Session start
session_start();

// Connection to the database:
$dbc = mysqli_connect('localhost', 'root', 'password', 'shopma');

// Access to page
if ($_SESSION['status'] == 'Admin logged in') {
    // Display products query
    $selectProducts = 'SELECT PName, PDes, Price FROM Products;';
    $result = mysqli_query($dbc, $selectProducts);
} else {
    $message = "Only logged in admin has access to this page. :)";
    echo "<script type='text/javascript'>alert('$message');</script>";?>
    <script type="text/javascript">window.location="login.html";</script>
    <?php
}

// Variables
$name = "";
$name = isset($_POST['name']) ? $_POST['name'] : '';
$desc= "";
$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
$price = "";
$price = isset($_POST['price']) ? $_POST['price'] : '';
$image = "";
$image = isset($_POST['image']) ? $_POST['image'] : '';

// Add new products
if(isset($_POST['add']))
{
    if($name != "" && $desc != "" && $price != "" && $image != "") {
        $addProduct = "INSERT INTO Products(PName, PDes, Price, Image) VALUES('$name', '$desc', '$price', '$image')";
        $result = mysqli_query($dbc, $addProduct);
        $message = "Good, product is added.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>

<div class="container">
<form action="adminPage.php" method="post" style="border:1px solid #ccc; width: 30%; margin-left: 35%">
    <legend style="text-align: center"><b>Update products:</b></legend>
    <p style="width: 90%;">Find product by id: <input name="id" type="text" size="60" maxlength="100"></p>
    <input style="background-color: #4CAF50; color: white; margin-left: 40%;" name="find" type="submit" value="Find product">
    <?php
    $findId = "";
    $findId = isset($_POST['id']) ? $_POST['id'] : '';

    if (isset($_POST['find'])) {

        $findById = " SELECT * FROM Products WHERE ProductId = $findId";
        $findByIdResult = mysqli_query($dbc, $findById);
        $row = mysqli_fetch_array($findByIdResult);

        $fetch_id = $row['ProductId'];
        $fetch_name = $row['PName'];
        $fetch_desc = $row['PDes'];
        $fetch_price = $row['Price'];
        $fetch_img = $row['Image'];
    ?>

    <p style="width: 90%;">Product id: <input name="id" type="text" size="60" maxlength="100" value="<?=$fetch_id?>" readonly></p>
    <p style="width: 90%;">Product name: <input name="name" type="text" size="60" maxlength="100" value="<?=$fetch_name?>" required></p>
    <p style="width: 90%;">Product description: <input name="desc" type="text" size="60" maxlength="500" value="<?=$fetch_desc?>" required></p>
    <p style="width: 90%;">Product price: <input name="price" type="text" size="60" maxlength="100" value="<?=$fetch_price?>" required></p>
    <p style="width: 90%;">Product image: <input name="image" type="text" size="60" maxlength="100" value="<?=$fetch_img?>" required></p>
    <input style="background-color: #4CAF50; color: white; margin-left: 40%;" name="update"  type="submit" value="Update product">

    <?php
    }  // Update product
    if (isset($_POST['update'])) {
        $fetch_id = "";
        $fetch_id = isset($_POST['id']) ? $_POST['id'] : '';
        $fetch_name = "";
        $fetch_name = isset($_POST['name']) ? $_POST['name'] : '';
        $fetch_img = "";
        $fetch_img = isset($_POST['image']) ? $_POST['image'] : '';
        $fetch_price = "";
        $fetch_price = isset($_POST['price']) ? $_POST['price'] : '';
        $fetch_desc = "";
        $fetch_desc = isset($_POST['desc']) ? $_POST['desc'] : '';

        $updateProduct = "UPDATE Products SET PName='$fetch_name', PDes='$fetch_desc', Price= '$fetch_price', Image='$fetch_img'  WHERE ProductId= $fetch_id";
        if(mysqli_query($dbc, $updateProduct)){
            $message = "Successfully updated products.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else {
            echo "ERROR: Could not able to execute $updateProduct. " . mysqli_error($dbc);
        }
    }
    ?>
</form>
</div>

<?php
// Select products
$getProducts = "SELECT ProductId, PName, PDes, Price FROM Products;";
$getResult = mysqli_query($dbc, $getProducts);
// Storing the products in an array
$products = array();

// Get all products:
while (list($id, $product, $desc, $price) = mysqli_fetch_array($getResult, MYSQLI_NUM)) {
    $products[] = array('ProductId' => $id, 'product' => $product, 'PDes' => $desc, 'Price' => $price);
}

// Display all products
echo '<h2 style="text-align: center">List of products</h2>';
echo "<table style='margin-left: 35%'>";
echo "
  <tr>
    <th>Product Id</th>
    <th>Product name</th>
    <th>Product description</th> 
    <th>Price</th>
  </tr>";
foreach ($products as $product) {
    echo"
<tr>
<td>{$product['ProductId']}</td>
<td>{$product['product']}</td>
    <td>{$product['PDes']}</td>
    <td>{$product['Price']}$</td>
   
";
} echo "</table> ";
?>
?>