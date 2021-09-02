<?php $background =  get_sub_field('background'); ?>
<?php $title =  get_sub_field('title'); ?>
<section class="section  section_colonnes <?php echo $background; ?>  ">



    <div class="container">
        <?php if ($title) : ?>
            <h2 class="sectiontitle"><?php echo $title; ?></h2>
        <?php endif; ?>
        <div class="columns">

            <?php while (have_rows('columns')) : the_row(); ?>
                <div class="column ">
                    <?php echo get_sub_field('content'); ?>
                </div>
            <?php endwhile; ?>
        </div> <!-- END OF columns -->

    </div><!--  END OF CONTAINER -->

</section>