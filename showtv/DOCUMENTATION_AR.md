# دليل المشروع الشامل - ShowTV منصة البث المباشر

## نظرة عامة على المشروع

ShowTV هو تطبيق ويب مبني باستخدام Laravel يهدف إلى توفير منصة للبث المباشر للمحتوى المرئي مع نظام إدارة المستخدمين المتقدم ونظام تتبع النشاطات.

## هيكل المشروع (Project Structure)

### 1. المجلدات الأساسية (Core Directories)

```
showtv/
├── app/                     # التطبيق الرئيسي
├── bootstrap/              # ملفات بدء التشغيل
├── config/                 # ملفات الإعدادات
├── database/               # قاعدة البيانات
├── public/                 # الملفات العامة
├── resources/              # الموارد (Views, CSS, JS)
├── routes/                 # تعريف المسارات
├── storage/                # تخزين الملفات
├── tests/                  # اختبارات الوحدة
├── vendor/                 # مكتبات Composer
└── composer.json           # إعدادات Composer
```

### 2. مجلد التطبيق (app/)

```
app/
├── Console/                # أوامر وحدة التحكم
│   ├── Commands/           # الأوامر المخصصة
│   └── Kernel.php         # نواة وحدة التحكم
├── Events/                # الأحداث
│   └── UserRegistered.php # حدث تسجيل المستخدم
├── Exceptions/            # معالجة الأخطاء
│   └── Handler.php       # معالج الأخطاء الرئيسي
├── Http/                  # طبقة HTTP
│   ├── Controllers/       # وحدات التحكم
│   │   ├── Admin/        # وحدات تحكم الإدارة
│   │   ├── Auth/         # وحدات تحكم المصادقة
│   │   └── [الوحدات الأخرى]
│   ├── Middleware/       # الطبقة الوسطية
│   └── Kernel.php        # نواة HTTP
├── Listeners/            # مستمعو الأحداث
├── Models/              # نماذج البيانات
├── Policies/            # سياسات التخويل
├── Providers/           # مقدمو الخدمات
└── Services/            # الخدمات المخصصة
```

### 3. نماذج البيانات (Models)

```
app/Models/
├── User.php              # نموذج المستخدم
├── Show.php              # نموذج العرض/البرنامج
├── Episode.php           # نموذج الحلقة
├── UserPreference.php    # تفضيلات المستخدم
├── UserActivityLog.php   # سجل نشاطات المستخدم
└── UserSession.php       # جلسات المستخدم
```

### 4. وحدة التحكم (Controllers)

```
app/Http/Controllers/
├── Auth/
│   ├── LoginController.php      # تسجيل الدخول
│   ├── RegisterController.php   # التسجيل
│   ├── ForgotPasswordController.php
│   ├── ResetPasswordController.php
│   ├── ConfirmPasswordController.php
│   └── VerificationController.php
├── Admin/
│   ├── AdminController.php      # لوحة تحكم الإدارة
│   ├── UserController.php       # إدارة المستخدمين
│   ├── EpisodeController.php    # إدارة الحلقات
│   └── ShowController.php       # إدارة البرامج
├── ProfileController.php        # إدارة الملف الشخصي
├── HomeController.php           # الصفحة الرئيسية
├── ShowController.php           # عرض البرامج
└── EpisodeController.php        # عرض الحلقات
```

### 5. قاعدة البيانات (Database)

```
database/
├── factories/          # مصانع البيانات
├── migrations/         # عمليات الترحيل
├── seeders/           # زراع البيانات
└── [other files]
```

### 6. الموارد (Resources)

```
resources/
├── css/               # ملفات CSS
├── js/                # ملفات JavaScript
├── lang/              # ملفات الترجمة
│   ├── ar/           # اللغة العربية
│   └── en/           # اللغة الإنجليزية
├── sass/              # ملفات SASS
└── views/             # قوالب العرض
    ├── admin/        # قوالب الإدارة
    ├── auth/         # قوالب المصادقة
    ├── episodes/     # قوالب الحلقات
    ├── profile/      # قوالب الملف الشخصي
    ├── shows/        # قوالب البرامج
    ├── layouts/      # القوالب الرئيسية
    └── partials/     # الأجزاء المشتركة
```

## المتطلبات (Requirements)

