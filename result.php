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

$answers = '';
for ($i = 0; $i < MAX_QUESTION_NUMBER; $i++) {
    $answers .= $_POST['answer_' . $i] ?? ' ';
}

$score = compute_score($answers);

$questions = retrieve_questions();
$all_questions = $questions['questions'];
$correct_answers = get_answers();

$hero_class = ($score > 2) ? 'is-success' : 'is-danger';
$birthdate_formatted = date('F d, Y', strtotime($birthdate));
$is_perfect = ($score == MAX_QUESTION_NUMBER);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPT10 Laboratory Activity #3A - Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/site/site.min.css">
    <script src="https://cdn.jsdelivr.net/npm/confetti-js@0.0.18/dist/index.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --navy: #0b1730; --white: #fff; --gray: #202735; --muted: #aeb7c6; }
        * { font-family: Inter, Arial, sans-serif; }
        body { background-color: var(--gray); }
        .result-section {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .section { background-color: var(--white); }
        .table-container { margin-top: 20px; }
        #confetti-canvas {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none;
            z-index: 999;
        }
        .correct-answer { color: #1b6b3a; font-weight: 600; }
        .wrong-answer { color: #cc0000; font-weight: 600; }
        .score-big { font-size: 3rem; font-weight: 800; }
        .tag.is-success {
            background-color: var(--navy) !important;
            color: var(--white) !important;
        }
        .tag.is-danger { background-color: #cc0000 !important; }
        .title { color: var(--gray) !important; }
    </style>
</head>
<body>

<!-- Hero section: is-success if score > 2, is-danger otherwise -->
<section class="hero <?php echo $hero_class; ?>">
    <div class="hero-body">
        <div class="has-text-centered">
            <p class="title" style="color: var(--white) !important;">
                <?php if ($is_perfect): ?>
                    Perfect Score!
                <?php elseif ($score > 2): ?>
                    Great Job!
                <?php else: ?>
                    Better Luck Next Time
                <?php endif; ?>
            </p>
            <p class="score-big" style="color: var(--white);"><?php echo $score; ?> / <?php echo MAX_QUESTION_NUMBER; ?></p>
            <p class="subtitle" style="color: rgba(255,255,255,0.85);">This is the IPT10 PHP Quiz Web Application Laboratory Activity.</p>
        </div>
    </div>
</section>

<section class="section">
    <div class="result-section">
        <h3 class="title is-4">Your Information</h3>
        <div class="table-container">
            <table class="table is-bordered is-hoverable is-fullwidth">
                <tbody>
                    <tr>
                        <th>Input Field</th>
                        <th>Value</th>
                    </tr>
                    <tr>
                        <td>Complete Name</td>
                        <td><?php echo htmlspecialchars($complete_name); ?></td>
                    </tr>
                    <tr class="is-selected">
                        <td>Email</td>
                        <td><?php echo htmlspecialchars($email); ?></td>
                    </tr>
                    <tr>
                        <td>Birthdate</td>
                        <td><?php echo $birthdate_formatted; ?></td>
                    </tr>
                    <tr>
                        <td>Contact Number</td>
                        <td><?php echo htmlspecialchars($contact_number); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <h3 class="title is-4" style="margin-top: 40px;">Question Review</h3>
        <div class="table-container">
            <table class="table is-bordered is-hoverable is-fullwidth is-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Correct Answer</th>
                        <th>Your Answer</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < MAX_QUESTION_NUMBER; $i++): ?>
                    <?php
                        $user_answer = isset($answers[$i]) ? $answers[$i] : '-';
                        $correct = $correct_answers[$i];
                        $is_correct = ($user_answer === $correct);
                        
                        $correct_text = '';
                        $user_text = '';
                        foreach ($all_questions[$i]['options'] as $option) {
                            if ($option['key'] === $correct) $correct_text = $option['value'];
                            if ($option['key'] === $user_answer) $user_text = $option['value'];
                        }
                        if ($user_text === '') $user_text = 'No answer';
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo htmlspecialchars($all_questions[$i]['question']); ?></td>
                        <td class="correct-answer"><?php echo $correct . ' - ' . htmlspecialchars($correct_text); ?></td>
                        <td class="<?php echo $is_correct ? 'correct-answer' : 'wrong-answer'; ?>">
                            <?php echo $user_answer . ' - ' . htmlspecialchars($user_text); ?>
                        </td>
                        <td>
                            <?php if ($is_correct): ?>
                                <span class="tag is-success">Correct</span>
                            <?php else: ?>
                                <span class="tag is-danger">Wrong</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>

        <?php if ($is_perfect): ?>
        <canvas id="confetti-canvas"></canvas>
        <?php endif; ?>
    </div>
</section>

<?php if ($is_perfect): ?>
<script>
    var confetti = new ConfettiGenerator({ target: 'confetti-canvas' });
    confetti.render();
</script>
<?php endif; ?>

</body>
</html>
