# MySQL Setup Guide for SHOW.TV

This guide walks you through converting your SQLite database to MySQL and using it with your Laravel application.

## ⚙️ Prerequisites

- MySQL 8.0+ or MariaDB 10.11+ installed
- MySQL running on localhost (default port 3306)
- MySQL command-line client installed
- Laravel app already running with SQLite

## 🚀 Step 1: Install MySQL (If Not Already Installed)

### On Ubuntu/Debian:
```bash
sudo apt-get update
sudo apt-get install mysql-server
sudo mysql_secure_installation
```

### On macOS (with Homebrew):
```bash
brew install mysql
mysql.server start
mysql_secure_installation
```

### Using Docker:
```bash
docker run -d \
  --name mysql-showtv \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=showtv \
  -e MYSQL_USER=showtv \
  -e MYSQL_PASSWORD=showtv123 \
  -p 3306:3306 \
  mysql:8.0
```

## 📋 Step 2: Create MySQL Database

Open MySQL command-line client:

```bash
mysql -u root -p
```

Enter your root password, then run:

```sql
-- Create database with UTF-8 support
CREATE DATABASE IF NOT EXISTS showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user for SHOW.TV app
CREATE USER IF NOT EXISTS 'showtv'@'localhost' IDENTIFIED BY 'showtv123';

-- Grant all privileges to the user
GRANT ALL PRIVILEGES ON showtv.* TO 'showtv'@'localhost';
FLUSH PRIVILEGES;

-- Verify
SHOW DATABASES;
SELECT USER();
EXIT;
```

## 📥 Step 3: Import the Database Dump

The `MYSQL_SETUP_DUMP.sql` file contains all your shows, episodes, users, and migrations.

### Method 1: Using command-line (Recommended)

```bash
# Navigate to the project directory
cd /path/to/showtv_complete

# Import the dump
mysql -u showtv -p showtv < MYSQL_SETUP_DUMP.sql
```

When prompted, enter the password: `showtv123`

### Method 2: Using MySQL Workbench

1. Open MySQL Workbench
2. Click on your connection or create a new one:
   - **Hostname**: localhost
   - **Port**: 3306
   - **Username**: showtv
   - **Password**: showtv123

3. Go to **File** → **Open SQL Script**
4. Select `MYSQL_SETUP_DUMP.sql`
5. Click the **Execute** button (⚡)

### Method 3: Using MySQL directly

```bash
mysql -u showtv -p showtv -e "SOURCE /path/to/MYSQL_SETUP_DUMP.sql"
```

## ✅ Step 4: Verify the Import

```bash
mysql -u showtv -p showtv
```

Run these queries to verify your data:

```sql
-- Check tables
SHOW TABLES;

-- Count shows
SELECT COUNT(*) as total_shows FROM shows;

-- Count episodes
SELECT COUNT(*) as total_episodes FROM episodes;

-- Count users
SELECT COUNT(*) as total_users FROM users;

-- List all shows
SELECT id, title FROM shows LIMIT 10;

-- Verify migrations
SELECT migration, batch FROM migrations ORDER BY batch DESC LIMIT 5;

EXIT;
```

## 🔧 Step 5: Update Laravel Configuration

Update your `.env` file in the `showtv` directory:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=showtv123
```

### For Docker MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=mysql-showtv
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=showtv123
```

### For Remote MySQL Server:
```env
DB_CONNECTION=mysql
DB_HOST=your.mysql.server.com
DB_PORT=3306
DB_DATABASE=showtv
DB_USERNAME=showtv
DB_PASSWORD=your_password
```

## 🔄 Step 6: Test the Connection

Navigate to the Laravel app directory and test the database connection:

```bash
cd /path/to/showtv_complete/showtv

# Test connection (Laravel will try to connect to the DB)
php artisan tinker
>>> DB::connection()->getPDO()
>>> exit()
```

You should see no errors. If there's an error, verify your `.env` credentials.

## 🌐 Step 7: Run Laravel Migrations (Optional)

If you want to ensure all migrations are registered, run:

```bash
cd showtv
php artisan migrate --force
```

⚠️ This is safe because the tables already exist from the dump.

## 🧹 Step 8: Clear Cache and Restart (Recommended)

```bash
cd showtv

# Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:cache
php artisan view:cache

# If using file system storage
php artisan storage:link
```

## 🎯 Step 9: Start the Application

```bash
cd showtv

# Start the Laravel development server
php artisan serve

# Open in browser
# http://127.0.0.1:8000
```

## 🧪 Test the Application

1. **Login**: Visit `http://127.0.0.1:8000/login`
   - Email: `admin@showtv.com`
   - Password: `admin123`

2. **Browse Shows**: Click on "المسلسلات" (Shows)

3. **Watch an Episode**: Click on any episode to verify video playback

4. **Check Database**: Verify the MySQL database contains your data

