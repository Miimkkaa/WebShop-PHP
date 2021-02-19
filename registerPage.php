<?php
// Connection to the database:
$dbc = mysqli_connect('localhost', 'root', 'password', 'shopma');

// Variables from the form
$name = $_POST['name'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = $_POST['pass'];

// Add user to the database
$signUp = "INSERT INTO Users(UName, Phone, Address, Email, Pass) VALUES('$name', '$phone', '$address', '$email', '$password')";

// Form validation using Regex and submit user to database
if(preg_match('/[a-zA-Z\s]*$/', $name) && // Name as alphabets
    preg_match('/^[0-9]{8}$/', $phone) && // 8 digits only
    preg_match('/^[a-zA-Z0-9,.!?]*$/', $address) && // Alphanumeric, commas and white spaces
    preg_match('/^[\w-\.]+@([\w-]+\.)+[\w-]{2,5}$/', $email) && // Common e-mail format
    preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{6,}$/', $password) // At least one capital/lowercase, 6 characters, symbol
) {
    $result = mysqli_query($dbc, $signUp);
    $message = "Successfully created account!";
    echo "<script type='text/javascript'>alert('$message');</script>";
    ?>
    <script type="text/javascript">window.location="login.html";</script>
    <?php
} else {
    $message = "Please try to add correct information";
    echo "<script type='text/javascript'>alert('$message');</script>";  ?>
    <script type="text/javascript">window.location="register.html";</script>
    <?php
}
