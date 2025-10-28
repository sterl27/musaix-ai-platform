<?php
// File: classes/chat/frontend/ajax/fn-ajax-get-frontend-chat-nonce.php

namespace WPAICG\Chat\Frontend\Ajax;

use WPAICG\Utils\AIPKit_CORS_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Returns a fresh nonce for the frontend chat AJAX/SSE handlers.
 *
 * This endpoint is intentionally available to unauthenticated users because the
 * nonce is required for subsequent security checks on other actions and does not
 * grant privileges on its own.
 *
 * It sets CORS headers (when relevant) and sends no-cache headers to avoid proxy caching.
 */
function ajax_get_frontend_chat_nonce_logic(): void
{
    // Handle preflight OPTIONS
    AIPKit_CORS_Manager::handle_preflight_request();

    // Optionally honor embed domain restrictions if a bot_id is posted
    $bot_id = 0;
    if (isset($_POST['bot_id'])) {
        $bot_id = absint(wp_unslash($_POST['bot_id']));
    }

    if ($bot_id > 0) {
        // Only enforce CORS for true cross-origin
        $is_cross_origin = false;
        if (isset($_SERVER['HTTP_ORIGIN']) && !empty($_SERVER['HTTP_ORIGIN'])) {
            $origin = $_SERVER['HTTP_ORIGIN'];
            $site_url = get_site_url();
            $site_parsed = parse_url($site_url);
            $origin_parsed = parse_url($origin);
            if ($origin_parsed && $site_parsed && (
                ($origin_parsed['host'] ?? '') !== ($site_parsed['host'] ?? '') ||
                ($origin_parsed['scheme'] ?? 'http') !== ($site_parsed['scheme'] ?? 'http')
            )) {
                $is_cross_origin = true;
            }
        }

        if ($is_cross_origin) {
            // Respect embed settings (plan + allowed domains) via the central CORS manager
            $origin_allowed = AIPKit_CORS_Manager::check_and_set_cors_headers($bot_id);
            if (!$origin_allowed) {
                wp_send_json_error([
                    'message' => __('This domain is not permitted to access the chatbot.', 'gpt3-ai-content-generator'),
                    'code'    => 'cors_denied'
                ], 403);
                return;
            }
        }
    }

    // Prevent caching of the nonce response anywhere
    nocache_headers();

    $nonce = wp_create_nonce('aipkit_frontend_chat_nonce');
    wp_send_json_success(['nonce' => $nonce]);
}

