<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Get global variable</title>
</head>
<body>


<form method="GET">
    <input type="hidden" name="name" value="Milena">
    <button type="submit">Press for name</button>
</form>

<?php
echo $_GET['name'];
?>

</body>
</html>

