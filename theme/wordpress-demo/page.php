<?php get_header(); ?>
<main class="site-main page-main<?php echo is_page('interfacex') ? ' interface-page' : ''; ?>">
    <?php while (have_posts()) : ?>
        <?php the_post(); ?>
        <article <?php post_class(); ?>>
            <h1><?php the_title(); ?></h1>
            <div class="page-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>
<?php get_footer(); ?>
