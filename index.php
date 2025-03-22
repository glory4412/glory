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

            <div class="form-group signature-section">
                <label>Digital Signature:</label>
                <div class="signature-pad-wrapper">
                    <div class="signature-pad-container">
                        <canvas id="signaturePad" width="600" height="200"></canvas>
                        <input type="hidden" id="signature" name="signature" required>
                    </div>
                    <div class="signature-controls">
                        <button type="button" id="clearSignature" class="btn-secondary">Clear</button>
                        <button type="button" id="undoSignature" class="btn-secondary">Undo</button>
                        <div class="pen-settings">
                            <input type="color" id="penColor" value="#000000">
                            <input type="range" id="penSize" min="1" max="5" value="2">
                        </div>
                    </div>
                    <div class="signature-guide"></div>
                </div>
                <small>Please sign using your mouse or touch screen. By signing, you acknowledge the information provided is accurate.</small>
            </div>

            <button type="submit" id="submitBtn" disabled>Submit Information</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const canvas = document.getElementById('signaturePad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                velocityFilterWeight: 0.7,
                minWidth: 0.5,
                maxWidth: 2.5,
                throttle: 16,
            });
            
            const clearButton = document.getElementById('clearSignature');
            const undoButton = document.getElementById('undoSignature');
            const submitButton = document.getElementById('submitBtn');
            const signatureInput = document.getElementById('signature');
            const penColor = document.getElementById('penColor');
            const penSize = document.getElementById('penSize');

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }

            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            function updateSubmitButton() {
                submitButton.disabled = signaturePad.isEmpty();
            }

            signaturePad.addEventListener('endStroke', () => {
                signatureInput.value = signaturePad.toDataURL();
                updateSubmitButton();
            });

            clearButton.addEventListener('click', () => {
                signaturePad.clear();
                signatureInput.value = '';
                updateSubmitButton();
            });

            undoButton.addEventListener('click', () => {
                const data = signaturePad.toData();
                if (data) {
                    data.pop();
                    signaturePad.fromData(data);
                    signatureInput.value = signaturePad.toDataURL();
                    updateSubmitButton();
                }
            });

            penColor.addEventListener('change', (e) => {
                signaturePad.penColor = e.target.value;
            });

            penSize.addEventListener('input', (e) => {
                signaturePad.minWidth = e.target.value;
                signaturePad.maxWidth = e.target.value * 2;
            });
        });
    </script>
</body>
</html>
</body>
</html>

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
    if (form.bank_name.value.length < 2) {
        errorMessage += 'Invalid bank name\n';
        isValid = false;
    }

    const accountRegex = /^\d{5,17}$/;
    if (!accountRegex.test(form.bank_account_number.value)) {
        errorMessage += 'Invalid bank account number\n';
        isValid = false;
    }

    if (form.routing_number.value && !/^\d{9}$/.test(form.routing_number.value)) {
        errorMessage += 'Invalid routing number (should be 9 digits)\n';
        isValid = false;
    }

    // User Credentials Validation
    if (form.user_id.value.length < 5) {
        errorMessage += 'User ID must be at least 5 characters long\n';
        isValid = false;
    }

    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    if (!passwordRegex.test(form.password.value)) {
        errorMessage += 'Password must be at least 8 characters with letters and numbers\n';
        isValid = false;
    }

    // Signature Validation
    if (!form.signature.value) {
        errorMessage += 'Signature is required\n';
        isValid = false;
    }

    if (!isValid) {
        alert('Please correct the following errors:\n\n' + errorMessage);
        return false;
    }

    if (confirm('Are you sure you want to submit this information?')) {
        form.submit();
    }
    return false;
}

// Real-time validation
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('invalid');
            if (this.value.trim() === '') {
                this.classList.add('invalid');
            }
        });
    });
});
</script>
