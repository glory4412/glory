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
        <form action="process_form.php" method="POST" id="nokForm" onsubmit="return validateForm(event);">
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
                    <textarea id="nok_address" name="nok_address" required></textarea>
                </div>
                <div class="form-group">
                    <label for="nok_relationship">Relationship:</label>
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

            <fieldset>
                <legend>Digital Signature</legend>
                <div class="signature-container">
                    <canvas id="signatureCanvas" width="600" height="200"></canvas>
                    <input type="hidden" id="signature" name="signature">
                    <div class="signature-controls">
                        <button type="button" id="clearSignature">Clear</button>
                        <button type="button" id="undoSignature">Undo</button>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit">Submit</button>
                <button type="reset">Reset</button>
            </div>
        </form>
    </div>

    <script>
        function validateForm(event) {
            event.preventDefault();
            const form = document.getElementById('nokForm');
            let isValid = true;
            let errorMessage = '';

            // Account Holder Validation
            const nameRegex = /^[a-zA-Z\s]{2,}$/;
            if (!nameRegex.test(form.account_holder_name.value)) {
                errorMessage += 'Invalid account holder name (only letters and spaces allowed)\n';
                isValid = false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(form.account_holder_email.value)) {
                errorMessage += 'Invalid email format\n';
                isValid = false;
            }

            const phoneRegex = /^\+?[\d\s-]{10,}$/;
            if (!phoneRegex.test(form.account_holder_phone.value)) {
                errorMessage += 'Invalid phone number (minimum 10 digits)\n';
                isValid = false;
            }

            // Date validation
            const dob = new Date(form.account_holder_dob.value);
            const today = new Date();
            if (dob >= today) {
                errorMessage += 'Date of birth must be in the past\n';
                isValid = false;
            }

            // Next of Kin Validation
            if (!nameRegex.test(form.nok_name.value)) {
                errorMessage += 'Invalid next of kin name\n';
                isValid = false;
            }

            if (form.nok_email.value && !emailRegex.test(form.nok_email.value)) {
                errorMessage += 'Invalid next of kin email format\n';
                isValid = false;
            }

            if (!phoneRegex.test(form.nok_phone.value)) {
                errorMessage += 'Invalid next of kin phone number\n';
                isValid = false;
            }

            if (form.nok_address.value.length < 10) {
                errorMessage += 'Address is too short\n';
                isValid = false;
            }

            // Bank Information Validation
            if (form.bank_account_number.value.length < 5) {
                errorMessage += 'Invalid bank account number\n';
                isValid = false;
            }

            // Signature Validation
            if (!form.signature.value) {
                errorMessage += 'Signature is required\n';
                isValid = false;
            }

            if (!isValid) {
                alert(errorMessage);
                return false;
            }

            form.submit();
            return true;
        }

        // Signature Pad Implementation
        const canvas = document.getElementById('signatureCanvas');
        const ctx = canvas.getContext('2d');
        const signatureInput = document.getElementById('signature');
        let isDrawing = false;
        let points = [];
        let undoStack = [];

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseout', stopDrawing);

        function startDrawing(e) {
            isDrawing = true;
            const point = getPoint(e);
            points.push(point);
            ctx.beginPath();
            ctx.moveTo(point.x, point.y);
        }

        function draw(e) {
            if (!isDrawing) return;
            const point = getPoint(e);
            points.push(point);
            ctx.lineTo(point.x, point.y);
            ctx.stroke();
        }

        function stopDrawing() {
            if (isDrawing) {
                isDrawing = false;
                undoStack.push([...points]);
                signatureInput.value = canvas.toDataURL();
            }
        }

        function getPoint(e) {
            const rect = canvas.getBoundingClientRect();
            return {
                x: e.clientX - rect.left,
                y: e.clientY - rect.top
            };
        }

        document.getElementById('clearSignature').addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            points = [];
            undoStack = [];
            signatureInput.value = '';
        });

        document.getElementById('undoSignature').addEventListener('click', () => {
            if (undoStack.length > 0) {
                undoStack.pop();
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                if (undoStack.length > 0) {
                    redrawSignature();
                }
                signatureInput.value = canvas.toDataURL();
            }
        });

        function redrawSignature() {
            const lastPoints = undoStack[undoStack.length - 1];
            ctx.beginPath();
            ctx.moveTo(lastPoints[0].x, lastPoints[0].y);
            for (let i = 1; i < lastPoints.length; i++) {
                ctx.lineTo(lastPoints[i].x, lastPoints[i].y);
                ctx.stroke();
            }
        }

        // Initialize canvas style
        ctx.strokeStyle = '#000';
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
    </script>
</body>
</html>