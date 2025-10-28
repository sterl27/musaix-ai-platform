<?php
// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/chat/storage/sitewide/clear-site-wide-cache.php
// Status: NEW FILE

namespace WPAICG\Chat\Storage\SiteWide;

use WPAICG\Chat\Storage\SiteWideBotManager; // To access constants

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Logic for the clear_site_wide_cache method of SiteWideBotManager.
 */
function clear_site_wide_cache_logic(): void {
    wp_cache_delete(SiteWideBotManager::SITE_WIDE_BOT_CACHE_KEY, 'aipkit');
    delete_transient(SiteWideBotManager::SITE_WIDE_BOT_CACHE_KEY);
}