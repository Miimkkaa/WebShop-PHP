<?php
// Session start
session_start();

// Logout
session_destroy();
header("location: login.html");
