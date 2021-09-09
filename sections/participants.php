<?php $participants = get_users(
    array(
        'role' => 'participant',
        'number' => -1
    )
); ?>


<section class="section section_participants">


    <div class="container">

        <div class="participant_containers">


            <?php foreach ($participants as $participant) : ?>

                <?php $image =  get_field('image',  "user_" . $participant->ID); ?>
                <?php $structure =  get_field('structure_name',  "user_" . $participant->ID); ?>
                <?php $position =  get_field('structure_position',  "user_" . $participant->ID); ?>
                <div class="participant_container">
                    <div class="participant_image">
                        <?php if ($image) : ?>
                            <!-- <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo ($participant->display_name); ?>" /> -->
                        <?php endif; ?>
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