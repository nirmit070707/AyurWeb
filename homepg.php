<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AyurWeb - Ancient Wisdom, Modern Wellness</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Navigation Styles */
        .nav-dark {
            background: linear-gradient(135deg,rgb(77, 30, 138) 0%,rgb(46, 109, 182) 100%);
            box-shadow: 0 4px 20px rgba(30, 58, 138, 0.15);
        }
        
        .nav-link {
            transition: all 0.3s ease;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .nav-link:hover {
            color: #60a5fa;
            transform: translateY(-1px);
        }
        
        .logo-text {
            color: white;
            font-weight: 700;
        }
        
        /* Enhanced Button Styles */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        /* Hero Section Enhancement */
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="%23667eea" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="%23764ba2" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Floating Elements Enhancement */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin-top: 4rem;
        }

        .hero-circle {
            width: 350px;
            height: 350px;
            background: rgba(102, 126, 234, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            backdrop-filter: blur(15px);
            border: 2px solid rgba(102, 126, 234, 0.2);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.1);
        }

        .hero-icon {
            font-size: 6rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: float 4s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(180deg); }
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: floatAround 10s ease-in-out infinite;
            font-size: 2rem;
        }

        .floating-element:nth-child(1) { top: 15%; left: 10%; animation-delay: 0s; }
        .floating-element:nth-child(2) { top: 70%; right: 12%; animation-delay: 3s; }
        .floating-element:nth-child(3) { bottom: 25%; left: 15%; animation-delay: 6s; }

        @keyframes floatAround {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-20px) rotate(90deg) scale(1.1); }
            50% { transform: translateY(-35px) rotate(180deg) scale(0.9); }
            75% { transform: translateY(-20px) rotate(270deg) scale(1.1); }
        }

        /* Enhanced Dosha Cards */
        /* Enhanced Dosha Cards */
.dosha-container {
    padding: 80px 0;
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    position: relative;
}

.dosha-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.dosha-card {
    position: relative;
    height: 600px;
    border-radius: 20px;
    overflow: hidden;
    background: white;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
    /* Enhanced shadow system */
    box-shadow: 
        0 4px 6px rgba(0, 0, 0, 0.07),
        0 10px 15px rgba(0, 0, 0, 0.1),
        0 20px 25px rgba(0, 0, 0, 0.1);
}

.dosha-card:hover {
    transform: translateY(-12px) scale(1.02);
    /* Enhanced hover shadow */
    box-shadow: 
        0 8px 12px rgba(0, 0, 0, 0.1),
        0 20px 30px rgba(0, 0, 0, 0.15),
        0 35px 50px rgba(0, 0, 0, 0.12),
        0 0 0 1px rgba(102, 126, 234, 0.1);
    z-index: 10;
}

.dosha-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 1;
}

.dosha-card:hover::before {
    opacity: 1;
}

.dosha-image-container {
    height: 520px;
    overflow: hidden;
    position: relative;
}

.dosha-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.dosha-card:hover img {
    transform: scale(1.1);
}

.dosha-content {
    padding: 25px;
    position: relative;
    z-index: 2;
    background: white;
    height: 170px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.dosha-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.dosha-subtitle {
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 16px;
    font-weight: 500;
}

.learn-more-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 80px;
    gap: 8px;
    /* Enhanced button shadow */
    box-shadow: 
        0 3px 6px rgba(102, 126, 234, 0.25),
        0 8px 20px rgba(102, 126, 234, 0.15);
}

.learn-more-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.learn-more-btn:hover::before {
    left: 100%;
}

.learn-more-btn:hover {
    transform: translateY(-3px);
    box-shadow: 
        0 6px 12px rgba(102, 126, 234, 0.3),
        0 15px 30px rgba(102, 126, 234, 0.2);
}

.learn-more-btn:active {
    transform: translateY(-1px);
}

/* Individual card shadow colors */
.dosha-card:nth-child(1) {
    box-shadow: 
        0 4px 6px rgba(255, 107, 107, 0.07),
        0 10px 15px rgba(255, 107, 107, 0.1),
        0 20px 25px rgba(255, 107, 107, 0.1);
}

.dosha-card:nth-child(1):hover {
    box-shadow: 
        0 8px 12px rgba(255, 107, 107, 0.1),
        0 20px 30px rgba(255, 107, 107, 0.15),
        0 35px 50px rgba(255, 107, 107, 0.12);
}

.dosha-card:nth-child(2) {
    box-shadow: 
        0 4px 6px rgba(251, 146, 60, 0.07),
        0 10px 15px rgba(251, 146, 60, 0.1),
        0 20px 25px rgba(251, 146, 60, 0.1);
}

