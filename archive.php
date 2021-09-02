<?php get_header(); ?>


<div class="container">
    <header id="page_header">
        <h1 class="entry-title" itemprop="name"><?php the_archive_title(); ?></h1>
        <div class="archive-meta" itemprop="description"><?php if ('' != the_archive_description()) {
                                                                echo esc_html(the_archive_description());
                                                            } ?></div>
    </header>

    <section>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('entry'); ?>
        <?php endwhile;
        endif; ?>
    </section>

    <?php get_template_part('nav', 'below'); ?>
</div>

<?php get_footer(); ?>