<?php
session_start();

$isLoggedIn = isset($_SESSION['user_id']) && isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

$blogs = [
    ['id' => 1, 'title' => 'Understanding Vata Dosha: The Energy of Movement', 'content' => 'Vata dosha is one of the three fundamental energies in Ayurveda, governing movement and communication in the body. When balanced, Vata brings creativity and vitality. It controls breathing, blinking, muscle and tissue movement, pulsation of the heart, and all movements in the cytoplasm and cell membranes. In balance, Vata promotes creativity and flexibility; out of balance, it produces fear and anxiety.', 'author' => 'Dr. Priya Sharma', 'date' => '2025-06-01', 'category' => 'Doshas', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400', 'likes' => 24, 'views' => 156],
    ['id' => 2, 'title' => 'Ayurvedic Diet: Eating According to Your Constitution', 'content' => 'Your Ayurvedic constitution determines which foods will nourish you best. Learn how to create balanced meals that support your unique dosha combination. Vata types benefit from warm, moist, grounding foods. Pitta types need cooling, less spicy foods. Kapha types thrive on light, warm, spicy foods that stimulate digestion.', 'author' => 'Chef Arjun Patel', 'date' => '2025-05-28', 'category' => 'Nutrition', 'image' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=400', 'likes' => 18, 'views' => 203],
    ['id' => 3, 'title' => 'Morning Rituals for Holistic Wellness', 'content' => 'Start your day with these ancient Ayurvedic practices that align your body and mind with natural rhythms. From tongue scraping to meditation, oil pulling to gentle movement, these morning rituals help establish a foundation for vibrant health throughout the day.', 'author' => 'Yoga Master Anita', 'date' => '2025-05-25', 'category' => 'Lifestyle', 'image' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400', 'likes' => 31, 'views' => 298],
    ['id' => 4, 'title' => 'Herbs and Spices: Nature\'s Medicine Cabinet', 'content' => 'Discover the healing properties of common kitchen herbs and spices from an Ayurvedic perspective. Learn how turmeric, ginger, and other spices can transform your health. These natural remedies have been used for thousands of years to promote healing and maintain balance in the body.', 'author' => 'Herbalist Raj Kumar', 'date' => '2025-05-22', 'category' => 'Herbs', 'image' => 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=400', 'likes' => 42, 'views' => 387]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_blog']) && $isLoggedIn) {
    $newBlog = ['title' => $_POST['blog_title'], 'content' => $_POST['blog_content'], 'category' => $_POST['blog_category'], 'author' => $username, 'date' => date('Y-m-d'), 'likes' => 0, 'views' => 0];
    array_unshift($blogs, $newBlog);
    $uploadSuccess = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AyurWeb Blog - Ancient Wisdom Shared</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hero-section { background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); }
        .nav-link { transition: all 0.3s ease; }
        .nav-link:hover { color: #667eea; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3); }
        .user-avatar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .blog-card { background: white; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); border: 1px solid rgba(102, 126, 234, 0.1); }
        .blog-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(102, 126, 234, 0.2); }
        .blog-image { height: 250px; overflow: hidden; position: relative; }
        .blog-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
        .blog-card:hover .blog-image img { transform: scale(1.1); }
        .category-badge { position: absolute; top: 15px; left: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .blog-content { padding: 25px; }
        .blog-title { font-size: 20px; font-weight: 700; color: #2d3748; margin-bottom: 12px; line-height: 1.3; transition: color 0.3s ease; }
        .blog-card:hover .blog-title { color: #667eea; }
        .blog-excerpt { color: #4a5568; font-size: 14px; line-height: 1.6; margin-bottom: 15px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .blog-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; font-size: 13px; color: #718096; }
        .blog-stats { display: flex; align-items: center; gap: 15px; font-size: 13px; color: #718096; }
        .stat-item { display: flex; align-items: center; gap: 5px; }
        .read-more-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; width: 100%; }
        .read-more-btn:hover { transform: translateY(-1px); box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3); }
        .upload-section { background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-radius: 25px; padding: 40px; margin: 40px 0; border: 2px dashed rgba(102, 126, 234, 0.3); transition: all 0.3s ease; }
        .upload-section:hover { border-color: rgba(102, 126, 234, 0.6); background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%); }
        .form-group { margin-bottom: 25px; }
        .form-label { display: block; font-weight: 600; color: #2d3748; margin-bottom: 8px; font-size: 16px; }
        .form-input { width: 100%; padding: 12px 16px; border: 2px solid #e2e8f0; border-radius: 12px; font-size: 16px; transition: all 0.3s ease; background: white; }
        .form-input:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .form-textarea { min-height: 150px; resize: vertical; }
        .upload-btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; border-radius: 12px; font-size: 16px; font-weight: 600; border: none; cursor: pointer; transition: all 0.3s ease; width: 100%; }
        .upload-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3); }
        .success-message { background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); color: white; padding: 15px 20px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .filter-section { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05); margin-bottom: 30px; }
        .filter-btn { background: #f7fafc; color: #4a5568; padding: 8px 16px; border-radius: 20px; border: 2px solid transparent; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.3s ease; margin: 5px; }
        .filter-btn:hover, .filter-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); }
        .search-box { background: white; border: 2px solid #e2e8f0; border-radius: 15px; padding: 12px 20px; font-size: 16px; width: 100%; transition: all 0.3s ease; }
        .search-box:focus { outline: none; border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .section-title { font-size: 36px; font-weight: 700; color: #2d3748; margin-bottom: 15px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .section-subtitle { font-size: 18px; color: #4a5568; margin-bottom: 30px; }
        @media (max-width: 768px) { .blog-grid { grid-template-columns: 1fr; } .filter-section { text-align: center; } .upload-section { padding: 25px; } }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center">
                            <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-leaf text-white text-lg"></i>
                            </div>
                            <span class="text-2xl font-bold text-gray-800">AyurWeb</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="homepg.php" class="nav-link text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium">Home</a>
                        
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if ($isLoggedIn): ?>
                        <div class="flex items-center space-x-3">
                            <div class="user-avatar w-8 h-8 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-semibold"><?php echo strtoupper(substr($username, 0, 1)); ?></span>
                            </div>
                            <span class="text-gray-700 font-medium">Welcome, <?php echo htmlspecialchars($username); ?></span>
                            <a href="logout.php" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition duration-300">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="text-gray-700 hover:text-blue-600 px-4 py-2 text-sm font-medium transition duration-300">Login</a>
                        <a href="register.php" class="btn-primary text-white px-6 py-2 rounded-lg text-sm font-medium">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="section-title">AyurWeb Blog</h1>
            <p class="section-subtitle max-w-2xl mx-auto">Discover ancient wisdom through modern perspectives. Share your knowledge and learn from our community of Ayurveda enthusiasts.</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Upload Blog Section -->
        <?php if ($isLoggedIn): ?>
            <?php if (isset($uploadSuccess)): ?>
                <div class="success-message">
                    <i class="fas fa-check-circle text-xl"></i>
                    <span>Your blog has been uploaded successfully!</span>
                </div>
            <?php endif; ?>
            
            <div class="upload-section">
                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                    <i class="fas fa-pen-fancy mr-3"></i>Share Your Ayurvedic Wisdom
                </h2>
                <form method="POST" action="">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Blog Title</label>
                            <input type="text" name="blog_title" class="form-input" placeholder="Enter your blog title..." required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="blog_category" class="form-input" required>
                                <option value="">Select Category</option>
                                <option value="Doshas">Doshas</option>
                                <option value="Nutrition">Nutrition</option>
                                <option value="Lifestyle">Lifestyle</option>
                                <option value="Herbs">Herbs & Remedies</option>
                                <option value="Meditation">Meditation & Yoga</option>
                                <option value="Seasonal">Seasonal Wellness</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Blog Content</label>
                        <textarea name="blog_content" class="form-input form-textarea" placeholder="Share your knowledge and insights about Ayurveda..." required></textarea>
                    </div>
                    <button type="submit" name="upload_blog" class="upload-btn">
                        <i class="fas fa-cloud-upload-alt mr-2"></i>Publish Blog
                    </button>
                </form>
            </div>
        <?php else: ?>
            <div class="upload-section text-center">
                <i class="fas fa-lock text-4xl text-gray-400 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Want to Share Your Knowledge?</h2>
                <p class="text-gray-600 mb-6">Login to upload your own Ayurvedic blogs and contribute to our community.</p>
                <div class="space-x-4">
                    <a href="login.php" class="btn-primary text-white px-6 py-3 rounded-lg font-medium">Login to Write</a>
                    <a href="register.php" class="border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-medium hover:border-blue-500 transition duration-300">Register</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Filter and Search Section -->
        <div class="filter-section">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Filter by Category:</h3>
                    <div class="flex flex-wrap">
                        <button class="filter-btn active" data-filter="all">All Posts</button>
                        <button class="filter-btn" data-filter="Doshas">Doshas</button>
                        <button class="filter-btn" data-filter="Nutrition">Nutrition</button>
                        <button class="filter-btn" data-filter="Lifestyle">Lifestyle</button>
                        <button class="filter-btn" data-filter="Herbs">Herbs</button>
                    </div>
                </div>
                <div class="md:w-80">
                    <input type="text" class="search-box" id="searchBox" placeholder="Search blogs...">
                </div>
            </div>
        </div>

        <!-- Blog Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 blog-grid" id="blogGrid">
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-card" data-category="<?php echo $blog['category']; ?>">
                    <?php if (isset($blog['image'])): ?>
                        <div class="blog-image">
                            <img src="<?php echo $blog['image']; ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <div class="category-badge"><?php echo $blog['category']; ?></div>
                        </div>
                    <?php else: ?>
                        <div class="blog-image" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-leaf text-white text-4xl"></i>
                            <div class="category-badge"><?php echo $blog['category']; ?></div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="blog-content">
                        <h3 class="blog-title"><?php echo htmlspecialchars($blog['title']); ?></h3>
                        <div class="blog-meta">
                            <span><i class="fas fa-user mr-1"></i><?php echo htmlspecialchars($blog['author']); ?></span>
                            <span><i class="fas fa-calendar mr-1"></i><?php echo date('M d, Y', strtotime($blog['date'])); ?></span>
                        </div>
                        <p class="blog-excerpt"><?php echo htmlspecialchars(substr($blog['content'], 0, 150)) . '...'; ?></p>
                        <div class="blog-stats">
                            <div class="stat-item">
                                <i class="fas fa-heart"></i>
                                <span><?php echo $blog['likes']; ?></span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-eye"></i>
                                <span><?php echo $blog['views']; ?></span>
                            </div>
                        </div>
                        <button class="read-more-btn mt-4" onclick="openModal(<?php echo htmlspecialchars(json_encode($blog)); ?>)">
                            Read More <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Blog Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-4xl w-full max-h-90vh overflow-y-auto">
            <div class="p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 id="modalTitle" class="text-3xl font-bold text-gray-800 mb-2"></h2>
                        <div id="modalMeta" class="text-gray-600"></div>
                    </div>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 text-2xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div id="modalContent" class="prose max-w-none text-gray-700 leading-relaxed"></div>
                <div class="flex items-center justify-between mt-8 pt-6 border-t">
                    <div class="flex items-center space-x-4">
                        <button class="flex items-center space-x-2 text-gray-600 hover:text-red-500 transition duration-300">
                            <i class="fas fa-heart"></i>
                            <span id="modalLikes"></span>
                        </button>
                        <div class="flex items-center space-x-2 text-gray-600">
                            <i class="fas fa-eye"></i>
                            <span id="modalViews"></span>
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-gray-600 hover:text-blue-500 transition duration-300">
                            <i class="fab fa-facebook text-xl"></i>
                        </button>
                        <button class="text-gray-600 hover:text-blue-400 transition duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </button>
                        <button class="text-gray-600 hover:text-green-500 transition duration-300">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="gradient-bg text-white py-16 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-leaf text-white text-xl"></i>
                    </div>
                    <span class="text-3xl font-bold">AyurWeb</span>
                </div>
                <p class="text-gray-200 mb-6 max-w-2xl mx-auto">Sharing ancient wisdom for modern wellness. Join our community of Ayurveda enthusiasts and continue your journey toward holistic health.</p>
                <p class="text-gray-300">&copy; 2025 AyurWeb. All rights reserved. | Crafted with <i class="fas fa-heart text-red-400"></i> for your wellness journey.</p>
            </div>
        </div>
    </footer>

    <script>
        const filterBtns = document.querySelectorAll('.filter-btn');
        const blogCards = document.querySelectorAll('.blog-card');
        const searchBox = document.getElementById('searchBox');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                filterBtns.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                const filter = btn.dataset.filter;
                blogCards.forEach(card => {
                    if (filter === 'all' || card.dataset.category === filter) {
                        card.style.display = 'block';
                        setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 100);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(20px)';
                        setTimeout(() => { card.style.display = 'none'; }, 300);
                    }
                });
            });
        });

        searchBox.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            blogCards.forEach(card => {
                const title = card.querySelector('.blog-title').textContent.toLowerCase();
                const content = card.querySelector('.blog-excerpt').textContent.toLowerCase();
                card.style.display = (title.includes(searchTerm) || content.includes(searchTerm)) ? 'block' : 'none';
            });
        });

        function openModal(blog) {
            document.getElementById('modalTitle').textContent = blog.title;
            document.getElementById('modalMeta').innerHTML = `<i class="fas fa-user mr-1"></i>${blog.author} | <i class="fas fa-calendar mr-1"></i>${new Date(blog.date).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'})}`;
            document.getElementById('modalContent').textContent = blog.content;
            document.getElementById('modalLikes').textContent = blog.likes;
            document.getElementById('modalViews').textContent = blog.views;
            document.getElementById('modal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('modal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) closeModal();
        });
    </script>
</body>
</html>