- PHP 7.3 أو أحدث
- Composer
- MySQL 5.7 أو أحدث
- Node.js (للمكتبات الأمامية)
- Apache/Nginx

## خطوات التشغيل (Installation Steps)

### 1. تثبيت المتطلبات

```bash
# تثبيت PHP و Composer
sudo apt update
sudo apt install php php-cli php-fpm php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# تثبيت MySQL
sudo apt install mysql-server
sudo mysql_secure_installation
```

### 2. إعداد المشروع

```bash
# الدخول لمجلد المشروع
cd /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv

# تثبيت المكتبات
composer install

# إنشاء ملف الإعدادات
cp .env.example .env

# إنشاء مفتاح التطبيق
php artisan key:generate
```

### 3. إعداد قاعدة البيانات

```bash
# إنشاء قاعدة البيانات
mysql -u root -p
CREATE DATABASE showtv;
CREATE USER 'showtv_user'@'localhost' IDENTIFIED BY 'your_password';
GRANT ALL PRIVILEGES ON showtv.* TO 'showtv_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 4. تحديث ملف .env

```bash
# تحرير ملف .env
nano .env
```

قم بتحديث المتغيرات التالية:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv_user
DB_PASSWORD=your_password

# إعدادات البريد الإلكتروني
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@showtv.com
MAIL_FROM_NAME="${APP_NAME}"

# إعدادات APIs
TMDB_API_KEY=your_tmdb_api_key
GOOGLE_IMAGES_API_KEY=your_google_images_api_key
GOOGLE_SEARCH_ENGINE_ID=your_search_engine_id
YOUTUBE_API_KEY=your_youtube_api_key
```

### 5. تشغيل عمليات الترحيل

```bash
# تشغيل الترحيلات
php artisan migrate

# زراع البيانات (اختياري)
php artisan db:seed
```

### 6. إنشاء رابط التخزين

```bash
php artisan storage:link
```

### 7. بناء الأصول الأمامية

```bash
# تثبيت npm
npm install

# بناء الأصول
npm run build

# أو للتطوير
npm run dev
```

### 8. تشغيل التطبيق

```bash
# للخادم المحلي
php artisan serve

# أو للخادم المخصص
php artisan serve --host=0.0.0.0 --port=8000
```

## الأوامر المفيدة (Useful Commands)

### إدارة قاعدة البيانات
```bash
# عرض حالة الترحيلات
php artisan migrate:status

# تراجع عن آخر عملية ترحيل
php artisan migrate:rollback

# إعادة تشغيل جميع الترحيلات
php artisan migrate:fresh

# زراعة البيانات
php artisan db:seed

# إعادة تشغيل الترحيلات والزراعة
php artisan migrate:fresh --seed
```

### إدارة التخزين
```bash
# إنشاء رابط التخزين
php artisan storage:link

# عرض معلومات التخزين
php artisan storage:link --verbose

# تنظيف التخزين
php artisan storage:unlink
```

### إدارة التخزين المؤقت
```bash
# تنظيف التخزين المؤقت للتكوين
php artisan config:clear

# إنشاء تخزين مؤقت للتكوين
php artisan config:cache

# تنظيف التخزين المؤقت للمسارات
php artisan route:clear

# إنشاء تخزين مؤقت للمسارات
php artisan route:cache

# تنظيف التخزين المؤقت للعرض
php artisan view:clear

# إنشاء تخزين مؤقت للعرض
php artisan view:cache
```

### إدارة المستخدمين
```bash
# إنشاء مستخدم مشرف
php artisan tinker
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@showtv.com';
$user->password = Hash::make('password');
$user->role = 'admin';
$user->save();
exit;
```

### الاختبارات
```bash
# تشغيل جميع الاختبارات
php artisan test

# تشغيل اختبار محدد
php artisan test --filter=RegisterControllerTest

# تشغيل الاختبارات مع التغطية
php artisan test --coverage
```

## المسارات الرئيسية (Main Routes)

### المسارات العامة
- `/` - الصفحة الرئيسية
- `/register` - التسجيل
- `/login` - تسجيل الدخول
- `/shows` - قائمة البرامج
- `/search` - البحث

### مسارات الملف الشخصي
- `/profile` - عرض الملف الشخصي
- `/profile/edit` - تعديل الملف الشخصي
- `/profile/dashboard` - لوحة تحكم المستخدم

