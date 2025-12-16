# SHOW.TV - Fixes and Improvements

## 🔧 المشاكل المحلولة

### 1. ✅ تحويل قاعدة البيانات من SQLite إلى MySQL
**المشكلة:** البيانات لم تكن تُحفظ بشكل صحيح
**الحل:**
- تم تحديث ملف `.env` لاستخدام MySQL بدلاً من SQLite
- تم إنشاء migration جديد لإضافة الحقول المفقودة
- تم تحديث جميع الـ Models للعمل مع MySQL

**الخطوات:**
```bash
# 1. تثبيت MySQL (إذا لم يكن مثبتاً)
sudo apt-get install mysql-server

# 2. إنشاء قاعدة البيانات
mysql -u root -e "CREATE DATABASE showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 3. تشغيل الـ Migrations
php artisan migrate

# 4. إضافة بيانات تجريبية (اختياري)
php artisan db:seed
```

---

### 2. ✅ إضافة دعم الفيديوهات والصور والوصف
**المشكلة:** الحلقات لم تكن تعرض الفيديوهات والصور والوصف
**الحل:**
- تم إضافة حقول جديدة للـ Episodes:
  - `thumbnail` - صورة الحلقة
  - `video_url` - رابط الفيديو
  - `youtube_video_id` - معرف فيديو YouTube
- تم إضافة حقول للـ Shows:
  - `wallpaper` - صورة الخلفية
  - `poster` - صورة الملصق

**الملفات المحدثة:**
- `database/migrations/2025_12_16_120000_add_playlist_and_media_fields.php`
- `resources/views/episodes/show.blade.php` - يعرض الفيديو والصورة والوصف

---

### 3. ✅ إضافة خيار Playlist
**الميزات الجديدة:**
- إنشاء قوائم تشغيل شخصية
- إضافة/حذف الحلقات من القوائم
- عرض جميع الحلقات في القائمة
- تحرير وحذف القوائم

**الملفات الجديدة:**
- `app/Models/Playlist.php` - Model للقوائم
- `app/Http/Controllers/PlaylistController.php` - Controller
- `app/Policies/PlaylistPolicy.php` - Authorization Policy
- `resources/views/playlists/` - جميع الـ Views

**الـ Routes:**
```php
Route::resource('playlists', PlaylistController::class);
Route::post('/playlists/{playlist}/episodes', 'PlaylistController@addEpisode');
Route::delete('/playlists/{playlist}/episodes/{episode}', 'PlaylistController@removeEpisode');
```

---

## 🌐 APIs المدمجة

### 1. Shahed API
**الملف:** `app/Http/Controllers/Admin/ShahedApiController.php`

**الميزات:**
- البحث عن المسلسلات العربية
- استيراد المسلسلات من Shahed
- استيراد الحلقات من Shahed
- الحصول على معلومات الحلقات

**الاستخدام:**
```php
// البحث عن مسلسل
GET /api/shahed/search?q=مسلسل

// استيراد مسلسل
POST /api/shahed/import
{
    "shahed_id": "123",
    "title": "اسم المسلسل",
    "description": "الوصف",
    "poster": "رابط الصورة",
    "wallpaper": "رابط الخلفية"
}

// استيراد حلقة
POST /api/shahed/episodes/import
{
    "show_id": 1,
    "title": "اسم الحلقة",
    "description": "الوصف",
    "duration": 45,
    "airing_time": "الجمعة 8:30 مساءً",
    "thumbnail": "رابط الصورة",
    "video_url": "رابط الفيديو"
}
```

### 2. Netflix API (بديل)
يمكن استخدام:
- TMDB API (The Movie Database)
- IMDb API
- أو أي API آخر للمسلسلات

---

## 📺 المسلسلات العربية السورية

### قناة رؤيا
تم إضافة دعم كامل لقناة رؤيا من خلال:
- `app/Http/Controllers/Admin/RoyaController.php`
- YouTube API Integration
- البحث عن الفيديوهات من قناة رؤيا

**الـ Routes:**
```php
GET /admin/roya - عرض لوحة التحكم
POST /admin/roya/sync - مزامنة الفيديوهات
GET /admin/roya/videos - الحصول على الفيديوهات
GET /admin/roya/search - البحث عن الفيديوهات
```

**المسلسلات المتاحة:**
- مسلسلات سورية كلاسيكية
- مسلسلات درامية حديثة
- برامج تلفزيونية
- أفلام سينمائية

---

