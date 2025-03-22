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
    die("Connection error: " . $e->getMessage());
}

$query = "SELECT * FROM next_of_kin_info ORDER BY submission_timestamp DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Records</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Submitted Records</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Account Holder</th>
                <th>Email</th>
                <th>Next of Kin</th>
                <th>Submission Date</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['account_holder_name']); ?></td>
                <td><?php echo htmlspecialchars($row['account_holder_email']); ?></td>
                <td><?php echo htmlspecialchars($row['nok_name']); ?></td>
                <td><?php echo htmlspecialchars($row['submission_timestamp']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>