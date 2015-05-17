/* Modify ratings by clicking on a "like" or "dislike" button. */
if (ifLiked != 0) { // if the user has rated this listing
    // Get the value of their rating.
    toggleRating(likedVal);
}

/* Add or delete a rating. */
$(".likedislike").click(function(e) {
    e.preventDefault();
    var theRating = $(this).attr("id");
    var other = 1 - theRating;
    toggleRating(theRating);
    // Get the currentClass after toggling the rating button
    var currentClass = $(this).attr("class");
    // If the button was disabled
    if (currentClass == "btn btn-default likedislike") {
        var theAction = "D"; // delete rating
    } else { // Something was rated
        var theAction = "A"; // add rating
    }
    changeRating(theRating, theAction);
    $.ajax({
        url: "php/listingfunctions.php",
        type: "POST",
        data: {
            f: "rate",
            username: user,
            rating: theRating,
            listid: lid,
            action: theAction
        }
    });
});

/* Allow a user to request being added to a listing. */
$("#addme").click(function() {
    $.ajax({
        url: "php/listingfunctions.php",
        type: "POST",
        data: {
            f: "adduser",
            username: user,
            listid: lid
        }
    });
    $(this).text("Request sent");
    $(this).attr("disabled", "disabled");
});

/* Remove a user from a listing. */
$("#removetenant").click(function() {
    $.ajax({
        url: "php/listingfunctions.php",
        type: "POST",
        data: {
            f: "deleteTenant",
            username: user,
            listid: lid
        }
    }).done(function() {
        window.location = "http://ec2-52-4-96-163.compute-1.amazonaws.com/listing.php?id=" + lid;
    });
});

/* Add input fields to allow editing of a listing. */
$("#edit-listing").click(function() {
    $("input[name=addr-edit]").attr("value", address);
    $("input[name=city-edit]").attr("value", city);
    $("textarea[name=desc-edit]").val(description);
    // Replace the interest list with an editable tag list
    var currentTags = "";
    $("#tags button").each(function(i) {
        currentTags = currentTags + $(this).text() + ",";
    });
    currentTags = currentTags.substring(0, currentTags.length - 1);
    $("input[name=tags-edit]").attr("value", currentTags);
    $("input[name=tags-edit]").tagsinput("refresh");
});

/* Save a listing. */
$("#save").click(function() {
    var newAddress = $("input[name=addr-edit]").val();
    var newCity = $("input[name=city-edit]").val();
    var newDesc = $("textarea[name=desc-edit]").val();
    var newTags = $("input[name=tags-edit]").val();
    $.ajax({
        url: "php/listingfunctions.php",
        type: "POST",
        data: {
            f: "edit",
            listid: lid,
            addr: newAddress,
            city: newCity,
            desc: newDesc,
            tags: newTags
        }
    }).done(function() {
        location.reload()
    });
});

/* Delete user. */
$("#deleteuser").click(function() {
    var t = $("input[name=tenant]").val();
    $.ajax({
        url: "php/listingfunctions.php",
        type: "POST",
        data: {
            f: "deletetenant",
            listid: lid,
            tenant: t
        }
    }).done(function() {
        location.reload()
    });
});

/* Delete a listing. */
$("#delete").click(function() {
    var confirmBox = confirm("Are you sure you want to delete this space?");
    if (confirmBox == true) { // The user confirmed.
        $.ajax({
            url: "php/listingfunctions.php",
            type: "POST",
            data: {
                f: "delete",
                listid: lid
            }
        });
        // Redirect to the index page on deletion.
        window.location = "http://ec2-52-11-184-213.us-west-2.compute.amazonaws.com";
    }
});

/* Functions for listing.php */
/* Toggles the class of the rating button with the given id and disables the 
 * other button. */
function toggleRating(id) {
        var other = 1 - id;
        $("#" + id).toggleClass("btn-primary");
        // If the rating was removed (the button was set to default)
        if ($("#" + id).attr("class") == "btn btn-default likedislike") {
            $("#" + other).removeAttr("disabled");
        } else { // The rating was added
            $("#" + other).prop("disabled", "disabled");
        }
    }

/* Changes the rating on the page. */
function changeRating(id, action) {
    if (((id == 1) && (action == "A")) || ((id == 0) && (action == "D"))) {
        document.getElementById("rating").innerHTML++;
    } else if (((id == 1) && (action == "D")) || ((id == 0) && (action == "A"))) {
        document.getElementById("rating").innerHTML--;
    }
}