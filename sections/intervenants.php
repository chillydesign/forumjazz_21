<?php $intervenants = get_users(
    array(
        'role' => 'intervenant',
        'number' => -1
    )
); ?>


<section class="section section_intervenants">


    <div class="container">
        <?php get_template_part('tabs_forum', null, array('hide_search' => true)); ?>
        <div class="intervenant_containers">


            <?php foreach ($intervenants as $intervenant) : ?>

                <?php $image =  get_field('image',  "user_" . $intervenant->ID); ?>
                <?php $structure =  get_field('structure_name',  "user_" . $intervenant->ID); ?>
                <?php $position =  get_field('structure_position',  "user_" . $intervenant->ID); ?>
                <div class="intervenant_container">
                    <h3>
                        <?php echo ($intervenant->first_name); ?>

                        <?php echo ($intervenant->last_name); ?>
                    </h3>
                    <p> <strong><?php echo $structure; ?></strong> &nbsp; <?php echo $position; ?></p>
                    <?php if ($image) : ?>
                        <!-- <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo ($intervenant->display_name); ?>" /> -->
                    <?php endif; ?>
                </div>

            <?php endforeach ?>
        </div>
    </div>
</section>