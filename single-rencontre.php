<?php get_header(); ?>
<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <p class="breadcrumbs"><a href="<?php echo get_permalink(322); ?>?subpage=rencontres"><?php _e('retour', 'webfactor'); ?></a></p>
            <?php get_template_part('event-shared'); ?>

    <?php endwhile;
    endif; ?>

</div>
<?php get_footer(); ?>