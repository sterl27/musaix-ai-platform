#!/bin/bash

echo "🎵 Musaix Pro - Plugin Installation & Content Import Script"
echo "==========================================================="
echo ""

# Function to activate plugins via WordPress admin
activate_plugins() {
    echo "🔌 Activating Essential Plugins..."
    echo ""
    echo "Please complete these steps manually:"
    echo ""
    echo "1. Go to: http://localhost:8080/wp-admin/plugins.php"
    echo "2. Login with: admin / admin123"
    echo "3. Activate the following plugins:"
    echo "   ✅ WordPress Importer"
    echo "   ✅ Elementor"
    echo "   ✅ Akismet Anti-spam (optional)"
    echo "   ✅ Hello Dolly (optional)"
    echo ""
}

# Function to guide import process
import_content() {
    echo "📥 Content Import Process:"
    echo ""
    echo "Step 1: Go to WordPress Admin"
    echo "   🌐 http://localhost:8080/wp-admin"
    echo ""
    echo "Step 2: Navigate to Import Tool"
    echo "   📁 Tools → Import → WordPress"
    echo ""
    echo "Step 3: Run WordPress Importer"
    echo "   🚀 Click 'Run Importer'"
    echo ""
    echo "Step 4: Upload Your Export File"
    echo "   📤 Choose file: musaixpro.WordPress.2025-10-28.xml"
    echo "   💡 The file is already copied to the container"
    echo ""
    echo "Step 5: Import Settings"
    echo "   👤 Assign authors: Create new users or assign to existing"
    echo "   🖼️  Check: 'Download and import file attachments'"
    echo "   ⚡ Click 'Submit'"
    echo ""
}

# Function to show expected content
show_expected_content() {
    echo "🎯 Content That Will Be Imported:"
    echo ""
    echo "📄 Pages & Posts:"
    echo "   • Main Musaix Pro pages"
    echo "   • AI-powered tool pages"
    echo "   • Blog posts and content"
    echo ""
    echo "🤖 AI Tools & Features:"
    echo "   • Advanced Tweet Classifier"
    echo "   • Blog Post Generator"
    echo "   • Business Strategy Advisor"
    echo "   • AI Chatbots (aipkit_chatbot)"
    echo "   • AI Forms (aipkit_ai_form)"
    echo ""
    echo "🎨 Design Elements:"
    echo "   • Elementor page designs"
    echo "   • Custom layouts and templates"
    echo "   • Media files and images"
    echo ""
    echo "⚙️  Settings & Configuration:"
    echo "   • Theme settings"
    echo "   • Plugin configurations"
    echo "   • WordPress customizations"
    echo ""
}

# Function to show post-import steps
post_import_steps() {
    echo "✅ After Import Completion:"
    echo ""
    echo "1. 🔍 Review Imported Content"
    echo "   • Check Pages: http://localhost:8080/wp-admin/edit.php?post_type=page"
    echo "   • Check Posts: http://localhost:8080/wp-admin/edit.php"
    echo ""
    echo "2. 🎨 Configure Elementor"
    echo "   • Go to Elementor → Settings"
    echo "   • Configure page builder settings"
    echo "   • Check templates and global widgets"
    echo ""
    echo "3. 🤖 Set Up AI Tools"
    echo "   • Configure AI chatbots"
    echo "   • Test AI forms and tools"
    echo "   • Verify API connections"
    echo ""
    echo "4. 🌐 Test Your Site"
    echo "   • Visit: http://localhost:8080"
    echo "   • Test functionality"
    echo "   • Check responsive design"
    echo ""
    echo "5. 🛠️  Development Ready!"
    echo "   • Edit files in: ./wordpress/ directory"
    echo "   • Use VS Code for development"
    echo "   • Database accessible via phpMyAdmin: http://localhost:8081"
    echo ""
}

# Main execution
echo "🚀 Starting Plugin & Content Setup Process..."
echo ""

activate_plugins
import_content
show_expected_content
post_import_steps

echo "💡 Quick Access Links:"
echo "   • WordPress Admin: http://localhost:8080/wp-admin"
echo "   • Site Frontend:   http://localhost:8080"
echo "   • phpMyAdmin:      http://localhost:8081"
echo ""
echo "🔐 Login: admin / admin123"
echo ""
echo "Happy developing! 🎵✨"
echo ""

# Option to open browser automatically
read -p "🌐 Would you like to open WordPress admin in browser? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo "🚀 Opening WordPress admin..."
    if command -v xdg-open > /dev/null; then
        xdg-open http://localhost:8080/wp-admin
    elif command -v open > /dev/null; then
        open http://localhost:8080/wp-admin
    else
        echo "Please manually open: http://localhost:8080/wp-admin"
    fi
fi