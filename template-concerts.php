<?php /* Template Name: Concerts Template */  ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php
        $dates =  array(
            array('date' => '2021-11-24', 'nice_date' =>  'Mercredi 24', 'concerts' => array()),
            array('date' => '2021-11-25', 'nice_date' =>  'Jeudi 25', 'concerts' => array()),
            array('date' => '2021-11-26', 'nice_date' =>  'Vendredi 26', 'concerts' => array()),
            array('date' => '2021-11-27', 'nice_date' =>  'Samedi 27', 'concerts' => array()),
        );

        $concerts  = get_posts(array(
            'post_type' => 'concert',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'concert_category',
                    'field'    => 'slug',
                    'terms' => 'showcase',
                    'operator' => 'NOT IN'
                )
            )
        ));
        $processed_dates =  processDatesForConcertGrid($dates, $concerts);





        ?>

        <header id="page_header">
            <div class="container">
                <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            </div>
        </header>


        <section>


            <div class="container">

                <form id="search_concerts_form">
                    <div class="button_group">
                        <a href="#" class="button">Programmation</a>
                        <a href="#" class="button">Sélection jeune public</a>
                        <a href="#" class="button">Jeune public</a>
                    </div>
                    <input type="text" id="search_concerts" placeholder="rechercher ..." />
                </form>

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
                                        <a href="<?php echo $concert->guid; ?>">
                                            <span> <?php echo $concert->post_title . ' - ' . $concert->time; ?></span>
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





        </div>
<?php endwhile;
endif; ?>
<?php get_footer(); ?>