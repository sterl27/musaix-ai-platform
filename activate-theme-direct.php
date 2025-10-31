<?php
// Direct database theme activation
define('WP_USE_THEMES', false);
require_once('/var/www/html/wp-load.php');

// Directly update the theme option in the database
$theme_slug = 'musaix-pro';

// Check if theme exists
$theme_root = get_theme_root();
$theme_path = $theme_root . '/' . $theme_slug;

if (is_dir($theme_path)) {
    // Update the current theme options
    update_option('stylesheet', $theme_slug);
    update_option('template', $theme_slug);
    
    echo "Musaix Pro theme activated successfully!\n";
    
    // Verify activation
    $current_theme = get_option('stylesheet');
    echo "Current active theme: {$current_theme}\n";
    
    // Also set theme customizations
    set_theme_mod('musaix_primary_color', '#6366f1');
    set_theme_mod('musaix_accent_color', '#f59e0b');
    
    echo "Theme customizations applied.\n";
} else {
    echo "Musaix Pro theme not found at: {$theme_path}\n";
    echo "Available themes:\n";
    $themes = wp_get_themes();
    foreach ($themes as $slug => $theme) {
        echo "- {$slug}: {$theme->display('Name')}\n";
    }
}
?>