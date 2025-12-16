# SHOW.TV - Laravel Streaming Platform

## Project Overview
SHOW.TV is a full-featured streaming platform built with Laravel 8, featuring:
- User authentication with role-based access control
- TV shows and episodes management
- Follow/unfollow shows
- Like/dislike episodes
- Search functionality
- Voice navigation (Web Speech API)
- Light/Dark theme switcher
- Arabic/English language support
- Admin panel for content management

## Technology Stack
- **Backend**: Laravel 8.x (PHP 8.1)
- **Database**: MySQL 8.0
- **Frontend**: Bootstrap 5.3, jQuery 3.6
- **Icons**: Font Awesome 6.4

## Installation & Setup

### Prerequisites
- PHP 8.1+
- MySQL 8.0+
- Composer
- Node.js & NPM/PNPM

### Step 1: Clone and Install Dependencies
```bash
cd /home/ubuntu/showtv
composer install
pnpm install
```

### Step 2: Configure Environment
```bash
cp .env.example .env
php artisan key:generate
```

Update `.env` with database credentials:
```
DB_DATABASE=showtv_db
DB_USERNAME=showtv_user
DB_PASSWORD=showtv_password
```

### Step 3: Run Migrations and Seeders
```bash
php artisan migrate
php artisan db:seed
```

### Step 4: Create Storage Link
```bash
php artisan storage:link
```

### Step 5: Start Development Server
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Access the application at: `http://localhost:8000`

## Default Login Credentials

### Admin Account
- Email: `admin@showtv.com`
- Password: `admin123`

### Regular User Account
- Email: `user@showtv.com`
- Password: `user123`

## Features

### User Features
1. **Homepage**: Latest episodes from all shows
2. **Shows Listing**: Browse all available TV shows
3. **Show Details**: View show information and episodes
4. **Episode Viewer**: Watch episodes with embedded video player
5. **Follow/Unfollow**: Follow your favorite shows
6. **Like/Dislike**: React to episodes
7. **Search**: Search for shows and episodes
8. **Voice Navigation**: Use voice commands to navigate (supported browsers only)
9. **Theme Switcher**: Toggle between light and dark themes
10. **Language Switcher**: Switch between English and Arabic

### Admin Features
1. **Dashboard**: View statistics (shows, episodes, users)
2. **Manage Shows**: Create, edit, delete TV shows
3. **Manage Episodes**: Create, edit, delete episodes
4. **View Users**: List all registered users

## Voice Commands

### English
- "home" - Navigate to homepage
- "shows" - Navigate to shows page
- "search" - Focus search input

### Arabic
- "الرئيسية" - Navigate to homepage
- "مسلسلات" - Navigate to shows page
- "بحث" - Focus search input

## Database Schema

### Tables
1. **users** - User accounts with roles
2. **shows** - TV shows/series
3. **episodes** - Individual episodes
4. **user_show_follows** - User follows for shows
5. **episode_user_likes** - User likes/dislikes for episodes

## Routes

### Public Routes
- `GET /` - Homepage
- `GET /search` - Search page

### Authenticated Routes
- `GET /shows` - Shows listing
- `GET /shows/{show}` - Show details
- `POST /shows/{show}/follow` - Follow show
- `DELETE /shows/{show}/unfollow` - Unfollow show
- `GET /episodes/{episode}` - Episode viewer
- `POST /episodes/{episode}/like` - Like episode
- `POST /episodes/{episode}/dislike` - Dislike episode

### Admin Routes (require admin role)
- `GET /admin` - Admin dashboard
- `GET /admin/users` - Users list
- Resource routes for shows and episodes management

## Deployment to Production

### On Ubuntu Server

1. **Install Required Packages**
```bash
sudo apt update
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath mysql-server nginx composer
```

2. **Configure Nginx**
Create `/etc/nginx/sites-available/showtv`:
```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/showtv/public;

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

3. **Set Permissions**
```bash
sudo chown -R www-data:www-data /var/www/showtv
sudo chmod -R 755 /var/www/showtv/storage
sudo chmod -R 755 /var/www/showtv/bootstrap/cache
```

4. **Optimize for Production**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## قناة رؤيا API Integration

**Note**: قناة رؤيا (Roya TV) does not have a publicly available API. The current implementation uses sample data. To integrate with an actual API:

1. Create a service class in `app/Services/RoyaTVService.php`
2. Implement API calls to fetch shows and episodes
3. Update the seeders to fetch from the API instead of using static data
4. Schedule regular syncs using Laravel's task scheduler

## Troubleshooting

### Database Connection Error
- Verify MySQL is running: `sudo service mysql status`
- Check database credentials in `.env`
- Ensure database exists: `mysql -u root -p -e "SHOW DATABASES;"`

### Permission Errors
- Run: `sudo chmod -R 775 storage bootstrap/cache`
- Run: `sudo chown -R www-data:www-data storage bootstrap/cache`

### Voice Navigation Not Working
- Voice navigation requires HTTPS in production
- Only works in supported browsers (Chrome, Edge, Safari)

## License
This project is open-source and available for educational purposes.

## Support
For issues or questions, please refer to the Laravel documentation: https://laravel.com/docs
