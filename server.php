<?php
session_start();

// initializing variables
$PASSENGER_ID = "";
$NAME = "";
$AGE = "";
$CONTACT_INFO = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'Ticket_reserve');

// REGISTER USER
if (isset($_POST['submit'])) {
    // receive all input values from the form
    $PASSENGER_ID = mysqli_real_escape_string($db, $_POST['passenid']);
    $NAME = mysqli_real_escape_string($db, $_POST['passenname']);
    $AGE = mysqli_real_escape_string($db, $_POST['passenage']);
    $CONTACT_INFO = mysqli_real_escape_string($db, $_POST['passencontact']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($PASSENGER_ID)) { array_push($errors, "Passenger ID is required"); }
    if (empty($NAME)) { array_push($errors, "Name is required"); }
    if (empty($AGE)) { array_push($errors, "Age is required"); }
    if (empty($CONTACT_INFO)) { array_push($errors, "Contact info is required"); }

    // Check if the passenger ID already exists in the database
    $user_check_query = "SELECT * FROM passengers WHERE passenger_id='$PASSENGER_ID' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if passenger exists
        if ($user['passenger_id'] === $PASSENGER_ID) {
            array_push($errors, "Passenger ID already exists");
        }
    }

    // Finally, register passenger if there are no errors in the form
    if (count($errors) == 0) {
        $query = "INSERT INTO passengers (passenger_id, name, age, contact_info) 
                  VALUES('$PASSENGER_ID', '$NAME', '$AGE', '$CONTACT_INFO')";
        mysqli_query($db, $query);
        // Your success message or redirection code can go here
    }
}
?>
