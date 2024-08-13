<?php
/**
 *
 * Plugin Name: Simple Short Link
 * Plugin URI: https://wordpress.org/plugins/simple-short-link/
 * Description: Makes short links to your posts without any external services or database bloat.
 * Version: 1.0.3
 * Author: Abdoo
 * Author URI: https://abdoo.me
 * License: GPLv2 or later
 * Text Domain: simple-short-link
 * Domain Path: /languages
 *
 * ===================================================================
 * 
 * Copyright 2024  Abdullatif Al-Mayhob, Abdoo abdoo.mayhob@gmail.com
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 3, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * ===================================================================
 * 
 * TODO:
 * - Add support for CPTs
 */

// If this file is called directly, abort.
defined('ABSPATH') or die;

// Load Translation Files, Only needed in admin area.
add_action('admin_init', function () {
    load_plugin_textdomain('simple-short-link', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

// Enqueue scripts and styles
add_action('admin_enqueue_scripts', function ($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        wp_enqueue_script('simple-short-link-js', plugin_dir_url(__FILE__) . 'simple-short-link.js', [], '1.0.0', true);
        // wp_enqueue_style('simple-short-link-css', plugin_dir_url(__FILE__) . 'simple-short-link.css', [], '1.0.0');
    }
});

// Shortlink Box
add_action('add_meta_boxes', function() {
    add_meta_box(
        'shortlink-box', 
        __('Short Link', 'simple-short-link'), 
        'ssl_simple_shortlink_meta_box_cb', 
        'post', 
        'side', 
        'high'
    );
});

function ssl_simple_shortlink_meta_box_cb($post) {
    // Short Link Works only on published posts.
    if ('publish' !== $post->post_status) {
        echo esc_html_e('Short Link is for Published Posts Only.', 'simple-short-link');
        return;
    }
    $post_link = site_url() . '/?p=' . $post->ID;
    ?>
    <input type="text" value="<?php echo esc_url($post_link); ?>" id="shortlink" readonly>
    <button type="button" class="button" id="copy-shortlink"><?php esc_html_e('Copy', 'simple-short-link'); ?></button>
    <?php
}
