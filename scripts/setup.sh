#!/bin/bash

# Musaix Pro WordPress Setup Script
# This script sets up the complete development environment

echo "🎵 Setting up Musaix Pro WordPress Development Environment..."

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker first."
    exit 1
fi

# Check if .env exists
if [ ! -f ".env" ]; then
    echo "📝 Creating .env file from template..."
    cp .env.example .env
    echo "⚠️  Please edit .env file with your secure passwords before continuing."
    read -p "Press Enter to continue after editing .env file..."
fi

echo "🚀 Starting Docker containers..."
docker-compose up -d

echo "⏳ Waiting for WordPress to be ready..."
sleep 30

echo "📦 Installing WordPress core..."
docker-compose run --rm wpcli wp core install \
    --url=http://localhost:8080 \
    --title="Musaix Pro" \
    --admin_user=admin \
    --admin_password=admin123 \
    --admin_email=admin@example.com

echo "🔌 Installing essential plugins..."
docker-compose exec wordpress wp plugin install wordpress-importer --activate
docker-compose exec wordpress wp plugin install elementor --activate

# Check if XML file exists and import
if [ -f "musaixpro.WordPress.2025-10-28.xml" ]; then
    echo "📥 Copying WordPress export file..."
    docker cp musaixpro.WordPress.2025-10-28.xml musaixpro_wordpress:/var/www/html/
    
    echo "📊 Importing WordPress data..."
    docker-compose exec wordpress wp import musaixpro.WordPress.2025-10-28.xml --authors=create
    
    echo "🔧 Setting proper permissions..."
    docker-compose exec wordpress chown -R www-data:www-data /var/www/html
else
    echo "⚠️  WordPress export file not found. You can import it manually later."
fi

echo "✅ Setup complete!"
echo ""
echo "🌐 Your WordPress site is now available at:"
echo "   WordPress: http://localhost:8080"
echo "   phpMyAdmin: http://localhost:8081"
echo "   Login: admin / admin123"
echo ""
echo "🛠️  Useful commands:"
echo "   docker-compose logs -f wordpress  # View logs"
echo "   docker-compose down              # Stop services"
echo "   docker-compose up -d             # Start services"
echo ""
echo "📖 Check README.md for more information!"