<?php get_header(); ?>
<header id="page_header">
    <div class="container">
        <h1 class="entry-title" itemprop="name"><?php single_term_title(); ?></h1>
        <div class="archive-meta" itemprop="description"><?php if ('' != the_archive_description()) {
                                                                echo esc_html(the_archive_description());
                                                            } ?></div>
    </div>
</header>
<section>
    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php get_template_part('entry'); ?>
        <?php endwhile;
        endif; ?>
    </div>
</section>
<?php get_template_part('nav', 'below'); ?>
<?php get_footer(); ?>