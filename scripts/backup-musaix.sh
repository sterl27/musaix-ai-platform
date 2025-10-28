#!/bin/bash

# 🛡️ MUSAIX.COM AUTOMATED BACKUP SCRIPT
# Run this on your HostGator server: ssh acaptade@192.254.189.236

echo "💾 MUSAIX.COM - AUTOMATED BACKUP SYSTEM"
echo "======================================="
echo ""

# Configuration
BACKUP_DIR="$HOME/musaix_backups"
SITE_DIR="$HOME/public_html"
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_NAME="musaix_backup_$DATE"

# Extract database credentials from wp-config.php
cd "$SITE_DIR" || { echo "❌ Cannot access site directory"; exit 1; }

if [ -f wp-config.php ]; then
    DB_NAME=$(grep "DB_NAME" wp-config.php | cut -d "'" -f 4)
    DB_USER=$(grep "DB_USER" wp-config.php | cut -d "'" -f 4)
    DB_PASS=$(grep "DB_PASSWORD" wp-config.php | cut -d "'" -f 4)
    DB_HOST=$(grep "DB_HOST" wp-config.php | cut -d "'" -f 4)
    
    echo "🗄️ Database: $DB_NAME"
    echo "👤 User: $DB_USER"
    echo "🖥️ Host: $DB_HOST"
else
    echo "❌ wp-config.php not found"
    exit 1
fi

echo ""
echo "📁 CREATING BACKUP DIRECTORY"
echo "============================"

# Create backup directory structure
mkdir -p "$BACKUP_DIR/$BACKUP_NAME"/{files,database,logs}
echo "✅ Backup directory created: $BACKUP_DIR/$BACKUP_NAME"

echo ""
echo "🗄️ DATABASE BACKUP"
echo "=================="

echo "📊 Backing up database: $DB_NAME"

# Create database backup
mysqldump -h "$DB_HOST" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" > "$BACKUP_DIR/$BACKUP_NAME/database/musaix_database.sql"

if [ $? -eq 0 ]; then
    echo "✅ Database backup completed"
    
    # Get database size
    DB_SIZE=$(du -sh "$BACKUP_DIR/$BACKUP_NAME/database/musaix_database.sql" | cut -f1)
    echo "📊 Database backup size: $DB_SIZE"
else
    echo "❌ Database backup failed"
fi

echo ""
echo "📁 FILES BACKUP"
echo "==============="

echo "📦 Backing up WordPress files..."

# Create files backup (excluding cache and temporary files)
cd "$SITE_DIR" || exit 1

tar -czf "$BACKUP_DIR/$BACKUP_NAME/files/musaix_files.tar.gz" \
    --exclude="wp-content/cache/*" \
    --exclude="wp-content/uploads/cache/*" \
    --exclude="*.log" \
    --exclude="error_log" \
    --exclude=".tmp" \
    --exclude="*.tmp" \
    . 

if [ $? -eq 0 ]; then
    echo "✅ Files backup completed"
    
    # Get files backup size
    FILES_SIZE=$(du -sh "$BACKUP_DIR/$BACKUP_NAME/files/musaix_files.tar.gz" | cut -f1)
    echo "📦 Files backup size: $FILES_SIZE"
else
    echo "❌ Files backup failed"
fi

echo ""
echo "📝 CONFIGURATION BACKUP"
echo "======================"

# Backup important configuration files separately
CONFIG_FILES=(
    "wp-config.php"
    ".htaccess"
    "robots.txt"
)

mkdir -p "$BACKUP_DIR/$BACKUP_NAME/config"

for config_file in "${CONFIG_FILES[@]}"; do
    if [ -f "$config_file" ]; then
        cp "$config_file" "$BACKUP_DIR/$BACKUP_NAME/config/"
        echo "✅ Backed up: $config_file"
    else
        echo "⚠️ Not found: $config_file"
    fi
done

echo ""
echo "📊 BACKUP INFORMATION"
echo "===================="

# Create backup info file
cat > "$BACKUP_DIR/$BACKUP_NAME/backup_info.txt" << EOF
🎵 MUSAIX.COM BACKUP INFORMATION
==============================

Backup Date: $(date)
Backup Name: $BACKUP_NAME
Site URL: https://musaix.com

DATABASE INFO:
- Name: $DB_NAME
- User: $DB_USER
- Host: $DB_HOST
- Backup Size: $DB_SIZE

FILES INFO:
- Source: $SITE_DIR
- Backup Size: $FILES_SIZE
- Excluded: cache files, logs, temporary files

WORDPRESS INFO:
- Version: $(grep "wp_version = " wp-includes/version.php | cut -d "'" -f 2 2>/dev/null || echo "Unknown")
- Admin User: S73RL
- Plugins: $(ls wp-content/plugins 2>/dev/null | wc -l) installed
- Themes: $(ls wp-content/themes 2>/dev/null | wc -l) installed

BACKUP CONTENTS:
├── database/
│   └── musaix_database.sql
├── files/
│   └── musaix_files.tar.gz
├── config/
│   ├── wp-config.php
│   ├── .htaccess
│   └── robots.txt (if exists)
├── logs/
└── backup_info.txt

RESTORE INSTRUCTIONS:
1. Extract files: tar -xzf files/musaix_files.tar.gz
2. Import database: mysql -u USER -p DATABASE < database/musaix_database.sql
3. Update wp-config.php with current database credentials
4. Set file permissions: directories 755, files 644
5. Test site functionality

SECURITY NOTE:
This backup contains sensitive information including database passwords.
Store securely and delete old backups regularly.
EOF

echo "✅ Backup information file created"

echo ""
echo "📋 BACKUP LOGS"
echo "=============="

# Copy recent error logs if they exist
LOG_FILES=(
    "error_log"
    "wp-content/debug.log"
)

for log_file in "${LOG_FILES[@]}"; do
    if [ -f "$log_file" ] && [ -s "$log_file" ]; then
        cp "$log_file" "$BACKUP_DIR/$BACKUP_NAME/logs/"
        echo "✅ Copied log: $log_file"
    fi
done

echo ""
echo "🧹 CLEANUP OLD BACKUPS"
echo "======================"

# Keep only last 7 backups
cd "$BACKUP_DIR" || exit 1
ls -dt musaix_backup_* | tail -n +8 | xargs rm -rf 2>/dev/null

REMAINING_BACKUPS=$(ls -d musaix_backup_* 2>/dev/null | wc -l)
echo "🗂️ Keeping $REMAINING_BACKUPS most recent backups"

echo ""
echo "✅ BACKUP COMPLETE!"
echo "==================="

# Calculate total backup size
TOTAL_SIZE=$(du -sh "$BACKUP_DIR/$BACKUP_NAME" | cut -f1)

echo ""
echo "📊 BACKUP SUMMARY:"
echo "  📅 Date: $(date)"
echo "  📁 Location: $BACKUP_DIR/$BACKUP_NAME"
echo "  💾 Total Size: $TOTAL_SIZE"
echo "  🗄️ Database: $DB_SIZE"
echo "  📦 Files: $FILES_SIZE"
echo ""
echo "🎵 Your Musaix Pro site backup is complete and secure!"
echo ""
echo "🔧 TO RESTORE THIS BACKUP:"
echo "  1. cd $BACKUP_DIR/$BACKUP_NAME"
echo "  2. Read backup_info.txt for detailed instructions"
echo "  3. Extract files and import database as needed"
echo ""
echo "⏰ AUTOMATE THIS BACKUP:"
echo "  Add to crontab: 0 2 * * * $HOME/backup-musaix.sh >/dev/null 2>&1"
echo "  (Runs daily at 2 AM)"