#!/bin/bash

# ShowTV Quick Setup Script
echo "🚀 ShowTV Quick Setup Script"
echo "=============================="

# Check if we're in the correct directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Please run this script from the showtv directory"
    exit 1
fi

echo "📋 Step 1: Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "📋 Step 2: Generating application key..."
php artisan key:generate

echo "📋 Step 3: Setting up environment..."
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo "✅ Created .env file from example"
else
    echo "✅ .env file already exists"
fi

echo "📋 Step 4: Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo "📋 Step 5: Creating storage link..."
php artisan storage:link

echo "📋 Step 6: Setting up database..."
echo "Please make sure MySQL is running and configured in .env file"
echo "Database configuration should be set before continuing..."

read -p "Press Enter to continue with database setup, or Ctrl+C to exit..."

echo "📋 Step 7: Running migrations..."
php artisan migrate --force

echo "📋 Step 8: Seeding database..."
php artisan db:seed --force

echo "📋 Step 9: Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "📋 Step 10: Setting permissions..."
chmod -R 755 storage bootstrap/cache

echo "🎉 Setup completed successfully!"
echo ""
echo "📋 Next steps:"
echo "1. Make sure your .env file has correct database credentials"
echo "2. Set up your email and API keys in .env file"
echo "3. Run 'npm install && npm run build' for frontend assets"
echo "4. Start the server with: php artisan serve"
echo ""
echo "🌐 Access your application at: http://localhost:8000"
echo "🔧 Admin panel at: http://localhost:8000/admin (after creating admin user)"
echo ""
echo "To create an admin user, run:"
echo "php artisan tinker"
echo '$user = new App\Models\User();'
echo '$user->name = "Admin";'
echo '$user->email = "admin@showtv.com";'
echo '$user->password = Hash::make("password");'
echo '$user->role = "admin";'
echo '$user->save();'
echo 'exit;'
echo ""
echo "📖 For detailed documentation, see: DOCUMENTATION_AR.md"
