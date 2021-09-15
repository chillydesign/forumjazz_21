<?php $site_url = site_url(); ?>
<form id="search_concerts_form">
    <div class="button_group">
        <a href="<?php echo $site_url; ?>/rencontres?subpage=programme" class="button"><?php _e('Programme', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/rencontres?subpage=rencontres" class="button"><?php _e('Rencontres', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/rencontres?subpage=showcases" class="button"><?php _e('Showcases', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/intervenants" class="button"><?php _e('Intervenants', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/participants" class="button"><?php _e('Participants', 'blankslate'); ?></a>
    </div>
    <?php if (!$args['hide_search']) : ?>
        <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
    <?php endif; ?>
</form>