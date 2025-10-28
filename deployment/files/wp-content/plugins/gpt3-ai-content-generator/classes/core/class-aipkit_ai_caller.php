<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/core/class-aipkit_ai_caller.php
// Status: MODIFIED

namespace WPAICG\Core;

use WPAICG\AIPKit_Providers;
use WPAICG\AIPKIT_AI_Settings;
use WPAICG\Core\Providers\ProviderStrategyFactory;
use WPAICG\Core\Providers\ProviderStrategyInterface;
use WPAICG\Core\Providers\Google\GoogleSettingsHandler;
use WPAICG\Core\AIPKit_Payload_Sanitizer;
use WP_Error;
use WPAICG\Core\AIPKit_Instruction_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * AIPKit_AI_Caller
 *
 * Generic service class responsible for making standard (non-streaming) AI calls.
 * It uses the Provider Strategy pattern to handle provider specifics.
 * It does NOT handle module-specific context like chat history formatting or logging.
 * Uses InstructionManager to process system instructions.
 * MODIFIED: Accepts and passes image_inputs via ai_params_override to payload formatters.
 * MODIFIED: Sanitizes image_inputs before logging request payloads using AIPKit_Payload_Sanitizer.
 * MODIFIED: Adds 'provider' and 'model' to WP_Error data for context in error events.
 */