## 📊 MySQL Workbench Integration

### Open in MySQL Workbench:

1. **Open MySQL Workbench**
2. **Database** → **Connect to Database**
3. Enter credentials:
   - **Hostname**: `localhost`
   - **Port**: `3306`
   - **Username**: `showtv`
   - **Password**: `showtv123`
4. **Test Connection** → Click OK
5. You can now browse all tables visually

### Browse Your Data:

In Workbench, expand the left panel:
- `showtv` database
  - ├─ Tables
  - │  ├─ shows
  - │  ├─ episodes
  - │  ├─ users
  - │  ├─ episode_user_likes
  - │  └─ (more tables...)

## 🔍 Troubleshooting

### "Access denied for user 'showtv'@'localhost'"

**Solution**: The password in `.env` doesn't match what you set in MySQL.

```bash
# Reset the password
mysql -u root -p
ALTER USER 'showtv'@'localhost' IDENTIFIED BY 'showtv123';
FLUSH PRIVILEGES;
EXIT;
```

### "Unknown database 'showtv'"

**Solution**: The database wasn't created or the import failed.

```bash
# Create it manually
mysql -u root -p
CREATE DATABASE showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Then import the dump
mysql -u showtv -p showtv < MYSQL_SETUP_DUMP.sql
```

### "Port 3306 is already in use"

**Solution**: Either MySQL is running on a different port, or another service is using 3306.

```bash
# Check what's using port 3306
sudo lsof -i :3306

# Find your MySQL port
mysql -u root -p
SHOW VARIABLES LIKE 'port';
```

Update `.env` with the correct port:
```env
DB_PORT=3307  # Use the actual port
```

### "Charset mismatch"

**Solution**: Ensure MySQL is using utf8mb4.

```bash
mysql -u root -p
ALTER DATABASE showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE shows CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE episodes CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

## 📦 Backup Your MySQL Database

```bash
# Create a backup
mysqldump -u showtv -p showtv > showtv_backup.sql

# Restore from backup
mysql -u showtv -p showtv < showtv_backup.sql
```

## 🔐 Security Recommendations

### Change Default Passwords

```bash
mysql -u root -p
ALTER USER 'root'@'localhost' IDENTIFIED BY 'new_root_password';
ALTER USER 'showtv'@'localhost' IDENTIFIED BY 'new_showtv_password';
FLUSH PRIVILEGES;
EXIT;
```

Update `.env` with the new password.

### Restrict User Privileges (Optional)

```bash
mysql -u root -p
# Instead of ALL PRIVILEGES, grant only what's needed:
GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, ALTER, DROP ON showtv.* TO 'showtv'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### Use Environment Variables (Production)

Never commit your `.env` file to version control. Use secrets management:

```bash
# Add to .gitignore
echo ".env" >> .gitignore

# Set environment variables in production
export DB_PASSWORD="your_secure_password"
export DB_HOST="your.production.server.com"
```

## 📋 Verification Checklist

- ✅ MySQL is running
- ✅ Database `showtv` created
- ✅ User `showtv` created with password
- ✅ Dump imported without errors
- ✅ `.env` file updated with MySQL credentials
- ✅ Laravel can connect to MySQL
- ✅ All tables appear in `SHOW TABLES;`
- ✅ Data visible in MySQL Workbench
- ✅ Application loads without errors
- ✅ Login works with `admin@showtv.com`
- ✅ Shows and episodes display correctly

## 📚 Useful MySQL Commands

```bash
# Connect to MySQL
mysql -u showtv -p showtv

# Show all databases
SHOW DATABASES;

# Use showtv database
USE showtv;

# List all tables
SHOW TABLES;

# Show table structure
DESCRIBE shows;
DESCRIBE episodes;

# Count records
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM shows;
SELECT COUNT(*) FROM episodes;

# Query users
SELECT id, name, email, role FROM users;

# Query shows with episode count
SELECT s.id, s.title, COUNT(e.id) as episode_count
FROM shows s
LEFT JOIN episodes e ON s.id = e.show_id
GROUP BY s.id;

# Exit MySQL
EXIT;
```

## 🆘 Need Help?

If you encounter issues:

1. **Check MySQL is running**:
   ```bash
   systemctl status mysql
   # or
   brew services list | grep mysql
   ```

2. **Check Laravel logs**:
   ```bash
   tail -f showtv/storage/logs/laravel.log
   ```

3. **Verify network connectivity**:
   ```bash
   ping localhost
   telnet localhost 3306
   ```

4. **Review `.env` file**:
   ```bash
   cat showtv/.env | grep DB_
   ```

---

**Need to switch back to SQLite?**

1. Change `.env` back to SQLite
2. Your original database still exists at `showtv/database/database.sqlite`
3. The application will work immediately without any additional setup

Happy streaming! 🎬
