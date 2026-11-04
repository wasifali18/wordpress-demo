<?php

$pages = [
    'home' => [
        'title' => 'Home',
        'content' => '',
    ],
    'interfacex' => [
        'title' => 'InterfaceX',
        'content' => '[interfacex_request]',
    ],
];

$page_ids = [];

foreach ($pages as $slug => $page_data) {
    $page = get_page_by_path($slug, OBJECT, 'page');

    if ($page instanceof WP_Post) {
        $result = wp_update_post([
            'ID' => $page->ID,
            'post_status' => 'publish',
            'post_name' => $slug,
            'post_title' => $page_data['title'],
            'post_content' => $page_data['content'],
        ], true);

        if (is_wp_error($result)) {
            WP_CLI::error(sprintf('Could not update the "%s" page: %s', $slug, $result->get_error_message()));
        }

        $page_ids[$slug] = (int) $page->ID;
        continue;
    }

    $page_id = wp_insert_post([
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_name' => $slug,
        'post_title' => $page_data['title'],
        'post_content' => $page_data['content'],
    ], true);

    if (is_wp_error($page_id)) {
        WP_CLI::error(sprintf('Could not create the "%s" page: %s', $slug, $page_id->get_error_message()));
    }

    $page_ids[$slug] = (int) $page_id;
}

update_option('show_on_front', 'page');
update_option('page_on_front', $page_ids['home']);

WP_CLI::success('Theme, plugin, and stable pages are ready.');
