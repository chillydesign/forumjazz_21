<?php get_header(); ?>
<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <p class="breadcrumbs">
                <?php $for_forum = has_term('showcase', 'concert_category'); ?>
                <?php if ($for_forum) : ?>
                    <a href="<?php echo get_permalink(322); ?>?subpage=programme"><?php _e('retour', 'webfactor'); ?></a>
                <?php else : ?>
                    <a href="<?php echo get_permalink(320); ?>?subpage=programme"><?php _e('retour', 'webfactor'); ?></a>
                <?php endif; ?>
            </p>


            <?php get_template_part('event-shared'); ?>



    <?php endwhile;
    endif; ?>

</div>
<?php get_footer(); ?>