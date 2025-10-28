<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/autogpt/cron/event-processor/trigger/trigger-content-indexing-task.php
// Status: MODIFIED

namespace WPAICG\AutoGPT\Cron\EventProcessor\Trigger;

use WPAICG\AutoGPT\Cron\AIPKit_Automated_Task_Content_Queuer;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Triggers the queuing logic for a content indexing task.
 *
 * @param int $task_id The ID of the task.
 * @param array $task_config The configuration of the task.
 * @param string|null $last_run_time The last time the task was run.
 * @return void
 */
function trigger_content_indexing_task_logic(int $task_id, array $task_config, ?string $last_run_time): void
{
    // Case 1: Handle the one-time bulk index.
    if (isset($task_config['index_existing_now_flag']) && $task_config['index_existing_now_flag'] === '1') {
        AIPKit_Automated_Task_Content_Queuer::maybe_queue_initial_indexing_content($task_id, $task_config, false);
    }

    // Case 2: Handle the ongoing sync of new/updated content.
    if (isset($task_config['only_new_updated_flag']) && $task_config['only_new_updated_flag'] === '1') {
        AIPKit_Automated_Task_Content_Queuer::queue_new_or_updated_indexing_content($task_id, $task_config, $last_run_time);
    }
}