class AIPKit_AI_Caller
{
    /**
     * Makes a standard (non-streaming) API call to the specified AI provider.
     */
    public function make_standard_call(
        string $provider,
        string $model,
        array $messages,
        array $ai_params_override = [],
        ?string $base_system_instruction = null,
        array $instruction_context = []
    ): array|WP_Error {

        $strategy = ProviderStrategyFactory::get_strategy($provider);
        if (is_wp_error($strategy)) {
            return new WP_Error(
                $strategy->get_error_code(),
                $strategy->get_error_message(),
                ['provider' => $provider, 'model' => $model, 'status_code' => 500, 'operation' => 'get_strategy']
            );
        }

        if (!class_exists(AIPKit_Instruction_Manager::class)) {
            $manager_path = WPAICG_PLUGIN_DIR . 'classes/core/class-aipkit-instruction-manager.php';
            if (file_exists($manager_path)) {
                require_once $manager_path;
            } else {
                return new WP_Error(
                    'internal_error_instruction_manager',
                    'Instruction processing component missing.',
                    ['provider' => $provider, 'model' => $model, 'status_code' => 500, 'operation' => 'load_instruction_manager']
                );
            }
        }
        $full_instruction_context = array_merge($instruction_context, ['base_instructions' => $base_system_instruction ?? '']);
        $instructions_processed = AIPKit_Instruction_Manager::build_instructions($full_instruction_context);

        $provData = AIPKit_Providers::get_provider_data($provider);
        $global_ai_params = AIPKIT_AI_Settings::get_ai_parameters();

        $final_ai_params = array_merge($global_ai_params, $ai_params_override);
        if (isset($ai_params_override['use_openai_conversation_state'])) {
            $final_ai_params['use_openai_conversation_state'] = (bool)$ai_params_override['use_openai_conversation_state'];
        }
        if (isset($ai_params_override['previous_response_id'])) {
            $final_ai_params['previous_response_id'] = $ai_params_override['previous_response_id'];
        }
        if (isset($ai_params_override['vector_store_tool_config'])) {
            $final_ai_params['vector_store_tool_config'] = $ai_params_override['vector_store_tool_config'];
        }
        if (isset($ai_params_override['image_inputs'])) {
            $final_ai_params['image_inputs'] = $ai_params_override['image_inputs'];
        }

        if ($provider === 'Google' && !isset($final_ai_params['safety_settings'])) {
            if (class_exists(GoogleSettingsHandler::class)) {
                $final_ai_params['safety_settings'] = GoogleSettingsHandler::get_safety_settings();
            } else {
                $final_ai_params['safety_settings'] = [];
            }
        } elseif ($provider === 'OpenAI' && !isset($final_ai_params['store_conversation'])) {
            $openaiProvData = AIPKit_Providers::get_provider_data('OpenAI');
            $final_ai_params['store_conversation'] = $openaiProvData['store_conversation'] ?? '0';
        }

        $api_params = [
            'api_key'                 => $provData['api_key'] ?? '',
            'base_url'                => $provData['base_url'] ?? '',
            'api_version'             => $provData['api_version'] ?? '',
            'azure_endpoint'          => ($provider === 'Azure') ? ($provData['endpoint'] ?? '') : '',
            'azure_inference_version' => ($provider === 'Azure') ? ($provData['api_version_inference'] ?? '2025-01-01-preview') : '',
            'azure_authoring_version' => ($provider === 'Azure') ? ($provData['api_version_authoring'] ?? '2023-03-15-preview') : '',
            'model'                   => $model,
            'deployment'              => ($provider === 'Azure') ? $model : null,
        ];

    // Ollama doesn't require an API key
    if ($provider !== 'Ollama' && empty($api_params['api_key'])) {
            /* translators: %s: The name of the AI provider (e.g., OpenAI, Google). */
            return new WP_Error('missing_api_key', sprintf(__('API key is missing for %s.', 'gpt3-ai-content-generator'), $provider), ['provider' => $provider, 'model' => $model]);
        }
        if ($provider === 'Azure' && empty($api_params['azure_endpoint'])) {
            return new WP_Error('missing_azure_endpoint', __('Azure endpoint is missing.', 'gpt3-ai-content-generator'), ['provider' => $provider, 'model' => $model]);
        }
        if (empty($model)) {
            return new WP_Error('missing_model', __('AI Model or Deployment Name is missing.', 'gpt3-ai-content-generator'), ['provider' => $provider, 'model' => $model]);
        }

        $request_body_data = $strategy->format_chat_payload('', $instructions_processed, $messages, $final_ai_params, $model);

        $sanitized_final_ai_params = AIPKit_Payload_Sanitizer::sanitize_for_logging($final_ai_params);
        $sanitized_request_body_data = AIPKit_Payload_Sanitizer::sanitize_for_logging($request_body_data);

        $request_body_json = json_encode($request_body_data);
        // Post-encode sanitize: ensure score_threshold is clamped and rendered with <=6 decimals without relying on ini settings
        if (is_string($request_body_json) && strpos($request_body_json, 'score_threshold') !== false) {
            $request_body_json = preg_replace_callback(
                '/("score_threshold"\s*:\s*)(-?\d+(?:\.\d+)?(?:[eE][+\-]?\d+)?)/',
                function ($m) {
                    $val = (float)$m[2];
                    if ($val <= 0) { $val = 0.0; }
                    elseif ($val >= 1) { $val = 1.0; }
                    else { $val = round($val, 6); }
                    $formatted = rtrim(rtrim(number_format($val, 6, '.', ''), '0'), '.');
                    if ($formatted === '' || $formatted === '-0') { $formatted = '0'; }
                    return $m[1] . $formatted;
                },
                $request_body_json
            );
        }

        $request_payload_log = [
            'provider' => $provider,
            'model' => $model,
            'system_instruction' => $instructions_processed,
            'messages' => $messages,
            'ai_params' => $sanitized_final_ai_params,
            'payload_sent' => $sanitized_request_body_data,
        ];
        $sanitized_request_body_json_for_log = json_encode($sanitized_request_body_data);


        $url = $strategy->build_api_url('chat', $api_params);
        if (is_wp_error($url)) {
            return new WP_Error($url->get_error_code(), $url->get_error_message(), ['provider' => $provider, 'model' => $model]);
        }

        $headers = $strategy->get_api_headers($api_params['api_key'], 'chat');
        $options = $strategy->get_request_options('chat');

        $response = wp_remote_request($url, array_merge($options, ['headers' => $headers, 'body' => $request_body_json, 'data_format' => 'body']));

        if (is_wp_error($response)) {
            /* translators: %s: The specific error message from the failed HTTP request. */
            return new WP_Error('http_request_failed', sprintf(__('HTTP request failed: %s', 'gpt3-ai-content-generator'), $response->get_error_message()), ['request_payload' => $request_payload_log, 'provider' => $provider, 'model' => $model, 'status_code' => 503]);
        }

        $status_code = wp_remote_retrieve_response_code($response);
        $response_body_raw = wp_remote_retrieve_body($response);

        if ($status_code >= 400) {
            $parsed_message = $strategy->parse_error_response($response_body_raw, $status_code);
            /* translators: %1$s: The AI provider name (e.g., OpenAI). %2$d: The HTTP status code. %3$s: The error message from the API. */
            return new WP_Error('api_error', sprintf(__('%1$s API Error (HTTP %2$d): %3$s', 'gpt3-ai-content-generator'), $provider, $status_code, $parsed_message), ['status_code' => $status_code, 'response_body_for_debug' => $response_body_raw, 'request_payload' => $request_payload_log, 'provider' => $provider, 'model' => $model]);
        }

        $decoded_response = json_decode($response_body_raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return new WP_Error('json_decode_error', __('Failed to parse JSON from API response.', 'gpt3-ai-content-generator'), ['response_body_for_debug' => $response_body_raw, 'request_payload' => $request_payload_log, 'provider' => $provider, 'model' => $model, 'status_code' => 500]);
        }

        $parsed_data = $strategy->parse_chat_response($decoded_response, $request_body_data);
        if (is_wp_error($parsed_data)) {
            $error_data_from_parser = $parsed_data->get_error_data() ?? [];
            $error_data_from_parser['response_body_for_debug'] = $response_body_raw;
            $error_data_from_parser['request_payload'] = $request_payload_log;
            $error_data_from_parser['provider'] = $provider;
            $error_data_from_parser['model'] = $model;
            $error_data_from_parser['status_code'] = $status_code;
            return new WP_Error($parsed_data->get_error_code(), $parsed_data->get_error_message(), $error_data_from_parser);
        }

        $return_data = [
            'content'             => trim($parsed_data['content'] ?? ''),
            'usage'               => $parsed_data['usage'] ?? null,
            'request_payload_log' => $request_payload_log,
        ];
        if (isset($parsed_data['openai_response_id'])) {
            $return_data['openai_response_id'] = $parsed_data['openai_response_id'];
        }
        if (isset($parsed_data['grounding_metadata'])) {
            $return_data['grounding_metadata'] = $parsed_data['grounding_metadata'];
        }
        // Include vector search scores from instruction context if available
        if (!empty($instruction_context['vector_search_scores'])) {
            $return_data['vector_search_scores'] = $instruction_context['vector_search_scores'];
        }

        return $return_data;
    }

