<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$complete_name = $_POST['complete_name'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$contact_number = $_POST['contact_number'];

$name_parts = explode(' ', trim($complete_name));
$first_name = $name_parts[0];
?>
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
        .instruction-box {
            max-width: 700px;
            margin: 60px auto;
            background: var(--white);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.35);
        }
        .title { color: var(--gray) !important; }
        .subtitle { color: var(--muted) !important; }
        .label { color: var(--gray) !important; }
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
    </style>
</head>
<body>
<section class="section">
    <div class="instruction-box">
        <h1 class="title">Instructions</h1>

        <h2 class="subtitle">
            Hello <strong style="color: var(--navy);"><?php echo htmlspecialchars($first_name); ?></strong>, please read the instructions first
        </h2>

        <form method="POST" action="quiz.php" id="instructionForm">
            <input type="hidden" name="complete_name" value="<?php echo htmlspecialchars($complete_name); ?>" />
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
            <input type="hidden" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" />
            <input type="hidden" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" />

            <div class="content">
                <p>
                    Welcome to the IPT10 Quiz Application. This quiz contains <strong>5 questions</strong> about Philippine history and geography. 
                    Please read the following instructions carefully before proceeding:
                </p>
                <ul>
                    <li>All questions will be displayed at once on a single page.</li>
                    <li>Select one answer for each question by clicking on the radio button.</li>
                    <li>You have <strong>60 seconds</strong> to complete the quiz. The form will auto-submit when the timer runs out.</li>
                    <li>Your results will be shown after submission along with the correct answers.</li>
                </ul>
            </div>

            <div class="field">
                <label class="label">Terms and Conditions</label>
                <div class="control">
                    <textarea class="textarea" readonly>By taking this quiz, you agree to the following terms and conditions:

1. Your registration information will be used solely for the purpose of this quiz activity.
2. Your answers and score will be recorded for grading purposes.
3. You must complete the quiz within the allotted time.
4. Any form of cheating or dishonesty is strictly prohibited.
5. Your results will be visible to the course facilitator/instructor.</textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                        <input type="checkbox" name="agree" id="agreeCheckbox">
                        I agree to the <a href="#" style="color: var(--navy); text-decoration: underline;">terms and conditions</a>
                    </label>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button type="submit" id="startQuizBtn" class="button is-link is-fullwidth" disabled>Start Quiz</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    const agreeCheckbox = document.getElementById('agreeCheckbox');
    const startQuizBtn = document.getElementById('startQuizBtn');

    agreeCheckbox.addEventListener('change', function() {
        startQuizBtn.disabled = !this.checked;
    });
</script>

</body>
</html>
