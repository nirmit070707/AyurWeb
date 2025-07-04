<?php
require_once 'config.php';

// Redirect if already logged in
if (is_logged_in()) {
    redirect('homepg.php');
}

$errors = [];
$login_identifier = $_SERVER['REMOTE_ADDR']; // Use IP for rate limiting

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check rate limiting
    if (!check_rate_limit($login_identifier)) {
        $errors[] = "Too many login attempts. Please try again later.";
    } else {
        // Get and sanitize form data
        $username_or_email = sanitize_input($_POST['username_or_email']);
        $password = $_POST['password'];
        $remember_me = isset($_POST['remember_me']);

        // Validation
        if (empty($username_or_email)) {
            $errors[] = "Please enter your username or email";
        }

        if (empty($password)) {
            $errors[] = "Please enter your password";
        }

        // If no validation errors, attempt login
        if (empty($errors)) {
            try {
                $database = new Database();
                $db = $database->getConnection();

                // Check if input is email or username
                $is_email = validate_email($username_or_email);
                
                if ($is_email) {
                    $query = "SELECT id, username, email, password_hash, first_name, last_name, is_active 
                              FROM users WHERE email = :identifier AND is_active = 1";
                } else {
                    $query = "SELECT id, username, email, password_hash, first_name, last_name, is_active 
                              FROM users WHERE username = :identifier AND is_active = 1";
                }

                $stmt = $db->prepare($query);
                $stmt->bindParam(':identifier', $username_or_email);
                $stmt->execute();

                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    // Verify password
                    if (password_verify($password, $user['password_hash'])) {
                        // Update last login time
                        $update_query = "UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = :user_id";
                        $update_stmt = $db->prepare($update_query);
                        $update_stmt->bindParam(':user_id', $user['id']);
                        $update_stmt->execute();

                        // Login user
                        login_user($user['id'], $user['username']);

                        // Set remember me cookie if requested
                        if ($remember_me) {
                            $token = bin2hex(random_bytes(32));
                            setcookie('remember_token', $token, time() + (30 * 24 * 60 * 60), '/', '', true, true); // 30 days
                            
                            // Store token in database (you might want to create a remember_tokens table)
                            // For simplicity, we'll skip this implementation
                        }

                        set_message("Welcome back, " . htmlspecialchars($user['first_name']) . "!", "success");
                        
                        // Redirect to intended page or dashboard
                        $redirect_url = $_GET['redirect'] ?? 'homepg.php';
                        redirect($redirect_url);
                    } else {
                        $errors[] = "Invalid username/email or password";
                        increment_rate_limit($login_identifier);
                    }
                } else {
                    $errors[] = "Invalid username/email or password";
                    increment_rate_limit($login_identifier);
                }
            } catch (Exception $e) {
                $errors[] = "Login failed. Please try again.";
                log_error("Login error: " . $e->getMessage());
            }
        }
    }
}

// Get flash message if any
$flash_message = get_flash_message();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AYURWEB</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:  #667eea ;
            --primary-dark: rgb(70, 92, 141);
            --accent: #F59E0B;
            --bg: #F0FDF4;
            --white: #FFFFFF;
            --text: #111827;
            --text-light: #6B7280;
            --shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', sans-serif; 
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            background: var(--white);
            border-radius: 25px;
            box-shadow: var(--shadow);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            position: relative;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 3rem 2rem 2rem;
            text-align: center;
            position: relative;
        }

        /* .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.1), transparent 70%);
            animation: rotate 20s linear infinite;
        } */

       

        .login-header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .login-header p {
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .login-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text);
        }

        input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #E5E7EB;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(89, 172, 94, 0.1);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .remember-me input[type="checkbox"] {
            width: auto;
        }

        .forgot-password {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 16px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(89, 172, 94, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(89, 172, 94, 0.4);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .register-link {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #E5E7EB;
        }

        .register-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            position: absolute;
            top: 2rem;
            left: 2rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .back-home:hover {
            color: white;
            transform: translateX(-3px);
        }

        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
        }

        .alert-error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }

        .alert-success {
            background: #F0FDF4;
            color: #16A34A;
            border: 1px solid #BBF7D0;
        }

        .alert-warning {
            background: #FFFBEB;
            color: #D97706;
            border: 1px solid #FED7AA;
        }

        @media (max-width: 768px) {
            .login-container {
                margin: 1rem;
                max-width: none;
            }
            
            .login-header h1 {
                font-size: 2rem;
            }

            .back-home {
                position: static;
                justify-content: center;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>
    <a href="homepg.php" class="back-home">
        <i class="fas fa-arrow-left"></i>
        Back to Home
    </a>

    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to continue your Ayurvedic journey</p>
        </div>

        <div class="login-form">
            <?php if ($flash_message): ?>
                <div class="alert alert-<?php echo $flash_message['type']; ?>">
                    <i class="fas fa-<?php echo $flash_message['type'] === 'success' ? 'check-circle' : ($flash_message['type'] === 'warning' ? 'exclamation-triangle' : 'info-circle'); ?>"></i>
                    <?php echo htmlspecialchars($flash_message['message']); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php foreach ($errors as $error): ?>
                        <div><?php echo htmlspecialchars($error); ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username_or_email">Username or Email *</label>
                    <input type="text" id="username_or_email" name="username_or_email" required 
                           value="<?php echo htmlspecialchars($_POST['username_or_email'] ?? ''); ?>"
                           placeholder="Enter your username or email">
                </div>

                <div class="form-group">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required 
                           placeholder="Enter your password">
                </div>

                <!-- <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember_me" value="1">
                        Remember me
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div> -->

                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i>
                    Sign In
                </button>
            </form>

            <div class="register-link">
                Don't have an account? <a href="register.php">Create one here</a>
            </div>
        </div>
    </div>

    <script>
        // Real-time form validation
        document.querySelectorAll('input[required]').forEach(input => {
            input.addEventListener('blur', function() {
                if (!this.value.trim()) {
                    this.style.borderColor = '#DC2626';
                } else {
                    this.style.borderColor = '#E5E7EB';
                }
            });
        });

        // Auto-hide flash messages
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease';
                setTimeout(() => alert.remove(), 500);
            }, 5000);
        });
    </script>
</body>
</html>