## 📊 قاعدة البيانات

### الجداول الجديدة:

#### `playlists`
```sql
CREATE TABLE playlists (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

#### `playlist_episode`
```sql
CREATE TABLE playlist_episode (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    playlist_id BIGINT NOT NULL,
    episode_id BIGINT NOT NULL,
    order INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (playlist_id) REFERENCES playlists(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE,
    UNIQUE KEY (playlist_id, episode_id)
);
```

### الحقول المضافة:

#### `episodes` table
- `thumbnail` VARCHAR(255) - صورة الحلقة
- `video_url` VARCHAR(255) - رابط الفيديو
- `youtube_video_id` VARCHAR(255) - معرف YouTube

#### `shows` table
- `wallpaper` VARCHAR(255) - صورة الخلفية
- `poster` VARCHAR(255) - صورة الملصق

---

## 🚀 التثبيت والتشغيل

### 1. تثبيت المتطلبات
```bash
cd showtv
composer install
npm install
```

### 2. إعداد البيئة
```bash
cp .env.example .env
php artisan key:generate
```

### 3. إعداد قاعدة البيانات
```bash
# إنشاء قاعدة البيانات
mysql -u root -e "CREATE DATABASE showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# تشغيل الـ Migrations
php artisan migrate

# إضافة بيانات تجريبية
php artisan db:seed
```

### 4. تشغيل التطبيق
```bash
php artisan serve
# الآن يمكنك الوصول إلى http://localhost:8000
```

---

## 🔐 الأمان

### Authorization
- تم إضافة `PlaylistPolicy` للتحقق من صلاحيات المستخدم
- فقط مالك القائمة يمكنه تعديلها أو حذفها
- جميع الـ Routes محمية بـ `auth` middleware

### Validation
- جميع المدخلات يتم التحقق منها
- حماية من CSRF attacks
- تشفير كلمات المرور

---

## 📱 الميزات الإضافية

### 1. البحث المتقدم
- البحث عن المسلسلات
- البحث عن الحلقات
- البحث عن القوائم

### 2. التصنيفات
- تصنيف المسلسلات
- تصنيف الحلقات
- تصنيف القوائم

### 3. التقييمات
- تقييم الحلقات (Like/Dislike)
- عرض عدد التقييمات
- تتبع تقييمات المستخدم

### 4. المتابعة
- متابعة المسلسلات
- إشعارات جديدة
- قائمة المسلسلات المتابعة

---

## 🐛 استكشاف الأخطاء

### المشكلة: قاعدة البيانات لا تتصل
**الحل:**
```bash
# تحقق من بيانات الاتصال في .env
# تأكد من تشغيل MySQL
sudo service mysql start

# أعد تشغيل الـ Migrations
php artisan migrate:refresh
```

### المشكلة: الفيديوهات لا تعرض
**الحل:**
- تأكد من أن `video_url` أو `youtube_video_id` موجود
- تحقق من صحة الرابط
- تأكد من أن الملف موجود في `storage/app/public/`

### المشكلة: الصور لا تظهر
**الحل:**
```bash
# أنشئ رابط للـ Storage
php artisan storage:link

# تأكد من أن الصور موجودة في storage/app/public/
```

---

## 📝 ملاحظات مهمة

1. **MySQL Configuration**: تأكد من أن MySQL مثبت وقيد التشغيل
2. **Storage**: استخدم `php artisan storage:link` لربط المجلد
3. **API Keys**: أضف مفاتيح API الخاصة بك في `.env`
4. **Permissions**: تأكد من صلاحيات المجلدات `storage/` و `bootstrap/cache/`

---

## 🎯 الخطوات التالية

1. ✅ تحويل قاعدة البيانات إلى MySQL
2. ✅ إضافة دعم الفيديوهات والصور
3. ✅ إضافة خيار Playlist
4. ✅ دمج Shahed API
5. ✅ دمج قناة رؤيا
6. ⏳ إضافة المزيد من المسلسلات العربية
7. ⏳ تحسين الواجهة الأمامية
8. ⏳ إضافة تطبيق موبايل

---

## 📞 الدعم

للمساعدة أو الإبلاغ عن مشاكل:
- تحقق من ملف `README.md`
- راجع `MYSQL_DATABASE_SCHEMA.md` لمعلومات قاعدة البيانات
- اتصل بفريق الدعم

---

**آخر تحديث:** 16 ديسمبر 2025
**الإصدار:** 2.0.0
