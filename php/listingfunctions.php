<?php
include "database.php";

$func   = $_POST['f']; // Check what function to apply
$listid = $_POST['listid'];

/* Returns the correct query to update the rating given a rating $r, an
 * action ("A(dd)" or "D(elete)"), and the list ID $lid. */
function updateRating($r, $a, $lid)
{
    if ((($r == 1) and ($a == "A")) or (($r == 0) and ($a == "D"))) {
        return "UPDATE listings SET rating = rating + 1 WHERE listid = $lid";
    } elseif ((($r == 1) && ($a == "D")) || (($r == 0) && ($a == "A"))) {
        return "UPDATE listings SET rating = rating - 1 WHERE listid = $lid";
    }
}

/* Add or remove a rating for a listing. */
if ($func == "rate") {
    $user         = $_POST['username'];
    $rating       = $_POST['rating'];
    $action       = $_POST['action'];
    $modifyRating = updateRating($rating, $action, $listid);
    
    if ($action == 'A') { // Add a new rating to the listing.
        $insertRating = "INSERT INTO postrated VALUES ('$user', $listid, $rating)";
        querydb($insertRating);
    } elseif ($action == 'D') { // Delete a rating for the listing.
        $deleteRating = "DELETE FROM postrated WHERE username = '$user' AND listid = $listid";
        querydb($deleteRating);
    }
    querydb($modifyRating);
}

/* Edit a listing. */
if ($func == "edit") {
    $addr     = $_POST['addr'];
    $city     = $_POST['city'];
    $desc     = $_POST['desc'];
    $allTags  = $_POST['tags'];
    $everyTag = explode(",", $allTags);
    querydb("UPDATE listings SET address = '$addr', city = '$city', description = '$desc' WHERE listid = $listid");
    querydb("DELETE FROM listinterests WHERE listid = $listid");
    foreach ($everyTag as $tag) {
        querydb("INSERT INTO listinterests VALUES ($listid, '$tag')");
    }
}

/* Delete a listing. */
if ($func == "delete") {
    querydb("DELETE FROM postrated WHERE listid = $listid");
    querydb("DELETE FROM posted WHERE listid = $listid");
    querydb("DELETE FROM tenant WHERE listid = $listid");
    querydb("DELETE FROM listinterests WHERE listid = $listid");
    querydb("DELETE FROM listings WHERE listid = $listid");
}

/* Add a user request. */
if ($func == "adduser") {
    $user = $_POST['username'];
    querydb("INSERT into requests values ('$user', $listid)");
}

/* Confirm a user to be added to a listing. */
if ($func == "addtenant") {
    $user   = $_POST['username'];
    $action = $_POST['action'];
    if ($action == "accept") {
        querydb("INSERT INTO tenant VALUES ($listid, '$user')");
    }
    querydb("DELETE FROM requests WHERE username = '$user' AND listid = $listid");
}

/* Delete a tenant from the listing. */
if ($func == "deletetenant") {
    $tenant = $_POST['tenant'];
    querydb("DELETE FROM tenant WHERE username = '$tenant' AND listid = $listid");
}
/* Delete a user from a listing. */
if ($func == "deleteTenant") {
    $user = $_POST['username'];
    querydb("DELETE FROM tenant WHERE username = '$user' AND listid = $listid");
    
}
?>