<?php

// This one na Database connection details
$servername = "0.0.0.0"; // Replace with your server name if different
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "glory"; // Replace with your database name

//To Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// To Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $account_holder_name = $_POST["account_holder_name"];
    $account_holder_email = $_POST["account_holder_email"];
    $account_holder_phone = $_POST["account_holder_phone"];
    $account_holder_dob = $_POST["account_holder_dob"];
    $valid_id = $_POST["valid_id"];
    $nok_name = $_POST["nok_name"];
    $nok_email = $_POST["nok_email"];
    $nok_phone = $_POST["nok_phone"];
    $nok_address = $_POST["nok_address"];
    $nok_relationship = $_POST["nok_relationship"];
    $bank_name = $_POST["bank_name"];
    $bank_account_number = $_POST["bank_account_number"];
    $routing_number = $_POST["routing_number"];
    $user_id = $_POST["user_id"];
    $password = $_POST["password"]; // **SECURITY WARNING:** Do not store plain passwords!
    $signature = $_POST["signature"];

    // **SECURITY BEST PRACTICE:** Hash the password before storing it in the database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO next_of_kin_info (account_holder_name, account_holder_email, account_holder_phone, account_holder_dob, valid_id, nok_name, nok_email, nok_phone, nok_address, nok_relationship, bank_name, bank_account_number, routing_number, user_id, password, signature) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssss", $account_holder_name, $account_holder_email, $account_holder_phone, $account_holder_dob, $valid_id, $nok_name, $nok_email, $nok_phone, $nok_address, $nok_relationship, $bank_name, $bank_account_number, $routing_number, $user_id, $hashed_password, $signature);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<h2>Registration Successful!</h2>";
        echo "<p>Your information has been successfully submitted.</p>";
        // You might want to redirect the user to a success page here:
        // header("Location: success.html");
        // exit();
    } else {
        echo "<h2>Error!</h2>";
        echo "<p>There was an error submitting your information. Please try again later.</p>";
        echo "<p>Error details: " . $stmt->error . "</p>";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

?>