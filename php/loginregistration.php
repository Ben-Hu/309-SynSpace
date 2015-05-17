<?php
// Function for user registration
if (isset($_POST['register'])) {
    $user   = $_POST['username'];
    $pass   = $_POST['password'];
    $first  = $_POST['firstname'];
    $last   = $_POST['lastname'];
    $result = querydb("INSERT INTO users VALUES('$user', '$pass', '$first', '$last')");
    if (!$result) { // If the username is already taken
        echo "<script> alert('Your username is already taken. Unsuccessful registration.'); </script>";
    } else {
        echo "<script> alert('You have successfully registered! You may now login.'); </script>";
    }
}

// Function for login
if (isset($_POST['login'])) {
    $user        = $_POST['user'];
    $pass        = $_POST['pass'];
    // Query the database to see if there is a combination that matches the
    // user input.
    $query       = "SELECT firstname, lastname FROM users WHERE username='$user' AND password='$pass'";
    $result      = querydb($query);
    $getFullName = pg_fetch_row($result);
    $numrows     = pg_num_rows($result);
    
    if ($numrows == 0) {
        echo "<script>alert('Incorrect username/password combination.')</script>";
    } else {
        // Start a new user session and set the username
        session_start();
        $_SESSION["username"] = $user;
        $_SESSION["fullname"] = $getFullName[0] . " " . $getFullName[1];
        // Close the session temporarily after writing to it.
        session_write_close();
    }
}

?>