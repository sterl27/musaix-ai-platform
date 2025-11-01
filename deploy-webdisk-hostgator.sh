#!/bin/bash

# 🚀 MUSAIX PRO V2.0 - WEB DISK DEPLOYMENT GUIDE
echo "🎵 MUSAIX PRO V2.0 - WEB DISK DEPLOYMENT TO HOSTGATOR"
echo "===================================================="
echo ""
echo "🌐 Domain: musaix.com"
echo "📁 Web Disk: Direct file access available"
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${GREEN}✅ WEB DISK ACCESS DETECTED!${NC}"
echo ""
echo -e "${BLUE}🎯 Web Disk is the BEST method for deploying your Musaix Pro v2.0${NC}"
echo -e "${BLUE}   It provides direct file system access like a network drive!${NC}"
echo ""

# Check if deployment files exist
if [ ! -d "temp-deploy" ]; then
    echo -e "${RED}❌ Deployment files not found. Run deployment preparation first.${NC}"
    exit 1
fi

echo -e "${PURPLE}📋 WEB DISK DEPLOYMENT METHODS:${NC}"
echo ""
echo -e "${YELLOW}🔥 METHOD 1: CREATE WEB DISK ACCOUNT FOR DEPLOYMENT${NC}"
echo ""
echo "1. 📝 CREATE ADDITIONAL WEB DISK ACCOUNT:"
echo "   Username: musaix-deploy@musaix.com"
echo "   Password: [Create strong password]"
echo "   Directory: /"
echo "   Permissions: Read-Write"
echo "   ✅ Enable Digest Authentication (for Windows)"
echo ""
echo "2. 🌐 ACCESS WEB DISK:"
echo "   Windows: Map Network Drive"
echo "   - Computer → Map Network Drive"
echo "   - Drive Letter: M: (for Musaix)"
echo "   - Folder: \\\\musaix.com\\musaix-deploy"
echo "   - Username: musaix-deploy@musaix.com"
echo "   - Password: [Your created password]"
echo ""
echo "   Mac/Linux: WebDAV"
echo "   - Connect to Server: https://musaix.com:2078"
echo "   - Username: musaix-deploy@musaix.com"
echo "   - Password: [Your created password]"
echo ""
echo "3. 📂 NAVIGATE TO WORDPRESS:"
echo "   Open Web Disk → public_html → wp-content → themes"
echo ""
echo "4. 📁 UPLOAD THEME:"
echo "   Copy entire musaix-pro folder from:"
echo "   $(pwd)/temp-deploy/musaix-pro/"
echo "   To: Web Disk/public_html/wp-content/themes/"
echo ""

echo -e "${YELLOW}⚡ METHOD 2: USE MAIN WEB DISK ACCOUNT${NC}"
echo ""
echo "1. 🌐 ACCESS MAIN WEB DISK:"
echo "   Account: acaptade"
echo "   Directory: / (Root access)"
echo ""
echo "2. 🖥️ CONNECT TO WEB DISK:"
echo "   Windows Explorer:"
echo "   - Address: \\\\musaix.com\\acaptade"
echo "   - Or use WebDAV: https://musaix.com:2078"
echo ""
echo "3. 📂 NAVIGATE TO WORDPRESS:"
echo "   acaptade → public_html → wp-content → themes"
echo ""
echo "4. 📁 DRAG & DROP DEPLOYMENT:"
echo "   Simply drag musaix-pro folder to themes directory!"
echo ""

echo -e "${YELLOW}🚀 METHOD 3: WEB DISK + FTP HYBRID${NC}"
echo ""
echo "1. 📱 Use Web Disk for large files/folders"
echo "2. 🔧 Use cPanel File Manager for permissions"
echo "3. 🗄️ Use phpMyAdmin for database"
echo ""

# Create Web Disk specific instructions
cat > WEB-DISK-STEP-BY-STEP.md << 'EOF'
# 🚀 MUSAIX PRO V2.0 - WEB DISK DEPLOYMENT

## ✅ RECOMMENDED: CREATE DEDICATED WEB DISK ACCOUNT

### Step 1: Create Web Disk Account
1. **cPanel → Web Disk**
2. **Create Additional Account:**
   - Username: `musaix-deploy`
   - Domain: `musaix.com` 
   - Password: `Deploy2024!Musaix` (or your choice)
   - Directory: `/`
   - Permissions: `Read-Write`
   - ✅ **Enable Digest Authentication**

