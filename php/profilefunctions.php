<?php
include "database.php";

$func = $_POST['f']; // Check what function to apply


/* Returns the correct query to update the rating given a rating $r, an
 * action ("A(dd)" or "D(elete)"), and the list ID $lid. */
function updateRating($r, $a, $lid)
{
    if ((($r == 1) and ($a == "A")) or (($r == 0) and ($a == "D"))) {
        return "UPDATE users SET rating = rating + 1 WHERE username = $curruser";
    } elseif ((($r == 1) && ($a == "D")) || (($r == 0) && ($a == "A"))) {
        return "UPDATE users SET rating = rating - 1 WHERE username = $curruser";
    }
}

/* Add or remove a rating for a user. */
if ($func == "rate") {
    $user         = $_POST['username'];
    $curruser     = $_POST['personrated'];
    $rating       = $_POST['rating'];
    $action       = $_POST['action'];
    $modifyRating = updateRating($rating, $action, $listid);
    
    if ($action == 'A') { // Add a new rating to the listing.
        $insertRating = "INSERT INTO userrated VALUES ('$user', '$curruser', $rating)";
        querydb($insertRating);
    } elseif ($action == 'D') { // Delete a rating for the listing.
        $deleteRating = "DELETE FROM postrated WHERE username = '$user' AND personrated = $curruser";
        querydb($deleteRating);
    }
    querydb($modifyRating);
}

/* Edit a user's profile. */
if ($func == "edit") {
    $user     = $_POST['username'];
    $first    = $_POST['firstname'];
    $last     = $_POST['lastname'];
    $desc     = $_POST['desc'];
    $allTags  = $_POST['tags'];
    $everyTag = explode(",", $allTags);
    querydb("UPDATE users SET firstname = '$first', lastname = '$last', profile = '$desc' WHERE username = '$user'");
    querydb("DELETE FROM interests WHERE username = '$user'");
    foreach ($everyTag as $tag) {
        querydb("INSERT INTO interests VALUES ('$user', '$tag')");
    }
}


?>