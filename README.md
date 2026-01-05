# 📺 SHOW.TV - Advanced TV Show Streaming Platform

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)

**A comprehensive Laravel-based TV show streaming platform with YouTube integration, user management, and admin dashboard.**

[Features](#-features) • [Installation](#-installation) • [Documentation](#-documentation) • [Screenshots](#-screenshots) • [Contributing](#-contributing)

</div>

---

## 📖 About The Project

**SHOW.TV** is a modern, full-featured web application built with Laravel that provides a complete streaming platform for TV shows. The platform is specifically integrated with the ROYA YouTube channel, allowing automatic synchronization of content while providing a rich user experience with profile management, social interactions, and comprehensive admin controls.

### 🎯 Project Highlights

- **Full-Stack Laravel Application** built with modern PHP practices and MVC architecture
- **YouTube API Integration** for automatic video sync from ROYA channel
- **Complete Authentication System** with role-based access control (Admin/User)
- **Advanced User Profile Management** with photo uploads, preferences, and activity tracking
- **Social Features** including likes, follows, and user interactions
- **Responsive Design** that works seamlessly on desktop, tablet, and mobile devices
- **Admin Dashboard** with comprehensive content management tools
- **Bilingual Support** (English/Arabic) with RTL support
- **RESTful API** for potential mobile app integration

---

## ✨ Features

### 🔐 Authentication & User Management
- User registration with email verification
- Secure login/logout functionality
- Password reset and recovery
- Role-based access control (Admin/User)
- Profile photo upload and management
- User preferences and settings
- Activity logging and session tracking
- Social authentication ready

### 👤 User Profile System
- **Personal Information**: Name, bio, location, phone number
- **Profile Customization**: Upload and manage profile photos
- **Privacy Settings**: Manage visibility and preferences
- **Activity Dashboard**: View your likes, follows, and watch history
- **User Statistics**: Track your engagement with shows and episodes

### 📺 Content Management
- **TV Shows**: Browse and discover TV shows
- **Episodes**: Watch episodes with embedded YouTube player
- **Categories & Genres**: Organized content discovery
- **Search Functionality**: Find shows and episodes quickly
- **Content Filtering**: Filter by genre, popularity, release date

### 💬 Social Features
- **Like/Dislike Episodes**: Express your opinion
- **Follow Shows**: Get updates on your favorite shows
- **User Activity**: See what others are watching
- **Watchlist**: Save shows for later

### 🛠️ Admin Panel
- **Dashboard**: Overview of platform statistics
- **Show Management**: Add, edit, delete TV shows
- **Episode Management**: Manage episodes and their details
- **User Management**: View and manage registered users
- **ROYA Integration**: Sync content from ROYA YouTube channel
- **Content Moderation**: Monitor and moderate user interactions
- **Analytics**: View platform usage statistics

### 🔄 API Integration
- **YouTube Data API v3**: Automatic video synchronization
- **TMDB API**: Fetch show metadata and images (optional)
- **Google Images API**: Enhanced image search capabilities

### 🎨 Design & UX
- Modern, clean, and intuitive interface
- Fully responsive design (mobile-first approach)
- Bootstrap 5 for consistent styling
- Custom CSS for unique branding
- Smooth animations and transitions
- Dark mode ready

---

## 🚀 Installation

### Prerequisites

Before you begin, ensure you have the following installed:
- **PHP** >= 8.0
- **Composer** (latest version)
- **Node.js** >= 16.x and npm
- **MySQL** >= 8.0 or **SQLite** for development
- **Git** for version control

### Step-by-Step Setup

1. **Clone the Repository**
   ```bash
   git clone https://github.com/EyadH01/SHOW.TV.git
   cd SHOW.TV/showtv
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   # Copy environment file
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   ```

5. **Configure Database**
   
   **Option A: SQLite (Development)**
   ```bash
   touch database/database.sqlite
   ```
   Ensure your `.env` file has:
   ```
   DB_CONNECTION=sqlite
   ```

   **Option B: MySQL (Production)**
   ```bash
   # Create database
   mysql -u root -p
   CREATE DATABASE showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   EXIT;
   ```
   Update your `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=showtv
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run Database Migrations & Seeders**
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Set Up Storage**
   ```bash
   php artisan storage:link
   chmod -R 775 storage bootstrap/cache
   ```

8. **Build Frontend Assets**
   ```bash
   # Development
   npm run dev
   
   # Production
   npm run build
   ```

9. **Start the Application**
   ```bash
   php artisan serve
   ```

   Visit: **http://127.0.0.1:8000**

---

## 🔑 Default Credentials

After running the seeders, you can login with:

| Role  | Email | Password |
|-------|-------|----------|
| **Admin** | admin@showtv.com | admin123 |
| **User** | user@showtv.com | user123 |

> ⚠️ **Important**: Change these passwords in production!

---

## 🌐 Application Structure

```
showtv/
├── app/
│   ├── Console/          # Artisan commands
│   ├── Events/           # Event classes
│   ├── Http/
│   │   ├── Controllers/  # Request controllers
│   │   │   ├── Admin/    # Admin panel controllers
│   │   │   └── Auth/     # Authentication controllers
│   │   └── Middleware/   # HTTP middleware
│   ├── Listeners/        # Event listeners
│   ├── Models/           # Eloquent models
│   └── Services/         # Business logic services
│       ├── ImageService.php
│       ├── TMDBApiService.php
│       └── GoogleImagesApiService.php
├── config/               # Configuration files
├── database/
│   ├── migrations/       # Database migrations
│   └── seeders/          # Database seeders
├── public/               # Public assets
├── resources/
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   ├── lang/             # Language files (ar/en)
│   └── views/            # Blade templates
│       ├── admin/        # Admin panel views
│       ├── auth/         # Authentication views
│       ├── episodes/     # Episode views
│       ├── profile/      # User profile views
│       └── shows/        # TV show views
├── routes/
│   ├── api.php           # API routes
│   └── web.php           # Web routes
└── tests/                # Automated tests
```

---

## 🔧 Configuration

### YouTube API Setup

1. **Create a Google Cloud Project**
   - Visit [Google Cloud Console](https://console.cloud.google.com/)
   - Create a new project

2. **Enable YouTube Data API v3**
   - Navigate to "APIs & Services" > "Library"
   - Search for "YouTube Data API v3"
   - Click "Enable"

3. **Create API Credentials**
   - Go to "APIs & Services" > "Credentials"
   - Click "Create Credentials" > "API Key"
   - Copy the API key

4. **Configure in .env**
   ```env
   YOUTUBE_API_KEY=your_api_key_here
   YOUTUBE_CHANNEL_ID=UCwWhs_6x42TyRM4w_-phweA
   ```

### TMDB API Setup (Optional)

1. Register at [The Movie Database](https://www.themoviedb.org/)
2. Get your API key from account settings
3. Add to `.env`:
   ```env
   TMDB_API_KEY=your_tmdb_api_key
   ```

### Email Configuration

For email notifications and password resets:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@showtv.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 📚 Documentation

### Available Documentation Files

- 📄 **FINAL_DOCUMENTATION_AR.md** - Complete Arabic documentation
- 📄 **MYSQL_QUICK_START.md** - MySQL setup guide
- 📄 **EPISODE_ADD_GUIDE.md** - Guide for adding episodes
- 📄 **FILES_GUIDE.md** - Project files overview
- 📄 **REGISTRATION_COMPLETE.md** - Registration system documentation

### Key Routes

#### Public Routes
- `GET /` - Homepage
- `GET /shows` - Browse all shows
- `GET /shows/{show}` - Show details
- `GET /episodes/{episode}` - Watch episode
- `GET /search` - Search content

#### Authentication Routes
- `GET|POST /login` - User login
- `GET|POST /register` - User registration
- `POST /logout` - User logout
- `GET|POST /password/reset` - Password reset

#### User Routes (Authenticated)
- `GET /profile` - View profile
- `GET /profile/edit` - Edit profile
- `POST /profile/update` - Update profile
- `POST /profile/photo` - Upload profile photo
- `GET /profile/settings` - User settings
- `GET /profile/dashboard` - User dashboard

#### Admin Routes (Admin Only)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/shows` - Manage shows
- `GET /admin/episodes` - Manage episodes
- `GET /admin/users` - Manage users
- `GET /admin/roya` - ROYA channel sync

---

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test Suites
```bash
# Feature tests
php artisan test --testsuite=Feature

# Unit tests
php artisan test --testsuite=Unit

# Specific test file
php artisan test tests/Feature/Auth/RegisterControllerTest.php
```

### Browser Testing
```bash
npm install
npx playwright test
```

---

## 🐛 Troubleshooting

### Common Issues and Solutions

**Problem: Database Connection Error**
```bash
# Solution: Reset database
php artisan migrate:fresh --seed
```

**Problem: Permission Denied on Storage**
```bash
# Solution: Fix permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R $USER:www-data storage bootstrap/cache
```

**Problem: Composer Dependencies Error**
```bash
# Solution: Clear and reinstall
rm -rf vendor composer.lock
composer install
```

**Problem: npm Build Errors**
```bash
# Solution: Clear cache and rebuild
rm -rf node_modules package-lock.json
npm install
npm run build
```

**Problem: Cache Issues**
```bash
# Solution: Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Change default admin password
- [ ] Configure proper database credentials
- [ ] Set up SSL certificate (HTTPS)
- [ ] Configure email service
- [ ] Set up backup strategy
- [ ] Configure caching (Redis/Memcached)
- [ ] Enable queue workers
- [ ] Set up monitoring and logging

### Deploy to Server

```bash
# Clone repository
git clone https://github.com/EyadH01/SHOW.TV.git
cd SHOW.TV/showtv

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# Configure environment
cp .env.example .env
php artisan key:generate

# Set permissions
chmod -R 775 storage bootstrap/cache

# Run migrations
php artisan migrate --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🛠️ Built With

### Backend
- **[Laravel 10](https://laravel.com/)** - PHP Framework
- **[MySQL](https://www.mysql.com/)** - Database
- **[Composer](https://getcomposer.org/)** - Dependency Manager

### Frontend
- **[Bootstrap 5](https://getbootstrap.com/)** - CSS Framework
- **[jQuery](https://jquery.com/)** - JavaScript Library
- **[Font Awesome](https://fontawesome.com/)** - Icons

### APIs & Services
- **YouTube Data API v3** - Video content
- **TMDB API** - Movie/TV metadata
- **Google Images API** - Image search

### Development Tools
- **[Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)** - Debugging
- **[Laravel Telescope](https://laravel.com/docs/telescope)** - Application monitoring
- **[PHPUnit](https://phpunit.de/)** - Testing framework
- **[Playwright](https://playwright.dev/)** - Browser testing

---

## 📊 Database Schema

### Main Tables
- **users** - User accounts and authentication
- **shows** - TV show information
- **episodes** - Episode details and videos
- **user_show_follows** - Show following relationships
- **episode_user_likes** - Episode likes/dislikes
- **user_preferences** - User preferences and settings
- **user_activity_logs** - User activity tracking
- **user_sessions** - Active user sessions

---

## 🤝 Contributing

Contributions are welcome! Here's how you can help:

1. **Fork the Project**
2. **Create your Feature Branch**
   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. **Commit your Changes**
   ```bash
   git commit -m 'Add some AmazingFeature'
   ```
4. **Push to the Branch**
   ```bash
   git push origin feature/AmazingFeature
   ```
5. **Open a Pull Request**

### Coding Standards
- Follow PSR-12 coding standards
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 📝 License

This project is licensed under the **MIT License** - see the [LICENSE](LICENSE) file for details.

---

## 👨‍💻 Author

**Eyad Hasan**
- GitHub: [@EyadH01](https://github.com/EyadH01)
- Project Link: [https://github.com/EyadH01/SHOW.TV](https://github.com/EyadH01/SHOW.TV)

---

## 🙏 Acknowledgments

- Laravel Framework and Community
- ROYA TV for content inspiration
- All contributors and testers
- Open source community

---

## 📞 Support

If you encounter any issues or have questions:
- 🐛 [Report a Bug](https://github.com/EyadH01/SHOW.TV/issues)
- 💡 [Request a Feature](https://github.com/EyadH01/SHOW.TV/issues)
- 📧 Email: support@showtv.com

---

<div align="center">

**Made with ❤️ using Laravel**

⭐ Star this repo if you find it helpful!

</div>
