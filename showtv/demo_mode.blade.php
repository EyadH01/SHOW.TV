<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHOWTV - Demo Mode</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .demo-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .demo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .video-thumbnail {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }
        .video-thumbnail img {
            transition: transform 0.3s ease;
        }
        .video-thumbnail:hover img {
            transform: scale(1.05);
        }
        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            font-size: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .play-button:hover {
            background: rgba(220, 53, 69, 1);
            transform: translate(-50%, -50%) scale(1.1);
        }
        .feature-icon {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        .demo-section {
            padding: 2rem 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fab fa-youtube text-danger me-2"></i>SHOWTV
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#shows">المسلسلات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#roya">قناة رؤيا</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#login">
                            <i class="fas fa-sign-in-alt me-1"></i>تسجيل الدخول
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#register">
                            <i class="fas fa-user-plus me-1"></i>إنشاء حساب
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="py-5 text-white">
        <div class="container">
            <div class="row align-items-center min-vh-50">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        مرحباً بك في <span class="text-warning">SHOWTV</span>
                    </h1>
                    <p class="lead mb-4">
                        منصة عرض المسلسلات العربية المتكاملة مع قناة رؤيا على يوتيوب
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#shows" class="btn btn-warning btn-lg">
                            <i class="fas fa-play me-2"></i>ابدأ المشاهدة
                        </a>
                        <a href="#roya" class="btn btn-outline-light btn-lg">
                            <i class="fab fa-youtube me-2"></i>قناة رؤيا
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fab fa-youtube feature-icon"></i>
                        <h3>جميع المسلسلات في مكان واحد</h3>
                        <p class="text-light">شاهد أحدث الحلقات من قناة رؤيا مباشرة</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="demo-section bg-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold">المميزات</h2>
                    <p class="lead text-muted">كل ما تحتاجه لمتابعة مسلسلاتك المفضلة</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card demo-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-shield feature-icon"></i>
                            <h4>نظام المستخدمين</h4>
                            <p class="text-muted">تسجيل دخول آمن وإدارة الحسابات مع نظام الأدوار</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i>تسجيل الدخول والخروج</li>
                                <li><i class="fas fa-check text-success me-2"></i>إنشاء حساب جديد</li>
                                <li><i class="fas fa-check text-success me-2"></i>إعادة تعيين كلمة المرور</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card demo-card h-100">
                        <div class="card-body text-center">
                            <i class="fab fa-youtube feature-icon"></i>
                            <h4>تكامل ROYA</h4>
                            <p class="text-muted">ربط مباشر مع قناة رؤيا لجلب أحدث المحتوى</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i>جلب الفيديوهات تلقائياً</li>
                                <li><i class="fas fa-check text-success me-2"></i>مزامنة مع قاعدة البيانات</li>
                                <li><i class="fas fa-check text-success me-2"></i>البحث في المحتوى </ul>
                       </li>
                            </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card demo-card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-heart feature-icon"></i>
                            <h4>التفاعل</h4>
                            <p class="text-muted">إمكانية التفاعل مع المسلسلات والحلقات</p>
                            <ul class="list-unstyled text-start">
                                <li><i class="fas fa-check text-success me-2"></i>تقييم الحلقات</li>
                                <li><i class="fas fa-check text-success me-2"></i>متابعة المسلسلات</li>
                                <li><i class="fas fa-check text-success me-2"></i>واجهة مستخدم سهلة</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ROYA Channel Section -->
    <section id="roya" class="demo-section bg-light">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold">
                        <i class="fab fa-youtube text-danger me-2"></i>قناة رؤيا
                    </h2>
                    <p class="lead text-muted">جميع محتويات قناة رؤيا متوفرة في مكان واحد</p>
                </div>
            </div>
            <div class="row g-4">
                <!-- Sample Video 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card demo-card">
                        <div class="video-thumbnail position-relative">
                       <img src="https://via.placeholder.com/800x450?text=تحت+سابع+أرض" 
                           class="card-img-top" alt="تحت سابع أرض" style="height: 200px; object-fit: cover;">
                       <button class="play-button" onclick="playUnavailable()">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white p-2">
                                <small>45 دقيقة</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">تحت سابع أرض - الحلقة 1</h5>
                            <p class="card-text text-muted">بداية القصة وتعريف بالشخصيات الرئيسية في المسلسل الدرامي</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>الأحد @ 8:30 مساءً
                                </small>
                                <div>
                                    <button class="btn btn-sm btn-outline-danger me-1">
                                        <i class="fas fa-thumbs-up"></i> 150
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-thumbs-down"></i> 12
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Video 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card demo-card">
                        <div class="video-thumbnail position-relative">
                       <img src="https://via.placeholder.com/800x450?text=حكيم+باشا" 
                           class="card-img-top" alt="حكيم باشا" style="height: 200px; object-fit: cover;">
                       <button class="play-button" onclick="playUnavailable()">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white p-2">
                                <small>30 دقيقة</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">حكيم باشا - الحلقة 1</h5>
                            <p class="card-text text-muted">اليوم الأول للدكتور حكيم في المستشفى الحكومي</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>الجمعة @ 9:00 مساءً
                                </small>
                                <div>
                                    <button class="btn btn-sm btn-outline-danger me-1">
                                        <i class="fas fa-thumbs-up"></i> 89
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-thumbs-down"></i> 5
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sample Video 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="card demo-card">
                        <div class="video-thumbnail position-relative">
                       <img src="https://via.placeholder.com/800x450?text=كرفان" 
                           class="card-img-top" alt="كرفان" style="height: 200px; object-fit: cover;">
                       <button class="play-button" onclick="playUnavailable()">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="position-absolute bottom-0 start-0 bg-dark bg-opacity-75 text-white p-2">
                                <small>60 دقيقة</small>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">كرفان - لقاء مع فنان</h5>
                            <p class="card-text text-muted">حوار شيق مع أحد الفنانين المعروفين في برنامج كرفان</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>الأربعاء @ 10:00 مساءً
                                </small>
                                <div>
                                    <button class="btn btn-sm btn-outline-danger me-1">
                                        <i class="fas fa-thumbs-up"></i> 234
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-thumbs-down"></i> 8
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="https://www.youtube.com/@royatv" target="_blank" class="btn btn-danger btn-lg">
                    <i class="fab fa-youtube me-2"></i>زيارة قناة رؤيا
                </a>
            </div>
        </div>
    </section>

    <!-- Authentication Demo -->
    <section id="auth-demo" class="demo-section bg-white">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold">نظام المصادقة</h2>
                    <p class="lead text-muted">تسجيل الدخول وإدارة المستخدمين</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="mb-3">تسجيل الدخول</h4>
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">البريد الإلكتروني</label>
                                            <input type="email" class="form-control" placeholder="أدخل بريدك الإلكتروني">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">كلمة المرور</label>
                                            <input type="password" class="form-control" placeholder="أدخل كلمة المرور">
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="remember">
                                            <label class="form-check-label" for="remember">تذكرني</label>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-3">إنشاء حساب جديد</h4>
                                    <form>
                                        <div class="mb-3">
                                            <label class="form-label">الاسم</label>
                                            <input type="text" class="form-control" placeholder="أدخل اسمك">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">البريد الإلكتروني</label>
                                            <input type="email" class="form-control" placeholder="أدخل بريدك الإلكتروني">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">كلمة المرور</label>
                                            <input type="password" class="form-control" placeholder="أدخل كلمة مرور قوية">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">تأكيد كلمة المرور</label>
                                            <input type="password" class="form-control" placeholder="أعد إدخال كلمة المرور">
                                        </div>
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">مشغل الفيديو</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <div id="videoContainer" class="w-100 h-100 d-flex align-items-center justify-content-center text-center text-white" style="background:#000;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fab fa-youtube text-danger me-2"></i>SHOWTV</h5>
                    <p class="text-muted">منصة عرض المسلسلات العربية مع تكامل قناة رؤيا</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">
                        © 2024 SHOWTV. جميع الحقوق محفوظة.
                    </p>
                    <p class="text-muted">
                        <small>متصل مع <a href="https://www.youtube.com/@royatv" class="text-danger">قناة رؤيا</a></small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function playVideo(embedUrl) {
            const modal = new bootstrap.Modal(document.getElementById('videoModal'));
            const container = document.getElementById('videoContainer');
            container.innerHTML = `<iframe src="${embedUrl}?autoplay=1" allowfullscreen style="border: none; width:100%; height:100%"></iframe>`;
            modal.show();
        }

        function playUnavailable() {
            const modal = new bootstrap.Modal(document.getElementById('videoModal'));
            const container = document.getElementById('videoContainer');
            // Show a friendly message instead of embedding an external video
            container.innerHTML = '<div class="p-4"><h4>هذا الفيديو غير متاح في الوضع التجريبي</h4><p class="text-muted">يمكنك إضافة رابط فيديو صالح من لوحة الإدارة أو استيراد الفيديوهات من قنوات ROYA عبر لوحة الإدارة.</p></div>';
            modal.show();
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Close video modal and stop video when modal is closed
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
            const videoFrame = document.getElementById('videoFrame');
            videoFrame.src = '';
        });
    </script>
</body>
</html>
