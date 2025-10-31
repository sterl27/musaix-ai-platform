<?php
// Theme activation script
require_once('/var/www/html/wp-load.php');

// Check if we're logged in as admin (simplified check)
if (is_user_logged_in() && current_user_can('switch_themes')) {
    
    // Get available themes
    $themes = wp_get_themes();
    
    echo "Available themes:\n";
    foreach ($themes as $theme_slug => $theme) {
        echo "- {$theme_slug}: {$theme->get('Name')}\n";
    }
    
    // Check if Musaix Pro theme exists
    if (isset($themes['musaix-pro'])) {
        // Activate the theme
        switch_theme('musaix-pro');
        echo "\nMusaix Pro theme activated successfully!\n";
        
        // Verify activation
        $current_theme = wp_get_theme();
        echo "Current active theme: " . $current_theme->get('Name') . "\n";
    } else {
        echo "\nMusaix Pro theme not found!\n";
    }
} else {
    echo "Authentication required or insufficient permissions.\n";
}
?>