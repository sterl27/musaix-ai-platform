#!/bin/bash

echo "🚀 MUSAIX.COM DEPLOYMENT TO HOSTGATOR"
echo "====================================="
echo ""
echo "This script will help you deploy your local WordPress site to"
echo "your live musaix.com hosted on HostGator."
echo ""

echo "📋 DEPLOYMENT OPTIONS"
echo "===================="
echo ""
echo "1. 📁 Files Only (WordPress core, themes, plugins, uploads)"
echo "2. 🗄️ Database Only (content, settings, users)"  
echo "3. 🔄 Complete Deployment (files + database)"
echo "4. 🛠️ Generate Deployment Package (for manual upload)"
echo ""

while true; do
    read -p "Select deployment option (1-4): " deploy_option
    case $deploy_option in
        [1-4])
            echo ""
            break
            ;;
        *)
            echo "Please enter a number between 1 and 4."
            ;;
    esac
done

case $deploy_option in
    1)
        echo "📁 FILES ONLY DEPLOYMENT SELECTED"
        echo "================================="
        echo ""
        echo "This will prepare WordPress files for upload to HostGator."
        echo "⚠️  Your database and content will remain unchanged."
        echo ""
        ;;
    2)
        echo "🗄️ DATABASE ONLY DEPLOYMENT SELECTED"
        echo "===================================="
        echo ""
        echo "This will export your local database for import to HostGator."
        echo "⚠️  Your WordPress files will remain unchanged."
        echo ""
        ;;
    3)
        echo "🔄 COMPLETE DEPLOYMENT SELECTED"
        echo "==============================="
        echo ""
        echo "This will prepare both files and database for HostGator."
        echo "⚠️  This will completely replace your live site content!"
        echo ""
        ;;
    4)
        echo "🛠️ DEPLOYMENT PACKAGE SELECTED"
        echo "==============================="
        echo ""
        echo "This will create packages you can manually upload to HostGator."
        echo "✅ Safest option for beginners"
        echo ""
        ;;
esac

# Get HostGator details for all options
echo "🌐 HOSTGATOR CONFIGURATION"
echo "=========================="
echo ""

echo "Please provide your HostGator details:"
echo ""

read -p "🌍 Your domain (musaix.com): " domain
domain=${domain:-musaix.com}

read -p "📁 Web root directory (usually public_html): " web_root
web_root=${web_root:-public_html}

echo ""
echo "🗄️ DATABASE DETAILS"
echo "==================="
echo ""

read -p "Database Host (usually localhost): " db_host
db_host=${db_host:-localhost}

read -p "Database Name: " db_name
read -p "Database Username: " db_user
read -s -p "Database Password: " db_pass
echo ""

# Only ask for FTP if doing file deployment
if [[ $deploy_option =~ ^[134]$ ]]; then
    echo ""
    echo "📡 FTP/SFTP DETAILS"
    echo "==================="
    echo ""
    
    read -p "FTP Host (usually your domain or ftp.yourdomain.com): " ftp_host
    read -p "FTP Username: " ftp_user
    read -s -p "FTP Password: " ftp_pass
    echo ""
    
    read -p "FTP Port (21 for FTP, 22 for SFTP): " ftp_port
    ftp_port=${ftp_port:-21}
fi

echo ""
echo "💾 SAVING CONFIGURATION"
echo "======================="
echo ""

# Save configuration
cat > .deployment-config << EOF
# Musaix.com Deployment Configuration
DOMAIN="$domain"
WEB_ROOT="$web_root"
DB_HOST="$db_host" 
DB_NAME="$db_name"
DB_USER="$db_user"
DB_PASS="$db_pass"
DEPLOY_OPTION="$deploy_option"
EOF

# Add FTP details if provided
if [[ $deploy_option =~ ^[134]$ ]]; then
    cat >> .deployment-config << EOF
FTP_HOST="$ftp_host"
FTP_USER="$ftp_user"
FTP_PASS="$ftp_pass"
FTP_PORT="$ftp_port"
EOF
fi

echo "✅ Configuration saved to .deployment-config"
echo ""
echo "🎯 READY FOR DEPLOYMENT"
echo "======================="
echo ""
echo "Configuration Summary:"
echo "• Domain: $domain"
echo "• Deploy Option: $deploy_option"
echo "• Database: $db_name on $db_host"
if [[ $deploy_option =~ ^[134]$ ]]; then
    echo "• FTP: $ftp_user@$ftp_host:$ftp_port"
fi
echo ""
echo "🚀 Next Step: Run ./deploy-execute.sh to create your deployment package"
echo ""
echo "⚠️  Security Note: .deployment-config contains sensitive information."
echo "    It will be automatically removed after deployment for security."