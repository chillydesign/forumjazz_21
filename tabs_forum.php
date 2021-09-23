<?php $site_url = site_url(); ?>
<form id="search_concerts_form">
    <div class="button_group">


        <?php get_permalink(get_page_by_path('rencontres')); ?>

        <a href="<?php get_permalink(get_page_by_path('rencontres')); ?>?subpage=programme" class="button"><?php _e('Programme', 'blankslate'); ?></a>
        <a href="<?php get_permalink(get_page_by_path('rencontres')); ?>?subpage=rencontres" class="button"><?php _e('Rencontres', 'blankslate'); ?></a>
        <a href="<?php get_permalink(get_page_by_path('rencontres')); ?>?subpage=showcases" class="button"><?php _e('Showcases', 'blankslate'); ?></a>
        <a href="<?php get_permalink(get_page_by_path('extras-forum')); ?>" class="button"><?php _e('Extras Forum', 'blankslate'); ?></a>
        <a href="<?php get_permalink(get_page_by_path('intervenants')); ?>" class="button"><?php _e('Intervenants', 'blankslate'); ?></a>
        <a href="<?php get_permalink(get_page_by_path('participants')); ?>" class="button"><?php _e('Participants', 'blankslate'); ?></a>


    </div>
    <?php if (!$args['hide_search']) : ?>
        <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
    <?php endif; ?>
</form>