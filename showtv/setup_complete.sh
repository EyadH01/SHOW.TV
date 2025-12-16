#!/bin/bash
echo "Setting up SHOW.TV Application..."
cd /home/ubuntu/showtv

# Start the Laravel development server
php artisan serve --host=0.0.0.0 --port=8000 &
echo "Laravel server started on port 8000"

echo "Setup complete!"
echo "Access the application at: http://localhost:8000"
echo ""
echo "Login credentials:"
echo "Admin: admin@showtv.com / admin123"
echo "User: user@showtv.com / user123"
