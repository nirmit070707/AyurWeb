<?php
require_once 'config.php';

// Ensure user is logged in
require_login();

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch dosha from database
try {
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT dosha FROM users WHERE id = :user_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch();
    $dosha = $result['dosha'] ?? null;
} catch (Exception $e) {
    log_error("View result error: " . $e->getMessage());
    $dosha = null;
}

// Map dosha to page
$redirect_map = [
    'vata' => 'vata_result.html',
    'kapha' => 'kapha_result.html',
    'pitta' => 'pitta_result.html',
    'vata &amp; kapha' => 'vata_kapha.html',
    'kapha &amp; vata' => 'vata_kapha.html',
    'pitta &amp; vata' => 'vata_pitta.html',
    'vata &amp; pitta' => 'vata_pitta.html',
    'kapha &amp; pitta' => 'kapha_pitta.html',
    'pitta &amp; kapha' => 'kapha_pitta.html',
    'vata &amp; pitta &amp; kapha' => 'tridosha.html'
];

// Default link
$analysis_link = "#";
$show_button = false;

if ($dosha && isset($redirect_map[strtolower($dosha)])) {
    $analysis_link = $redirect_map[strtolower($dosha)];
    $show_button = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dosha Result - AYURWEB</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #2d8659;
            --light-green: #4ade80;
            --gold: #f59e0b;
            --sage: #6b7280;
            --cream: #fef7ed;
            --soft-white: #fefefe;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #d1fae5 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(45, 134, 89, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(74, 222, 128, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(245, 158, 11, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .result-card {
            background: var(--soft-white);
            border-radius: 24px;
            box-shadow: 
                0 20px 40px rgba(0,0,0,0.1),
                0 4px 12px rgba(0,0,0,0.05);
            padding: 3rem 2.5rem;
            max-width: 600px;
            width: 100%;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }

        .result-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-green), var(--light-green), var(--gold));
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .welcome-icon {
            font-size: 3rem;
            color: var(--primary-green);
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: var(--sage);
            font-size: 1.1rem;
            font-weight: 400;
        }

        .dosha-result {
            background: linear-gradient(135deg, var(--cream) 0%, #fef3c7 100%);
            border-radius: 16px;
            padding: 2rem;
            margin: 2rem 0;
            text-align: center;
            border: 2px solid rgba(245, 158, 11, 0.2);
            position: relative;
        }

        .dosha-result::before {
            content: '✨';
            position: absolute;
            top: -10px;
            right: 20px;
            font-size: 1.5rem;
            animation: sparkle 2s ease-in-out infinite;
        }

        @keyframes sparkle {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.2); }
        }

        .dosha-label {
            font-size: 1.1rem;
            color: var(--sage);
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .dosha-name {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dosha-description {
            color: var(--sage);
            font-size: 0.95rem;
            font-style: italic;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-green), var(--light-green));
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(45, 134, 89, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(45, 134, 89, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            border: 2px solid var(--primary-green);
            padding: 0.875rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            color: var(--primary-green);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: var(--primary-green);
            color: white;
            transform: translateY(-2px);
        }

        .error-state {
            text-align: center;
            padding: 2rem;
        }

        .error-icon {
            font-size: 3rem;
            color: #ef4444;
            margin-bottom: 1rem;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1rem;
        }

        .error-message {
            color: var(--sage);
            margin-bottom: 2rem;
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, var(--gold), #f97316);
            border: none;
            padding: 0.875rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            color: white;
        }

        .decorative-elements {
            position: absolute;
            top: 20px;
            right: 20px;
            opacity: 0.1;
            font-size: 8rem;
            color: var(--primary-green);
            z-index: -1;
        }

        @media (max-width: 768px) {
            .result-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }
            
            .welcome-title {
                font-size: 1.5rem;
            }
            
            .dosha-name {
                font-size: 2rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .btn-primary-custom,
            .btn-secondary-custom,
            .btn-warning-custom {
                width: 100%;
                justify-content: center;
                max-width: 280px;
            }
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="main-container">
    <div class="result-card">
        <div class="decorative-elements">
            <i class="fas fa-leaf"></i>
        </div>

        <?php if ($dosha): ?>
            <div class="welcome-section">
                <div class="welcome-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <h1 class="welcome-title">Namaste, <?= htmlspecialchars($username) ?>!</h1>
                <p class="welcome-subtitle">Your Ayurvedic journey begins here</p>
            </div>

            <div class="dosha-result pulse-animation">
                <div class="dosha-label">Your Dominant Dosha is:</div>
                <div class="dosha-name"><?= (ucwords($dosha)) ?></div>
                <script>
                    // Display the dosha in the console for debugging
                    console.log("Your dosha is: <?= ($dosha) ?>");
                </script>
                <div class="dosha-description">The unique constitution that defines your mind-body type</div>
            </div>

            <?php if ($show_button): ?>
                <div class="action-buttons">
                    <a href="<?= $analysis_link ?>" class="btn-primary-custom">
                        <i class="fas fa-chart-line"></i>
                        View Detailed Analysis
                    </a>
                    <a href="homepg.php" class="btn-secondary-custom">
                        <i class="fas fa-home"></i>
                        Back to Homepage
                    </a>
                </div>
            <?php else: ?>
                <div class="error-state">
                    <div class="error-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="error-title">Analysis Unavailable</div>
                    <div class="error-message">We're working on preparing your personalized analysis. Please check back soon!</div>
                    <a href="indexw.php" class="btn-secondary-custom">
                        <i class="fas fa-home"></i>
                        Return to Homepage
                    </a>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="error-state">
                <div class="error-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="error-title">No Dosha Result Found</div>
                <div class="error-message">It looks like you haven't taken the Ayurvedic quiz yet. Discover your unique mind-body constitution!</div>
                <a href="indexw.php" class="btn-warning-custom">
                    <i class="fas fa-play-circle"></i>
                    Take the Quiz
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>