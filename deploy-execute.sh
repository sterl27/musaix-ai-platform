#!/bin/bash

echo "🚀 EXECUTING MUSAIX.COM DEPLOYMENT"
echo "=================================="
echo ""

# Load configuration
if [ ! -f ".deployment-config" ]; then
    echo "❌ Configuration file not found!"
    echo "Please run ./deploy-setup.sh first"
    exit 1
fi

source .deployment-config

echo "🔄 Starting deployment with saved configuration..."
echo ""

# Create deployment directories
mkdir -p deployment/{files,database,backups}

case $DEPLOY_OPTION in
    1|3) # Files deployment
        echo "📁 PREPARING FILES FOR DEPLOYMENT"
        echo "================================="
        echo ""
        
        # Export WordPress files from container
        echo "📦 Extracting WordPress files from container..."
        docker-compose exec wordpress tar -czf /tmp/wordpress-files.tar.gz -C /var/www/html \
            --exclude='wp-config.php' \
            --exclude='*.log' \
            --exclude='.htaccess' \
            .
        
        # Copy files to local deployment directory
        docker cp musaixpro_wordpress:/tmp/wordpress-files.tar.gz deployment/files/
        
        cd deployment/files
        tar -xzf wordpress-files.tar.gz
        rm wordpress-files.tar.gz
        cd ../..
        
        echo "✅ WordPress files prepared"
        echo ""
        
        # Create production wp-config.php
        echo "⚙️ Creating production wp-config.php..."
        cat > deployment/files/wp-config.php << EOF
<?php
/**
 * WordPress configuration for musaix.com production
 */

// Database settings
define('DB_NAME', '$DB_NAME');
define('DB_USER', '$DB_USER');
define('DB_PASSWORD', '$DB_PASS');
define('DB_HOST', '$DB_HOST');
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

// WordPress URLs
define('WP_HOME','https://musaix.com');
define('WP_SITEURL','https://musaix.com');

// Security keys (you should regenerate these)
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// WordPress table prefix
\$table_prefix = 'wp_';

// WordPress debugging (disable in production)
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Force SSL
define('FORCE_SSL_ADMIN', true);

// Automatic updates
define('WP_AUTO_UPDATE_CORE', true);

// Memory limit
define('WP_MEMORY_LIMIT', '256M');

