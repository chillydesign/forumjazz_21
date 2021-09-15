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

                <?php $image =  get_field('image',  "user_" . $intervenant->ID); ?>
                <?php $structure =  get_field('structure_name',  "user_" . $intervenant->ID); ?>
                <?php $position =  get_field('structure_position',  "user_" . $intervenant->ID); ?>

                <div class="participant_container">
                    <div class="participant_image" style="background-image: url('<?php echo $image; ?>');">
                    </div>
                    <div class="participant_text">
                        <h3>
                            <?php echo ($intervenant->first_name); ?>
                            <?php echo ($intervenant->last_name); ?>
                        </h3>
                        <p> <strong><?php echo $structure; ?></strong> <br>
                            <em class="overflow"><?php echo $position; ?></em>
                        </p>
                    </div>

                </div>

            <?php endforeach ?>
        </div>
    </div>
</section>