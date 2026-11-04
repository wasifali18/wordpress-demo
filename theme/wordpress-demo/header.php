<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="site-header-inner">
        <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>">
            <span class="brand-mark" aria-hidden="true">I</span>
            <span><?php echo esc_html(get_bloginfo('name')); ?></span>
        </a>
        <nav class="site-nav" aria-label="<?php esc_attr_e('Main navigation', 'wordpress-demo'); ?>">
            <a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Overview', 'wordpress-demo'); ?></a>
            <a class="nav-cta" href="<?php echo esc_url(home_url('/interfacex/')); ?>">
                <?php esc_html_e('Open InterfaceX', 'wordpress-demo'); ?>
                <span aria-hidden="true">&rarr;</span>
            </a>
        </nav>
    </div>
</header>
