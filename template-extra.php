<?php /* Template Name: Extra Template */  ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $concerts  = get_posts(array(
            'post_type' => 'extra',
            'posts_per_page' => -1,
            'suppress_filters' => 0, // stop wpml giving posts from all languages
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
                <?php get_template_part('tabs_concerts'); ?>

                <div id="concert_grid" class="jeune_concert_grid">
                    <?php foreach ($concerts as $concert) : ?>

                        <!--END OF concert_location_box -->
                        <div class="concert_location_box">
                            <div class="concert_box" data-search="<?php echo $concert->search; ?>">
                                <h4 style="background-image:url('<?php echo $concert->image; ?>')">
                                    <a href="<?php echo $concert->url; ?>">
                                        <span> <?php echo $concert->time . ' - ' . $concert->post_title; ?></span>
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