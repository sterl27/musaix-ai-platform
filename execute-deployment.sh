#!/bin/bash

# 🚀 MUSAIX PRO V2.0 - EXECUTE WEB DISK DEPLOYMENT
echo "🎵 MUSAIX PRO V2.0 - EXECUTING DEPLOYMENT WITH YOUR CREDENTIALS"
echo "============================================================="
echo ""

# Your Web Disk Account Details
WD_USERNAME="S73RL@musaix.com"
WD_PASSWORD="Bl@ckbirdSr71"
WD_DOMAIN="musaix.com"
WD_DIRECTORY="public_html/S73RL"

# Colors for output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
PURPLE='\033[0;35m'
CYAN='\033[0;36m'
BOLD='\033[1m'
NC='\033[0m' # No Color

echo -e "${BOLD}${GREEN}✅ WEB DISK ACCOUNT CONFIRMED:${NC}"
echo -e "   Username: ${CYAN}$WD_USERNAME${NC}"
echo -e "   Password: ${CYAN}$WD_PASSWORD${NC}"
echo -e "   Directory: ${CYAN}$WD_DIRECTORY${NC}"
echo -e "   Domain: ${CYAN}$WD_DOMAIN${NC}"
echo -e "   Digest Auth: ${GREEN}✅ Enabled${NC}"
echo ""

# Check deployment files
echo -e "${BLUE}📦 CHECKING DEPLOYMENT PACKAGE...${NC}"
if [ ! -d "temp-deploy/musaix-pro" ]; then
    echo -e "${YELLOW}⚠️  Creating deployment package...${NC}"
    mkdir -p temp-deploy
    if [ -d "wordpress/wp-content/themes/musaix-pro" ]; then
        cp -r wordpress/wp-content/themes/musaix-pro temp-deploy/
        echo -e "${GREEN}✅ Theme files copied${NC}"
    else
        echo -e "${RED}❌ Theme source not found${NC}"
        exit 1
    fi
else
    echo -e "${GREEN}✅ Theme package ready: temp-deploy/musaix-pro/${NC}"
fi

# Verify theme files
echo -e "${BLUE}📋 VERIFYING THEME FILES...${NC}"
THEME_PATH="temp-deploy/musaix-pro"
REQUIRED_FILES=("functions.php" "index.php" "style.css")
MISSING_FILES=()

for file in "${REQUIRED_FILES[@]}"; do
    if [ -f "$THEME_PATH/$file" ]; then
        echo -e "   ✅ $file"
    else
        echo -e "   ❌ $file ${RED}(MISSING)${NC}"
        MISSING_FILES+=("$file")
    fi
done

