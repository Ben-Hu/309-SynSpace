<?php
session_start();
$user       = $_SESSION['username'];
$getListing = querydb("SELECT p.listid, address FROM posted p JOIN listings l ON p.listid = l.listid WHERE username='$user'");

$getsomeRequests = querydb("SELECT p.listid, address, city, r.username FROM posted p JOIN requests r ON p.listid = r.listid JOIN listings l ON l.listid = p.listid WHERE p.username = '$user' LIMIT 5");
$getRequests     = querydb("SELECT p.listid, address, city, r.username FROM posted p JOIN requests r ON p.listid = r.listid JOIN listings l ON l.listid = p.listid WHERE p.username = '$user'");
$numOfRequests   = pg_num_rows($getRequests);

// Check if the user is an administrator
$ifAdmin = querydb("SELECT * from admins WHERE username = '$user'");
$isAdmin = pg_num_rows($ifAdmin);
?>