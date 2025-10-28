<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/chat/admin/ajax/class-aipkit-chatbot-image-ajax-handler.php
// Status: MODIFIED

namespace WPAICG\Chat\Admin\Ajax;

use WPAICG\Images\AIPKit_Image_Manager;
use WPAICG\Chat\Storage\LogStorage;
use WPAICG\AIPKit\Addons\AIPKit_IP_Anonymization;
// --- MODIFIED: Use new Token Manager namespace and its constants ---
use WPAICG\Core\TokenManager\AIPKit_Token_Manager;
use WPAICG\Core\TokenManager\Constants\GuestTableConstants;
// --- END MODIFICATION ---
use WPAICG\aipkit_dashboard;
use WPAICG\Chat\Storage\BotStorage;
use WP_Error;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Handles AJAX requests for generating images triggered from within a chatbot conversation.
 * Uses the frontend nonce as the request originates from the chat UI.
 * UPDATED: Implements token checking and recording against chatbot limits.
 * MODIFIED: Logs the original user message before processing image generation.
 * ADDED: Retrieves and uses the chatbot's specific image model setting.
 */
class ChatbotImageAjaxHandler extends BaseAjaxHandler
{
    private $log_storage;
    private $image_manager;
    // --- MODIFIED: Type hint for new Token Manager ---
    private $token_manager;
    // --- END MODIFICATION ---
    private $bot_storage;

    public function __construct()
    {
        // Instantiate dependencies
        if (!class_exists(LogStorage::class)) {
            return;
        }
        if (!class_exists(AIPKit_Image_Manager::class)) {
            return;
        }
        // --- MODIFIED: Ensure New Token Manager is loaded ---
        if (!class_exists(\WPAICG\Core\TokenManager\AIPKit_Token_Manager::class)) {
            $token_manager_path = WPAICG_PLUGIN_DIR . 'classes/core/token-manager/AIPKit_Token_Manager.php'; // Updated path
            if (file_exists($token_manager_path)) {
                require_once $token_manager_path;
            } else {
                return;
            }
        }
        // --- END MODIFICATION ---
        if (!class_exists(BotStorage::class)) {
            $bot_storage_path = WPAICG_PLUGIN_DIR . 'classes/chat/storage/class-aipkit_chat_bot_storage.php';
            if (file_exists($bot_storage_path)) {
                require_once $bot_storage_path;
            } else {
                return;
            }
        }


        $this->log_storage = new LogStorage();
        $this->image_manager = new AIPKit_Image_Manager();
        // --- MODIFIED: Instantiate new Token Manager ---
        $this->token_manager = new \WPAICG\Core\TokenManager\AIPKit_Token_Manager();
        // --- END MODIFICATION ---
        $this->bot_storage = new BotStorage();
    }

