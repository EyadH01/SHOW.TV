# SHOW.TV Project Files Guide

Complete reference for all files and what they do.

## 📁 Project Root Directory

```
showtv_complete/
├── README.md                           # Main project documentation
├── SUMMARY.md                          # Project overview
├── QUICK_START.md                      # Getting started guide
├── SETUP_GUIDE.md                      # Initial setup instructions
├── EPISODE_ADD_GUIDE.md                # How to add episodes (3 methods)
├── MYSQL_QUICK_START.md               # Quick MySQL setup (3 min)
├── MYSQL_SETUP_GUIDE.md               # Full MySQL documentation
├── MYSQL_SETUP_DUMP.sql               # MySQL database dump (61KB)
├── setup_mysql.sh                     # Automated MySQL setup script
├── TODO.md                             # Project tasks and progress
│
└── showtv/                             # Laravel application root
    ├── artisan                         # Laravel CLI
    ├── composer.json                   # PHP dependencies
    ├── package.json                    # Node.js dependencies
    ├── .env                            # Environment configuration ⚠️ KEEP PRIVATE
    ├── README.md                       # Laravel-specific docs
    │
    ├── app/
    │   ├── Models/
    │   │   ├── User.php               # User model (profiles, roles)
    │   │   ├── Show.php               # Show/Series model
    │   │   └── Episode.php            # Episode model
    │   │
    │   ├── Http/Controllers/
    │   │   ├── HomeController.php     # Homepage (latest episodes)
    │   │   ├── ProfileController.php  # User profiles
    │   │   ├── Auth/
    │   │   │   ├── LoginController.php
    │   │   │   ├── RegisterController.php
    │   │   │   └── ...
    │   │   └── Admin/
    │   │       └── EpisodeController.php  # Episode CRUD (video upload)
    │   │
    │   └── Console/Commands/
    │       └── AddEpisodeFromYoutube.php  # CLI command for quick episode add
    │
    ├── routes/
    │   ├── web.php                    # Web routes (pages)
    │   ├── api.php                    # API routes
    │   └── auth.php                   # Auth routes
    │
    ├── resources/views/
    │   ├── layouts/
    │   │   ├── app.blade.php          # Main layout template
    │   │   └── auth.blade.php         # Auth pages layout
    │   │
    │   ├── home.blade.php             # Homepage with profile card
    │   ├── episodes/
    │   │   ├── show.blade.php         # Episode player (YouTube + MP4)
    │   │   └── index.blade.php        # Episodes list
    │   │
    │   ├── shows/
    │   │   ├── index.blade.php        # Shows list
    │   │   ├── show.blade.php         # Show details
    │   │   └── ...
    │   │
    │   ├── profile/
    │   │   ├── show.blade.php         # User profile page
    │   │   └── edit.blade.php         # Edit profile form
    │   │
    │   ├── partials/
    │   │   ├── navbar.blade.php       # Navigation bar with profile
    │   │   └── ...
    │   │
    │   └── auth/
    │       ├── login.blade.php        # Login form
    │       ├── register.blade.php     # Registration form
    │       └── ...
    │
    ├── database/
    │   ├── database.sqlite            # SQLite database (primary)
    │   ├── database.sqlite.bak.*.    # Database backups
    │   │
    │   ├── migrations/
    │   │   ├── *_create_users_table.php
    │   │   ├── *_create_shows_table.php
    │   │   ├── *_create_episodes_table.php
    │   │   ├── *_add_youtube_video_id_to_episodes_table.php
    │   │   └── ... (17 migrations total)
    │   │
    │   └── seeders/
    │       ├── DatabaseSeeder.php     # Main seeder
    │       ├── UsersTableSeeder.php   # Seed users
    │       ├── ShowsTableSeeder.php   # Seed shows
    │       └── CleanupSeeder.php      # Remove bad data
    │
    ├── storage/
    │   ├── app/public/
    │   │   ├── profile-images/        # User profile photos
    │   │   ├── videos/                # Uploaded MP4 files
    │   │   └── episodes/              # Episode thumbnails
    │   │
    │   ├── framework/
    │   │   ├── cache/                 # Laravel caches
    │   │   └── views/                 # Compiled views
    │   │
    │   └── logs/
    │       └── laravel.log            # Application logs
    │
    ├── public/
    │   ├── index.php                  # Laravel entry point
    │   ├── storage -> ../storage/app/public
    │   └── ... (assets, CSS, JS)
    │
    ├── config/
    │   ├── app.php                    # App configuration
    │   ├── database.php               # Database config (SQLite/MySQL)
    │   ├── auth.php                   # Authentication config
    │   └── ... (other configs)
    │
    ├── vendor/                        # Composer packages (PHP dependencies)
    │   └── ... (100+ packages)
    │
    └── node_modules/                  # npm packages (JS dependencies)
        └── ... (build tools)
```

## 📄 Key Configuration Files

### `.env` (Environment Variables)
Located in `showtv/.env` - **NEVER commit this!**

```env
APP_NAME=SHOW.TV
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

# Database (change for MySQL)
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Or for MySQL:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=showtv123
```

### `composer.json`
Laravel framework and PHP package dependencies:
- Laravel 8.75
- Authentication scaffolding
- Database tools
- Utility packages

### `package.json`
Node.js build tools:
- webpack-mix
- Bootstrap CSS
- jQuery
- PostCSS

## 🎥 Video Support

### YouTube Videos
- Stored in: `episodes.youtube_video_id` (e.g., "dQw4w9WgXcQ")
- Display: Auto-generates thumbnail from YouTube
- Player: Embedded iframe

### Local MP4 Files
- Uploaded to: `storage/app/public/videos/`
- Stored in: `episodes.video_url` (e.g., "videos/episode1.mp4")
- Player: HTML5 `<video>` element

