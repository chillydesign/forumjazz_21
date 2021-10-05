<?php $participants = get_users(
    array(
        'role__in' =>  array('participant', 'intervenant'),
        'number' => -1,
        'orderby' => array('meta_value', 'login'),
        'meta_key' => 'last_name',
        'order' => 'ASC',
    )
); ?>

<section class="section section_participants">


    <div class="container">
        <?php get_template_part('tabs_forum', null, array('hide_search' => true)); ?>


        <div class="participants_container">


            <?php foreach ($participants as $participant) : ?>

                <?php $image = user_structure_image($participant->ID); ?>
                <?php $structure =  get_field('structure_name',  "user_" . $participant->ID); ?>
                <?php $position =  get_field('structure_position',  "user_" . $participant->ID); ?>
                <?php $website =  get_field('structure_website',  "user_" . $participant->ID); ?>

                <div class="participant_container">
                    <div class="participant_image" style="background-image: url('<?php echo $image; ?>');">
                    </div>
                    <div class="participant_text">
                        <h3>
                            <?php echo ($participant->first_name); ?>
                            <?php echo ($participant->last_name); ?>
                        </h3>
                        <p> <strong><?php echo $structure; ?>&nbsp;</strong> <br>
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