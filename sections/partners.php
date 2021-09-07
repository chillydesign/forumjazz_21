<?php $title =  get_sub_field('title_nav'); ?>

<section class="section  section_partners">

    <div class="container">
        <h2><?php echo get_sub_field('title'); ?></h2>
        <div class="partners">
            <?php while (have_rows('partners')) : the_row(); ?>
                <div class="partner">
                    <a href="<?php echo get_sub_field('lien'); ?>" target="_blank">
                        <div class="partner_picture" style="background-image:url('<?php echo get_sub_field('photo')['sizes']['medium']; ?>')"></div>
                        <?php $description = get_sub_field('description'); ?>
                        <?php if ($description) : ?>
                            <div class="partner_description">
                                <p><?php echo $description; ?></p>
                            </div>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endwhile; ?>
        </div>

    </div><!--  END OF CONTAINER -->

</section>