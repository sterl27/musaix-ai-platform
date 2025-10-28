<?php

// File: /Applications/MAMP/htdocs/wordpress/wp-content/plugins/gpt3-ai-content-generator/classes/content-writer/class-aipkit-image-injector.php
// Status: MODIFIED

namespace WPAICG\ContentWriter;

use SplQueue;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Handles injecting generated image HTML into post content based on placement rules.
 */
class AIPKit_Image_Injector
{
    /**
     * Main injection method that routes to specific placement logic.
     *
     * @param string $content The HTML content of the post.
     * @param array $images An array of image data items from the generation API.
     * @param string $placement The placement rule (e.g., 'after_first_h2', 'at_end').
     * @param int $param_x Optional parameter for 'every_x' placements.
     * @param string $alignment Optional alignment class ('none', 'left', 'center', 'right').
     * @param string $image_size Optional display size for injected images ('thumbnail', 'medium', 'large', 'full').
     * @return string The content with images injected.
     */
    public function inject_images(string $content, array $images, string $placement, int $param_x = 2, string $alignment = 'none', string $image_size = 'large'): string
    {
        if (empty($images) || empty(trim($content))) {
            return $content;
        }

        switch ($placement) {
            case 'after_first_h2':
                return $this->inject_after_first_h2($content, $images, $alignment, $image_size);

            case 'after_first_h3':
                return $this->inject_after_first_h3($content, $images, $alignment, $image_size);

            case 'after_every_x_h2':
                return $this->inject_after_every_x_heading($content, $images, $param_x, 'h2', $alignment, $image_size);

            case 'after_every_x_h3':
                return $this->inject_after_every_x_heading($content, $images, $param_x, 'h3', $alignment, $image_size);

            case 'after_every_x_p':
                return $this->inject_after_every_x_paragraph($content, $images, $param_x, $alignment, $image_size);

            case 'at_end':
                return $this->inject_at_end($content, $images, $alignment, $image_size);

            default:
                // Fallback to after first h2 if placement is unknown
                return $this->inject_after_first_h2($content, $images, $alignment, $image_size);
        }
    }

    /**
     * Injects the first available image after the first <h2> tag.
     *
     * @param string $content The HTML content.
     * @param array $images The array of image data.
     * @param string $alignment The alignment class.
     * @param string $image_size The image size.
     * @return string Modified content.
     */
    private function inject_after_first_h2(string $content, array $images, string $alignment, string $image_size): string
    {
        $image_html = $this->get_image_html($images[0], $alignment, $image_size);
        if (empty($image_html)) {
            return $content;
        }

        $position = stripos($content, '</h2>');
        if ($position !== false) {
            return substr_replace($content, '</h2>' . "\n\n" . $image_html . "\n\n", $position, 5);
        }
        // Fallback: append if no h2 found
        return $content . "\n\n" . $image_html;
    }

    /**
     * Injects the first available image after the first <h3> tag.
     *
     * @param string $content The HTML content.
     * @param array $images The array of image data.
     * @param string $alignment The alignment class.
     * @param string $image_size The image size.
     * @return string Modified content.
     */
    private function inject_after_first_h3(string $content, array $images, string $alignment, string $image_size): string
    {
        $image_html = $this->get_image_html($images[0], $alignment, $image_size);
        if (empty($image_html)) {
            return $content;
        }

        $position = stripos($content, '</h3>');
        if ($position !== false) {
            return substr_replace($content, '</h3>' . "\n\n" . $image_html . "\n\n", $position, 5);
        }
        // Fallback: append if no h3 found
        return $content . "\n\n" . $image_html;
    }

