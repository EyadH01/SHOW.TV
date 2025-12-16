<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOW.TV - منصة البث المباشر</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-bg: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            --card-bg: rgba(255, 255, 255, 0.05);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --text-light: #ffffff;
            --text-muted: #b0b0b0;
            --border-color: rgba(255, 255, 255, 0.2);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --glow: 0 0 20px rgba(102, 126, 234, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            background-attachment: fixed;
            color: var(--text-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated background particles */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(120, 219, 226, 0.3) 0%, transparent 50%);
            animation: float 20s ease-in-out infinite;
            pointer-events: none;
            z-index: -1;
        }

        @keyframes  float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        .navbar {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            box-shadow: var(--shadow);
            position: relative;
        }

        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--primary-gradient);
            opacity: 0.1;
            z-index: -1;
        }

        .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
            text-shadow: 0 0 20px rgba(102, 126, 234, 0.5);
        }

        .nav-link {
            color: var(--text-light) !important;
            margin: 0 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            position: relative;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-gradient);
            transition: width 0.3s ease;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: #4facfe !important;
            transform: translateY(-2px);
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 20px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--primary-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border-color: rgba(102, 126, 234, 0.5);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 12px;
            box-shadow: var(--glow);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 30px rgba(102, 126, 234, 0.6);
        }

        .btn-secondary {
            background: var(--secondary-gradient);
            border: none;
            border-radius: 12px;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 0 30px rgba(255, 87, 108, 0.6);
        }

        .search-box {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            border-radius: 25px;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .search-box:focus {
            border-color: #4facfe;
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(240, 147, 251, 0.1));
            padding: 5rem 0;
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: var(--accent-gradient);
            opacity: 0.05;
            animation: rotate 20s linear infinite;
        }

        @keyframes  rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .show-card {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .show-card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .show-card:hover img {
            transform: scale(1.15);
        }

        .show-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(102, 126, 234, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .show-card:hover .show-overlay {
            opacity: 1;
        }

        .footer {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border-top: 1px solid var(--border-color);
            padding: 3rem 0;
            margin-top: 4rem;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--primary-gradient);
        }

        .alert {
            border: none;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            border-left: 4px solid;
            box-shadow: var(--shadow);
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border-left-color: #28a745;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border-left-color: #dc3545;
        }

        .alert-info {
            background: rgba(23, 162, 184, 0.2);
            color: #17a2b8;
            border-left-color: #17a2b8;
        }

        .form-control, .form-select {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4facfe;
            box-shadow: 0 0 20px rgba(79, 172, 254, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .dropdown-menu {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .dropdown-item {
            color: var(--text-light);
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 2px 4px;
        }

        .dropdown-item:hover {
            background: var(--primary-gradient);
            color: white;
            transform: translateX(5px);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-gradient);
        }

        /* Loading animation */
        @keyframes  pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .loading {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-play-circle"></i> SHOW.TV
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>">
                            <i class="fas fa-home"></i> <span class="nav-text"><?php echo e(__('nav.home')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('shows.index')); ?>">
                            <i class="fas fa-tv"></i> <span class="nav-text"><?php echo e(__('nav.shows')); ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <form action="<?php echo e(route('search')); ?>" method="GET" class="d-flex">
                            <input class="form-control search-box me-2" type="search" id="voice-search" name="q" placeholder="<?php echo e(__('nav.search_placeholder')); ?>">
                            <button class="btn btn-outline-danger me-1" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-outline-primary" type="button" id="voice-btn" title="<?php echo e(__('nav.voice_search')); ?>">
                                <i class="fas fa-microphone"></i>
                            </button>
                        </form>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <!-- Theme Toggle -->
                    <li class="nav-item">
                        <button class="btn btn-link nav-link" id="theme-toggle" title="<?php echo e(__('nav.toggle_theme')); ?>">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    <!-- Language Toggle -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i> <?php echo e(strtoupper(app()->getLocale())); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langDropdown">
                            <li><a class="dropdown-item" href="#" onclick="changeLanguage('ar')">
                                <i class="fas fa-language"></i> العربية
                            </a></li>
                            <li><a class="dropdown-item" href="#" onclick="changeLanguage('en')">
                                <i class="fas fa-language"></i> English
                            </a></li>
                        </ul>
                    </li>
                    <!-- Voice Navigation -->
                    <li class="nav-item">
                        <button class="btn btn-link nav-link" id="voice-nav-btn" title="<?php echo e(__('nav.voice_nav')); ?>">
                            <i class="fas fa-assistive-listening-systems"></i>
                        </button>
                    </li>
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                <i class="fas fa-sign-in-alt"></i> <?php echo e(__('nav.login')); ?>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">
                                <i class="fas fa-user-plus"></i> <?php echo e(__('nav.register')); ?>

                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex flex-column align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <?php if(Auth::user()->profile_image): ?>
                                    <img src="<?php echo e(asset('storage/' . Auth::user()->profile_image)); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="rounded-circle mb-1" style="width: 40px; height: 40px; object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-user-circle fa-2x mb-1"></i>
                                <?php endif; ?>
                                <span style="font-size: 0.8rem;"><?php echo e(Auth::user()->name); ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo e(route('profile.show')); ?>">
                                    <i class="fas fa-user"></i> <?php echo e(__('messages.my_profile')); ?>

                                </a></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>">
                                    <i class="fas fa-tachometer-alt"></i> <?php echo e(__('messages.dashboard')); ?>

                                </a></li>
                                <?php if(Auth::user()->role === 'admin'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?php echo e(route('admin.dashboard')); ?>">
                                        <i class="fas fa-cog"></i> <?php echo e(__('nav.admin_dashboard')); ?>

                                    </a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> <?php echo e(__('nav.logout')); ?>

                                </a></li>
                            </ul>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container-fluid">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show mt-3 auto-hide" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show mt-3 auto-hide" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5><i class="fas fa-play-circle"></i> SHOW.TV</h5>
                    <p class="text-muted">منصة البث المباشر للمسلسلات والأفلام</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>الروابط السريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo e(route('home')); ?>" class="text-muted text-decoration-none">الرئيسية</a></li>
                        <li><a href="<?php echo e(route('shows.index')); ?>" class="text-muted text-decoration-none">المسلسلات</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>التواصل</h5>
                    <p class="text-muted">
                        <i class="fas fa-envelope"></i> info@showtv.com
                    </p>
                </div>
            </div>
            <hr class="bg-secondary">
            <div class="text-center text-muted">
                <p>&copy; 2025 SHOW.TV. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Theme Management
        function initTheme() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
            updateThemeIcon(savedTheme);
        }

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        }

        function updateThemeIcon(theme) {
            const themeIcon = document.querySelector('#theme-toggle i');
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-moon';
            } else {
                themeIcon.className = 'fas fa-sun';
            }
        }

        // Language Management
        function changeLanguage(lang) {
            // Store language preference
            localStorage.setItem('language', lang);

            // Reload page with new language parameter
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('lang', lang);
            window.location.href = currentUrl.toString();
        }

        function initLanguage() {
            const urlParams = new URLSearchParams(window.location.search);
            const langParam = urlParams.get('lang');

            if (langParam) {
                localStorage.setItem('language', langParam);
            }

            const savedLang = localStorage.getItem('language') || 'ar';
            updateLanguageIndicator(savedLang);
        }

        function updateLanguageIndicator(lang) {
            const langText = document.querySelector('#langDropdown');
            if (langText) {
                langText.innerHTML = `<i class="fas fa-globe"></i> ${lang.toUpperCase()}`;
            }
        }

        // Voice Search
        function initVoiceSearch() {
            const voiceBtn = document.getElementById('voice-btn');
            const searchInput = document.getElementById('voice-search');

            if (!voiceBtn || !searchInput) return;

            // Check if browser supports speech recognition
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

            if (!SpeechRecognition) {
                voiceBtn.disabled = true;
                voiceBtn.title = 'Voice search not supported in this browser';
                return;
            }

            const recognition = new SpeechRecognition();
            recognition.lang = localStorage.getItem('language') === 'ar' ? 'ar-SA' : 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            voiceBtn.addEventListener('click', () => {
                recognition.start();
                voiceBtn.innerHTML = '<i class="fas fa-microphone-slash"></i>';
                voiceBtn.classList.add('recording');
            });

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                searchInput.value = transcript;
                // Auto-submit search
                searchInput.form.submit();
            };

            recognition.onend = () => {
                voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                voiceBtn.classList.remove('recording');
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error:', event.error);
                voiceBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                voiceBtn.classList.remove('recording');
            };
        }

        // Voice Navigation
        function initVoiceNavigation() {
            const voiceNavBtn = document.getElementById('voice-nav-btn');

            if (!voiceNavBtn) return;

            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

            if (!SpeechRecognition) {
                voiceNavBtn.disabled = true;
                voiceNavBtn.title = 'Voice navigation not supported in this browser';
                return;
            }

            const recognition = new SpeechRecognition();
            recognition.lang = localStorage.getItem('language') === 'ar' ? 'ar-SA' : 'en-US';
            recognition.interimResults = false;
            recognition.maxAlternatives = 1;

            voiceNavBtn.addEventListener('click', () => {
                recognition.start();
                voiceNavBtn.innerHTML = '<i class="fas fa-assistive-listening-systems"></i>';
                voiceNavBtn.classList.add('listening');
            });

            recognition.onresult = (event) => {
                const command = event.results[0][0].transcript.toLowerCase().trim();

                // Handle voice commands
                if (command.includes('home') || command.includes('الرئيسية')) {
                    window.location.href = '/';
                } else if (command.includes('shows') || command.includes('مسلسلات') || command.includes('البرامج')) {
                    window.location.href = '/shows';
                } else if (command.includes('search') || command.includes('بحث')) {
                    document.getElementById('voice-search')?.focus();
                } else if (command.includes('login') || command.includes('دخول')) {
                    window.location.href = '/login';
                } else if (command.includes('register') || command.includes('تسجيل')) {
                    window.location.href = '/register';
                } else if (command.includes('logout') || command.includes('خروج')) {
                    document.getElementById('logout-form')?.submit();
                } else {
                    // Speak command not recognized
                    speakText('Command not recognized. Try: home, shows, search, login, register, logout');
                }
            };

            recognition.onend = () => {
                voiceNavBtn.innerHTML = '<i class="fas fa-assistive-listening-systems"></i>';
                voiceNavBtn.classList.remove('listening');
            };

            recognition.onerror = (event) => {
                console.error('Voice navigation error:', event.error);
                voiceNavBtn.innerHTML = '<i class="fas fa-assistive-listening-systems"></i>';
                voiceNavBtn.classList.remove('listening');
            };
        }

        // Text-to-Speech function
        function speakText(text) {
            if ('speechSynthesis' in window) {
                const utterance = new SpeechSynthesisUtterance(text);
                utterance.lang = localStorage.getItem('language') === 'ar' ? 'ar-SA' : 'en-US';
                window.speechSynthesis.speak(utterance);
            }
        }

        // Initialize all features when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initTheme();
            initLanguage();
            initVoiceSearch();
            initVoiceNavigation();

            // Theme toggle event listener
            document.getElementById('theme-toggle')?.addEventListener('click', toggleTheme);

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                const alerts = document.querySelectorAll('.auto-hide');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });

        // Light theme styles (added dynamically)
        const lightThemeStyles = `
            :root[data-theme="light"] {
                --primary-color: #e50914;
                --dark-bg: #f8f9fa;
                --card-bg: #ffffff;
                --text-light: #212529;
                --text-muted: #6c757d;
            }

            :root[data-theme="light"] body {
                background-color: var(--dark-bg);
                color: var(--text-light);
            }

            :root[data-theme="light"] .card {
                background-color: var(--card-bg);
                border: 1px solid rgba(0, 0, 0, 0.125);
                color: var(--text-light);
            }

            :root[data-theme="light"] .navbar {
                background-color: rgba(255, 255, 255, 0.95) !important;
                color: var(--text-light);
            }

            :root[data-theme="light"] .nav-link {
                color: var(--text-light) !important;
            }

            :root[data-theme="light"] .footer {
                background-color: rgba(248, 249, 250, 0.95);
                color: var(--text-light);
            }
        `;

        // Add light theme styles to document
        const styleSheet = document.createElement('style');
        styleSheet.textContent = lightThemeStyles;
        document.head.appendChild(styleSheet);
    </script>
</body>
</html>
<?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/layouts/app.blade.php ENDPATH**/ ?>