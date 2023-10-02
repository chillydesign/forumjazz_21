<?php /* Template Name: Concerts Template */  ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $dates =  array(
            array('date' => '2023-11-29', 'nice_date' =>  __('Mercredi', 'blankslate') .  '<br>29 nov.', 'concerts' => array()),
            array('date' => '2023-11-30', 'nice_date' =>  __('Jeudi', 'blankslate') .  '<br>30 nov.', 'concerts' => array()),
            array('date' => '2023-12-01', 'nice_date' =>  __('Vendredi', 'blankslate') .  '<br>01 déc.', 'concerts' => array()),
            array('date' => '2023-12-02', 'nice_date' =>  __('Samedi', 'blankslate') .  '<br>02 déc.', 'concerts' => array()),
            array('date' => '2023-12-03', 'nice_date' =>  __('Dimanche', 'blankslate') .  '<br>03 déc.', 'concerts' => array()),
        );

        $tax_query = array(
            array(
                'taxonomy' => 'concert_category',
                'field'    => 'slug',
                'terms' => array('concert-tous-publics', 'jeune-public'),
                'operator' => 'IN'
            )
        );
        $concerts  = get_posts(array(
            'post_type' => 'concert',
            'posts_per_page' => -1,
            'tax_query'      =>  $tax_query,
            'suppress_filters' => 0, // stop wpml giving posts from all languages
        ));
        $processed_dates =  processDatesForConcertGrid($dates, $concerts);



        $margegare1 =  new stdClass();
        $margegare1->location = null;
        $margegare1->location_name = "Marché gare";
        $margegare1->post_title = "Afficher les showcases pro du Marché Gare";
        $margegare1->image = 'https://forumjazz.com/wp-content/uploads/2023/09/2JEUDI-30.11-SHOWCASES-MARCHE-GARE-300x300.jpg';
        $margegare1->time = '18:00';
        $margegare1->search_time = '18:00';
        $margegare1->url = "https://marchegare.fr/agenda/forum-jazz-2023-0";
        $margegare2 = clone $margegare1;
        $margegare2->url = "https://marchegare.fr/agenda/forum-jazz-2023";
        $margegare2->image = 'https://forumjazz.com/wp-content/uploads/2023/09/VENDREDI-01.12-SHOWCASES-MARCHE-GARE-400x300.jpg';

        array_push($processed_dates[1]['concerts'], $margegare1);
        array_push($processed_dates[2]['concerts'], $margegare2);


        ?>

        <header id="page_header">
            <div class="container">
                <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            </div>
        </header>


        <section>

            <div class="container">


                <?php get_template_part('tabs_concerts'); ?>

                <div id="concert_grid">
                    <div class="columns">


                        <?php foreach ($processed_dates as $date) : ?>
                            <div class="column">

                                <h2><?php echo $date['nice_date']; ?></h2>
                                <div>
                                    <?php $cur_location = false; ?>
                                    <?php foreach ($date['concerts'] as $concert) : ?>
                                        <?php if ($concert->location_name && $cur_location != $concert->location_name) : ?>
                                </div>
                                <!--END OF concert_location_box -->
                                <div class="concert_location_box">
                                    <h3 class="concert_h3"> <?php echo ($concert->location_name); ?> </h3>
                                <?php endif; ?>
                                <div class="concert_box" data-search="<?php echo $concert->search; ?>">
                                    <h4 style="background-image:url('<?php echo $concert->image; ?>')">
                                        <a href="<?php echo $concert->url; ?>">
                                            <span> <?php echo $concert->time . ' - ' . $concert->post_title; ?></span>
                                        </a>
                                    </h4>
                                </div>


                                <?php $cur_location = $concert->location_name; ?>
                            <?php endforeach; ?>
                                </div>
                            </div>

                        <?php endforeach; ?>


                    </div>
                </div>
            </div>
        </section>






<?php endwhile;
endif; ?>
<?php get_footer(); ?>