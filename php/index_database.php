<?php
session_start();
$getBestListings = querydb("SELECT * from listings ORDER BY rating");

$user           = $_SESSION['username'];
// Check for listings a user is a part of
$getAllListings = querydb("SELECT t.listid, address FROM tenant t JOIN listings l ON t.listid = l.listid WHERE username = '$user'");

/* Search for listings based on a tag. */
if (isset($_GET['search'])) {
    $search_tag = $_GET['search'];
    $SearchListings = querydb("SELECT * FROM listings WHERE listid in (SELECT listid FROM listinterests WHERE interest = '$search_tag')");
}
?>