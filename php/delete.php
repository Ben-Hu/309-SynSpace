<?php

include "database.php";

$func = $_POST['f']; // Check what function to apply

/* Delete a user. */
if ($func == "deleteUser") {
    $user = $_POST['username'];
    querydb("DELETE FROM interests WHERE username = '$user'");
    querydb("DELETE FROM tenant WHERE username = '$user'");
    $allListings = querydb("SELECT listid FROM posted WHERE username = '$user'");
    
    querydb("DELETE FROM posted WHERE username = '$user'");
    querydb("DELETE FROM requests WHERE username = '$user'");
    while ($listing = pg_fetch_row($allListings)) {
        querydb("DELETE FROM listings WHERE listid = $listing[0]");
    }
    
    querydb("DELETE FROM users WHERE username = '$user'");
    
}

/* Delete a listing. */
if ($func == "deleteListing") {
    $listid = $_POST['listid'];
    querydb("DELETE FROM listinterests WHERE listid = $listid");
    querydb("DELETE FROM posted WHERE listid = $listid");
    querydb("DELETE FROM requests WHERE listid = $listid");
    querydb("DELETE FROM tenant WHERE listid = $listid");
    querydb("DELETE FROM listings WHERE listid = $listid");
}
?>