    /**
     * Makes an API call to generate embeddings.
     */
    public function generate_embeddings(
        string $provider,
        $input,
        array $embedding_options = []
    ): array|WP_Error {

        $strategy = ProviderStrategyFactory::get_strategy($provider);
        if (is_wp_error($strategy)) {
            return new WP_Error($strategy->get_error_code(), $strategy->get_error_message(), ['provider' => $provider, 'model' => ($embedding_options['model'] ?? 'unknown'), 'status_code' => 500, 'operation' => 'get_strategy_embeddings']);
        }
        if (!method_exists($strategy, 'generate_embeddings')) {
            /* translators: %s: The name of the AI provider (e.g., OpenAI, Google). */
            return new WP_Error('method_not_supported', sprintf(__('Embedding generation is not supported by the %s provider strategy.', 'gpt3-ai-content-generator'), $provider), ['provider' => $provider, 'model' => ($embedding_options['model'] ?? 'unknown'), 'status_code' => 501, 'operation' => 'generate_embeddings_unsupported']);
        }

        $provData = AIPKit_Providers::get_provider_data($provider);
        $api_params = [
            'api_key'     => $provData['api_key'] ?? '',
            'base_url'    => $provData['base_url'] ?? '',
            'api_version' => $provData['api_version'] ?? '',
        ];
        if ($provider === 'Azure') {
            $api_params['azure_endpoint'] = $provData['endpoint'] ?? '';
        }

        if (empty($api_params['api_key'])) {
            /* translators: %s: The name of the AI provider (e.g., OpenAI, Google). */
            return new WP_Error('missing_api_key', sprintf(__('API key is missing for %s embedding generation.', 'gpt3-ai-content-generator'), $provider), ['provider' => $provider, 'model' => ($embedding_options['model'] ?? 'unknown')]);
        }
        if ($provider === 'Azure' && empty($api_params['azure_endpoint'])) {
            return new WP_Error('missing_azure_endpoint', __('Azure endpoint is missing for embedding generation.', 'gpt3-ai-content-generator'), ['provider' => $provider, 'model' => ($embedding_options['model'] ?? 'unknown')]);
        }
        if (empty($embedding_options['model'])) {
            return new WP_Error('missing_embedding_model', __('Embedding model/deployment ID is required.', 'gpt3-ai-content-generator'), ['provider' => $provider, 'model' => ($embedding_options['model'] ?? 'unknown')]);
        }

        $result = $strategy->generate_embeddings($input, $api_params, $embedding_options);

        if (is_wp_error($result)) {
            $error_data_from_strategy = $result->get_error_data() ?? [];
            $error_data_from_strategy['provider'] = $provider;
            $error_data_from_strategy['model'] = $embedding_options['model'] ?? 'unknown';
            $error_data_from_strategy['operation'] = 'generate_embeddings_api_call';
            return new WP_Error($result->get_error_code(), $result->get_error_message(), $error_data_from_strategy);
        }
        return $result;
    }
}
