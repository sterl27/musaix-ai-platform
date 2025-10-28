<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/autogpt/cron/event-processor/processor/content-indexing/qdrant-post-index-processor.php
// Status: NEW FILE

namespace WPAICG\AutoGPT\Cron\EventProcessor\Processor\ContentIndexing;

use WPAICG\Vector\PostProcessor\Qdrant\QdrantPostProcessor;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Processes a single Qdrant content indexing queue item.
 *
 * @param array $item The queue item from the database.
 * @param array $item_config The decoded item_config from the queue item.
 * @return array ['status' => 'success'|'error', 'message' => '...']
 */
function process_qdrant_indexing_logic(array $item, array $item_config): array
{
    if (!class_exists(QdrantPostProcessor::class)) {
        return ['status' => 'error', 'message' => "Qdrant Vector Post Processor class not found."];
    }
    $processor = new QdrantPostProcessor();
    $post_id_to_index = absint($item['target_identifier']);
    $target_store_id = $item_config['target_store_id'] ?? null;
    $embedding_provider = $item_config['embedding_provider'] ?? null;
    $embedding_model = $item_config['embedding_model'] ?? null;

    if (empty($target_store_id) || empty($embedding_provider) || empty($embedding_model)) {
        return ['status' => 'error', 'message' => "Missing configuration for Qdrant indexing task (collection, embedding provider, or model)."];
    }

    return $processor->index_single_post_to_collection($post_id_to_index, $target_store_id, $embedding_provider, $embedding_model);
}
