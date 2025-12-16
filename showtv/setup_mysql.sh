#!/bin/bash

# SHOW.TV MySQL Database Setup Script
# This script sets up the complete MySQL database for the SHOW.TV streaming platform

echo "🏗️  SHOW.TV MySQL Database Setup"
echo "=================================="

# Database configuration
DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_NAME="showtv_db"
DB_USER="root"
DB_PASS=""

echo "📋 Database Configuration:"
echo "Host: $DB_HOST"
echo "Port: $DB_PORT"
echo "Database: $DB_NAME"
echo "Username: $DB_USER"
echo ""

# Create database
echo "🔨 Creating database '$DB_NAME'..."
mysql -h$DB_HOST -P$DB_PORT -u$DB_USER -p$DB_PASS -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if [ $? -eq 0 ]; then
    echo "✅ Database created successfully!"
else
    echo "❌ Failed to create database. Please check your MySQL credentials."
    exit 1
fi

echo ""

# Run Laravel migrations
echo "🚀 Running Laravel migrations..."
cd /path/to/your/laravel/project  # Update this path
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo "✅ Migrations completed successfully!"
else
    echo "❌ Migration failed. Please check your database configuration."
    exit 1
fi

echo ""

# Run seeders
echo "🌱 Running database seeders..."
php artisan db:seed --force

if [ $? -eq 0 ]; then
    echo "✅ Database seeded successfully!"
else
    echo "❌ Seeding failed."
    exit 1
fi

echo ""
echo "🎉 MySQL Database Setup Complete!"
echo ""
echo "📊 Database Tables Created:"
echo "├── users (User accounts with roles)"
echo "├── shows (TV series information)"
echo "├── episodes (Episode data and media)"
echo "├── categories (Content categorization)"
echo "├── watch_history (User viewing progress)"
echo "├── comments (User comments and discussions)"
echo "├── ratings (Star ratings and reviews)"
echo "├── user_show_follows (Follow relationships)"
echo "├── episode_user_likes (Like/dislike system)"
echo "├── password_resets (Password recovery)"
echo "├── failed_jobs (Job queue management)"
echo "└── personal_access_tokens (API authentication)"
echo ""
echo "🔑 Default Admin Account:"
echo "Email: admin@showtv.com"
echo "Password: admin123"
echo ""
echo "🔑 Default User Account:"
echo "Email: user@showtv.com"
echo "Password: password123"
echo ""
echo "🌐 Application URL: http://127.0.0.1:8000"
echo ""
echo "📝 Next Steps:"
echo "1. Start your Laravel server: php artisan serve"
echo "2. Visit the application in your browser"
echo "3. Login with admin credentials to access admin features"
echo "4. Upload media files and manage content"
echo ""
echo "Happy streaming! 🎬"
