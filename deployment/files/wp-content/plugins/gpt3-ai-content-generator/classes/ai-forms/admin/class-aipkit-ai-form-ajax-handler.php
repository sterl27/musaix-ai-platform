<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/ai-forms/admin/class-aipkit-ai-form-ajax-handler.php
// Status: MODIFIED

namespace WPAICG\AIForms\Admin;

use WPAICG\Dashboard\Ajax\BaseDashboardAjaxHandler;
use WPAICG\AIForms\Storage\AIPKit_AI_Form_Storage;
use WP_Error;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Handles AJAX requests for AI Form management (Create, Read, Update, Delete).
 * Delegates logic to functions in the /admin/ajax/ai-forms/ directory.
 */
class AIPKit_AI_Form_Ajax_Handler extends BaseDashboardAjaxHandler
{
    private $form_storage;

    public function __construct()
    {
        if (class_exists(AIPKit_AI_Form_Storage::class)) {
            $this->form_storage = new AIPKit_AI_Form_Storage();
        }
    }

    /**
     * Registers the AJAX hooks for this handler.
     */
    public function register_ajax_hooks()
    {
        add_action('wp_ajax_aipkit_save_ai_form', [$this, 'ajax_save_ai_form']);
        add_action('wp_ajax_aipkit_list_ai_forms', [$this, 'ajax_list_ai_forms']);
        add_action('wp_ajax_aipkit_get_ai_form', [$this, 'ajax_get_ai_form']);
        add_action('wp_ajax_aipkit_delete_ai_form', [$this, 'ajax_delete_ai_form']);
        add_action('wp_ajax_aipkit_duplicate_ai_form', [$this, 'ajax_duplicate_ai_form']);
        add_action('wp_ajax_aipkit_get_form_preview', [$this, 'ajax_get_form_preview']);
        add_action('wp_ajax_aipkit_delete_all_ai_forms', [$this, 'ajax_delete_all_ai_forms']);
        add_action('wp_ajax_aipkit_export_all_ai_forms', [$this, 'ajax_export_all_ai_forms']);
        add_action('wp_ajax_aipkit_import_ai_forms', [$this, 'ajax_import_ai_forms']);
    }

    /**
     * Provides access to the form storage dependency for logic functions.
     * @return AIPKit_AI_Form_Storage|null
     */
    public function get_form_storage(): ?AIPKit_AI_Form_Storage
    {
        return $this->form_storage;
    }

