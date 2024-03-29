<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


        <?php $welcome_text =  get_field('welcome_text'); ?>
        <?php $who_we_are =  get_field('who_we_are'); ?>
        <?php $who_we_are_video =  get_field('who_we_are_video'); ?>
        <?php $concerts_box =  get_field('concerts_box'); ?>
        <?php $rencontres_box =  get_field('rencontres_box'); ?>
        <?php $concert_photo =  get_field('concert_photo'); ?>
        <?php $rencontres_photo =  get_field('rencontres_photo'); ?>
        <?php $concert_image =  ($concert_photo) ? $concert_photo['sizes']['large'] : ''; ?>
        <?php $rencontres_image =  ($rencontres_photo) ?  $rencontres_photo['sizes']['large'] : ''; ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <section id="welcome_section" class="always_visible">

                <div class="welcome_text">
                    <?php echo $welcome_text; ?>
                </div>

                <ul class="welcome_buttons">

                    <li style="display:none"><a href="<?php echo get_home_url(); ?>/conference-de-presse/"><strong><?php _e('Conférence de Presse', 'blankslate'); ?></strong><span><?php _e('Le 26 septembre 2023 au Périscope, Lyon', 'blankslate'); ?></span></a></li>
                    <li><a href="<?php echo get_home_url(); ?>/concerts"><strong> <?php _e('Concerts', 'blankslate'); ?></strong><span><?php _e('Ouverts au public & aux professionnels dans la limite des places disponibles.', 'blankslate'); ?></span></a></li>
                    <li><a href="<?php echo get_home_url(); ?>/rencontres"><strong><?php _e('Forum professionel & showcases', 'blankslate'); ?></strong><span><?php _e('Uniquement accessible aux professionnels et étudiants sur inscription.', 'blankslate'); ?></span></a></li>
                    <li><a href="<?php echo get_home_url(); ?>/billetterie"><strong><?php _e('Billetterie', 'blankslate'); ?></strong><span><?php _e('Achetez vos tickets pour les concerts ou notre pass professionnel', 'blankslate'); ?>
                            </span></a></li>
                </ul>
                <?php $tdu = get_template_directory_uri(); ?>
                <img src="<?php echo $tdu; ?>/img/metronome.png" style="max-width: 400px;position: absolute;top: 40px;  left: 30px;" alt="Metronome" />
                <?php // include('img/truck.svg'); 
                ?>
                <div id="jazz_canvas"></div>
            </section>

            <div class="container">
                <div class="who_we_are_video_container">
                    <?php echo $who_we_are_video; ?>
                </div>
            </div>



            <section id="who_are_we">
                <div class="container">

                    <h2><?php _e('UN FORUM JAZZ, UN FORUM DE MUSIQUES !', 'blankslate'); ?></h2>
                    <div style="padding: 0 50px">
                        <?php echo $who_we_are; ?>
                    </div>
                    <div class="columns">
                        <div class="column">


                        </div>
                        <div class="column">




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
                                                <?php _e('PROFESSIONNELS / ETUDIANTS', 'blankslate'); ?>
                                            </span>
                                        </div>
                                        <div class="column"></div>
                                    </div>
                                </h3>


                                <?php echo $rencontres_box; ?>



                            </div>
                        </div>
                        <div class="column">
                            <div class="conc_rec_image" style="background-image: url('<?php echo $concert_image; ?>')"></div>
                        </div>
                    </div>
                </div>

                <div class="concert_recontre_thing" id="concerts_thing">

                    <h3><?php _e('GRAND PUBLIC / PROFESSIONNELS / JEUNE PUBLIC', 'blankslate'); ?></h3>
                    <div class="columns ">
                        <div class="column">
                            <div class="concert_recontre_text">
                                <?php echo $concerts_box; ?>
                            </div>
                        </div>
                        <div class="column">
                            <div class="conc_rec_image" style="background-image: url('<?php echo $rencontres_image; ?>')"></div>
                        </div>
                    </div>
                </div>





            </section>

        </article>

<?php endwhile;
endif; ?>
<?php get_footer(); ?>