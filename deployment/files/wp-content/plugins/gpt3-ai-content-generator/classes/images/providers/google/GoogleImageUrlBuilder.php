<?php
// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/images/providers/google/GoogleImageUrlBuilder.php

namespace WPAICG\Images\Providers\Google;

use WP_Error;
use WPAICG\AIPKit_Providers;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Handles building API URLs specific to Google Image Generation models.
 */
class GoogleImageUrlBuilder {

    /**
     * Build the full API endpoint URL for a given Google Image Generation model.
     *
     * @param string $model_id The specific model ID (e.g., 'gemini-2.0-flash-preview-image-generation', 'imagen-3.0-generate-002').
     * @param array  $api_params Required parameters (base_url, api_version, api_key).
     * @return string|WP_Error The full URL or WP_Error.
     */
    public static function build(string $model_id, array $api_params): string|WP_Error {
        $base_url = !empty($api_params['base_url']) ? rtrim($api_params['base_url'], '/') : 'https://generativelanguage.googleapis.com';
        $api_version = !empty($api_params['api_version']) ? $api_params['api_version'] : 'v1beta'; // Most GenAI models use v1beta
        $api_key = !empty($api_params['api_key']) ? $api_params['api_key'] : '';

        if (empty($api_key)) {
            return new WP_Error('missing_google_api_key_for_image_url', __('Google API key is required for image URL construction.', 'gpt3-ai-content-generator'));
        }

        // The model_id from settings IS the full path relative to /models/ for these image models
        // e.g. "gemini-2.0-flash-preview-image-generation" or "imagen-3.0-generate-002"

        // Handle video models - redirect to video URL builder
        $is_video_model = false;
        if (class_exists('\\WPAICG\\AIPKit_Providers')) {
            $video_models = AIPKit_Providers::get_google_video_models();
            if (is_array($video_models) && !empty($video_models)) {
                foreach ($video_models as $vm) {
                    $vid = is_array($vm) ? ($vm['id'] ?? '') : (is_string($vm) ? $vm : '');
                    if (!empty($vid) && $vid === $model_id) { $is_video_model = true; break; }
                }
            }
        }
        // Fallback heuristic
        if (!$is_video_model && strpos($model_id, 'veo') !== false) {
            $is_video_model = true;
        }
        if ($is_video_model) {
            /* translators: %s: The model ID that was attempted to be used for image URL building. */
            return new WP_Error('video_model_in_image_url_builder', sprintf(__('Video model %s should use GoogleVideoUrlBuilder instead.', 'gpt3-ai-content-generator'), $model_id));
        }

        $endpoint_suffix = '';
        if ($model_id === 'gemini-2.0-flash-preview-image-generation') {
            $endpoint_suffix = ':generateContent';
            // imagen-3.0-generate-002 and imagen-4.0-generate-preview-06-06 and imagen-4.0-ultra-generate-preview-06-06  
        } elseif ($model_id === 'imagen-3.0-generate-002' || $model_id === 'imagen-4.0-generate-preview-06-06' || $model_id === 'imagen-4.0-ultra-generate-preview-06-06') {
            $endpoint_suffix = ':predict'; // Imagen models typically use :predict
        } else {
             // Fallback if model ID is not explicitly known, try to guess
            if (strpos($model_id, 'gemini') !== false) {
                $endpoint_suffix = ':generateContent';
            } elseif (strpos($model_id, 'imagen') !== false) {
                $endpoint_suffix = ':predict';
            } else {
                /* translators: %s: The model ID that was attempted to be used for URL building. */
                return new WP_Error('unsupported_google_image_model_for_url', sprintf(__('Unsupported Google image model for URL building: %s', 'gpt3-ai-content-generator'), $model_id));
            }
        }

        // Construct path: /v1beta/models/MODEL_ID:action
        $full_path = '/' . trim($api_version, '/') . '/models/' . urlencode($model_id) . $endpoint_suffix;
        $url_with_key = $base_url . $full_path . '?key=' . urlencode($api_key);

        return $url_with_key;
    }
}
