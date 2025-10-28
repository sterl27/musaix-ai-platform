# Musaix.com Deployment Instructions

## 🚀 Deployment Package Contents

- `files/` - WordPress files ready for upload
- `database/` - Database export file
- `scripts/` - Helper scripts for deployment

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
1. Connect to: 
2. Username: 
3. Upload files to: public_html
4. Ensure proper permissions (755 for directories, 644 for files)

## 🗄️ Database Deployment

### Using phpMyAdmin
1. Login to HostGator cPanel
2. Open phpMyAdmin
3. Select your database: 
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
```
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
```

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
