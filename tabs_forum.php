<?php $site_url = site_url(); ?>
<form id="search_concerts_form">
    <div class="button_group">



        <a href="<?php get_permalink(322); ?>?subpage=programme" class="button"><?php _e('Programme', 'blankslate'); ?></a>
        <a href="<?php get_permalink(322); ?>?subpage=rencontres" class="button"><?php _e('Rencontres', 'blankslate'); ?></a>
        <a href="<?php get_permalink(322); ?>?subpage=showcases" class="button"><?php _e('Showcases', 'blankslate'); ?></a>
        <a href="<?php get_permalink(705); ?>" class="button"><?php _e('Extras Forum', 'blankslate'); ?></a>
        <a href="<?php get_permalink(331); ?>" class="button"><?php _e('Intervenants', 'blankslate'); ?></a>
        <a href="<?php get_permalink(298); ?>" class="button"><?php _e('Participants', 'blankslate'); ?></a>


    </div>
    <?php if (!$args['hide_search']) : ?>
        <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
    <?php endif; ?>
</form>