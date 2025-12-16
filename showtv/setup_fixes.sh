#!/bin/bash

# SHOW.TV - Setup Script for Fixes and Improvements
# This script sets up the database and runs all necessary migrations

echo "🚀 SHOW.TV - Setup Script"
echo "=========================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if .env file exists
if [ ! -f .env ]; then
    echo -e "${RED}❌ .env file not found!${NC}"
    echo "Please copy .env.example to .env first:"
    echo "cp .env.example .env"
    exit 1
fi

echo -e "${YELLOW}📝 Step 1: Installing dependencies...${NC}"
composer install
npm install

echo -e "${YELLOW}🔑 Step 2: Generating application key...${NC}"
php artisan key:generate

echo -e "${YELLOW}🗄️  Step 3: Creating MySQL database...${NC}"
# Extract database credentials from .env
DB_HOST=$(grep DB_HOST .env | cut -d '=' -f2)
DB_DATABASE=$(grep DB_DATABASE .env | cut -d '=' -f2)
DB_USERNAME=$(grep DB_USERNAME .env | cut -d '=' -f2)
DB_PASSWORD=$(grep DB_PASSWORD .env | cut -d '=' -f2)

# Create database if it doesn't exist
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Database created successfully${NC}"
else
    echo -e "${YELLOW}⚠️  Database might already exist or MySQL is not running${NC}"
fi

echo -e "${YELLOW}🔄 Step 4: Running migrations...${NC}"
php artisan migrate --force

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Migrations completed successfully${NC}"
else
    echo -e "${RED}❌ Migration failed!${NC}"
    exit 1
fi

echo -e "${YELLOW}🔗 Step 5: Creating storage link...${NC}"
php artisan storage:link

echo -e "${YELLOW}🎨 Step 6: Building assets...${NC}"
npm run dev

echo -e "${YELLOW}🧹 Step 7: Clearing caches...${NC}"
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo ""
echo -e "${GREEN}✅ Setup completed successfully!${NC}"
echo ""
echo "🚀 To start the development server, run:"
echo "   php artisan serve"
echo ""
echo "📖 For more information, see FIXES_AND_IMPROVEMENTS.md"
echo ""
