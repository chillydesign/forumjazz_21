<?php get_header(); ?>
<article id="post-0" class="post not-found">
    <header id="page_header">
        <div class="container">
            <h1 class="entry-title" itemprop="name"><?php esc_html_e('Not Found', 'blankslate'); ?></h1>
        </div>
    </header>

    <section>
        <div class="container">
            <div class="entry-content" itemprop="mainContentOfPage">
                <p><?php esc_html_e('Nothing found for the requested page. Try a search instead?', 'blankslate'); ?></p>
                <?php get_search_form(); ?>
            </div>
        </div>
    </section>
</article>

<?php get_footer(); ?>