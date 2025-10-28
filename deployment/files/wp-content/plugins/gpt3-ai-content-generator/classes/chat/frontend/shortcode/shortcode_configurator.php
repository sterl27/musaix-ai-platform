<?php
// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/chat/frontend/shortcode/shortcode_configurator.php
// Status: MODIFIED

namespace WPAICG\Chat\Frontend\Shortcode;

use WP_Post;
// Removed unused class constants and direct dependencies here, as logic is moved.

// Load the main orchestrator function for building the config
require_once __DIR__ . '/configurator/build-config-array.php';


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Prepares the frontend JavaScript configuration object for the Chatbot Shortcode.
 * This class now acts as a dispatcher to the modularized logic.
 */
class Configurator {

    /**
     * Prepares the configuration array needed for the frontend JavaScript.
     * Delegates the main work to the build_config_array_logic function.
     *
     * @param int $bot_id
     * @param WP_Post $bot_post
     * @param array $settings Bot settings.
     * @param array $feature_flags Determined flags from FeatureManager.
     * @return array Frontend configuration data.
     */
    public static function prepare_config(int $bot_id, WP_Post $bot_post, array $settings, array $feature_flags): array {
        // Call the main orchestrator function from the new structure
        return ConfiguratorMethods\build_config_array_logic($bot_id, $bot_post, $settings, $feature_flags);
    }

    // Removed get_client_ip() static method as it's moved to configurator/get-client-ip.php
}