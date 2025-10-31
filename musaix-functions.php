<?php
/**
 * Musaix Pro Theme Functions
 * 
 * Custom functions and setup for the Musaix Pro dark theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function musaix_theme_setup() {
    // Add theme support for various features
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'musaix'),
        'footer' => __('Footer Menu', 'musaix'),
    ));
}
add_action('after_setup_theme', 'musaix_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function musaix_enqueue_assets() {
    // Google Fonts
    wp_enqueue_style('musaix-google-fonts', 
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap',
        array(), null
    );
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css',
        array(), '6.0.0'
    );
    
    // Main theme stylesheet
    wp_enqueue_style('musaix-theme-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Musaix Dark Theme CSS
    wp_enqueue_style('musaix-dark-theme', 
        get_template_directory_uri() . '/musaix-dark-theme.css',
        array('musaix-theme-style'), '1.0.0'
    );
    
    // Theme JavaScript
    wp_enqueue_script('musaix-theme-js',
        get_template_directory_uri() . '/assets/js/musaix-theme.js',
        array('jquery'), '1.0.0', true
    );
    
    // Localize script for AJAX
    wp_localize_script('musaix-theme-js', 'musaix_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('musaix_nonce')
    ));
}
add_action('wp_enqueue_scripts', 'musaix_enqueue_assets');

/**
 * Add Musaix body classes
 */
function musaix_body_classes($classes) {
    $classes[] = 'musaix-dark-theme';
    return $classes;
}
add_filter('body_class', 'musaix_body_classes');

/**
 * Custom Post Types
 */
