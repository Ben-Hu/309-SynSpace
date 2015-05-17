<?php
$curruser = $_GET['user'];
$user     = $_SESSION['username'];

// Get friends of the current user
$getFriends = "SELECT t2.username FROM tenant t1 CROSS JOIN tenant t2 WHERE t1.listid = t2.listid AND t1.username != t2.username AND t1.username = '$curruser'";
$friends    = querydb($getFriends);

// Get information about the current user
$info      = "SELECT * FROM users WHERE username='$curruser'";
$getInfo   = querydb($info);
$userInfo  = pg_fetch_row($getInfo);
$getRating = querydb("SELECT count(liked) FROM userrated WHERE username='$curruser'");
$rating    = pg_fetch_row($getRating);

// Get a list of the spaces the user owns
$owns = querydb("SELECT listid, address, city FROM listings NATURAL JOIN posted WHERE username = '$curruser'");

// Get a list of spaces the user is in 
$tenantIn = querydb("SELECT listid, address, city FROM tenant NATURAL JOIN listings WHERE username = '$curruser'");

$interests = querydb("SELECT interest FROM interests WHERE username = '$curruser'");

// Check if logged in user is a friend of the $curruser
$getIsFriend = querydb("SELECT * from tenant t1 CROSS JOIN tenant t2 WHERE t1.listid = t2.listid AND t1.username != t2.username AND t1.username = '$user' AND t2.username = '$curruser'");
$isFriend    = pg_num_rows($getIsFriend);

// Check if user has rated current user
$hasRated = querydb("SELECT liked from userrated WHERE username = '$user' AND personrated = '$curruser'");
$ifRated  = pg_num_rows($hasRated);
$likedVal = pg_fetch_row($hasRated);

?>