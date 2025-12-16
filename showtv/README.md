# SHOWTV - TV Show Streaming Platform

A Laravel-based TV show streaming platform integrated with ROYA YouTube channel.

## 🚀 Quick Start

### Prerequisites
- PHP 8.0+
- Composer
- Node.js & npm (for frontend assets)
- SQLite (default) or MySQL

### Installation

1. **Clone and navigate to project directory:**
   ```bash
   cd showtv_complete/showtv
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies:**
   ```bash
   npm install
   ```

4. **Environment Setup:**
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Generate application key:
     ```bash
     php artisan key:generate
     ```
   - Configure database (SQLite is configured by default)

5. **Database Setup:**
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Frontend Assets:**
   ```bash
   npm run dev
   # or for production
   npm run build
   ```

### Running the Application

```bash
php artisan serve
```

Visit: http://127.0.0.1:8000

## 🔑 Default Credentials

- **Admin**: admin@showtv.com / admin123
- **User**: Register new account through the website

## 🌐 Access Points

### Public Pages
- `/` - Homepage
- `/shows` - All TV shows
- `/shows/{show}` - Show details and episodes
- `/episodes/{episode}` - Episode player

### Authentication
- `/login` - User login
- `/register` - User registration

### Admin Panel
- `/admin/dashboard` - Admin dashboard
- `/admin/roya` - ROYA channel management

## 📺 Features

- **Authentication System**: User registration, login, admin roles
- **TV Shows & Episodes**: Browse shows, watch episodes with YouTube integration
- **ROYA API Integration**: Auto-sync videos from ROYA YouTube channel
- **User Interactions**: Like/dislike episodes, follow shows
- **Responsive Design**: Mobile-friendly interface

## 🛠️ YouTube API Setup (Optional)

To enable ROYA channel integration:

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Enable YouTube Data API v3
3. Create API Key
4. Add to `.env`:
   ```
   YOUTUBE_API_KEY=your_actual_api_key_here
   YOUTUBE_CHANNEL_ID=UCwWhs_6x42TyRM4w_-phweA
   ```

## 🐛 Troubleshooting

### Common Issues

**Database Connection Error**
```bash
php artisan migrate:fresh --seed
```

**Cache Issues**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

**Permission Issues**
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## 📊 Database

The application uses SQLite by default. For MySQL:

1. Create database: `CREATE DATABASE showtv;`
2. Update `.env`:
   ```
   DB_CONNECTION=mysql
   DB_DATABASE=showtv
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

## 🧪 Testing

Run tests:
```bash
php artisan test
```

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