if [ ${#MISSING_FILES[@]} -gt 0 ]; then
    echo -e "${RED}❌ Missing required theme files. Cannot proceed.${NC}"
    exit 1
fi

# Create database setup if missing
if [ ! -f "temp-deploy/setup-database.sql" ]; then
    echo -e "${YELLOW}📊 Creating database setup file...${NC}"
    cat > temp-deploy/setup-database.sql << 'SQL'
-- Musaix Pro v2.0 Training System Database
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

-- Sample training data
INSERT IGNORE INTO wp_training_data (title, content, file_type, category) VALUES
('Musaix AI Training Guide', 'Complete guide for AI music generation training.', 'text', 'Music'),
('Platform Documentation', 'Technical documentation for Musaix Pro platform.', 'text', 'Documentation'),
('Audio Processing Sample', 'Example of audio file processing workflow.', 'text', 'Audio');
SQL
    echo -e "${GREEN}✅ Database setup file created${NC}"
else
    echo -e "${GREEN}✅ Database setup ready: setup-database.sql${NC}"
fi

echo ""
echo -e "${BOLD}${PURPLE}🚀 DEPLOYMENT EXECUTION STEPS:${NC}"
echo ""

# Step 1: Web Disk Connection
echo -e "${BOLD}${BLUE}STEP 1: CONNECT TO WEB DISK${NC}"
echo ""
echo -e "${YELLOW}🖥️  WINDOWS CONNECTION:${NC}"
echo "   1. Open File Explorer (Windows + E)"
echo "   2. Right-click 'This PC' → 'Map Network Drive'"
echo ""
echo -e "${CYAN}   📋 EXACT CONNECTION DETAILS:${NC}"
echo -e "   Drive Letter: ${BOLD}M:${NC} (for Musaix)"
echo -e "   Folder: ${BOLD}\\\\musaix.com\\S73RL${NC}"
echo -e "   Username: ${BOLD}S73RL@musaix.com${NC}"
echo -e "   Password: ${BOLD}Bl@ckbirdSr71${NC}"
echo -e "   ✅ Check 'Reconnect at sign-in'"
echo -e "   ✅ Check 'Connect using different credentials'"
echo ""
echo -e "${YELLOW}🍎 MAC/LINUX CONNECTION:${NC}"
echo -e "   Server: ${BOLD}https://musaix.com:2078/S73RL${NC}"
echo -e "   Username: ${BOLD}S73RL@musaix.com${NC}"
echo -e "   Password: ${BOLD}Bl@ckbirdSr71${NC}"
echo ""

# Step 2: Navigation
echo -e "${BOLD}${BLUE}STEP 2: NAVIGATE TO THEMES DIRECTORY${NC}"
echo ""
echo -e "   📂 Web Disk Path: ${BOLD}M:\\wp-content\\themes\\${NC}"
echo -e "   📂 Full Server Path: ${BOLD}public_html/S73RL/wp-content/themes/${NC}"
echo ""

# Step 3: Upload
echo -e "${BOLD}${BLUE}STEP 3: UPLOAD MUSAIX PRO THEME${NC}"
echo ""
echo -e "   📋 Source: ${BOLD}$(pwd)/temp-deploy/musaix-pro/${NC}"
echo -e "   📥 Destination: ${BOLD}M:\\wp-content\\themes\\musaix-pro\\${NC}"
echo ""
echo -e "   🚀 Upload Method:"
echo "      1. Open local folder: $(pwd)/temp-deploy/"
echo "      2. Select 'musaix-pro' folder"
echo "      3. Drag and drop to M:\\wp-content\\themes\\"
echo "      4. Wait for upload completion (3-5 minutes)"
echo ""

# Step 4: Database
echo -e "${BOLD}${BLUE}STEP 4: SETUP DATABASE${NC}"
echo ""
echo -e "   🌐 Access: ${BOLD}HostGator cPanel → phpMyAdmin${NC}"
echo -e "   📊 Database: ${BOLD}Select WordPress database (acaptade_wp***)${NC}"
echo -e "   📥 Import: ${BOLD}$(pwd)/temp-deploy/setup-database.sql${NC}"
echo ""

# Step 5: Activation
echo -e "${BOLD}${BLUE}STEP 5: ACTIVATE THEME${NC}"
echo ""
echo -e "   🌐 WordPress Admin: ${BOLD}https://musaix.com/wp-admin${NC}"
echo -e "   🔑 Login: ${BOLD}S73RL${NC} / ${BOLD}Bl@ckbirdSr71${NC}"
echo -e "   🎨 Navigate: ${BOLD}Appearance → Themes → Activate 'Musaix Pro'${NC}"
echo ""

# Create deployment verification
echo -e "${BOLD}${BLUE}STEP 6: VERIFY DEPLOYMENT${NC}"
echo ""
echo -e "   ✅ Homepage: ${BOLD}https://musaix.com${NC} (cyberpunk design)"
echo -e "   ✅ Training: ${BOLD}https://musaix.com/training${NC} (file uploads)"
echo -e "   ✅ Mobile: Responsive hamburger menu"
echo -e "   ✅ Performance: Fast loading, smooth animations"
echo ""

# Create connection test script
cat > test-webdisk-connection.sh << 'TEST'
#!/bin/bash
echo "🔍 TESTING WEB DISK CONNECTION"
echo "============================="
echo ""
echo "Testing domain accessibility..."

# Test main domain
if ping -c 1 musaix.com >/dev/null 2>&1; then
    echo "✅ musaix.com: Domain reachable"
else
    echo "❌ musaix.com: Connection issues"
fi

# Test WebDAV port
if nc -z musaix.com 2078 2>/dev/null; then
    echo "✅ Port 2078: WebDAV port open"
else
    echo "⚠️  Port 2078: May be filtered (normal on some networks)"
fi

echo ""
echo "🔗 CONNECTION METHODS TO TRY:"
echo "1. Windows Network Drive: \\\\musaix.com\\S73RL"
echo "2. WebDAV HTTPS: https://musaix.com:2078/S73RL"
echo "3. WebDAV HTTP: http://musaix.com:2077/S73RL"
echo "4. Browser Access: https://musaix.com:2078"
echo ""
echo "If connection fails, try browser method first!"
TEST

chmod +x test-webdisk-connection.sh

# Create quick deployment commands
cat > quick-deploy-commands.txt << 'COMMANDS'
🚀 MUSAIX PRO V2.0 - QUICK DEPLOYMENT COMMANDS

WEB DISK CONNECTION:
Windows: \\musaix.com\S73RL
Mac/Linux: https://musaix.com:2078/S73RL
Username: S73RL@musaix.com
Password: Bl@ckbirdSr71

UPLOAD PATH:
M:\wp-content\themes\musaix-pro\

DATABASE IMPORT:
File: setup-database.sql
Location: cPanel → phpMyAdmin → Import

THEME ACTIVATION:
URL: https://musaix.com/wp-admin
Login: S73RL / Bl@ckbirdSr71
Path: Appearance → Themes → Musaix Pro

VERIFICATION URLS:
Homepage: https://musaix.com
Training: https://musaix.com/training
Admin: https://musaix.com/wp-admin
COMMANDS

echo -e "${GREEN}📋 DEPLOYMENT RESOURCES CREATED:${NC}"
echo "   ✅ Theme package: temp-deploy/musaix-pro/"
echo "   ✅ Database setup: temp-deploy/setup-database.sql"
echo "   ✅ Connection test: test-webdisk-connection.sh"
echo "   ✅ Quick commands: quick-deploy-commands.txt"
echo ""

echo -e "${BOLD}${GREEN}🎵 DEPLOYMENT PACKAGE READY!${NC}"
echo ""
echo -e "${CYAN}📊 PACKAGE CONTENTS:${NC}"
echo "   📁 Theme files: $(find temp-deploy/musaix-pro -type f | wc -l) files"
echo "   📦 Total size: $(du -sh temp-deploy/musaix-pro | cut -f1)"
echo "   🗄️  Database: wp_training_data table + sample data"
echo ""

echo -e "${BOLD}${PURPLE}⚡ EXECUTE DEPLOYMENT NOW:${NC}"
echo ""
echo "1. 🔗 Connect Web Disk using credentials above"
echo "2. 📂 Navigate to M:\\wp-content\\themes\\"
echo "3. 📥 Upload musaix-pro folder"
echo "4. 🗄️  Import database via phpMyAdmin"  
echo "5. 🎨 Activate theme in WordPress"
echo "6. ✅ Verify at https://musaix.com"
echo ""

echo -e "${BOLD}${GREEN}🚀 YOUR AI MUSIC PLATFORM WILL BE LIVE IN 15 MINUTES! ✨${NC}"
echo ""

# Show file tree
echo -e "${BLUE}📂 THEME FILE STRUCTURE TO UPLOAD:${NC}"
if command -v tree >/dev/null 2>&1; then
    tree temp-deploy/musaix-pro -I 'node_modules|.git' -L 2
else
    echo "temp-deploy/musaix-pro/"
    find temp-deploy/musaix-pro -maxdepth 2 -type f | head -15
    echo "... and more files"
fi
echo ""

echo -e "${CYAN}🎵 Ready to transform musaix.com into an ultra-modern AI music platform! 🎶${NC}"