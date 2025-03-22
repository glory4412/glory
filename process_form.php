
<?php
$host = getenv('MYSQL_HOST');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$db = getenv('MYSQL_DATABASE');

try {
    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
} catch (Exception $e) {
    error_log("Database Error: " . $e->getMessage());
    header("Location: index.php?error=" . urlencode("Database connection error"));
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['account_holder_name', 'account_holder_email', 'account_holder_phone', 
                       'nok_name', 'nok_phone', 'bank_name', 'bank_account_number'];
    
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            header("Location: index.php?error=" . urlencode("All required fields must be filled"));
            exit();
        }
    }
    
    if (!filter_var($_POST["account_holder_email"], FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?error=" . urlencode("Invalid email format"));
        exit();
    }
    
    $account_holder_name = mysqli_real_escape_string($conn, $_POST["account_holder_name"]);
    $account_holder_email = mysqli_real_escape_string($conn, $_POST["account_holder_email"]);
    $account_holder_phone = mysqli_real_escape_string($conn, $_POST["account_holder_phone"]);
    $account_holder_dob = mysqli_real_escape_string($conn, $_POST["account_holder_dob"]);
    $valid_id = mysqli_real_escape_string($conn, $_POST["valid_id"]);
    $nok_name = mysqli_real_escape_string($conn, $_POST["nok_name"]);
    $nok_email = mysqli_real_escape_string($conn, $_POST["nok_email"]);
    $nok_phone = mysqli_real_escape_string($conn, $_POST["nok_phone"]);
    $nok_address = mysqli_real_escape_string($conn, $_POST["nok_address"]);
    $nok_relationship = mysqli_real_escape_string($conn, $_POST["nok_relationship"]);
    $bank_name = mysqli_real_escape_string($conn, $_POST["bank_name"]);
    $bank_account_number = mysqli_real_escape_string($conn, $_POST["bank_account_number"]);
    $routing_number = mysqli_real_escape_string($conn, $_POST["routing_number"]);
    $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $signature = mysqli_real_escape_string($conn, $_POST["signature"]);

    $query = "INSERT INTO next_of_kin_info (account_holder_name, account_holder_email, account_holder_phone, 
              account_holder_dob, valid_id, nok_name, nok_email, nok_phone, nok_address, nok_relationship, 
              bank_name, bank_account_number, routing_number, user_id, password, signature) 
              VALUES ('$account_holder_name', '$account_holder_email', '$account_holder_phone', 
              '$account_holder_dob', '$valid_id', '$nok_name', '$nok_email', '$nok_phone', 
              '$nok_address', '$nok_relationship', '$bank_name', '$bank_account_number', 
              '$routing_number', '$user_id', '$password', '$signature')";

    if (mysqli_query($conn, $query)) {
        header("Location: success.html");
        exit();
    } else {
        header("Location: index.html?error=" . urlencode(mysqli_error($conn)));
        exit();
    }
}

mysqli_close($conn);
?>
