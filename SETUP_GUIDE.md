# SHOWTV Complete Setup Guide

## 🎯 Project Overview
SHOWTV is a Laravel-based TV show streaming platform integrated with ROYA YouTube channel.

## 🔧 Prerequisites
- PHP 8.0+
- MySQL 8.0+
- Composer
- Node.js & npm
- YouTube Data API v3 key

## 📋 Step-by-Step Setup

### 1. Database Setup
```bash
# Create MySQL database
mysql -u root -p
CREATE DATABASE showtv;
CREATE USER 'showtv'@'localhost' IDENTIFIED BY 'password123';
GRANT ALL PRIVILEGES ON showtv.* TO 'showtv'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 2. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Update .env file with your database credentials:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=password123

# Add YouTube API key (get from Google Cloud Console)
YOUTUBE_API_KEY=your_actual_api_key_here
```

### 3. YouTube API Setup
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create new project or select existing
3. Enable YouTube Data API v3
4. Go to Credentials → Create Credentials → API Key
5. Copy the API key and add it to `.env`

### 4. Run Setup Script
```bash
./setup_database.sh
```

### 5. Start Application
```bash
php artisan serve
```

## 🔑 Default Login Credentials
- **Admin**: admin@showtv.com / admin123
- **User**: Register new account through the website

## 📺 Features Implemented

### ✅ Authentication System
- User registration and login
- Admin role management
- Password reset functionality

### ✅ ROYA API Integration
- Fetch videos from ROYA YouTube channel
- Auto-sync episodes to database
- Search functionality for videos
- Admin dashboard for ROYA management

### ✅ Video Management
- Episode display with YouTube embed
- Like/dislike functionality
- Show following system
- Responsive video player

### ✅ Database Features
- Shows and Episodes management
- User-Show relationships
- Episode-User interactions (likes/dislikes)
- Admin user creation

## 🌐 Access Points

### Public Pages
- `/` - Homepage
- `/shows` - All TV shows
- `/shows/{show}` - Show details and episodes
- `/episodes/{episode}` - Episode player

### Authentication
- `/login` - User login
- `/register` - User registration
- `/password/reset` - Password reset

### Admin Panel
- `/admin/dashboard` - Admin dashboard
- `/admin/roya` - ROYA channel management
  - Sync videos from ROYA channel
  - Search videos
  - View channel statistics

## 🔧 ROYA API Features

### Available Endpoints
1. **GET /admin/roya** - ROYA dashboard with channel info
2. **POST /admin/roya/sync** - Sync ROYA videos to database
3. **GET /admin/roya/videos** - Get latest ROYA videos
4. **GET /admin/roya/search?q={query}** - Search ROYA videos

### Usage
1. Login as admin
2. Go to `/admin/roya`
3. Click "مزامنة البيانات" to sync ROYA videos
4. Browse and manage synced content

## 🛠️ Troubleshooting

### Common Issues

**Database Connection Error**
```bash
# Check MySQL service
sudo systemctl status mysql
# Restart if needed
sudo systemctl restart mysql
```

**YouTube API Error**
- Verify API key is correct
- Check API quotas in Google Cloud Console
- Ensure YouTube Data API v3 is enabled

**Migration Errors**
```bash
php artisan migrate:fresh --seed
```

**Cache Issues**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 📊 Database Schema

### Tables Created
- `users` - User accounts with roles
- `shows` - TV shows information
- `episodes` - Episode details with YouTube integration
- `user_show_follows` - User show relationships
- `episode_user_likes` - Episode ratings

## 🎬 ROYA Channel Integration

### Channel Details
- **Channel ID**: UCwWhs_6x42TyRM4w_-phweA
- **Channel URL**: https://www.youtube.com/@royatv
- **API Integration**: Automatic video fetching and syncing

### Video Processing
- Automatic show title extraction from video titles
- Duration parsing from YouTube API
- Thumbnail and description importing
- Episode numbering recognition

## 🚀 Deployment Notes

For production deployment:
1. Set `APP_ENV=production`
2. Set `APP_DEBUG=false`
3. Configure proper mail settings
4. Set up Redis for caching
5. Configure proper file storage
6. Set up SSL certificate

## 📞 Support

For issues or questions:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify all environment variables
3. Ensure all dependencies are installed
4. Check database connectivity

---

**Ready to stream ROYA content! 🎉**
