<form id="search_concerts_form">
    <div class="button_group">
        <a href="<?php echo get_permalink(320); ?>" class="button"><?php _e('Programmation', 'blankslate'); ?></a>
        <a href="<?php echo get_permalink(359); ?>" class="button"><?php _e('Sélection jeune public', 'blankslate'); ?></a>
        <a href="<?php echo get_permalink(329); ?>" class="button"><?php _e('Extras', 'blankslate'); ?></a>

        <?php $brochure_file = get_field('brochure'); ?>
        <?php if ($brochure_file) : ?>
            <a href="<?php echo $brochure_file['url']; ?>" target="_blank" class="button"><?php _e('Télécharger le programme', 'blankslate'); ?></a>
        <?php endif; ?>


    </div>
    <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
</form>