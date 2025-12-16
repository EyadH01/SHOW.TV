# SHOW.TV MySQL Database Schema

This document describes the complete MySQL database structure for the SHOW.TV streaming platform.

## 📊 Database Overview

The SHOW.TV application uses a comprehensive MySQL database with 12+ tables to manage users, content, interactions, and platform features.

## 🗄️ Database Tables

### 1. **users** - User Accounts & Authentication
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    image VARCHAR(255) NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```
**Purpose**: Stores user accounts with role-based permissions
**Key Features**:
- Role-based access control (user/admin)
- Profile images support
- Email verification system

### 2. **shows** - TV Series Information
```sql
CREATE TABLE shows (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    airing_time VARCHAR(255),
    thumbnail VARCHAR(255),
    wallpaper VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```
**Purpose**: Stores TV series metadata and media
**Key Features**:
- Series thumbnails and wallpapers
- Airing schedule information
- Rich descriptions

### 3. **episodes** - Episode Data & Media
```sql
CREATE TABLE episodes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    show_id BIGINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    duration INT DEFAULT 0,
    airing_time DATETIME,
    video_url VARCHAR(255),
    youtube_video_id VARCHAR(255),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE
);
```
**Purpose**: Stores individual episode information and media links
**Key Features**:
- Multiple video source support (local/YouTube)
- Duration tracking
- Airing time scheduling

### 4. **categories** - Content Categorization
```sql
CREATE TABLE categories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#007bff',
    icon VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```
**Purpose**: Organizes content by genres and categories
**Key Features**:
- Color-coded categories
- Icon support
- Sorting capabilities
- Active/inactive status

### 5. **watch_history** - User Viewing Progress
```sql
CREATE TABLE watch_history (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    episode_id BIGINT UNSIGNED NOT NULL,
    watch_time INT DEFAULT 0,
    duration INT DEFAULT 0,
    completed BOOLEAN DEFAULT FALSE,
    last_watched_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE,
    UNIQUE KEY user_episode (user_id, episode_id)
);
```
**Purpose**: Tracks user viewing progress and history
**Key Features**:
- Resume playback functionality
- Completion tracking
- Watch time analytics

### 6. **comments** - User Comments & Discussions
```sql
CREATE TABLE comments (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    episode_id BIGINT UNSIGNED NULL,
    show_id BIGINT UNSIGNED NULL,
    content TEXT NOT NULL,
    parent_id BIGINT UNSIGNED NULL,
    is_approved BOOLEAN DEFAULT TRUE,
    is_spoiler BOOLEAN DEFAULT FALSE,
    likes_count INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE
);
```
**Purpose**: Enables user discussions and comments
**Key Features**:
- Nested comments (replies)
- Spoiler protection
- Moderation system
- Like system

### 7. **ratings** - Star Ratings & Reviews
```sql
CREATE TABLE ratings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    episode_id BIGINT UNSIGNED NULL,
    show_id BIGINT UNSIGNED NULL,
    rating TINYINT NOT NULL,
    review TEXT,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE,
    UNIQUE KEY user_episode_rating (user_id, episode_id),
    UNIQUE KEY user_show_rating (user_id, show_id)
);
```
**Purpose**: Stores user ratings and reviews
**Key Features**:
- 1-5 star rating system
- Written reviews
- One rating per user per content

### 8. **user_show_follows** - Follow Relationships
```sql
CREATE TABLE user_show_follows (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    show_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE,
    UNIQUE KEY user_show_follow (user_id, show_id)
);
```
**Purpose**: Manages user follow relationships with shows
**Key Features**:
- Follow/unfollow functionality
- Prevents duplicate follows

### 9. **episode_user_likes** - Like/Dislike System
```sql
CREATE TABLE episode_user_likes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    episode_id BIGINT UNSIGNED NOT NULL,
    type ENUM('like', 'dislike') NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(id) ON DELETE CASCADE,
    UNIQUE KEY user_episode_like (user_id, episode_id)
);
```
**Purpose**: Handles episode like/dislike functionality
**Key Features**:
- Like and dislike options
- One vote per user per episode

## 🔧 Additional Tables (Laravel Standard)

### 10. **password_resets** - Password Recovery
### 11. **failed_jobs** - Job Queue Management
### 12. **personal_access_tokens** - API Authentication

## 🚀 Setup Instructions

### Prerequisites
- MySQL 5.7+ or MariaDB 10.0+
- PHP 8.1+
- Composer
- Node.js & npm

### Database Setup
1. **Create Database**:
```bash
mysql -u root -p
CREATE DATABASE showtv_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **Configure Environment**:
Update your `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=showtv_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

3. **Run Migrations**:
```bash
php artisan migrate
```

4. **Seed Database**:
```bash
php artisan db:seed
```

### Default Accounts
- **Admin**: `admin@showtv.com` / `admin123`
- **User**: `user@showtv.com` / `password123`

## 📈 Database Relationships

```
users (1) ──── (M) user_show_follows (M) ──── (1) shows
   │                      │
   │                      │
   └── (1) ──── (M) watch_history (M) ──── (1) episodes
   │                      │
   │                      │
   └── (1) ──── (M) comments (M) ──── (1) episodes
   │                      │
   │                      │
   └── (1) ──── (M) ratings (M) ──── (1) episodes
   │                      │
   │                      │
   └── (1) ──── (M) episode_user_likes (M) ──── (1) episodes

shows (1) ──── (M) episodes
   │
   └── (1) ──── (M) categories (through category_show pivot - if implemented)
```

## 🎯 Key Features Enabled by Schema

- **Role-based Access Control**: Admin vs User permissions
- **Content Management**: Full CRUD operations for shows/episodes
- **User Engagement**: Likes, comments, ratings, follows
- **Progress Tracking**: Resume watching functionality
- **Social Features**: Comments, reviews, ratings
- **Content Organization**: Categories and metadata
- **Analytics**: Viewing history and user behavior tracking

## 🔐 Security Considerations

- **Foreign Key Constraints**: Maintains data integrity
- **Unique Constraints**: Prevents duplicate relationships
- **Cascade Deletes**: Automatic cleanup of related data
- **Index Optimization**: Fast queries on commonly accessed fields
- **UTF8MB4 Support**: Full Unicode character support

This comprehensive database schema provides a solid foundation for a professional streaming platform with all the features you'd expect from services like Netflix or Hulu.