/* That's all, stop editing! Happy publishing. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

require_once(ABSPATH . 'wp-settings.php');
EOF
        
        echo "✅ Production wp-config.php created"
        echo ""
        ;;
esac

case $DEPLOY_OPTION in
    2|3) # Database deployment
        echo "🗄️ PREPARING DATABASE FOR DEPLOYMENT"
        echo "==================================="
        echo ""
        
        # Export database
        echo "📊 Exporting WordPress database..."
        docker-compose exec db mysqldump -u wordpress -pwordpress_password_123 musaixpro_wp > deployment/database/musaixpro-export.sql
        
        # Update URLs in database export
        echo "🔄 Updating URLs for production..."
        sed -i 's|http://localhost:8080|https://musaix.com|g' deployment/database/musaixpro-export.sql
        sed -i 's|localhost:8080|musaix.com|g' deployment/database/musaixpro-export.sql
        
        echo "✅ Database export prepared with updated URLs"
        echo ""
        ;;
esac

# Generate deployment package (Option 4) or all options
echo "📦 CREATING DEPLOYMENT PACKAGE"
echo "=============================="
echo ""

# Create comprehensive deployment instructions
cat > deployment/DEPLOYMENT_INSTRUCTIONS.md << EOF
# Musaix.com Deployment Instructions

## 🚀 Deployment Package Contents

- \`files/\` - WordPress files ready for upload
- \`database/\` - Database export file
- \`scripts/\` - Helper scripts for deployment

## 📋 Pre-Deployment Checklist

### 1. Backup Current Site
- Download current WordPress files
- Export current database via phpMyAdmin
- Save backups in a safe location

### 2. HostGator cPanel Access
- Login to your HostGator cPanel
- Access File Manager
- Access phpMyAdmin

## 🗂️ File Deployment

### Method 1: cPanel File Manager
1. Login to HostGator cPanel
2. Open File Manager
3. Navigate to public_html
4. Upload wordpress-files.zip
5. Extract files
6. Delete zip file

### Method 2: FTP Upload
1. Connect to: $FTP_HOST
2. Username: $FTP_USER
3. Upload files to: $WEB_ROOT
4. Ensure proper permissions (755 for directories, 644 for files)

## 🗄️ Database Deployment

### Using phpMyAdmin
1. Login to HostGator cPanel
2. Open phpMyAdmin
3. Select your database: $DB_NAME
4. Click "Import" tab
5. Upload: musaixpro-export.sql
6. Click "Go" to import

### Important Notes
- The database export has URLs updated for production
- User passwords and settings are preserved
- Your local admin accounts will be available

## ⚙️ Configuration Updates

### wp-config.php
- A production wp-config.php is included
- Update database credentials if different
- Regenerate security keys: https://api.wordpress.org/secret-key/1.1/salt/

### .htaccess (if needed)
Create in public_html root:
\`\`\`
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress

# Force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://musaix.com%{REQUEST_URI} [L,R=301]
\`\`\`

## 🔧 Post-Deployment Steps

1. **Test the site**: Visit https://musaix.com
2. **Login to admin**: https://musaix.com/wp-admin
3. **Update permalinks**: Settings → Permalinks → Save
4. **Check plugins**: Activate any needed plugins
5. **Test functionality**: Verify all features work
6. **Update DNS** (if needed): Ensure domain points to HostGator

## 🛡️ Security Checklist

- [ ] Update WordPress to latest version
- [ ] Update all plugins
- [ ] Change default admin passwords
- [ ] Install security plugins (Wordfence, etc.)
- [ ] Enable SSL certificate
- [ ] Set up regular backups

## 🆘 Rollback Instructions

If something goes wrong:
1. Restore backed up files via File Manager
2. Import backed up database via phpMyAdmin
3. Update wp-config.php with original settings

## 📞 Support

- HostGator Support: Available 24/7
- WordPress Codex: https://codex.wordpress.org/
- Contact: Your development team

## 🎵 Musaix Pro Features to Test

After deployment, verify these work:
- [ ] AI Tweet Classifier
- [ ] Blog Post Generator  
- [ ] Business Strategy Advisor
- [ ] AI Chatbots (aipkit_chatbot)
- [ ] AI Forms (aipkit_ai_form)
- [ ] Elementor page designs
- [ ] Media uploads and galleries
- [ ] Contact forms
- [ ] User registration/login

Good luck with your deployment! 🚀
EOF

# Create deployment scripts
mkdir -p deployment/scripts

# Create URL update script
cat > deployment/scripts/update-urls.sql << EOF
-- Update WordPress URLs for musaix.com
UPDATE wp_options SET option_value = 'https://musaix.com' WHERE option_name = 'home';
UPDATE wp_options SET option_value = 'https://musaix.com' WHERE option_name = 'siteurl';

-- Update post content URLs
UPDATE wp_posts SET post_content = REPLACE(post_content, 'http://localhost:8080', 'https://musaix.com');
UPDATE wp_posts SET post_content = REPLACE(post_content, 'localhost:8080', 'musaix.com');

-- Update meta values
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'http://localhost:8080', 'https://musaix.com');
UPDATE wp_postmeta SET meta_value = REPLACE(meta_value, 'localhost:8080', 'musaix.com');

-- Update comments
UPDATE wp_comments SET comment_content = REPLACE(comment_content, 'http://localhost:8080', 'https://musaix.com');

-- Flush rewrite rules (run this in WordPress admin after deployment)
-- Go to Settings → Permalinks and click Save
EOF

# Create file archive if files were prepared
if [ -d "deployment/files" ]; then
    echo "📦 Creating WordPress files archive..."
    cd deployment/files
    zip -r ../wordpress-files.zip . -x "*.log" "wp-config-sample.php"
    cd ../..
    echo "✅ Created: deployment/wordpress-files.zip"
fi

echo ""
echo "✅ DEPLOYMENT PACKAGE READY!"
echo "============================"
echo ""
echo "📁 Package Location: ./deployment/"
echo ""
echo "📋 Package Contents:"
[ -f "deployment/wordpress-files.zip" ] && echo "   ✅ wordpress-files.zip - WordPress files"
[ -f "deployment/database/musaixpro-export.sql" ] && echo "   ✅ musaixpro-export.sql - Database export"
echo "   ✅ wp-config.php - Production configuration"
echo "   ✅ DEPLOYMENT_INSTRUCTIONS.md - Complete guide"
echo "   ✅ scripts/update-urls.sql - URL update queries"
echo ""
echo "📖 Next Steps:"
echo "1. Read: deployment/DEPLOYMENT_INSTRUCTIONS.md"
echo "2. Backup your current live site"
echo "3. Upload files to HostGator"
echo "4. Import database"
echo "5. Test your site"
echo ""
echo "🎵 Your Musaix Pro site is ready for deployment!"

# Clean up sensitive config
if [[ $DEPLOY_OPTION =~ ^[13]$ ]]; then
    echo ""
    echo "🔐 Cleaning up local credentials..."
    rm -f .deployment-config
    echo "✅ Local credentials removed for security"
fi