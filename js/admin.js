/* Delete a user. */
$("#delete").click(function() {
    var user = $("input[name=user]").val();
    $.ajax({
        url: "php/delete.php",
        type: "POST",
        data: {
            f: "deleteUser",
            username: user
        }
    }).done(function() {
        location.reload();
    });
});

/* Delete a listing */
$("#deletespace").click(function() {
    var lid = $("input[name=listing]").val();
    $.ajax({
        url: "php/delete.php",
        type: "POST",
        data: {
            f: "deleteListing",
            listid: lid
        }
    }).done(function() {
        location.reload();
    });
});