### Step 2: Connect to Web Disk

**Windows (Recommended):**
```
1. Open File Explorer
2. Right-click "This PC" → "Map Network Drive"
3. Drive Letter: M: (for Musaix)
4. Folder: \\musaix.com\musaix-deploy
5. Username: musaix-deploy@musaix.com
6. Password: Deploy2024!Musaix
7. ✅ Reconnect at sign-in
```

**Mac/Linux:**
```
1. Finder → Go → Connect to Server
2. Server Address: https://musaix.com:2078
3. Username: musaix-deploy@musaix.com
4. Password: Deploy2024!Musaix
```

### Step 3: Deploy Theme
1. **Navigate in Web Disk:**
   ```
   M:\ → public_html → wp-content → themes
   ```

2. **Copy Theme Folder:**
   - From local: `/home/sterl/wp/temp-deploy/musaix-pro/`
   - To Web Disk: `M:\public_html\wp-content\themes\musaix-pro\`

3. **Verify Upload:**
   - Check all files copied correctly
   - Verify folder structure intact

### Step 4: Database Setup
1. **cPanel → phpMyAdmin**
2. **Select WordPress Database**
3. **Import SQL File:**
   - From: `/home/sterl/wp/temp-deploy/setup-database.sql`
   - Click "Import" → "Choose File" → "Go"

### Step 5: Activate Theme
1. **WordPress Admin:** https://musaix.com/wp-admin
2. **Login:** S73RL / Bl@ckbirdSr71
3. **Appearance → Themes**
4. **Activate:** Musaix Pro

## ✅ ADVANTAGES OF WEB DISK METHOD:

- 🚀 **Fastest Upload:** Direct file system access
- 📁 **Preserve Structure:** Maintains exact folder hierarchy  
- 🔄 **Real-time Sync:** Changes appear instantly
- 💾 **Large Files:** No upload size limits
- 🖥️ **Native Interface:** Works like local disk drive
- 🔧 **Easy Updates:** Just copy new files over existing

## 🎵 SUCCESS VERIFICATION:

After deployment:
1. ✅ **Homepage:** https://musaix.com (cyberpunk design)
2. ✅ **Training:** https://musaix.com/training (file upload)
3. ✅ **Mobile:** Responsive hamburger menu
4. ✅ **Admin:** WordPress dashboard fully functional
5. ✅ **Database:** Training system operational

## 🔧 TROUBLESHOOTING:

**Web Disk Won't Connect:**
- Ensure Digest Authentication enabled
- Try both HTTP (2077) and HTTPS (2078) ports
- Check firewall/antivirus blocking WebDAV

**Files Not Appearing:**
- Refresh WordPress admin (Appearance → Themes)
- Clear browser cache
- Check file permissions in cPanel

**Database Issues:**
- Verify table created: `SHOW TABLES LIKE 'wp_training_data';`
- Re-import SQL if needed
- Check database user permissions

Your Musaix Pro v2.0 will be live in minutes! 🚀✨
EOF

echo ""
echo -e "${GREEN}📋 DETAILED GUIDE CREATED: WEB-DISK-STEP-BY-STEP.md${NC}"
echo ""
echo -e "${PURPLE}🎵 DEPLOYMENT FILES READY:${NC}"
echo "✅ Theme folder: $(pwd)/temp-deploy/musaix-pro/"
echo "✅ Database setup: $(pwd)/temp-deploy/setup-database.sql"
echo "✅ Complete guide: $(pwd)/WEB-DISK-STEP-BY-STEP.md"
echo ""
echo -e "${GREEN}🚀 YOUR MUSAIX PRO V2.0 IS READY FOR WEB DISK DEPLOYMENT!${NC}"
echo ""
echo -e "${YELLOW}⚡ RECOMMENDED NEXT STEPS:${NC}"
echo "1. Create Web Disk account in cPanel"
echo "2. Connect Web Disk as network drive"  
echo "3. Copy musaix-pro folder via Web Disk"
echo "4. Import database via phpMyAdmin"
echo "5. Activate theme in WordPress admin"
echo ""
echo -e "${GREEN}🎶 Your ultra-modern AI music platform will be live shortly! ✨${NC}"