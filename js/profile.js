	/* Modify ratings by clicking on a "like" or "dislike" button. */
	if (ifLiked != 0) { // if the user has rated this listing
	    // Get the value of their rating.
	    toggleRating(likedVal);
	}

	/* Like or dislike a user. */
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
	        url: "php/profilefunctions.php",
	        type: "POST",
	        data: {
	            f: "rate",
	            username: user,
	            rating: theRating,
	            personrated: curruser,
	            action: theAction
	        }
	    });

	});

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

	/* Add input fields to allow editing of a listing. */
	$("#edit-profile").click(function() {
	    $("input[name=firstname-edit]").attr("value", first);
	    $("input[name=lastname-edit]").attr("value", last);
	    $("textarea[name=desc-edit]").val(description);
	    // Replace the interest list with an editable tag list
	    var currentTags = "";
	    $("#interests button").each(function(i) {
	        currentTags = currentTags + $(this).text() + ",";
	    });

	    currentTags = currentTags.substring(0, currentTags.length - 1);
	    $("input[name=tags-edit]").attr("value", currentTags);
	    $("input[name=tags-edit]").tagsinput("refresh");

	});

	/* Save an idea. */
	$("#save").click(function() {

	    var newFirst = $("input[name=firstname-edit]").val();
	    var newLast = $("input[name=lastname-edit]").val();
	    var newDesc = $("textarea[name=desc-edit]").val();
	    var newTags = $("input[name=tags-edit]").val();

	    $.ajax({
	        url: "php/profilefunctions.php",
	        type: "POST",
	        data: {
	            f: "edit",
	            username: user,
	            firstname: newFirst,
	            lastname: newLast,
	            desc: newDesc,
	            tags: newTags
	        }
	    }).done(function() {
	        location.reload()
	    });
	});