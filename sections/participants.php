<?php $participants = get_users(
    array(
        'role' => 'participant',
        'number' => -1
    )
); ?>


<section class="section section_participants">


    <div class="container">


        <?php foreach ($participants as $participant) : ?>

            <?php $image =  get_field('image',  "user_" . $participant->ID); ?>
            <div class="participant_container">
                <h3><?php echo ($participant->display_name); ?></h3>

                <?php if ($image) : ?>
                    <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo ($participant->display_name); ?>" />
                <?php endif; ?>
            </div>

        <?php endforeach ?>

    </div>
</section>