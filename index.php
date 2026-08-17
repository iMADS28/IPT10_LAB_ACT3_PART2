<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Laboratory Activity #3A</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #0b1730; --white: #fff; --gray: #202735; --muted: #aeb7c6; }
        * { font-family: Inter, Arial, sans-serif; }
        body { background-color: var(--gray); }
        .register-box {
            max-width: 600px;
            margin: 60px auto;
            background: var(--white);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.35);
        }
        .title, .label { color: var(--gray) !important; }
        .subtitle { color: var(--muted) !important; }
        .button.is-link, .button.is-success {
            background-color: var(--navy) !important;
            border-color: var(--navy) !important;
            color: var(--white) !important;
        }
        .button.is-link:hover, .button.is-success:hover {
            background-color: #0e1f3d !important;
            border-color: #0e1f3d !important;
        }
        .button[disabled] {
            background-color: var(--muted) !important;
            border-color: var(--muted) !important;
            opacity: 0.6;
        }
        .input:focus, .input:active {
            border-color: var(--navy) !important;
            box-shadow: 0 0 0 0.125em rgba(11,23,48,0.25) !important;
        }
        .input.is-success { border-color: var(--navy) !important; }
        .input.is-danger { border-color: #cc0000 !important; }
        .help.is-danger { color: #cc0000 !important; }
    </style>
</head>
<body>
<section class="section">
    <div class="register-box">
        <h1 class="title has-text-centered">User Registration</h1>
        <h2 class="subtitle has-text-centered">
            This is the IPT10 PHP Quiz Web Application Laboratory Activity. Please register
        </h2>

        <!-- BUG FIX: Changed method from GET to POST, and action from pre-instructions.php to instructions.php -->
        <form method="POST" action="instructions.php" id="registrationForm">
            <div class="field">
                <label class="label">Complete Name</label>
                <div class="control">
                    <input class="input" type="text" name="complete_name" id="complete_name" placeholder="e.g. Juan Dela Cruz" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Email Address</label>
                <div class="control">
                    <input class="input" name="email" id="email" type="email" placeholder="e.g. juan@example.com" required>
                </div>
                <p class="help is-danger" id="emailError" style="display:none;">Please enter a valid email address</p>
            </div>

            <div class="field">
                <label class="label">Birthdate</label>
                <div class="control">
                    <input class="input" name="birthdate" type="date" required />
                </div>
            </div>

            <div class="field">
                <label class="label">Contact Number</label>
                <div class="control">
                    <input class="input" name="contact_number" type="text" placeholder="e.g. 09171234567" />
                </div>
            </div>

            <!-- Next button - disabled by default until name and email are valid -->
            <div class="field">
                <div class="control">
                    <button type="submit" id="nextBtn" class="button is-link is-fullwidth" disabled>Proceed Next</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    const nameInput = document.getElementById('complete_name');
    const emailInput = document.getElementById('email');
    const nextBtn = document.getElementById('nextBtn');
    const emailError = document.getElementById('emailError');

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function validateForm() {
        const nameValid = nameInput.value.trim() !== '';
        const emailValid = isValidEmail(emailInput.value.trim());

        if (emailInput.value.trim() !== '' && !emailValid) {
            emailError.style.display = 'block';
            emailInput.classList.add('is-danger');
            emailInput.classList.remove('is-success');
        } else if (emailValid) {
            emailError.style.display = 'none';
            emailInput.classList.remove('is-danger');
            emailInput.classList.add('is-success');
        } else {
            emailError.style.display = 'none';
            emailInput.classList.remove('is-danger');
            emailInput.classList.remove('is-success');
        }

        nextBtn.disabled = !(nameValid && emailValid);
    }

    nameInput.addEventListener('input', validateForm);
    emailInput.addEventListener('input', validateForm);
</script>

</body>
</html>
