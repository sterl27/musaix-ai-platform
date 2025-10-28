#!/bin/bash

# Import WordPress XML data
# Usage: ./import-data.sh

echo "📊 Importing Musaix Pro WordPress data..."

# Check if containers are running
if ! docker-compose ps | grep -q "Up"; then
    echo "❌ WordPress containers are not running. Starting them..."
    docker-compose up -d
    echo "⏳ Waiting for services to be ready..."
    sleep 30
fi

# Check if XML file exists
if [ ! -f "../musaixpro.WordPress.2025-10-28.xml" ]; then
    echo "❌ WordPress export file not found!"
    echo "Please ensure musaixpro.WordPress.2025-10-28.xml is in the project root."
    exit 1
fi

# Copy XML file to container
echo "📥 Copying XML file to WordPress container..."
docker cp ../musaixpro.WordPress.2025-10-28.xml musaixpro_wordpress:/var/www/html/

# Install WordPress Importer if not already installed
echo "🔌 Installing WordPress Importer plugin..."
docker-compose exec wordpress wp plugin install wordpress-importer --activate

# Import the data
echo "📊 Starting import process..."
docker-compose exec wordpress wp import musaixpro.WordPress.2025-10-28.xml \
    --authors=create \
    --skip=attachment

# Set proper permissions
echo "🔧 Setting file permissions..."
docker-compose exec wordpress chown -R www-data:www-data /var/www/html

# Flush rewrite rules
echo "🔄 Flushing rewrite rules..."
docker-compose exec wordpress wp rewrite flush

echo "✅ Import complete!"
echo "🌐 Check your site at http://localhost:8080"