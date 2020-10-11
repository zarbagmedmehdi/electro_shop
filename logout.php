<?php
session_start();
unset($_SESSION['customer']);
unset($_SESSION['customerid']);
session_destroy();
header('location: login.php');
