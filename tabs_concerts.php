<?php $site_url = site_url(); ?>

<form id="search_concerts_form">
    <div class="button_group">
        <a href="<?php echo $site_url; ?>/concerts" class="button"><?php _e('Programmation', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/jeune-public" class="button"><?php _e('Sélection jeune public', 'blankslate'); ?></a>
        <a href="<?php echo $site_url; ?>/extras" class="button"><?php _e('Extras', 'blankslate'); ?></a>
    </div>
    <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
</form>