.dosha-card:nth-child(2):hover {
    box-shadow: 
        0 8px 12px rgba(251, 146, 60, 0.1),
        0 20px 30px rgba(251, 146, 60, 0.15),
        0 35px 50px rgba(251, 146, 60, 0.12);
}

.dosha-card:nth-child(3) {
    box-shadow: 
        0 4px 6px rgba(34, 197, 94, 0.07),
        0 10px 15px rgba(34, 197, 94, 0.1),
        0 20px 25px rgba(34, 197, 94, 0.1);
}

.dosha-card:nth-child(3):hover {
    box-shadow: 
        0 8px 12px rgba(34, 197, 94, 0.1),
        0 20px 30px rgba(34, 197, 94, 0.15),
        0 35px 50px rgba(34, 197, 94, 0.12);
}

/* Responsive Design for cards */
@media (max-width: 768px) {
    .dosha-grid {
        grid-template-columns: 1fr;
        gap: 30px;
        padding: 0 15px;
    }
    
    .dosha-card {
        height: 550px;
    }
    
    .dosha-image-container {
        height: 470px;
    }
    
    .dosha-content {
        height: 170px;
        padding: 20px;
    }
}
        /* Section Headers */
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title {
            font-size: 3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            font-size: 1.25rem;
            color: #6b7280;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Banner Enhancement */
        .banner {
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .banner img {
            width: 100%;
            height: 100%;
            transition: transform 0.3s ease;
        }

        .banner:hover img {
            transform: scale(1.02);
        }

        /* Quiz Section Enhancement */
        .quiz-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            position: relative;
        }

        .quiz-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="quiz-pattern" width="50" height="50" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="2" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23quiz-pattern)"/></svg>');
        }

        .quiz-content {
            position: relative;
            z-index: 2;
        }

        .quiz-locked {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Footer Enhancement */
        .footer-gradient {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        }

        .user-avatar {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .hero-circle {
                width: 250px;
                height: 250px;
            }
            
            .hero-icon {
                font-size: 4rem;
            }
        }

        /* Smooth Transitions */
        * {
            transition: color 0.3s ease, background-color 0.3s ease, transform 0.3s ease;
        }

        /* Loading Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Enhanced Navigation Bar -->
    <nav class="nav-dark shadow-xl sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center">
                            <div class="w-12 h-12 mr-3">
                                <img src="asep 2 logo (2).png" alt="AyurWeb Logo" class="w-full h-full object-contain">
                            </div>
                            <span class="text-2xl font-bold logo-text">AyurWeb</span>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="homepg.php" class="nav-link px-3 py-2 text-sm font-medium">Home</a>
                        <a href="#doshas" class="nav-link px-3 py-2 text-sm font-medium">Doshas</a>
                        <a href="#quiz" class="nav-link px-3 py-2 text-sm font-medium">Quiz</a>
                        <a href="#quick-links" class="nav-link px-3 py-2 text-sm font-medium">About</a>
                        <a href="blog.php" class="nav-link px-3 py-2 text-sm font-medium">Blogs</a>
                        <a href="view_result.php" class="nav-link px-3 py-2 text-sm font-medium">View Past Result</a>
                    </div>
                </div>
                
                <!-- Login/Register Buttons or User Info -->
                <div class="flex items-center space-x-4">
                    <?php if ($isLoggedIn): ?>
                        <div class="flex items-center space-x-3">
                            <div class="user-avatar w-8 h-8 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold"><?php echo strtoupper(substr($username, 0, 1)); ?></span>
                            </div>
                            <span class="text-white font-medium">Welcome, <?php echo htmlspecialchars($username); ?></span>
                            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition duration-300">
                                Logout
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="text-white hover:text-blue-300 px-4 py-2 text-sm font-medium transition duration-300">
                            Login
                        </a>
                        <a href="register.php" class="btn-secondary text-white px-6 py-2 rounded-lg text-sm font-medium">
                            Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Enhanced Banner Section -->
    <section id="banner" class="banner">
        <img src="banner2.jpg" alt="AyurWeb Banner">
    </section>

    <!-- Enhanced Hero Section -->
    <section class="hero-section py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="hero-content text-center">
                <h1 class="hero-title text-6xl font-bold mb-6">
                    Ancient Wisdom For Modern Wellness
                </h1>
                <p class="text-xl text-gray-600 mb-10 max-w-3xl mx-auto leading-relaxed">
                    Unlock the ancient wisdom of Ayurveda and find balance in your mind, body, and spirit through personalized wellness guidance.
                </p>
                <button class="btn-primary text-white px-10 py-4 rounded-full text-lg font-semibold">
                    <a href='#quiz'>
                    Start Your Journey <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </button>
                <div class="hero-visual">
                    <div class="hero-circle">
                        <i class="fas fa-yin-yang hero-icon"></i>
                    </div>
                    <div class="floating-elements">
                        <i class="fas fa-leaf floating-element"></i>
                        <i class="fas fa-fire floating-element"></i>
                        <i class="fas fa-tint floating-element"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Dosha Cards Section -->
    <section id="doshas" class="dosha-container">
        <div class="section-header fade-in">
            <h2 class="section-title">The Three Doshas</h2>
            <p class="section-subtitle">
                Discover the fundamental energies that govern your mind, body, and spirit in Ayurvedic medicine
            </p>
        </div>
        
        <div class="dosha-grid">
            <div class="dosha-card fade-in">
                <div class="dosha-image-container">
                    <img src="ChatGPT Image May 20, 2025, 11_17_58 AM.png" alt="Vata - Air and Space">
                </div>
                <div class="dosha-content">
                    <button class="learn-more-btn">
                        <a href='vaat.html'>
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    </button>
                </div>
            </div>

            <div class="dosha-card fade-in">
                <div class="dosha-image-container">
                    <img src="d11fb81a-bf1d-47d6-85b2-e2b7d9eeb752.png" alt="Pitta - Fire">
                </div>
                <div class="dosha-content">
                    <button class="learn-more-btn">
                        <a href='pitta.html'>
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    </button>
                </div>
            </div>

            <div class="dosha-card fade-in">
                <div class="dosha-image-container">
                    <img src="e8efdab1-93a5-4420-b78c-3aef1bfbaef3.png" alt="Kapha - Water and Earth">
                </div>
                <div class="dosha-content">
                    <button class="learn-more-btn">
                        <a href='kapha.html'>
                        Learn More <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Enhanced Quiz Section -->
    <section id="quiz" class="quiz-section py-24 <?php echo !$isLoggedIn ? 'quiz-locked' : ''; ?>">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="quiz-content bg-white/10 backdrop-blur-lg rounded-3xl p-12 border border-white/20 text-center">
                <?php if ($isLoggedIn): ?>
                    <h2 class="text-4xl font-bold text-white mb-6">Discover Your Dosha</h2>
                    <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                        Take our comprehensive quiz to understand your unique Ayurvedic constitution and receive personalized recommendations.
                    </p>
                    <a href="indexw.php" class="bg-white text-gray-800 px-10 py-4 rounded-full text-lg font-semibold hover:shadow-lg transition duration-300 inline-block">
                        Take Quiz Now <i class="fas fa-play ml-2"></i>
                    </a>
                <?php else: ?>
                    <div class="text-center">
                        <i class="fas fa-lock text-6xl text-white/50 mb-6"></i>
                        <h2 class="text-4xl font-bold text-white mb-6">Quiz Access Required</h2>
                        <p class="text-xl text-gray-200 mb-8 leading-relaxed">
                            Please <b>Login</b> or <b>Register</b> to access our personalized Dosha quiz and receive your custom Ayurvedic recommendations.
                        </p>
                        
                        
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Enhanced Footer -->
    <footer class="footer-gradient text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Centered Content -->
        <div class="flex flex-col items-center text-center">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-leaf text-white text-xl"></i>
                </div>
                <span class="text-3xl font-bold">AyurWeb</span>
            </div>
            <p class="text-gray-300 mb-6 max-w-xl leading-relaxed">
                Your trusted companion on the journey to holistic wellness through ancient Ayurvedic wisdom and modern science.
            </p>
            <div class="flex space-x-4">
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition duration-300">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition duration-300">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition duration-300">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center hover:bg-white/30 transition duration-300">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-white/20 mt-12 pt-8 text-center">
            <p class="text-gray-300">
                &copy; 2025 AyurWeb. All rights reserved. | Crafted with 
                <i class="fas fa-heart text-red-400"></i> for your wellness journey.
            </p>
        </div>
    </div>
</footer>

    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '-50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Add click handlers for learn more buttons
        document.querySelectorAll('.learn-more-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.stopPropagation();
                console.log('Learn more clicked');
            });
        });

        // Enhanced loading effect
        window.addEventListener('load', function() {
            document.body.style.opacity = '1';
        });
    </script>
</body>
</html>