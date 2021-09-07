<?php $participants = get_users(
    array(
        'role' => 'participant',
        'number' => -1
    )
); ?>


<section class="section section_participants">


    <div class="container">


        <?php foreach ($participants as $participant) : ?>
            <div class="participant_container">
                <h3><?php echo ($participant->display_name); ?></h3>
            </div>

        <?php endforeach ?>

    </div>
</section>