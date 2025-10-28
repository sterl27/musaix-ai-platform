<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/autogpt/class-aipkit-automated-task-cron.php

namespace WPAICG\AutoGPT;

// Use statement for the modularized logic functions namespace
use WPAICG\AutoGPT\Cron\Init;
// Import cron helper classes needed by the logic files or orchestrator
use WPAICG\AutoGPT\Cron\AIPKit_Automated_Task_Scheduler;
use WPAICG\AutoGPT\Cron\AIPKit_Automated_Task_Event_Processor;
use WPAICG\aipkit_dashboard;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// --- Require the new logic files ---
$init_logic_path = __DIR__ . '/cron/init/';
require_once $init_logic_path . 'ensure-dashboard-loaded.php';
require_once $init_logic_path . 'check-module-status.php';
require_once $init_logic_path . 'ensure-table-exists.php';
require_once $init_logic_path . 'evaluate-status-flags.php';
require_once $init_logic_path . 'register-main-cron-hook.php';
require_once $init_logic_path . 'attach-main-hook-action.php';
require_once $init_logic_path . 'attach-individual-task-hooks.php';
// --- End Require ---

/**
 * Orchestrates cron scheduling and processing for Automated Tasks using helper classes.
 * The init() method is now a clean orchestrator.
 */
class AIPKit_Automated_Task_Cron
{
    public const MAIN_CRON_HOOK = 'aipkit_process_automated_task_queue';

    /**
     * Initializes the main cron hook and ensures task-specific actions are hooked.
     * This method now delegates its logic to modularized functions.
     */
    public static function init()
    {
        // 1. Ensure Dashboard is loaded for module status check
        if (!Init\ensure_dashboard_loaded_logic()) {
            return; // Critical dependency missing
        }

        // 2. Check if AutoGPT module is active. If not, stop here.
        if (!Init\check_module_status_logic(self::MAIN_CRON_HOOK)) {
            return;
        }

        global $wpdb;
        $tasks_table_name = $wpdb->prefix . 'aipkit_automated_tasks';

        // 3. Ensure the database table exists. If not, stop here.
        if (!Init\ensure_table_exists_logic($wpdb, $tasks_table_name, self::MAIN_CRON_HOOK)) {
            return;
        }

        // 4. Evaluate current task status vs saved option to see if main cron needs an update
        $status_flags = Init\evaluate_status_flags_logic($wpdb, $tasks_table_name);

        // 5. Register or un-register the main hourly cron hook based on flags
        Init\register_main_cron_hook_logic(self::MAIN_CRON_HOOK, $status_flags['active_task_count'], $status_flags['pending_queue_count'], $status_flags['did_active_tasks_exist']);

        // 6. Attach the action for the main queue processing hook
        Init\attach_main_hook_action_logic(self::MAIN_CRON_HOOK);

        // 7. Attach actions for each individual task's cron event
        Init\attach_individual_task_hooks_logic($wpdb, $tasks_table_name);
    }
}
