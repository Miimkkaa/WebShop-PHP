<?php
// Starting the session
session_start();

// Database connection
$dbc = mysqli_connect("localhost", "root", "password", "shopma");

// Access to page
if ($_SESSION['status'] == 'Logged in') {
    // This takes the products from the database
    $status = $_SESSION['status'];
    echo $status;
    $query = "SELECT * FROM Products ORDER BY ProductId ASC";
    $result = mysqli_query($dbc, $query);
} else {
    $message = "Only logged in users can see the products :)";
    echo "<script type='text/javascript'>alert('$message');</script>";?>
    <script type="text/javascript">window.location="login.html";</script>
    <?php
} ?>

<!-- Menu and SubMenu -->
<?php

function get_menu_tree($parent_id)
{
	global $dbc;
	$menu = "";
	$sqlquery = " SELECT * FROM menu where status='1' and parent_id='" .$parent_id . "' ";
	$res=mysqli_query($dbc, $sqlquery);

    while($row=mysqli_fetch_array($res,MYSQLI_ASSOC))
	{
	       $menu .="<li><a href='".$row['link']."'>".$row['menu_name']."</a>";
		   $menu .= "<ul>".get_menu_tree($row['menu_id'])."</ul>";
 		   $menu .= "</li>";
    }
    return $menu;
}


// Add to cart (product)
if(isset($_POST["add_to_cart"])){
    if(isset($_SESSION["shopping_cart"])){
        $item_array_id = array_column($_SESSION["shopping_cart"], "product_id");
        if(!in_array($_GET["id"], $item_array_id)){
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            // If item is already added
            $_SESSION["shopping_cart"][$count] = $item_array;
            echo '<script>window.location="productsPage.php"</script>';
        } else {
            echo '<script>alert("Product is already added to cart.")</script>';
            echo '<script>window.location="productsPage.php"</script>';
        }
    } else {
        $item_array = array(
            'product_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'product_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"],
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}

// Remove product from cart
if(isset($_GET["action"])) {
    if($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $value) {
            if($value["product_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Product has been removed.")</script>';
                echo '<script>window.location="productsPage.php"</script>';
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Cart</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     <link rel="stylesheet" href="./menu.css" type="text/css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <title>Shopping cart</title>
</head>
<body>
</form>

<div class="container" style="width:700px;">
    <h3 style="text-align: center">Welcome, you can see all the products below:</h3>

<!-- MENU -->
    <ul class="main-navigation" style="margin-bottom: 10%">
        <?php echo get_menu_tree(0); //start from root menus having parent id 0 ?>
        <form method="post" class="logout" action="logoutPage.php">
            <button
              style="float: right;
              background-color: #1bc2a2;
              border-width: 0px;
              margin-top: 2%;
              font-weight: bold;" type="submit">LOGOUT</button>
        </form>
    </ul>
    <!-- Displaying products in cart -->
    <?php

    if(mysqli_num_rows($result) > 0)
    {
        while($row = mysqli_fetch_array($result))
        {
            ?>
            <div class="col-md-4">
                <form method="post" action="productsPage.php?action=add&id=<?php echo $row["ProductId"]; ?>">
                    <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
                        <img src="<?php echo $row["Image"]; ?>" class="img-responsive" /><br/>
                        <h4 class="text-info"><?php echo $row["PName"]; ?></h4>
                        <h4 class="text-danger">$ <?php echo $row["Price"]; ?></h4>
                        <input type="text" name="quantity" class="form-control" value="1" />
                        <input type="hidden" name="hidden_name" value="<?php echo $row["PName"]; ?>" />
                        <input type="hidden" name="hidden_price" value="<?php echo $row["Price"]; ?>" />
                        <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
                    </div>
                </form>
            </div>
            <?php
        }
    }
    ?>

    <div style="clear:both"></div>
    <br />
    <h3>Order Details</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="40%">Item Name</th>
                <th width="10%">Quantity</th>
                <th width="20%">Price</th>
                <th width="15%">Total</th>
                <th width="5%">Action</th>
            </tr>
            <?php
            if(!empty($_SESSION["shopping_cart"]))
            {
                $total = 0;
                foreach($_SESSION["shopping_cart"] as $keys => $values)
                {
                    ?>
                    <tr>
                        <td><?php echo $values["item_name"]; ?></td>
                        <td><?php echo $values["item_quantity"]; ?></td>
                        <td>$ <?php echo $values["product_price"]; ?></td>
                        <td>$ <?php echo number_format($values["item_quantity"] * $values["product_price"], 2); ?></td>
                        <td><a href="productsPage.php?action=delete&id=<?php echo $values["product_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                    </tr>
                    <?php
                    $total = $total + ($values["item_quantity"] * $values["product_price"]);
                }
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right">$ <?php echo number_format($total, 2); ?></td>
                    <td></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<br />

</body>
</html>