## 👤 User Profiles

### Storage
- Profile images: `storage/app/public/profile-images/`
- Database column: `users.image`
- Display: Navbar + Homepage profile card

### Registration
- Form: `resources/views/auth/register.blade.php`
- Handles image upload
- Saves to database

### Edit Profile
- Route: `/profile/{user}/edit`
- View: `resources/views/profile/edit.blade.php`
- Can update name, email, and profile image

## 🛠️ Development Commands

### Laravel Commands (in `showtv/` directory)

```bash
# Start development server
php artisan serve

# Run database seeders
php artisan db:seed

# Create storage symlink
php artisan storage:link

# Clear caches
php artisan cache:clear
php artisan config:clear

# Add episodes (new command!)
php artisan episode:add-youtube 5 "Title" youtube_id
```

### Database Commands

```bash
# SQLite query
sqlite3 database/database.sqlite

# MySQL query
mysql -u showtv -p showtv

# Backup SQLite
cp database/database.sqlite database/database.sqlite.backup

# Backup MySQL
mysqldump -u showtv -p showtv > backup.sql
```

### Git Commands

```bash
# View commits
git log --oneline

# See changes
git status
git diff

# Commit changes
git add .
git commit -m "Your message"

# View history
git log --graph --oneline --all
```

## 📊 Database Tables

### Core Tables
- **users**: User accounts, roles, profiles
- **shows**: TV series (70+ shows)
- **episodes**: Individual episodes (440+ episodes)
- **migrations**: Track schema changes

### Relationship Tables
- **episode_user_likes**: User ratings (like/dislike)
- **user_show_follows**: Bookmarked shows (future feature)

### System Tables
- **password_resets**: Password reset tokens
- **failed_jobs**: Failed async jobs
- **personal_access_tokens**: API tokens

## 🎨 Frontend Files

### CSS/Styling
- `resources/css/` - Custom CSS
- `resources/sass/` - SCSS files
- Bootstrap 5 via npm/CDN

### JavaScript
- `resources/js/` - Custom scripts
- jQuery for interactions
- Webpack bundling in `webpack.mix.js`

### Blade Templates
- `.blade.php` files - Laravel templating
- Syntax: `{{ variable }}`, `@if`, `@foreach`, etc.

## 📱 Responsive Design

All views are mobile-responsive:
- Bootstrap 5 grid system
- Mobile-first approach
- Touch-friendly buttons and navigation

## 🔐 Security

### Authentication
- Laravel built-in auth system
- Password hashing with bcrypt
- Session management
- CSRF protection

### File Permissions
- `storage/` - Writable by web server
- `bootstrap/cache/` - Writable by web server
- `database/` - SQLite file readable/writable
- `.env` - Not readable from web

### Environment Secrets
- Database credentials in `.env`
- API keys in `.env`
- Never commit `.env` file

## 📈 Performance Features

### Caching
- View caching
- Config caching
- Route caching

### Database
- Indexes on common queries
- Lazy loading with relationships
- Query optimization

### Frontend
- CSS minification
- JS bundling
- Image optimization

## 🐛 Debugging

### Logs
Location: `storage/logs/laravel.log`

View logs:
```bash
tail -f storage/logs/laravel.log
```

### Tinker (Interactive Shell)
```bash
php artisan tinker
>>> User::all()
>>> DB::table('shows')->count()
>>> exit()
```

### Browser DevTools
- F12 in Chrome/Firefox
- Check Console for JS errors
- Network tab for API calls
- Application tab for storage

## 📚 Documentation Files

| File | Purpose |
|------|---------|
| README.md | Main project overview |
| QUICK_START.md | 5-min getting started |
| SETUP_GUIDE.md | Full setup instructions |
| EPISODE_ADD_GUIDE.md | Add episodes (3 methods) |
| MYSQL_QUICK_START.md | MySQL in 3 minutes |
| MYSQL_SETUP_GUIDE.md | Complete MySQL reference |
| FILES_GUIDE.md | This file - project structure |
| SUMMARY.md | Development progress summary |
| TODO.md | Outstanding tasks |

## 🎯 Common Tasks

### Add a New Show
```bash
# Option 1: Via database
sqlite3 database/database.sqlite
> INSERT INTO shows (title, description, airing_time, thumbnail, wallpaper, created_at, updated_at) 
  VALUES ('Show Title', 'Description', 'Time', 'thumb_url', 'wall_url', NOW(), NOW());

# Option 2: Via admin panel
# Visit http://127.0.0.1:8000/admin/shows/create
```

### Add an Episode
```bash
# Option 1: CLI command
php artisan episode:add-youtube 5 "Episode Title" youtube_id

# Option 2: Admin panel
# Visit http://127.0.0.1:8000/admin/episodes/create

# Option 3: Direct database
sqlite3 database/database.sqlite
> INSERT INTO episodes (...) VALUES (...);
```

### Change Database to MySQL
```bash
# Edit showtv/.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=showtv123

# Run setup
./setup_mysql.sh

# Or manually import
mysql -u showtv -p showtv < MYSQL_SETUP_DUMP.sql
```

### Backup Everything
```bash
# All code and database
tar -czf showtv_backup_$(date +%Y%m%d).tar.gz showtv_complete/

# Just database
cp showtv/database/database.sqlite showtv/database/database.sqlite.backup.$(date +%Y%m%d)

# MySQL backup
mysqldump -u showtv -p showtv > showtv_mysql_backup_$(date +%Y%m%d).sql
```

---

**Need more info? See:**
- Main README.md - Project overview
- QUICK_START.md - Fast setup
- MYSQL_SETUP_GUIDE.md - MySQL reference
- EPISODE_ADD_GUIDE.md - Add content
