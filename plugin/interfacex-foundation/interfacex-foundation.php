<?php
/**
 * Plugin Name: InterfaceX Foundation
 * Description: Serves the existing InterfaceX frontend on its shortcode page.
 * Version: 0.3.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

defined('ABSPATH') || exit;

add_shortcode('interfacex_request', static function (): string {
    $script_path = __DIR__ . '/assets/app/interfacex-app.js';
    $style_path = __DIR__ . '/assets/app/interfacex-app.css';

    if (!is_readable($script_path) || !is_readable($style_path)) {
        return '<p class="interfacex-build-error" role="alert">InterfaceX assets are missing. Rebuild them from the demo_website project.</p>';
    }

    wp_enqueue_style(
        'interfacex-app',
        plugins_url('assets/app/interfacex-app.css', __FILE__),
        [],
        (string) filemtime($style_path)
    );
    wp_enqueue_script(
        'interfacex-app',
        plugins_url('assets/app/interfacex-app.js', __FILE__),
        [],
        (string) filemtime($script_path),
        true
    );

    return '<div class="interfacex-wordpress-app" data-interfacex-app-root><p class="interfacex-loading" role="status">Loading InterfaceX...</p></div><noscript>Enable JavaScript to use the InterfaceX workspace.</noscript>';
});
