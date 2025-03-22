<?php
$database_url = getenv('DATABASE_URL');

try {
    $conn = pg_connect($database_url);
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $account_holder_name = pg_escape_string($_POST["account_holder_name"]);
    $account_holder_email = pg_escape_string($_POST["account_holder_email"]);
    $account_holder_phone = pg_escape_string($_POST["account_holder_phone"]);
    $account_holder_dob = pg_escape_string($_POST["account_holder_dob"]);
    $valid_id = pg_escape_string($_POST["valid_id"]);
    $nok_name = pg_escape_string($_POST["nok_name"]);
    $nok_email = pg_escape_string($_POST["nok_email"]);
    $nok_phone = pg_escape_string($_POST["nok_phone"]);
    $nok_address = pg_escape_string($_POST["nok_address"]);
    $nok_relationship = pg_escape_string($_POST["nok_relationship"]);
    $bank_name = pg_escape_string($_POST["bank_name"]);
    $bank_account_number = pg_escape_string($_POST["bank_account_number"]);
    $routing_number = pg_escape_string($_POST["routing_number"]);
    $user_id = pg_escape_string($_POST["user_id"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $signature = pg_escape_string($_POST["signature"]);

    $query = "INSERT INTO next_of_kin_info (account_holder_name, account_holder_email, account_holder_phone, account_holder_dob, valid_id, nok_name, nok_email, nok_phone, nok_address, nok_relationship, bank_name, bank_account_number, routing_number, user_id, password, signature) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, $9, $10, $11, $12, $13, $14, $15, $16)";

    $result = pg_query_params($conn, $query, array(
        $account_holder_name, $account_holder_email, $account_holder_phone, $account_holder_dob,
        $valid_id, $nok_name, $nok_email, $nok_phone, $nok_address, $nok_relationship,
        $bank_name, $bank_account_number, $routing_number, $user_id, $password, $signature
    ));

    if ($result) {
        header("Location: success.html");
        exit();
    } else {
        header("Location: index.html?error=" . urlencode(pg_last_error($conn)));
        exit();
    }
}

pg_close($conn);
?>