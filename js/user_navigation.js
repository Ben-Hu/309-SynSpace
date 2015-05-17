	/* Add a user to the listing. */
	$(".accept").click(function() {
	    var currentid = $(this).attr("id").split("-")[0];
	    var name = $(this).attr("name").split("-")[0];
	    $("#" + currentid).replaceWith("<div class='alert alert-success alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + name + " has sucessfully joined.</div>");
	    $.ajax({
	        url: "php/listingfunctions.php",
	        type: "POST",
	        data: {
	            f: "addtenant",
	            action: "accept",
	            listid: currentid,
	            username: name
	        }
	    });

	});

	/* Prevent a user from being added to the listing. */
	$(".reject").click(function() {
	    var currentid = $(this).attr("id").split("-")[0];
	    var name = $(this).attr("name").split("-")[0];
	    $("#" + currentid).replaceWith("<div class='alert alert-danger alert-dismissable'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> You rejected " + name + "'s request. </div>");
	    $.ajax({
	        url: "php/listingfunctions.php",
	        type: "POST",
	        data: {
	            f: "addtenant",
	            action: "reject",
	            listid: currentid,
	            username: name
	        }
	    });

	});

	/* Sign out. */
	$("#signout").click(function() {
	    $.ajax({
	        url: "php/logout.php",
	        type: "POST",
	    }).done(function() {
	        window.location = "index.php";
	    });
	});