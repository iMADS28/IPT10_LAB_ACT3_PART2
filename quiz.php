<?php

require "helpers.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$complete_name = $_POST['complete_name'];
$email = $_POST['email'];
$birthdate = $_POST['birthdate'];
$contact_number = $_POST['contact_number'];
$agree = $_POST['agree'] ?? '';

$questions = retrieve_questions();
$all_questions = $questions['questions'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Laboratory Activity #3A - Quiz</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #0b1730; --white: #fff; --gray: #202735; --muted: #aeb7c6; }
        * { font-family: Inter, Arial, sans-serif; }
        body { background-color: var(--gray); }
        .quiz-box {
            max-width: 800px;
            margin: 40px auto;
            background: var(--white);
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 30px rgba(0,0,0,0.35);
        }
        .title { color: var(--gray) !important; }
        .subtitle { color: var(--muted) !important; }
        .question-card {
            background: #f4f5f7;
            border: 1px solid #e2e4e8;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .question-card h3 {
            margin-bottom: 15px;
            color: var(--gray);
        }
        .timer-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 4px;
            background: var(--navy);
            transition: width 1s linear;
            z-index: 1000;
        }
        .timer-display {
            position: fixed;
            top: 10px;
            right: 20px;
            background: var(--navy);
            color: var(--white);
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 1.1rem;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        .timer-display.warning { background: #cc0000; }
        .button.is-link {
            background-color: var(--navy) !important;
            border-color: var(--navy) !important;
            color: var(--white) !important;
        }
        .button.is-link:hover {
            background-color: #0e1f3d !important;
            border-color: #0e1f3d !important;
        }
        .tag.is-info {
            background-color: var(--navy) !important;
            color: var(--white) !important;
        }
    </style>
</head>
<body>

<div class="timer-bar" id="timerBar" style="width: 100%;"></div>
<div class="timer-display" id="timerDisplay">60s</div>

<section class="section">
    <div class="quiz-box">
        <h1 class="title has-text-centered">Quiz Time</h1>
        <h2 class="subtitle has-text-centered">
            Answer all <?php echo MAX_QUESTION_NUMBER; ?> questions below. You have 60 seconds.
        </h2>

        <form method="POST" action="result.php" id="quizForm">
            <input type="hidden" name="complete_name" value="<?php echo htmlspecialchars($complete_name); ?>" />
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>" />
            <input type="hidden" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" />
            <input type="hidden" name="contact_number" value="<?php echo htmlspecialchars($contact_number); ?>" />
            <input type="hidden" name="agree" value="<?php echo htmlspecialchars($agree); ?>" />

            <?php foreach ($all_questions as $index => $question): ?>
            <div class="question-card">
                <h3 class="is-size-5">
                    <span class="tag is-info is-medium">Q<?php echo $index + 1; ?></span>
                    &nbsp; <?php echo htmlspecialchars($question['question']); ?>
                </h3>

                <?php foreach ($question['options'] as $option): ?>
                <div class="field">
                    <div class="control">
                        <label class="radio">
                            <input type="radio"
                                name="answer_<?php echo $index; ?>"
                                value="<?php echo $option['key']; ?>" />
                            <strong><?php echo $option['key']; ?>.</strong> <?php echo htmlspecialchars($option['value']); ?>
                        </label>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>

            <div class="field">
                <div class="control">
                    <button type="submit" class="button is-link is-fullwidth is-medium">Submit Answers</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    let timeLeft = 60;
    const timerDisplay = document.getElementById('timerDisplay');
    const timerBar = document.getElementById('timerBar');
    const quizForm = document.getElementById('quizForm');

    const countdown = setInterval(function() {
        timeLeft--;
        timerDisplay.textContent = timeLeft + 's';
        timerBar.style.width = ((timeLeft / 60) * 100) + '%';

        if (timeLeft <= 10) {
            timerDisplay.classList.add('warning');
            timerBar.style.background = '#cc0000';
        }

        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerDisplay.textContent = "Time's up!";
            quizForm.submit();
        }
    }, 1000);
</script>

</body>
</html>
