<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/post-enhancer/ajax/actions/generate-title.php
// Status: MODIFIED

namespace WPAICG\PostEnhancer\Ajax\Actions;

use WPAICG\PostEnhancer\Ajax\Base\AIPKit_Post_Enhancer_Base_Ajax_Action;
use function WPAICG\PostEnhancer\Ajax\Base\get_post_content_snippet_logic;
use function WPAICG\PostEnhancer\Ajax\Base\generate_suggestions_logic;

class AIPKit_PostEnhancer_Generate_Title extends AIPKit_Post_Enhancer_Base_Ajax_Action {
    public function handle(): void {
        $permission_check = $this->check_permissions('aipkit_generate_title_nonce');
        if (is_wp_error($permission_check)) { $this->send_error_response($permission_check); return; }
        
        $post = $this->get_post();
        if (is_wp_error($post)) { $this->send_error_response($post); return; }

        $original_title = trim($post->post_title);
        $post_content_snippet = get_post_content_snippet_logic($post);

        $prompt_template = 'Generate exactly 5 alternative titles for a blog post based on the following information.' . "\n" .
                           'Return ONLY the 5 titles, each on a new line.' . "\n" .
                           'Do NOT include any introduction, explanation, numbering, or markdown formatting (like **).' . "\n\n" .
                           'Original title: "{title}"' . "\n" .
                           'Post content snippet: "{content}"';

        $prompt = str_replace(['{title}', '{content}'], [$original_title, $post_content_snippet], $prompt_template);
        $final_prompt = apply_filters('aipkit_post_enhancer_title_prompt', $prompt, $post->ID);
        
        generate_suggestions_logic('title', $post, $final_prompt);
    }
}