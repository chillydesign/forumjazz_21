<?php get_header(); ?>
<div class="container">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <header id="page_header">
                <div class="container">
                    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                </div>
            </header>


            <section>
                <meta itemprop="description" content="<?php echo wp_strip_all_tags(get_the_excerpt(), true); ?>" />
                <?php the_content(); ?>
            </section>

    <?php endwhile;
    endif; ?>

</div>
<?php get_footer(); ?>