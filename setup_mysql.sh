#!/bin/bash

# SHOW.TV MySQL Automated Setup Script
# This script automates the MySQL database setup for SHOW.TV

set -e

echo "==============================================="
echo "  SHOW.TV MySQL Database Setup Script"
echo "==============================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Check if MySQL is installed
echo -e "${BLUE}[1/7]${NC} Checking MySQL installation..."
if ! command -v mysql &> /dev/null; then
    echo -e "${RED}❌ MySQL is not installed${NC}"
    echo "Install MySQL using:"
    echo "  Ubuntu/Debian: sudo apt-get install mysql-server"
    echo "  macOS: brew install mysql"
    exit 1
fi
echo -e "${GREEN}✅ MySQL found: $(mysql --version)${NC}"
echo ""

# Get MySQL root password
echo -e "${BLUE}[2/7]${NC} Testing MySQL connection..."
read -sp "Enter MySQL root password: " ROOT_PASSWORD
echo ""

# Test connection
if ! mysql -u root -p"$ROOT_PASSWORD" -e "SELECT 1" &> /dev/null; then
    echo -e "${RED}❌ Failed to connect to MySQL${NC}"
    echo "Please verify your root password and try again."
    exit 1
fi
echo -e "${GREEN}✅ Connected to MySQL successfully${NC}"
echo ""

# Get custom password for showtv user (optional)
echo -e "${BLUE}[3/7]${NC} Setting up SHOW.TV user..."
echo "Default password: showtv123"
read -p "Enter password for 'showtv' user (press Enter for default): " SHOWTV_PASSWORD
SHOWTV_PASSWORD=${SHOWTV_PASSWORD:-showtv123}
echo ""

# Create database and user
echo -e "${BLUE}[4/7]${NC} Creating database and user..."
mysql -u root -p"$ROOT_PASSWORD" << EOF
CREATE DATABASE IF NOT EXISTS showtv CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'showtv'@'localhost' IDENTIFIED BY '$SHOWTV_PASSWORD';
GRANT ALL PRIVILEGES ON showtv.* TO 'showtv'@'localhost';
FLUSH PRIVILEGES;
EOF
echo -e "${GREEN}✅ Database and user created${NC}"
echo ""

# Import the dump
echo -e "${BLUE}[5/7]${NC} Importing database dump..."
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
if [ ! -f "$SCRIPT_DIR/MYSQL_SETUP_DUMP.sql" ]; then
    echo -e "${RED}❌ MYSQL_SETUP_DUMP.sql not found in $SCRIPT_DIR${NC}"
    exit 1
fi

mysql -u showtv -p"$SHOWTV_PASSWORD" showtv < "$SCRIPT_DIR/MYSQL_SETUP_DUMP.sql"
echo -e "${GREEN}✅ Database imported successfully${NC}"
echo ""

# Verify the import
echo -e "${BLUE}[6/7]${NC} Verifying import..."
SHOW_COUNT=$(mysql -u showtv -p"$SHOWTV_PASSWORD" -N showtv -e "SELECT COUNT(*) FROM shows;")
EPISODE_COUNT=$(mysql -u showtv -p"$SHOWTV_PASSWORD" -N showtv -e "SELECT COUNT(*) FROM episodes;")
USER_COUNT=$(mysql -u showtv -p"$SHOWTV_PASSWORD" -N showtv -e "SELECT COUNT(*) FROM users;")

echo "  Shows: $SHOW_COUNT"
echo "  Episodes: $EPISODE_COUNT"
echo "  Users: $USER_COUNT"
echo -e "${GREEN}✅ Data verified${NC}"
echo ""

# Update .env file
echo -e "${BLUE}[7/7]${NC} Updating .env configuration..."
ENV_FILE="$SCRIPT_DIR/showtv/.env"

if [ ! -f "$ENV_FILE" ]; then
    echo -e "${RED}❌ .env file not found at $ENV_FILE${NC}"
    echo "Please manually update your .env with these values:"
    echo ""
    echo "  DB_CONNECTION=mysql"
    echo "  DB_HOST=127.0.0.1"
    echo "  DB_PORT=3306"
    echo "  DB_DATABASE=showtv"
    echo "  DB_USERNAME=showtv"
    echo "  DB_PASSWORD=$SHOWTV_PASSWORD"
else
    # Backup original .env
    cp "$ENV_FILE" "$ENV_FILE.backup"
    
    # Update .env using sed (cross-platform compatible)
    sed -i.bak "s/^DB_CONNECTION=.*/DB_CONNECTION=mysql/" "$ENV_FILE"
    sed -i.bak "s/^DB_HOST=.*/DB_HOST=127.0.0.1/" "$ENV_FILE"
    sed -i.bak "s/^DB_PORT=.*/DB_PORT=3306/" "$ENV_FILE"
    sed -i.bak "s/^DB_DATABASE=.*/DB_DATABASE=showtv/" "$ENV_FILE"
    sed -i.bak "s/^DB_USERNAME=.*/DB_USERNAME=showtv/" "$ENV_FILE"
    sed -i.bak "s/^DB_PASSWORD=.*/DB_PASSWORD=$SHOWTV_PASSWORD/" "$ENV_FILE"
    
    # Clean up backup files created by sed on macOS
    rm -f "$ENV_FILE.bak"
    
    echo -e "${GREEN}✅ .env file updated (backup saved as .env.backup)${NC}"
fi
echo ""

echo "==============================================="
echo -e "${GREEN}✅ MySQL Setup Complete!${NC}"
echo "==============================================="
echo ""
echo "📝 Configuration Summary:"
echo "  Database: showtv"
echo "  User: showtv"
echo "  Password: $SHOWTV_PASSWORD"
echo "  Host: localhost"
echo "  Port: 3306"
echo ""
echo "🚀 Next steps:"
echo "  1. Clear Laravel cache:"
echo "     cd $SCRIPT_DIR/showtv"
echo "     php artisan cache:clear"
echo "     php artisan config:clear"
echo ""
echo "  2. Start the application:"
echo "     php artisan serve"
echo ""
echo "  3. Open in browser:"
echo "     http://127.0.0.1:8000"
echo ""
echo "  4. Login with:"
echo "     Email: admin@showtv.com"
echo "     Password: admin123"
echo ""
echo "📚 For troubleshooting, see: $SCRIPT_DIR/MYSQL_SETUP_GUIDE.md"
echo ""
