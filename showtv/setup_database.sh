#!/bin/bash

echo "🔧 Setting up SHOWTV Database..."

# Check if .env file exists
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from example..."
    cp .env.example .env
    echo "✅ .env file created. Please update database credentials and add YouTube API key."
else
    echo "✅ .env file already exists."
fi

echo ""
echo "📦 Installing Composer dependencies..."
composer install

echo ""
echo "🗃️ Generating application key..."
php artisan key:generate

echo ""
echo "🗄️ Clearing cache and config..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

echo ""
echo "📋 Running database migrations..."
php artisan migrate:fresh --seed

echo ""
echo "🎯 Creating admin user..."
php artisan tinker --execute="
\$user = new App\Models\User();
\$user->name = 'Admin';
\$user->email = 'admin@showtv.com';
\$user->password = Hash::make('admin123');
\$user->role = 'admin';
\$user->save();
echo 'Admin user created: admin@showtv.com / admin123' . PHP_EOL;
"

echo ""
echo "✅ Database setup complete!"
echo ""
echo "🔑 Next steps:"
echo "1. Update your .env file with:"
echo "   - Database credentials (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)"
echo "   - YouTube API key (YOUTUBE_API_KEY)"
echo ""
echo "2. Get YouTube API key from:"
echo "   - Go to https://console.cloud.google.com/"
echo "   - Create new project or select existing"
echo "   - Enable YouTube Data API v3"
echo "   - Create credentials (API Key)"
echo ""
echo "3. Start the application:"
echo "   php artisan serve"
echo ""
echo "4. Admin panel: http://localhost:8000/admin"
echo "   Login: admin@showtv.com / admin123"
