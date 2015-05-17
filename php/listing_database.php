<?php

$user       = $_SESSION["username"]; // Check if a user is logged in

// Get the information from the database for the current listing
$id      = $_GET['id'];
$getInfo = querydb("SELECT * from listings WHERE listid = $id");
$info    = pg_fetch_row($getInfo);
$addr    = "$info[1]" . ", ";
$city    = "$info[2]";

// Get skills/interest tags for the current listing
$tags = querydb("SELECT interest FROM listinterests WHERE listid = $id");

// Get the tenants for the current database
$allTenants = querydb("SELECT username FROM tenant WHERE listid = $id");

// Check if current page was rated by the current user
$ifRated     = querydb("SELECT liked FROM postrated WHERE username = '$user' AND listid = $id");
$likedResult = pg_fetch_row($ifRated);
$liked       = pg_num_rows($ifRated);

// Check if user owns this page
$owner   = querydb("SELECT * from posted WHERE username = '$user' AND listid = $id");
$isOwner = pg_num_rows($owner);

if ($isOwner == 0) {
    // Check if user is a tenant
    $tenant   = querydb("SELECT * from tenant WHERE username = '$user' AND listid = $id");
    $isTenant = pg_num_rows($tenant);
    $owner    = querydb("SELECT * from posted WHERE listid = $id");
}
$realOwner = pg_fetch_row($owner);
// Check if user requested to be added to this space.
$request   = querydb("SELECT * from requests WHERE username = '$user' AND listid = $id");
$ifRequest = pg_num_rows($request);

?>