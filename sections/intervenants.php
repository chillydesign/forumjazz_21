<?php $intervenants = get_users(
    array(
        'role' => 'intervenant',
        'number' => -1,
        'orderby' => array('meta_value', 'login'),
        'meta_key' => 'last_name',
        'order' => 'ASC',
    )
); ?>


<section class="section section_intervenants">


    <div class="container">
        <?php get_template_part('tabs_forum', null, array('hide_search' => true)); ?>
        <div class="participants_container">


            <?php foreach ($intervenants as $intervenant) : ?>

                <?php $image = user_structure_image($intervenant->ID); ?>
                <?php $structure =  get_field('structure_name',  "user_" . $intervenant->ID); ?>
                <?php $position =  get_field('structure_position',  "user_" . $intervenant->ID); ?>
                <?php $website =  get_field('structure_website',  "user_" . $intervenant->ID); ?>

                <div class="participant_container">
                    <div class="participant_image" style="background-image: url('<?php echo $image; ?>');">
                    </div>
                    <div class="participant_text">
                        <h3>
                            <?php echo ($intervenant->first_name); ?>
                            <?php echo ($intervenant->last_name); ?>
                        </h3>
                        <p><strong><?php echo $structure; ?>&nbsp;</strong> <br>
                            <em class="overflow"><?php echo $position; ?></em>
                        </p>
                    </div>
                    <?php if ($website) : ?>
                        <span class="social_links">
                            <a class="website" title="site web" href="<?php echo $website; ?>" target="_blank"></a>
                        </span>
                    <?php endif; ?>
                </div>

            <?php endforeach ?>
        </div>
    </div>
</section>