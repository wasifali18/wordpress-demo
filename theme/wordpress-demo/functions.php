<?php

add_action('after_setup_theme', static function (): void {
    add_theme_support('title-tag');
});

add_action('wp_enqueue_scripts', static function (): void {
    wp_enqueue_style(
        'wordpress-demo-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );
});
