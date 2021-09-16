<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


        <?php $welcome_text =  get_field('welcome_text'); ?>
        <?php $who_we_are =  get_field('who_we_are'); ?>
        <?php $who_we_are_video =  get_field('who_we_are_video'); ?>
        <?php $concerts_box =  get_field('concerts_box'); ?>
        <?php $rencontres_box =  get_field('rencontres_box'); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <section id="welcome_section" class="always_visible">

                <div class="welcome_text">
                    <?php echo $welcome_text; ?>
                </div>

                <ul class="welcome_buttons">
                    <li><a href="<?php echo get_home_url(); ?>/concerts"><strong> <?php _e('Concerts', 'blankslate'); ?></strong><span><?php _e('Ouverts au public & aux professionnels dans la limite des places disponibles.', 'blankslate'); ?></span></a></li>
                    <li><a href="<?php echo get_home_url(); ?>/rencontres"><strong><?php _e('Rencontres & showcases', 'blankslate'); ?></strong><span><?php _e('Uniquement accessible aux professionnels et étudiants sur inscription.', 'blankslate'); ?></span></a></li>
                    <li><a href="<?php echo get_home_url(); ?>/extras"><strong><?php _e('Extras', 'blankslate'); ?></strong><span><?php _e('Expositions, masterclass & autres évènements autour du forum.', 'blankslate'); ?>
                            </span></a></li>
                </ul>

                <?php include('img/truck.svg'); ?>
                <div id="jazz_canvas"></div>
            </section>


            <section id="who_are_we">
                <div class="container">

                    <h2>Qui sommes nous</h2>
                    <div class="columns">
                        <div class="column">
                            <?php echo $who_we_are_video; ?>

                        </div>
                        <div class="column">
                            <?php echo $who_we_are; ?>



                        </div>
                    </div>
                </div>

            </section>

            <section id="concerts_and_rencontres">



                <div class="concert_recontre_thing" id="recontres_thing">

                    <div class="columns columns_reversed">

                        <div class="column">
                            <div class="concert_recontre_text">
                                <h3>
                                    <div class="columns columns_reversed">

                                        <div class="column">
                                            <span class="h3_offset">
                                                PROFESSIONNELS / ETUDIANTS
                                            </span>
                                        </div>
                                        <div class="column"></div>
                                    </div>
                                </h3>


                                <?php echo $rencontres_box; ?>



                            </div>
                        </div>
                        <div class="column">
                            <div class="conc_rec_image"></div>
                        </div>
                    </div>
                </div>

                <div class="concert_recontre_thing" id="concerts_thing">

                    <h3>GRAND PUBLIC / PROFESSIONNELS / JEUNE PUBLIC</h3>
                    <div class="columns ">
                        <div class="column">
                            <div class="concert_recontre_text">
                                <?php echo $concerts_box; ?>

                            </div>
                        </div>
                        <div class="column">
                            <div class="conc_rec_image"></div>
                        </div>
                    </div>
                </div>





            </section>

        </article>

<?php endwhile;
endif; ?>
<?php get_footer(); ?>