### مسارات الإدارة
- `/admin` - لوحة تحكم الإدارة
- `/admin/shows` - إدارة البرامج
- `/admin/episodes` - إدارة الحلقات
- `/admin/users` - إدارة المستخدمين

## الخدمات (Services)

### ImageService
خدمة معالجة وحفظ الصور:
- رفع وتحسين صور المستخدمين
- إنشاء مصغرات للصور
- حذف الصور القديمة

### TMDBApiService
خدمة API لواجهة The Movie Database:
- البحث عن الأفلام والبرامج
- الحصول على تفاصيل المحتوى
- جلب صور ومقاطع الفيديو

### GoogleImagesApiService
خدمة Google Images API:
- البحث عن الصور
- تحميل وحفظ الصور
- التحقق من صحة روابط الصور

## الوظائف الرئيسية (Main Features)

### 1. نظام المصادقة والتسجيل
- تسجيل مستخدمين جدد
- تسجيل الدخول والخروج
- استعادة كلمة المرور
- تأكيد البريد الإلكتروني

### 2. إدارة الملف الشخصي
- عرض وتعديل المعلومات الشخصية
- رفع صورة الملف الشخصي
- إدارة التفضيلات

### 3. إدارة البرامج والحلقات
- عرض قائمة البرامج
- عرض تفاصيل الحلقات
- متابعة البرامج المفضلة
- الإعجاب بالحلقات

### 4. لوحة تحكم الإدارة
- إدارة المستخدمين
- إدارة البرامج والحلقات
- عرض الإحصائيات

### 5. نظام تتبع النشاطات
- تسجيل عمليات تسجيل الدخول
- تتبع نشاطات المستخدمين
- إدارة جلسات المستخدمين

## الأمان (Security)

### الحماية المطبقة
- حماية CSRF
- تشفير كلمات المرور
- التحقق من صحة البيانات
- حماية ضد هجمات Brute Force
- إدارة جلسات آمنة

### سياسات الأمان
- التحقق من صلاحيات المستخدمين
- حماية المسارات الحساسة
- تشفير البيانات الحساسة

## استكشاف الأخطاء (Troubleshooting)

### مشاكل شائعة وحلولها

#### خطأ في قاعدة البيانات
```bash
# فحص اتصال قاعدة البيانات
php artisan tinker
DB::connection()->getPdo();
exit;

# إعادة تشغيل الترحيلات
php artisan migrate:fresh
```

#### مشاكل التخزين المؤقت
```bash
# تنظيف جميع التخزين المؤقت
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### مشاكل الأذونات
```bash
# ضبط أذونات المجلدات
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### مشاكل Composer
```bash
# تنظيف وإعادة تثبيت
composer clear-cache
composer install --no-cache
```

## الدعم والصيانة (Support & Maintenance)

### النسخ الاحتياطية
```bash
# نسخ احتياطية لقاعدة البيانات
mysqldump -u showtv_user -p showtv > backup_$(date +%Y%m%d).sql

# نسخ احتياطية للملفات
tar -czf showtv_backup_$(date +%Y%m%d).tar.gz /path/to/showtv
```

### مراقبة الأداء
```bash
# عرض سجلات Laravel
tail -f storage/logs/laravel.log

# عرض سجلات Apache/Nginx
tail -f /var/log/apache2/error.log
# أو
tail -f /var/log/nginx/error.log
```

## التطوير المستقبلي (Future Development)

### الميزات المقترحة
- دعم البث المباشر
- نظام التعليقات والتقييمات
- تطبيق الهاتف المحمول
- نظام الدفع والاشتراكات
- تكامل مع منصات التواصل الاجتماعي

---

## معلومات إضافية

### المؤلف
مطور: فريق ShowTV

### التاريخ
آخر تحديث: 2025

### الترخيص
MIT License

### الدعم التقني
للحصول على الدعم التقني، يرجى مراجعة الوثائق أو التواصل مع فريق التطوير.

---

**ملاحظة:** هذا الدليل يغطي الأساسيات لتشغيل وتطوير مشروع ShowTV. للحصول على معلومات أكثر تفصيلاً، يرجى مراجعة كود المصدر والوثائق الفنية المضمنة.
