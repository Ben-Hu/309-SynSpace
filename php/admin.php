<?php
// Get the number of users, tenants, and listings
$getNumOfUsers   = querydb("SELECT count(username) FROM users");
$getNumOfTenants = querydb("SELECT count(username) FROM tenant");
$getNumOfSpaces  = querydb("SELECT count(listid) FROM listings");

$numusers    = pg_fetch_row($getNumOfUsers);
$numtenants  = pg_fetch_row($getNumOfTenants);
$numlistings = pg_fetch_row($getNumOfSpaces);

// Get the best and worst users and listings
$getbestUsers     = querydb("SELECT username FROM users ORDER BY rating DESC LIMIT 5");
$getbestListings  = querydb("SELECT listid, address FROM listings ORDER BY rating DESC LIMIT 5");
$getworstUsers    = querydb("SELECT username FROM users ORDER BY rating ASC LIMIT 5");
$getworstListings = querydb("SELECT listid, address FROM listings ORDER BY rating ASC LIMIT 5");
?>