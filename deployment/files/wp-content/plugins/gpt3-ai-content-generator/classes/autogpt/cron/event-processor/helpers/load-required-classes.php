<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/autogpt/cron/event-processor/helpers/load-required-classes.php
// Status: NEW FILE

namespace WPAICG\AutoGPT\Cron\EventProcessor\Helpers;

use WPAICG\Vector\PostProcessor\OpenAI\OpenAIPostProcessor;
use WPAICG\Vector\PostProcessor\Pinecone\PineconePostProcessor;
use WPAICG\Vector\PostProcessor\Qdrant\QdrantPostProcessor;
use WPAICG\Core\AIPKit_AI_Caller;
use WPAICG\ContentWriter\Prompt\AIPKit_Content_Writer_System_Instruction_Builder;
use WPAICG\ContentWriter\Prompt\AIPKit_Content_Writer_User_Prompt_Builder;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ensures all processor-related classes are loaded.
 *
 * @return void
 */
function load_required_classes_logic(): void
{
    $classes_to_load = [
        OpenAIPostProcessor::class => WPAICG_PLUGIN_DIR . 'classes/vector/post-processor/openai/class-openai-post-processor.php',
        PineconePostProcessor::class => WPAICG_PLUGIN_DIR . 'classes/vector/post-processor/pinecone/class-pinecone-post-processor.php',
        QdrantPostProcessor::class => WPAICG_PLUGIN_DIR . 'classes/vector/post-processor/qdrant/class-qdrant-post-processor.php',
        AIPKit_AI_Caller::class => WPAICG_PLUGIN_DIR . 'classes/core/class-aipkit_ai_caller.php',
        AIPKit_Content_Writer_System_Instruction_Builder::class => WPAICG_PLUGIN_DIR . 'classes/content-writer/prompt/class-aipkit-content-writer-system-instruction-builder.php',
        AIPKit_Content_Writer_User_Prompt_Builder::class => WPAICG_PLUGIN_DIR . 'classes/content-writer/prompt/class-aipkit-content-writer-user-prompt-builder.php',
    ];

    foreach ($classes_to_load as $class_name => $file_path) {
        if (!class_exists($class_name) && file_exists($file_path)) {
            require_once $file_path;
        }
    }
}