    /**
     * AJAX: Generates an image based on a prompt from the chat.
     */
    public function ajax_chat_generate_image()
    {
        // phpcs:ignore WordPress.Security.NonceVerification.Missing  -- Nonce is checked by $this->check_frontend_permissions() at the start of the method.
        $permission_check = $this->check_frontend_permissions();
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        $user_id = get_current_user_id();
        $is_logged_in = $user_id > 0;
        $client_ip = isset($_SERVER['REMOTE_ADDR']) ? filter_var(wp_unslash($_SERVER['REMOTE_ADDR']), FILTER_VALIDATE_IP) : null;
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce verification is handled in check_frontend_permissions method.
        $bot_id = isset($_POST['bot_id']) ? absint($_POST['bot_id']) : 0;
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce verification is handled in check_frontend_permissions method.
        $session_id_from_post = isset($_POST['session_id']) ? sanitize_text_field(wp_unslash($_POST['session_id'])) : null;
        $session_id = $is_logged_in ? null : $session_id_from_post;
        if (!$is_logged_in && empty($session_id) && class_exists('\WPAICG\Chat\Frontend\Shortcode\Configurator')) {
            $session_id = \WPAICG\Chat\Frontend\Shortcode\Configurator::get_guest_uuid();
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce verification is handled in check_frontend_permissions method.
        $conversation_uuid = isset($_POST['conversation_uuid']) ? sanitize_key($_POST['conversation_uuid']) : '';
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce verification is handled in
        $prompt = isset($_POST['prompt']) ? sanitize_textarea_field(wp_unslash($_POST['prompt'])) : '';
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce verification is handled in
        $original_user_text = isset($_POST['original_user_text']) ? sanitize_textarea_field(wp_unslash($_POST['original_user_text'])) : $prompt;
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce verification is handled in
        $user_message_id_from_post = isset($_POST['user_message_id']) ? sanitize_key($_POST['user_message_id']) : ('aipkit-client-umsg-' . wp_generate_password(12, false));

        $request_time = time();
        $user_wp_role = !$is_logged_in ? null : implode(', ', wp_get_current_user()->roles);

        if (empty($bot_id)) {
            $this->send_wp_error(new WP_Error('missing_bot_id', __('Bot ID is required.', 'gpt3-ai-content-generator'), ['status' => 400]));
            return;
        }
        if (empty($conversation_uuid)) {
            $this->send_wp_error(new WP_Error('missing_conv_uuid', __('Conversation ID is required.', 'gpt3-ai-content-generator'), ['status' => 400]));
            return;
        }
        if (!$is_logged_in && empty($session_id)) {
            $this->send_wp_error(new WP_Error('missing_session_id', __('Session ID is missing for guest.', 'gpt3-ai-content-generator'), ['status' => 400]));
            return;
        }

        $base_log_data = [
            'bot_id'             => $bot_id,
            'user_id'            => $user_id ?: null,
            'session_id'         => $session_id,
            'conversation_uuid'  => $conversation_uuid,
            'module'             => 'chat',
            'is_guest'           => $is_logged_in ? 0 : 1,
            'role'               => $user_wp_role,
            'ip_address'         => $client_ip,
        ];

        if (aipkit_dashboard::is_addon_active('token_management')) {
            $token_check_result = null;
            // --- MODIFIED: Use new GuestTableConstant ---
            $context_id_for_token_check = $is_logged_in ? 0 : GuestTableConstants::IMG_GEN_GUEST_CONTEXT_ID;
            // --- END MODIFICATION ---
            $token_check_result = $this->token_manager->check_and_reset_tokens($user_id ?: null, $session_id, $context_id_for_token_check, 'image_generator');

            if (is_wp_error($token_check_result)) {
                $user_command_log_data = array_merge($base_log_data, [
                   'message_role'    => 'user',
                   'message_content' => $original_user_text,
                   'timestamp'       => $request_time,
                   'message_id'      => $user_message_id_from_post,
                ]);
                $this->log_storage->log_message($user_command_log_data);
                $this->log_image_generation_attempt(
                    $conversation_uuid,
                    $prompt,
                    [],
                    $token_check_result,
                    null,
                    $user_id,
                    $session_id,
                    $client_ip,
                    $bot_id,
                    $user_wp_role
                );
                $this->send_wp_error($token_check_result);
                return;
            }
        }

        $user_command_log_data = array_merge($base_log_data, [
            'message_role'    => 'user',
            'message_content' => $original_user_text,
            'timestamp'       => $request_time,
            'message_id'      => $user_message_id_from_post,
            'ai_provider'     => null,
            'ai_model'        => null,
            'usage'           => null,
            'request_payload' => ['command' => $original_user_text, 'extracted_prompt' => $prompt],
            'response_data'   => null,
        ]);
        $bot_response_message_id = $this->log_storage->log_message($user_command_log_data)['message_id'] ?? ('aipkit-bot-msg-' . uniqid());


        $bot_settings = $this->bot_storage->get_chatbot_settings($bot_id);
        $selected_image_model = $bot_settings['chat_image_model_id'] ?? \WPAICG\Chat\Storage\BotSettingsManager::DEFAULT_CHAT_IMAGE_MODEL_ID;
        $provider_for_image = 'OpenAI';

        $replicate_model_ids = [];
        if (class_exists('\WPAICG\AIPKit_Providers')) {
            $replicate_models = \WPAICG\AIPKit_Providers::get_replicate_models();
            if (!empty($replicate_models)) {
                $replicate_model_ids = wp_list_pluck($replicate_models, 'id');
            }
        }

        // Get Azure image models for detection
        $azure_model_ids = [];
        if (class_exists('\WPAICG\AIPKit_Providers')) {
            $azure_models = \WPAICG\AIPKit_Providers::get_azure_image_models();
            if (!empty($azure_models)) {
                $azure_model_ids = wp_list_pluck($azure_models, 'id');
            }
        }

        // Determine Google provider using synced Google Image Models
        $google_image_model_ids = [];
        if (class_exists('\\WPAICG\\AIPKit_Providers')) {
            $google_image_models = \WPAICG\AIPKit_Providers::get_google_image_models();
            if (!empty($google_image_models)) {
                $google_image_model_ids = wp_list_pluck($google_image_models, 'id');
            }
        }
        if (in_array($selected_image_model, $google_image_model_ids, true)) {
            $provider_for_image = 'Google';
        } elseif (in_array($selected_image_model, $azure_model_ids, true)) {
            $provider_for_image = 'Azure';
        } elseif (in_array($selected_image_model, $replicate_model_ids, true)) {
            $provider_for_image = 'Replicate';
        }

        // --- MODIFICATION: Add user identifier to options ---
        $user_identifier = $is_logged_in ? (string)$user_id : 'guest';
        // --- END MODIFICATION ---

        $generation_options_from_main_settings = \WPAICG\Images\AIPKit_Image_Settings_Ajax_Handler::get_settings();
        $provider_module_defaults = $generation_options_from_main_settings['defaults'][$provider_for_image] ?? ($generation_options_from_main_settings['defaults']['OpenAI'] ?? []);
        $final_generation_options = array_merge(
            $provider_module_defaults,
            [
                'provider' => $provider_for_image,
                'model'    => $selected_image_model,
                'n'        => 1,
                'user'     => $user_identifier, // ADDED
            ]
        );
        if (($final_generation_options['model'] ?? '') === 'gpt-image-1' && $provider_for_image === 'OpenAI') {
            unset($final_generation_options['response_format']);
            $final_generation_options['output_format'] = 'png';
        } elseif (($final_generation_options['model'] ?? '') === 'dall-e-3' && $provider_for_image === 'OpenAI') {
            $final_generation_options['response_format'] = 'url';
        } elseif (($final_generation_options['model'] ?? '') === 'dall-e-2' && $provider_for_image === 'OpenAI') {
            $final_generation_options['response_format'] = 'url';
        }

        $result = $this->image_manager->generate_image($prompt, $final_generation_options, $is_logged_in ? $user_id : null);
        $images_array = [];
        $usage_data = null;

        if (!is_wp_error($result)) {
            $images_array = $result['images'] ?? [];
            $usage_data = $result['usage'] ?? null;
            $images_generated_count = count($images_array);
            $tokens_to_record_for_chatbot = $usage_data['total_tokens'] ?? ($images_generated_count * AIPKit_Image_Manager::TOKENS_PER_IMAGE);

            if (aipkit_dashboard::is_addon_active('token_management') && $tokens_to_record_for_chatbot > 0) {
                // --- MODIFIED: Use new GuestTableConstant ---
                $context_id_for_token_record = $is_logged_in ? $bot_id : GuestTableConstants::IMG_GEN_GUEST_CONTEXT_ID;
                $module_to_record_against = $is_logged_in ? 'chat' : 'image_generator';
                $this->token_manager->record_token_usage($user_id ?: null, $session_id, $context_id_for_token_record, $tokens_to_record_for_chatbot, $module_to_record_against);
                // --- END MODIFICATION ---
            }
        }

        $user_wp_role = !$is_logged_in ? null : implode(', ', wp_get_current_user()->roles);
        $this->log_image_generation_attempt(
            $conversation_uuid,
            $prompt,
            $final_generation_options,
            $result,
            $usage_data,
            $user_id,
            $session_id,
            $client_ip,
            $bot_id,
            $user_wp_role,
            $bot_response_message_id
        );

        if (is_wp_error($result)) {
            $this->send_wp_error($result);
        } else {
            wp_send_json_success([
                'type' => 'image',
                'images' => $images_array,
                'prompt' => $prompt,
                'message_id' => $bot_response_message_id,
            ]);
        }
    }

    private function log_image_generation_attempt(string $conversation_uuid, string $extracted_prompt, array $request_options_for_log, array|WP_Error $result, ?array $usage_data, ?int $user_id, ?string $session_id, ?string $client_ip, int $bot_id_for_log, ?string $user_wp_role, string $bot_response_message_id = null)
    {
        if (!$this->log_storage) {
            return;
        }
        $is_error = is_wp_error($result);
        $response_data = [];
        $message_content = '';
        $logged_request_payload = ['prompt' => $extracted_prompt, 'options' => $request_options_for_log,];
        $model_used = $request_options_for_log['model'] ?? 'unknown_image_model';
        $provider_used = $request_options_for_log['provider'] ?? 'UnknownProvider';
        if ($is_error) {
            $message_content = "Error generating image: " . $result->get_error_message();
            $response_data['error_code'] = $result->get_error_code();
        } else {
            $images = $result['images'] ?? [];
            $prompt_snippet = esc_html(mb_substr($extracted_prompt, 0, 50));
            $message_content = sprintf('[Image generated for prompt: "%s..."]', $prompt_snippet);
            $response_data['type'] = 'image';
            $response_data['images'] = [];
            foreach ($images as $img_data) {
                $response_data['images'][] = [ 'url' => $img_data['url'] ?? null, 'revised_prompt' => $img_data['revised_prompt'] ?? null, 'has_b64' => isset($img_data['b64_json']), 'attachment_id' => $img_data['attachment_id'] ?? null, 'media_library_url' => $img_data['media_library_url'] ?? null ];
            }
        }
        if ($bot_response_message_id === null) {
            $bot_response_message_id = 'aipkit-img-err-' . time() . '-' . wp_generate_password(8, false);
        }
        $log_data = [
            'bot_id'             => $bot_id_for_log, 'user_id'            => $user_id ?: null, 'session_id'         => $session_id, 'conversation_uuid' => $conversation_uuid,
            'module'             => 'chat', 'is_guest'           => ($user_id === 0 || $user_id === null), 'role'               => $user_wp_role,
            'ip_address'         => \WPAICG\AIPKit\Addons\AIPKit_IP_Anonymization::maybe_anonymize($client_ip),
            'message_role'       => 'bot', 'message_content'    => $message_content, 'timestamp'          => time(),
            'ai_provider'        => $provider_used, 'ai_model'           => $model_used, 'usage'              => $usage_data,
            'message_id'         => $bot_response_message_id,
            'request_payload'    => $logged_request_payload, 'response_data'      => $response_data,
        ];
        $log_result = $this->log_storage->log_message($log_data);
    }
}