function musaix_register_post_types() {
    // AI Music Tracks
    register_post_type('ai_track', array(
        'labels' => array(
            'name' => __('AI Tracks', 'musaix'),
            'singular_name' => __('AI Track', 'musaix'),
            'add_new' => __('Add New Track', 'musaix'),
            'add_new_item' => __('Add New AI Track', 'musaix'),
            'edit_item' => __('Edit AI Track', 'musaix'),
            'new_item' => __('New AI Track', 'musaix'),
            'view_item' => __('View AI Track', 'musaix'),
            'search_items' => __('Search AI Tracks', 'musaix'),
            'not_found' => __('No AI tracks found', 'musaix'),
            'not_found_in_trash' => __('No AI tracks found in trash', 'musaix'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-format-audio',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'ai-tracks'),
    ));
    
    // Features
    register_post_type('feature', array(
        'labels' => array(
            'name' => __('Features', 'musaix'),
            'singular_name' => __('Feature', 'musaix'),
            'add_new' => __('Add New Feature', 'musaix'),
            'add_new_item' => __('Add New Feature', 'musaix'),
            'edit_item' => __('Edit Feature', 'musaix'),
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-star-filled',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'features'),
    ));
}
add_action('init', 'musaix_register_post_types');

/**
 * Custom Meta Boxes
 */
function musaix_add_meta_boxes() {
    add_meta_box(
        'musaix_track_details',
        __('Track Details', 'musaix'),
        'musaix_track_details_callback',
        'ai_track',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'musaix_add_meta_boxes');

function musaix_track_details_callback($post) {
    wp_nonce_field('musaix_save_track_details', 'musaix_track_details_nonce');
    
    $genre = get_post_meta($post->ID, '_musaix_genre', true);
    $bpm = get_post_meta($post->ID, '_musaix_bpm', true);
    $key = get_post_meta($post->ID, '_musaix_key', true);
    $duration = get_post_meta($post->ID, '_musaix_duration', true);
    $audio_url = get_post_meta($post->ID, '_musaix_audio_url', true);
    
    ?>
    <table class="form-table">
        <tr>
            <th scope="row">
                <label for="musaix_genre"><?php _e('Genre', 'musaix'); ?></label>
            </th>
            <td>
                <input type="text" id="musaix_genre" name="musaix_genre" value="<?php echo esc_attr($genre); ?>" class="regular-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="musaix_bpm"><?php _e('BPM', 'musaix'); ?></label>
            </th>
            <td>
                <input type="number" id="musaix_bpm" name="musaix_bpm" value="<?php echo esc_attr($bpm); ?>" class="small-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="musaix_key"><?php _e('Key', 'musaix'); ?></label>
            </th>
            <td>
                <select id="musaix_key" name="musaix_key">
                    <option value=""><?php _e('Select Key', 'musaix'); ?></option>
                    <?php
                    $keys = array('C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B');
                    foreach ($keys as $k) {
                        echo '<option value="' . $k . '"' . selected($key, $k, false) . '>' . $k . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="musaix_duration"><?php _e('Duration (seconds)', 'musaix'); ?></label>
            </th>
            <td>
                <input type="number" id="musaix_duration" name="musaix_duration" value="<?php echo esc_attr($duration); ?>" class="small-text" />
            </td>
        </tr>
        <tr>
            <th scope="row">
                <label for="musaix_audio_url"><?php _e('Audio File URL', 'musaix'); ?></label>
            </th>
            <td>
                <input type="url" id="musaix_audio_url" name="musaix_audio_url" value="<?php echo esc_attr($audio_url); ?>" class="regular-text" />
                <p class="description"><?php _e('Enter the URL of the audio file', 'musaix'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

function musaix_save_track_details($post_id) {
    if (!isset($_POST['musaix_track_details_nonce']) || 
        !wp_verify_nonce($_POST['musaix_track_details_nonce'], 'musaix_save_track_details')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    $fields = array('musaix_genre', 'musaix_bpm', 'musaix_key', 'musaix_duration', 'musaix_audio_url');
    
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, '_' . $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'musaix_save_track_details');

/**
 * Custom Widgets
 */
function musaix_register_widgets() {
    register_sidebar(array(
        'name' => __('Footer Widgets', 'musaix'),
        'id' => 'footer-widgets',
        'description' => __('Widgets displayed in the footer', 'musaix'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'musaix_register_widgets');

/**
 * AJAX Handler for Contact Form
 */
function musaix_handle_contact_form() {
    check_ajax_referer('musaix_nonce', 'nonce');
    
    $first_name = sanitize_text_field($_POST['firstName']);
    $last_name = sanitize_text_field($_POST['lastName']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Send email (you would configure this with your email service)
    $to = get_option('admin_email');
    $email_subject = 'Contact Form Submission: ' . $subject;
    $email_message = "Name: {$first_name} {$last_name}\n";
    $email_message .= "Email: {$email}\n";
    $email_message .= "Subject: {$subject}\n\n";
    $email_message .= "Message:\n{$message}";
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $first_name . ' ' . $last_name . ' <' . $email . '>'
    );
    
    $sent = wp_mail($to, $email_subject, $email_message, $headers);
    
    if ($sent) {
        wp_send_json_success(array('message' => 'Thank you for your message! We\'ll get back to you within 24 hours.'));
    } else {
        wp_send_json_error(array('message' => 'Sorry, there was an error sending your message. Please try again.'));
    }
}
add_action('wp_ajax_musaix_contact_form', 'musaix_handle_contact_form');
add_action('wp_ajax_nopriv_musaix_contact_form', 'musaix_handle_contact_form');

/**
 * Customizer Settings
 */
function musaix_customize_register($wp_customize) {
    // Brand Colors Section
    $wp_customize->add_section('musaix_colors', array(
        'title' => __('Musaix Brand Colors', 'musaix'),
        'priority' => 30,
    ));
    
    // Primary Color
    $wp_customize->add_setting('musaix_primary_color', array(
        'default' => '#6366f1',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'musaix_primary_color', array(
        'label' => __('Primary Color', 'musaix'),
        'section' => 'musaix_colors',
        'settings' => 'musaix_primary_color',
    )));
    
    // Accent Color
    $wp_customize->add_setting('musaix_accent_color', array(
        'default' => '#f59e0b',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'musaix_accent_color', array(
        'label' => __('Accent Color', 'musaix'),
        'section' => 'musaix_colors',
        'settings' => 'musaix_accent_color',
    )));
    
    // Social Media Section
    $wp_customize->add_section('musaix_social', array(
        'title' => __('Social Media Links', 'musaix'),
        'priority' => 35,
    ));
    
    $social_networks = array(
        'twitter' => 'Twitter',
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'youtube' => 'YouTube',
        'linkedin' => 'LinkedIn',
        'discord' => 'Discord'
    );
    
    foreach ($social_networks as $network => $label) {
        $wp_customize->add_setting('musaix_' . $network . '_url', array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('musaix_' . $network . '_url', array(
            'label' => $label . ' URL',
            'section' => 'musaix_social',
            'type' => 'url',
        ));
    }
}
add_action('customize_register', 'musaix_customize_register');

/**
 * Output custom CSS from customizer
 */
function musaix_customizer_css() {
    $primary_color = get_theme_mod('musaix_primary_color', '#6366f1');
    $accent_color = get_theme_mod('musaix_accent_color', '#f59e0b');
    
    ?>
    <style type="text/css">
        :root {
            --musaix-primary: <?php echo esc_html($primary_color); ?>;
            --musaix-accent: <?php echo esc_html($accent_color); ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'musaix_customizer_css');

/**
 * Admin Enqueue
 */
function musaix_admin_enqueue($hook) {
    if ('post.php' == $hook || 'post-new.php' == $hook) {
        wp_enqueue_style('musaix-admin-style', 
            get_template_directory_uri() . '/assets/css/admin.css',
            array(), '1.0.0'
        );
    }
}
add_action('admin_enqueue_scripts', 'musaix_admin_enqueue');

/**
 * Page Templates
 */
function musaix_page_templates($templates) {
    $templates['musaix-homepage.php'] = 'Musaix Homepage';
    $templates['musaix-about.php'] = 'Musaix About';
    $templates['musaix-contact.php'] = 'Musaix Contact';
    return $templates;
}
add_filter('theme_page_templates', 'musaix_page_templates');

/**
 * Load custom page templates
 */
function musaix_load_custom_templates($template) {
    global $post;
    
    if (!$post) {
        return $template;
    }
    
    $page_template = get_post_meta($post->ID, '_wp_page_template', true);
    
    switch ($page_template) {
        case 'musaix-homepage.php':
            $template = get_template_directory() . '/musaix-homepage-template.php';
            break;
        case 'musaix-about.php':
            $template = get_template_directory() . '/musaix-about-template.php';
            break;
        case 'musaix-contact.php':
            $template = get_template_directory() . '/musaix-contact-template.php';
            break;
    }
    
    return $template;
}
add_filter('page_template', 'musaix_load_custom_templates');

/**
 * Remove WordPress version from head
 */
remove_action('wp_head', 'wp_generator');

/**
 * Clean up WordPress head
 */
function musaix_clean_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
}
add_action('after_setup_theme', 'musaix_clean_head');

/**
 * Disable XML-RPC for security
 */
add_filter('xmlrpc_enabled', '__return_false');

/**
 * Remove query strings from static resources
 */
function musaix_remove_query_strings($src) {
    $parts = explode('?ver', $src);
    return $parts[0];
}
add_filter('script_loader_src', 'musaix_remove_query_strings', 15, 1);
add_filter('style_loader_src', 'musaix_remove_query_strings', 15, 1);

/**
 * Security headers
 */
function musaix_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
}
add_action('send_headers', 'musaix_security_headers');