    /**
     * AJAX: Saves or updates an AI Form.
     */
    public function ajax_save_ai_form()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-save-form.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_save_form_logic($this);
    }

    /**
     * AJAX: Lists all AI Forms.
     */
    public function ajax_list_ai_forms()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-list-forms.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_list_forms_logic($this);
    }

    /**
     * AJAX: Gets a single AI Form's data for editing.
     */
    public function ajax_get_ai_form()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-get-form.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_get_form_logic($this);
    }

    /**
     * AJAX: Deletes an AI Form.
     */
    public function ajax_delete_ai_form()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-delete-form.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_delete_form_logic($this);
    }

    /**
     * AJAX: Duplicates an AI Form.
     */
    public function ajax_duplicate_ai_form()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-duplicate-form.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_duplicate_form_logic($this);
    }

    /**
     * AJAX: Exports all AI Forms.
     * @since 2.1
     */
    public function ajax_export_all_ai_forms()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-export-all-forms.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_export_all_forms_logic($this);
    }


    /**
     * AJAX: Gets the rendered HTML and required assets for an AI Form preview.
     */
    public function ajax_get_form_preview()
    {
        // 1. Security Check
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        // 2. Get and validate form_id
        // phpcs:ignore WordPress.Security.NonceVerification.Missing -- Reason: Nonce is verified in check_module_access_permissions() above.
        $form_id = isset($_POST['form_id']) ? absint($_POST['form_id']) : 0;
        if (empty($form_id)) {
            $this->send_wp_error(new \WP_Error('id_required', __('Form ID is required for preview.', 'gpt3-ai-content-generator'), ['status' => 400]));
            return;
        }

        // 3. Construct and render the shortcode
        $shortcode = '[aipkit_ai_form id="' . $form_id . '"]';
        $rendered_html = do_shortcode($shortcode);

        // 4. Get asset URLs for frontend loading
        $dist_url = WPAICG_PLUGIN_URL . 'dist/';
        $version = defined('WPAICG_VERSION') ? WPAICG_VERSION : '1.0.0';

        $assets = [
            'css' => [
                'public-ai-forms' => $dist_url . 'css/public-ai-forms.bundle.css?ver=' . $version,
            ],
            'js' => [
                'public-main' => $dist_url . 'js/public-main.bundle.js?ver=' . $version,
            ],
        ];

        // 5. Generate the public config object that would normally be localized
        $frontend_display_settings = [];
        if (class_exists('\\WPAICG\\AIForms\\Admin\\AIPKit_AI_Form_Settings_Ajax_Handler')) {
            $all_settings = \WPAICG\AIForms\Admin\AIPKit_AI_Form_Settings_Ajax_Handler::get_settings();
            $frontend_display_settings = $all_settings['frontend_display'] ?? [];
        }

        $public_config = [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'ajaxNonce' => wp_create_nonce('aipkit_frontend_chat_nonce'),
            'is_user_logged_in' => is_user_logged_in(),
            'save_as_post_nonce' => wp_create_nonce('aipkit_ai_form_save_as_post_nonce'),
            'allowed_providers' => $frontend_display_settings['allowed_providers'] ?? '',
            'allowed_models' => $frontend_display_settings['allowed_models'] ?? '',
            'text' => [
                'processing' => __('Processing...', 'gpt3-ai-content-generator'),
                'error' => __('An error occurred.', 'gpt3-ai-content-generator'),
                'saveAsPost' => __('Save', 'gpt3-ai-content-generator'),
            ]
        ];

        // 5b. Get models data
        $models = [];
        if (class_exists('\\WPAICG\\AIPKit_Providers')) {
            $models = [
                'openai'     => \WPAICG\AIPKit_Providers::get_openai_models(),
                'openrouter' => \WPAICG\AIPKit_Providers::get_openrouter_models(),
                'google'     => \WPAICG\AIPKit_Providers::get_google_models(),
                'azure'      => \WPAICG\AIPKit_Providers::get_azure_deployments(),
                'deepseek'   => \WPAICG\AIPKit_Providers::get_deepseek_models(),
            ];
            if (
                class_exists('\\WPAICG\\aipkit_dashboard') &&
                \WPAICG\aipkit_dashboard::is_pro_plan() &&
                \WPAICG\aipkit_dashboard::is_addon_active('ollama')
            ) {
                $models['ollama'] = \WPAICG\AIPKit_Providers::get_ollama_models();
            }
        }

        // 6. Send the response
        wp_send_json_success([
            'html'   => $rendered_html,
            'assets' => $assets,
            'config' => $public_config,
            'models' => $models, // Add models to response
        ]);
    }

    /**
     * AJAX: Deletes all AI Forms.
     */
    public function ajax_delete_all_ai_forms()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-delete-all-forms.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_delete_all_forms_logic($this);
    }

    /**
     * AJAX: Imports AI Forms from a JSON file.
     * @since 2.1
     */
    public function ajax_import_ai_forms()
    {
        $permission_check = $this->check_module_access_permissions('ai-forms', 'aipkit_manage_ai_forms_nonce');
        if (is_wp_error($permission_check)) {
            $this->send_wp_error($permission_check);
            return;
        }

        require_once WPAICG_PLUGIN_DIR . 'admin/ajax/ai-forms/ajax-import-forms.php';
        \WPAICG\Admin\Ajax\AIForms\do_ajax_import_forms_logic($this);
    }
}
