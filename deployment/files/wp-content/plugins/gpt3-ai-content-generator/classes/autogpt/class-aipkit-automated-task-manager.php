<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/autogpt/class-aipkit-automated-task-manager.php
// Status: MODIFIED

namespace WPAICG\AutoGPT;

use WPAICG\Dashboard\Ajax\BaseDashboardAjaxHandler; // Keep this if not creating a new base
// Import new action classes
use WPAICG\AutoGPT\Ajax\AIPKit_Save_Automated_Task_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Get_Automated_Tasks_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Delete_Automated_Task_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Update_Automated_Task_Status_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Run_Automated_Task_Now_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Get_Automated_Task_Queue_Items_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Delete_Automated_Task_Queue_Item_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Delete_Automated_Task_Queue_Items_By_Status_Action;
use WPAICG\AutoGPT\Ajax\AIPKit_Retry_Automated_Task_Queue_Item_Action;
use WP_Error; // Ensure WP_Error is available

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Manages Automated Tasks: Orchestrates AJAX handling via dedicated action classes.
 */
class AIPKit_Automated_Task_Manager extends BaseDashboardAjaxHandler
{ // Or new AIPKit_Automated_Task_Base_Ajax_Action

    // Table names are now handled by the individual action classes if they extend the new base.
    // const NONCE_ACTION is now defined in the base action class.

    public function __construct()
    {
        // Constructor can be empty if not needed, or can initialize dependencies
        // for the init_ajax_hooks method if any are required at this level.
    }

    /**
     * Initializes AJAX hooks by instantiating and registering dedicated action handlers.
     */
    public function init_ajax_hooks()
    {
        // Instantiate each new action handler
        $save_task_action = new AIPKit_Save_Automated_Task_Action();
        $get_tasks_action = new AIPKit_Get_Automated_Tasks_Action();
        $delete_task_action = new AIPKit_Delete_Automated_Task_Action();
        $update_status_action = new AIPKit_Update_Automated_Task_Status_Action();
        $run_now_action = new AIPKit_Run_Automated_Task_Now_Action();
        $get_queue_action = new AIPKit_Get_Automated_Task_Queue_Items_Action();
        $delete_queue_item_action = new AIPKit_Delete_Automated_Task_Queue_Item_Action();
        $delete_queue_items_action = new AIPKit_Delete_Automated_Task_Queue_Items_By_Status_Action();
        $retry_queue_item_action = new AIPKit_Retry_Automated_Task_Queue_Item_Action();

        // Register AJAX actions pointing to the handle_request method of each new class
        add_action('wp_ajax_aipkit_save_automated_task', [$save_task_action, 'handle_request']);
        add_action('wp_ajax_aipkit_get_automated_tasks', [$get_tasks_action, 'handle_request']);
        add_action('wp_ajax_aipkit_delete_automated_task', [$delete_task_action, 'handle_request']);
        add_action('wp_ajax_aipkit_update_automated_task_status', [$update_status_action, 'handle_request']);
        add_action('wp_ajax_aipkit_run_automated_task_now', [$run_now_action, 'handle_request']);
        add_action('wp_ajax_aipkit_get_automated_task_queue_items', [$get_queue_action, 'handle_request']);
        add_action('wp_ajax_aipkit_delete_automated_task_queue_item', [$delete_queue_item_action, 'handle_request']);
        add_action('wp_ajax_aipkit_delete_automated_task_queue_items_by_status', [$delete_queue_items_action, 'handle_request']);
        add_action('wp_ajax_aipkit_retry_automated_task_queue_item', [$retry_queue_item_action, 'handle_request']);
    }

    // All previous ajax_* methods are now moved to their respective action classes.
}
