<?php /* Template Name: Extra Template */  ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $concerts  = get_posts(array(
            'post_type' => 'extra',
            'posts_per_page' => -1,
        ));
        $concerts = processConcerts($concerts);

        ?>

        <header id="page_header">
            <div class="container">
                <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            </div>
        </header>

        <section>

            <div class="container">
                <?php $site_url = site_url(); ?>
                <form id="search_concerts_form">
                    <div class="button_group">
                        <a href="<?php echo $site_url; ?>/concerts" class="button"><?php _e('Programmation', 'blankslate'); ?></a>
                        <a href="<?php echo $site_url; ?>/jeune-public" class="button"><?php _e('Sélection jeune public', 'blankslate'); ?></a>
                        <a href="<?php echo $site_url; ?>/extras" class="button"><?php _e('Extras', 'blankslate'); ?></a>
                    </div>
                    <input type="text" id="search_concerts" placeholder="<?php _e('rechercher', 'blankslate'); ?> ..." />
                </form>

                <div id="concert_grid" class="jeune_concert_grid">
                    <?php foreach ($concerts as $concert) : ?>

                        <!--END OF concert_location_box -->
                        <div class="concert_location_box">
                            <div class="concert_box" data-search="<?php echo $concert->search; ?>">
                                <h4 style="background-image:url('<?php echo $concert->image; ?>')">
                                    <a href="<?php echo $concert->guid; ?>">
                                        <span> <?php echo $concert->post_title . ' - ' . $concert->time; ?></span>
                                    </a>
                                </h4>
                            </div>


                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
        </section>



<?php endwhile;
endif; ?>
<?php get_footer(); ?>