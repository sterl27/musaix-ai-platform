<?php
// Create Training page in WordPress
require_once(dirname(__FILE__) . '/wordpress/wp-config.php');
require_once(dirname(__FILE__) . '/wordpress/wp-load.php');

// Check if page already exists
$existing_page = get_page_by_title('Training');

if ($existing_page) {
    echo "Training page already exists with ID: " . $existing_page->ID . "\n";
} else {
    // Create the Training page
    $page_data = array(
        'post_title'     => 'Training',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'post_author'    => 1,
        'page_template'  => 'page-training.php'
    );
    
    $page_id = wp_insert_post($page_data);
    
    if ($page_id && !is_wp_error($page_id)) {
        // Set the page template
        update_post_meta($page_id, '_wp_page_template', 'page-training.php');
        
        echo "Training page created successfully with ID: $page_id\n";
        echo "Page URL: " . get_permalink($page_id) . "\n";
    } else {
        echo "Error creating Training page\n";
        if (is_wp_error($page_id)) {
            echo "Error: " . $page_id->get_error_message() . "\n";
        }
    }
}
?>