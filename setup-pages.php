<?php
// Page creation script
require_once('/var/www/html/wp-load.php');

// Function to create a page with custom template
function create_musaix_page($title, $content, $template = '') {
    $page_data = array(
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'publish',
        'post_type'    => 'page',
        'post_author'  => 1,
    );
    
    // Insert the page
    $page_id = wp_insert_post($page_data);
    
    if ($page_id && !is_wp_error($page_id)) {
        // Set custom template if provided
        if ($template) {
            update_post_meta($page_id, '_wp_page_template', $template);
        }
        
        echo "Created page: {$title} (ID: {$page_id})\n";
        return $page_id;
    } else {
        echo "Failed to create page: {$title}\n";
        return false;
    }
}

// Create homepage
$homepage_content = 'Welcome to Musaix Pro - the future of AI-powered music creation. This page uses our custom homepage template with hero section, features showcase, and modern dark theme design.';
$homepage_id = create_musaix_page('Home', $homepage_content, 'musaix-homepage.php');

// Set as homepage
if ($homepage_id) {
    update_option('page_on_front', $homepage_id);
    update_option('show_on_front', 'page');
    echo "Set as homepage\n";
}

// Create About page
$about_content = 'Learn about Musaix Pro\'s mission to revolutionize music creation through artificial intelligence. Meet our team and discover our story.';
create_musaix_page('About', $about_content, 'musaix-about.php');

// Create Contact page
$contact_content = 'Get in touch with the Musaix Pro team. We\'re here to help with any questions about our AI music creation platform.';
create_musaix_page('Contact', $contact_content, 'musaix-contact.php');

// Create Features page
$features_content = 'Discover the powerful AI music tools available in Musaix Pro. From composition to mixing, our platform has everything you need.';
create_musaix_page('Features', $features_content);

// Create Pricing page
$pricing_content = 'Choose the perfect plan for your music creation needs. From free to professional, we have options for every creator.';
create_musaix_page('Pricing', $pricing_content);

// Create a blog page
$blog_content = 'Stay updated with the latest news, tutorials, and insights from the world of AI music creation.';
$blog_id = create_musaix_page('Blog', $blog_content);

// Set as blog page
if ($blog_id) {
    update_option('page_for_posts', $blog_id);
    echo "Set as blog page\n";
}

// Create sample blog posts
$posts = array(
    array(
        'title' => 'Getting Started with AI Music Composition',
        'content' => 'Learn how to create your first AI-generated track with Musaix Pro. This comprehensive guide will walk you through the basics of AI music composition, from setting up your parameters to exporting your final track.',
        'category' => 'Tutorials'
    ),
    array(
        'title' => 'The Future of Music Production',
        'content' => 'Explore how artificial intelligence is revolutionizing the music industry. From automated mixing to intelligent composition, discover what the future holds for music creators.',
        'category' => 'Industry News'
    ),
    array(
        'title' => '5 Tips for Better AI-Generated Vocals',
        'content' => 'Master the art of AI vocal synthesis with these professional tips. Learn how to create more natural-sounding voices and improve the quality of your generated vocals.',
        'category' => 'Tips & Tricks'
    )
);

// Create categories first
$tutorial_cat = wp_create_category('Tutorials');
$news_cat = wp_create_category('Industry News');
$tips_cat = wp_create_category('Tips & Tricks');

foreach ($posts as $post_data) {
    $post = array(
        'post_title'   => $post_data['title'],
        'post_content' => $post_data['content'],
        'post_status'  => 'publish',
        'post_type'    => 'post',
        'post_author'  => 1,
        'post_category' => array(wp_create_category($post_data['category']))
    );
    
    $post_id = wp_insert_post($post);
    if ($post_id) {
        echo "Created blog post: {$post_data['title']} (ID: {$post_id})\n";
    }
}

// Create navigation menu
$menu_name = 'Primary Menu';
$menu_exists = wp_get_nav_menu_object($menu_name);

if (!$menu_exists) {
    $menu_id = wp_create_nav_menu($menu_name);
    
    // Add menu items
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Home',
        'menu-item-object' => 'page',
        'menu-item-object-id' => $homepage_id,
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'About',
        'menu-item-url' => home_url('/about/'),
        'menu-item-type' => 'custom',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Features',
        'menu-item-url' => home_url('/features/'),
        'menu-item-type' => 'custom',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Pricing',
        'menu-item-url' => home_url('/pricing/'),
        'menu-item-type' => 'custom',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Blog',
        'menu-item-object' => 'page',
        'menu-item-object-id' => $blog_id,
        'menu-item-type' => 'post_type',
        'menu-item-status' => 'publish'
    ));
    
    wp_update_nav_menu_item($menu_id, 0, array(
        'menu-item-title' => 'Contact',
        'menu-item-url' => home_url('/contact/'),
        'menu-item-type' => 'custom',
        'menu-item-status' => 'publish'
    ));
    
    // Assign menu to theme location
    $locations = get_theme_mod('nav_menu_locations');
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
    
    echo "Created navigation menu\n";
}

echo "\nMusaix Pro setup completed successfully!\n";
echo "Visit your site to see the new dark theme in action.\n";
?>