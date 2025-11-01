#!/bin/bash

# 🚀 MUSAIX PRO V2.0 - HOSTGATOR DEPLOYMENT HELPER
echo "🎵 MUSAIX PRO V2.0 - DEPLOYMENT TO HOSTGATOR"
echo "=============================================="

# Check if we're in the right directory
if [ ! -f "docker-compose.yml" ]; then
    echo "❌ Error: Run this script from the wp/ directory"
    exit 1
fi

echo "📦 Creating deployment package..."

# Create deployment directory
mkdir -p deployment-package
cd deployment-package

# Copy theme files
echo "🎨 Packaging theme files..."
cp -r ../wordpress/wp-content/themes/musaix-pro ./
cp ../UPDATE-SUMMARY.md ./
cp ../HOSTGATOR-DEPLOYMENT-GUIDE.md ./

# Create database setup script
echo "🗄️ Creating database setup script..."
cat > setup-database.sql << 'EOF'
-- Musaix Pro v2.0 Database Setup
CREATE TABLE IF NOT EXISTS wp_training_data (
    id int(11) NOT NULL AUTO_INCREMENT,
    title varchar(255) NOT NULL,
    content longtext,
    file_type varchar(50),
    file_size int(11),
    category varchar(100),
    metadata json,
    created_at timestamp DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY category_idx (category),
    KEY created_at_idx (created_at),
    KEY file_type_idx (file_type)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
EOF

# Create installation instructions
echo "📋 Creating installation guide..."
cat > INSTALLATION-STEPS.txt << 'EOF'
🚀 MUSAIX PRO V2.0 - HOSTGATOR INSTALLATION STEPS

1. LOGIN TO CPANEL
   - Go to your HostGator customer portal
   - Access cPanel for musaix.com

2. UPLOAD THEME
   - File Manager → public_html/wp-content/themes/
   - Upload musaix-pro folder
   - Set permissions: folders 755, files 644

3. SETUP DATABASE
   - cPanel → phpMyAdmin
   - Select your WordPress database
   - Import setup-database.sql

4. ACTIVATE THEME
   - WordPress Admin → Appearance → Themes
   - Activate "Musaix Pro"

5. TEST FEATURES
   - Visit https://musaix.com
   - Test training page: https://musaix.com/training
   - Verify mobile responsiveness

✅ Your ultra-modern AI music platform is ready!
EOF

# Create archive
echo "📦 Creating final deployment archive..."
cd ..
tar -czf musaix-pro-v2-hostgator-deployment.tar.gz deployment-package/
rm -rf deployment-package

echo ""
echo "✅ DEPLOYMENT PACKAGE READY!"
echo "📦 File: musaix-pro-v2-hostgator-deployment.tar.gz"
echo ""
echo "🚀 NEXT STEPS:"
echo "1. Download: musaix-pro-v2-hostgator-deployment.tar.gz"
echo "2. Upload to HostGator via cPanel File Manager"
echo "3. Extract in public_html/"
echo "4. Follow INSTALLATION-STEPS.txt"
echo ""
echo "🎵 Your Musaix Pro v2.0 will be live shortly!"