    /**
     * Injects an image after every X specified heading tag.
     *
     * @param string $content The HTML content.
     * @param array $images The array of image data.
     * @param int $x The number of headings to skip between insertions.
     * @param string $heading_tag The heading tag (e.g., 'h2', 'h3').
     * @param string $alignment The alignment class.
     * @param string $image_size The image size.
     * @return string Modified content.
     */
    private function inject_after_every_x_heading(string $content, array $images, int $x, string $heading_tag, string $alignment, string $image_size): string
    {
        if ($x <= 0) {
            return $this->inject_at_end($content, $images, $alignment, $image_size); // Fallback if X is invalid
        }

        $image_html_array = array_map(fn ($img) => $this->get_image_html($img, $alignment, $image_size), $images);
        $image_queue = new SplQueue();
        foreach ($image_html_array as $img_html) {
            $image_queue->enqueue($img_html);
        }

        if ($image_queue->isEmpty()) {
            return $content;
        }

        $parts = preg_split('/(<\/' . $heading_tag . '>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        $new_content = '';
        $heading_count = 0;

        foreach ($parts as $i => $part) {
            $new_content .= $part;
            // The delimiter is captured, so it's every other part starting from index 1
            if ($i > 0 && ($i % 2) !== 0) {
                $heading_count++;
                if ($heading_count % $x === 0 && !$image_queue->isEmpty()) {
                    $new_content .= "\n\n" . $image_queue->dequeue() . "\n\n";
                }
            }
        }

        // Add any remaining images at the end
        while (!$image_queue->isEmpty()) {
            $new_content .= "\n\n" . $image_queue->dequeue();
        }

        return $new_content;
    }

    /**
     * Injects an image after every X paragraphs.
     *
     * @param string $content The HTML content.
     * @param array $images The array of image data.
     * @param int $x The number of paragraphs to skip between insertions.
     * @param string $alignment The alignment class.
     * @param string $image_size The image size.
     * @return string Modified content.
     */
    private function inject_after_every_x_paragraph(string $content, array $images, int $x, string $alignment, string $image_size): string
    {
        if ($x <= 0) {
            return $this->inject_at_end($content, $images, $alignment, $image_size);
        }

        $image_html_array = array_map(fn ($img) => $this->get_image_html($img, $alignment, $image_size), $images);
        $image_queue = new SplQueue();
        foreach ($image_html_array as $img_html) {
            $image_queue->enqueue($img_html);
        }

        if ($image_queue->isEmpty()) {
            return $content;
        }

        $parts = preg_split('/(<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        $new_content = '';
        $p_count = 0;

        foreach ($parts as $i => $part) {
            $new_content .= $part;
            if ($i > 0 && ($i % 2) !== 0) {
                $p_count++;
                if ($p_count % $x === 0 && !$image_queue->isEmpty()) {
                    $new_content .= "\n\n" . $image_queue->dequeue() . "\n\n";
                }
            }
        }
        while (!$image_queue->isEmpty()) {
            $new_content .= "\n\n" . $image_queue->dequeue();
        }
        return $new_content;
    }

    /**
     * Appends all images to the end of the content.
     *
     * @param string $content The HTML content.
     * @param array $images The array of image data.
     * @param string $alignment The alignment class.
     * @param string $image_size The image size.
     * @return string Modified content.
     */
    private function inject_at_end(string $content, array $images, string $alignment, string $image_size): string
    {
        $image_html_array = array_map(fn ($img) => $this->get_image_html($img, $alignment, $image_size), $images);
        return $content . "\n\n" . implode("\n\n", $image_html_array);
    }

    /**
     * Generates a standard WordPress <img> tag.
     *
     * @param array|null $image_item The image data.
     * @param string $alignment The requested alignment ('none', 'left', 'center', 'right').
     * @param string $image_size The requested WP image size ('thumbnail', 'medium', 'large', 'full').
     * @return string The generated HTML or an empty string.
     */
    private function get_image_html(?array $image_item, string $alignment = 'none', string $image_size = 'large'): string
    {
        if (empty($image_item) || empty($image_item['attachment_id'])) {
            return '';
        }
        $attachment_id = absint($image_item['attachment_id']);
        $alt_text = esc_attr($image_item['revised_prompt'] ?? get_the_title($attachment_id) ?: 'AI Generated Image');

        // Get image data (URL, width, height) for the specified size from WordPress
        $image_attributes = wp_get_attachment_image_src($attachment_id, $image_size);

        if (!$image_attributes) {
            // Fallback to full size if the requested size doesn't exist.
            $image_attributes = wp_get_attachment_image_src($attachment_id, 'full');
            if (!$image_attributes) {
                // Final fallback: use raw URL and no dimensions if something is wrong.
                $url = esc_url($image_item['media_library_url'] ?? '');
                $width_attr = '';
                $height_attr = '';
                $size_class = 'size-full';
            } else {
                list($url, $width, $height) = $image_attributes;
                $url = esc_url($url);
                $width_attr = sprintf(' width="%d"', $width);
                $height_attr = sprintf(' height="%d"', $height);
                $size_class = 'size-full';
            }
        } else {
            list($url, $width, $height) = $image_attributes;
            $url = esc_url($url);
            $width_attr = sprintf(' width="%d"', $width);
            $height_attr = sprintf(' height="%d"', $height);
            $size_class = 'size-' . esc_attr($image_size);
        }

        // --- Build Classes ---
        $class_list = [];

        // 1. Alignment class
        if (in_array($alignment, ['left', 'right', 'center', 'none'], true)) {
            $class_list[] = 'align' . $alignment;
        }

        // 2. WordPress image ID class
        $class_list[] = 'wp-image-' . $attachment_id;

        // 3. Size class
        $class_list[] = $size_class;

        $final_classes = esc_attr(implode(' ', $class_list));

        // Assemble the final <img> tag
        // phpcs:ignore PluginCheck.CodeAnalysis.ImageFunctions.NonEnqueuedImage -- Reason: The image source is correctly retrieved using a WordPress function (e.g., `wp_get_attachment_image_url`). The `<img>` tag is constructed manually to build a custom HTML structure with specific wrappers, classes, or attributes that are not achievable with the standard `wp_get_attachment_image()` function.
        return sprintf('<img class="%s" src="%s" alt="%s"%s%s />',
            $final_classes,
            $url,
            $alt_text,
            $width_attr,
            $height_attr
        );
    }
}
