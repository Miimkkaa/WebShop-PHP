<?php
// Session
session_start();

// Connection to the database:
$dbc = mysqli_connect('localhost', 'root', 'password', 'shopma');

// Variables from form
$email = $_POST['email'];
$password = $_POST['pass'];

// Searching in database for combination of email and password
$login = "SELECT Email, Pass FROM Users WHERE Email = '".$email."' AND Pass = '".$password."';";
$result = mysqli_query($dbc, $login);

// Login
if ($email == 'admin@dk.dk' && $password = "myAdminPass23!") {
    $message = "Welcome admin!";
    $_SESSION['status'] = "Admin logged in";
    echo "<script type='text/javascript'>alert('$message');</script>";?>
    <script type="text/javascript">window.location="adminPage.php";</script>
    <?php
}
else if (mysqli_fetch_assoc($result) != 0) {
    $message = "Login successful!";
    $_SESSION['status'] = "Logged in";
    echo "<script type='text/javascript'>alert('$message');</script>"; ?>
    <script type="text/javascript">window.location="productsPage.php";</script>
<?php
}
else {
    $message = "Invalid credentials! Please try again.";
    echo "<script type='text/javascript'>alert('$message');</script>";?>
<script type="text/javascript">window.location="login.html";</script>
<?php
}

