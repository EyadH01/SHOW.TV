# SHOW.TV MySQL Migration - Quick Start

Converting your SHOW.TV database from SQLite to MySQL for use in MySQL Workbench and production environments.

## 📦 Files Included

| File | Description |
|------|-------------|
| `MYSQL_SETUP_DUMP.sql` | Complete MySQL database dump (61KB) - ready to import |
| `MYSQL_SETUP_GUIDE.md` | Comprehensive step-by-step setup guide |
| `setup_mysql.sh` | Automated setup script (Linux/macOS) |

## ⚡ Quick Setup (3 minutes)

### Option 1: Automated Setup (Linux/macOS)

```bash
# Navigate to project root
cd /path/to/showtv_complete

# Run the setup script
./setup_mysql.sh

# Follow the prompts and you're done!
```

### Option 2: Manual Setup

```bash
# 1. Create database
mysql -u root -p
> CREATE DATABASE IF NOT EXISTS showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
> CREATE USER IF NOT EXISTS 'showtv'@'localhost' IDENTIFIED BY 'showtv123';
> GRANT ALL PRIVILEGES ON showtv.* TO 'showtv'@'localhost';
> FLUSH PRIVILEGES;
> EXIT;

# 2. Import the dump
mysql -u showtv -p showtv < MYSQL_SETUP_DUMP.sql

# 3. Update .env in the showtv directory
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=showtv123

# 4. Clear Laravel cache
cd showtv
php artisan cache:clear
php artisan config:clear

# 5. Start the app
php artisan serve
```

### Option 3: MySQL Workbench

1. Open **MySQL Workbench**
2. **File** → **Open SQL Script**
3. Select `MYSQL_SETUP_DUMP.sql`
4. Execute the script
5. Update `.env` with credentials (see above)
6. Start the Laravel app

## ✅ Verify Setup

```bash
# Test database connection
cd showtv
php artisan tinker
>>> DB::connection()->getPDO()
>>> exit()

# Or check with MySQL directly
mysql -u showtv -p showtv
> SELECT COUNT(*) FROM shows;
> SELECT COUNT(*) FROM episodes;
> SELECT COUNT(*) FROM users;
```

## 🔧 Database Credentials

**Default credentials:**
- **Host**: localhost
- **Port**: 3306
- **Database**: showtv
- **Username**: showtv
- **Password**: showtv123

Update these in `showtv/.env` if you use different credentials.

## 🔄 What Gets Imported

The dump includes everything from your SQLite database:

- ✅ All 70+ TV shows
- ✅ 440+ episodes with video IDs and thumbnails
- ✅ User accounts (admin and test users)
- ✅ Migrations history
- ✅ All tables and relationships
- ✅ UTF-8 support for Arabic text

## 📚 Full Documentation

See **`MYSQL_SETUP_GUIDE.md`** for:

- Detailed step-by-step instructions
- Multiple setup methods
- Troubleshooting guide
- Security recommendations
- Backup procedures
- MySQL Workbench integration
- Docker setup option
- And more...

## 🆘 Troubleshooting

### MySQL Connection Error

```bash
# Check MySQL is running
systemctl status mysql
# or
brew services list | grep mysql

# Verify credentials in .env
cat showtv/.env | grep DB_
```

### Import Failed

```bash
# Check database exists
mysql -u root -p
> SHOW DATABASES;
> USE showtv;
> SHOW TABLES;

# Re-run the import if needed
mysql -u showtv -p showtv < MYSQL_SETUP_DUMP.sql
```

### Laravel Can't Connect

```bash
# Clear cache
cd showtv
php artisan cache:clear
php artisan config:clear

# Test connection
php artisan tinker
>>> DB::connection()->getPDO()
```

## 🔙 Switch Back to SQLite

If you want to use SQLite again:

```bash
# Edit showtv/.env
DB_CONNECTION=sqlite

# Your SQLite database is still available at:
# showtv/database/database.sqlite
```

## 📊 Next Steps

1. **View in MySQL Workbench**: 
   - Open Workbench
   - Connect with credentials above
   - Browse `showtv` database

2. **Start the app**:
   ```bash
   cd showtv
   php artisan serve
   ```

3. **Login**:
   - Email: `admin@showtv.com`
   - Password: `admin123`

4. **Browse shows** and test video playback

## 📞 Need Help?

- **Setup issues**: See `MYSQL_SETUP_GUIDE.md` Troubleshooting section
- **Laravel errors**: Check `showtv/storage/logs/laravel.log`
- **MySQL issues**: Run `mysql -u root -p` and verify tables exist

---

**Happy streaming! 🎬**
