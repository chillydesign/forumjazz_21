<?php $participants = get_users(
    array(
        'role' => 'participant',
        'number' => -1,
        'orderby' => array('meta_value', 'login'),
        'meta_key' => 'last_name',
        'order' => 'ASC',
    )
); ?>


<section class="section section_participants">


    <div class="container">
        <?php get_template_part('tabs_forum', null, array('hide_search' => true)); ?>


        <div class="participant_containers">


            <?php foreach ($participants as $participant) : ?>

                <?php
                $image = null;
                $image_id =  get_field('structure_image',  "user_" . $participant->ID);
                if ($image_id) {
                    $image_src = wp_get_attachment_image_src($image_id, 'medium');
                    if ($image_src) {
                        $image = $image_src[0];
                    }
                }
                if (!$image) {
                    $image = get_avatar_url($participant->user_email);
                }
                $structure =  get_field('structure_name',  "user_" . $participant->ID);
                $position =  get_field('structure_position',  "user_" . $participant->ID);

                ?>



                <div class="participant_container">
                    <div class="participant_image" style="background-image: url('<?php echo $image; ?>');">
                    </div>
                    <div class="participant_text">
                        <h3>
                            <?php echo ($participant->first_name); ?>
                            <?php echo ($participant->last_name); ?>
                        </h3>
                        <p> <strong><?php echo $structure; ?></strong> <br>
                            <em><?php echo $position; ?></em>
                        </p>
                    </div>


                </div>

            <?php endforeach ?>
        </div>
    </div>
</section>