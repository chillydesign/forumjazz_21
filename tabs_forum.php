<?php $site_url = site_url(); ?>
<form id="search_concerts_form">
    <div class="button_group">
        <a href="<?php echo $site_url; ?>/forum" class="button"><?php _e('Programmation', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/intervenants" class="button"><?php _e('Intervenants', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/participants" class="button"><?php _e('Participants', 'blankslate'); ?></a>
    </div>
    <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
</form>