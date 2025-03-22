
<?php
$database_url = getenv('DATABASE_URL');

try {
    $conn = pg_connect($database_url);
    if (!$conn) {
        throw new Exception("Database connection failed");
    }
} catch (Exception $e) {
    die("Connection error: " . $e->getMessage());
}

$query = "SELECT * FROM next_of_kin_info ORDER BY submission_timestamp DESC";
$result = pg_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Records</title>
    <link rel="stylesheet" href="style.css">
    <meta http-equiv="refresh" content="30">
    <style>
        body { background: #f5f5f5; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .record-details { background: #fff; padding: 15px; margin: 10px 0; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .timestamp { color: #666; font-size: 0.9em; }
        .section { margin-bottom: 10px; }
        .label { font-weight: bold; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Next of Kin Information System - Records</h1>
        <div id="records">
            <?php while ($row = pg_fetch_assoc($result)): ?>
            <div class="record-details">
                <div class="timestamp">Submitted: <?php echo htmlspecialchars($row['submission_timestamp']); ?></div>
                
                <div class="section">
                    <h3>Account Holder Information</h3>
                    <p><span class="label">Name:</span> <?php echo htmlspecialchars($row['account_holder_name']); ?></p>
                    <p><span class="label">Email:</span> <?php echo htmlspecialchars($row['account_holder_email']); ?></p>
                    <p><span class="label">Phone:</span> <?php echo htmlspecialchars($row['account_holder_phone']); ?></p>
                    <p><span class="label">Date of Birth:</span> <?php echo htmlspecialchars($row['account_holder_dob']); ?></p>
                    <p><span class="label">ID Type:</span> <?php echo htmlspecialchars($row['valid_id']); ?></p>
                </div>

                <div class="section">
                    <h3>Next of Kin Details</h3>
                    <p><span class="label">Name:</span> <?php echo htmlspecialchars($row['nok_name']); ?></p>
                    <p><span class="label">Email:</span> <?php echo htmlspecialchars($row['nok_email']); ?></p>
                    <p><span class="label">Phone:</span> <?php echo htmlspecialchars($row['nok_phone']); ?></p>
                    <p><span class="label">Address:</span> <?php echo htmlspecialchars($row['nok_address']); ?></p>
                    <p><span class="label">Relationship:</span> <?php echo htmlspecialchars($row['nok_relationship']); ?></p>
                </div>

                <div class="section">
                    <h3>Bank Information</h3>
                    <p><span class="label">Bank Name:</span> <?php echo htmlspecialchars($row['bank_name']); ?></p>
                    <p><span class="label">Account Number:</span> <?php echo htmlspecialchars($row['bank_account_number']); ?></p>
                    <p><span class="label">Routing Number:</span> <?php echo htmlspecialchars($row['routing_number']); ?></p>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
<?php pg_close($conn); ?>
