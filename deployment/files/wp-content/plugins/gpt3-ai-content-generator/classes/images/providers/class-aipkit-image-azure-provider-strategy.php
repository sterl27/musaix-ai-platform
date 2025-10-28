<?php
// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/images/providers/class-aipkit-image-azure-provider-strategy.php
// Status: NEW FILE

namespace WPAICG\Images\Providers;

use WPAICG\Images\AIPKit_Image_Base_Provider_Strategy;
use WP_Error;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Azure Image Generation Provider Strategy.
 * Implements generation using Azure OpenAI DALL-E deployments.
 */
class AIPKit_Image_Azure_Provider_Strategy extends AIPKit_Image_Base_Provider_Strategy
{
    /**
     * Build the full API endpoint URL for Azure image generation.
     *
     * @param string $operation Expected to be 'images/generations'.
     * @param array  $params Required parameters ('azure_endpoint', 'deployment', 'api_version_images').
     * @return string|WP_Error The full URL or WP_Error.
     */
    private function build_api_url(string $operation, array $params): string|WP_Error
    {
        $endpoint = $params['azure_endpoint'] ?? '';
        $deployment_name = $params['deployment'] ?? '';
        $api_version = $params['api_version_images'] ?? '2024-04-01-preview';

        if (empty($endpoint)) {
            return new WP_Error('azure_image_missing_endpoint', __('Azure Endpoint is required.', 'gpt3-ai-content-generator'));
        }
        if (empty($deployment_name)) {
            return new WP_Error('azure_image_missing_deployment', __('Azure Deployment Name (model) is required.', 'gpt3-ai-content-generator'));
        }

        return rtrim($endpoint, '/') . '/openai/deployments/' . urlencode($deployment_name) . '/images/generations?api-version=' . urlencode($api_version);
    }

    /**
     * Generate an image based on a text prompt using Azure DALL-E.
     *
     * @param string $prompt The text prompt describing the image.
     * @param array $api_params API connection parameters ('api_key', 'endpoint', 'api_version_images').
     * @param array $options Generation options ('model' which is deployment, 'n', 'size', 'quality', 'style').
     * @return array|WP_Error Array containing 'images' and 'usage' or WP_Error on failure.
     */
    public function generate_image(string $prompt, array $api_params, array $options = []): array|WP_Error
    {
        $api_key = $api_params['api_key'] ?? null;
        if (empty($api_key)) {
            return new WP_Error('azure_image_missing_key', __('Azure API Key is required for image generation.', 'gpt3-ai-content-generator'));
        }

        $url_params = [
            'azure_endpoint' => $api_params['endpoint'] ?? '',
            'deployment' => $options['model'] ?? '',
            'api_version_images' => $api_params['api_version_images'] ?? '2024-04-01-preview',
        ];

        $url = $this->build_api_url('images/generations', $url_params);
        if (is_wp_error($url)) {
            return $url;
        }

        // Build a payload compatible with OpenAI DALL-E 3
        $payload = [
            'prompt' => wp_strip_all_tags($prompt),
            'n' => 1, // DALL-E 3 on Azure supports n=1
        ];
        if (isset($options['size'])) {
            $payload['size'] = $options['size'];
        }
        if (isset($options['quality'])) {
            $payload['quality'] = $options['quality'];
        }
        if (isset($options['style'])) {
            $payload['style'] = $options['style'];
        }

        $headers_array = $this->get_api_headers($api_key, 'generate');
        $request_options = $this->get_request_options('generate');
        $request_body_json = wp_json_encode($payload);

        $request_args = array_merge($request_options, [
            'headers' => $headers_array,
            'body' => $request_body_json,
        ]);

        $response = wp_remote_post($url, $request_args);

        if (is_wp_error($response)) {
            return new WP_Error('azure_image_http_error', __('HTTP error during Azure image generation.', 'gpt3-ai-content-generator'));
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $decoded_response = $this->decode_json($body, 'Azure Image Generation');

        if ($status_code !== 200 || is_wp_error($decoded_response)) {
            $error_msg = is_wp_error($decoded_response) ? $decoded_response->get_error_message() : $this->parse_error_response($body, $status_code, 'Azure Image');
            return new WP_Error('azure_image_api_error', sprintf(__('Azure Image API Error (%1$d): %2$s', 'gpt3-ai-content-generator'), $status_code, $error_msg));
        }

        // The response structure is the same as OpenAI's
        $images = [];
        if (isset($decoded_response['data']) && is_array($decoded_response['data'])) {
            foreach ($decoded_response['data'] as $imageData) {
                $images[] = [
                    'url'            => $imageData['url'] ?? null,
                    'b64_json'       => $imageData['b64_json'] ?? null,
                    'revised_prompt' => $imageData['revised_prompt'] ?? null,
                ];
            }
        }
        // --- ADDED: Estimate token usage for Azure DALL-E ---
        $estimated_usage = null;
        if (!empty($images)) {
            $num_images = count($images);
            $prompt_words = str_word_count($prompt);
            $estimated_input_tokens = max(1, (int)($prompt_words * 1.3));
            $tokens_per_image = 2000; // DALL-E 3 estimate
            $estimated_output_tokens = $num_images * $tokens_per_image;
            $total_tokens = $estimated_input_tokens + $estimated_output_tokens;
            
            $estimated_usage = [
                'input_tokens' => $estimated_input_tokens,
                'output_tokens' => $estimated_output_tokens,
                'total_tokens' => $total_tokens,
                'provider_raw' => [
                    'source' => 'estimated_azure_dalle3_cost',
                    'model' => $options['model'] ?? 'dall-e-3',
                    'images_generated' => $num_images,
                    'tokens_per_image' => $tokens_per_image,
                    'prompt_tokens_estimated' => $estimated_input_tokens,
                ],
            ];
        }

        return ['images' => $images, 'usage' => $estimated_usage];
        // --- END ADDED ---
    }

    /**
     * Get the supported image sizes for Azure DALL-E 3.
     */
    public function get_supported_sizes(): array
    {
        return ['1024x1024', '1792x1024', '1024x1792'];
    }

    /**
     * Get API headers required for Azure requests.
     */
    public function get_api_headers(string $api_key, string $operation): array
    {
        return [
            'Content-Type' => 'application/json',
            'api-key' => $api_key,
        ];
    }
}