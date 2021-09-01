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
                    <li><a href="#"><strong> Concerts & showcases</strong><span>Ouverts au public & aux professionnels dans la limite des places disponibles.</span></a></li>
                    <li><a href="#"><strong>Rencontres</strong><span>Uniquement accessible aux professionnels et étudiants sur inscription.</span></a></li>
                    <li><a href="#"><strong>Extras</strong><span>
                                Expositions, masterclass & autres évènements autour du forum.</span></a></li>
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


                            <a href="#" class="button">A propos du forum jazz</a>
                        </div>
                    </div>
                </div>

            </section>

            <section id="concerts_and_rencontres">

                <div class="concert_recontre_thing" id="concerts_thing">

                    <h3>GRAND PUBLIC / PROFESSIONNELS / JEUNE PUBLIC</h3>
                    <div class="columns ">
                        <div class="column">
                            <div class="concert_recontre_text">
                                <?php echo $concerts_box; ?>
                                <a href="#" class="button button_yellow">Programmation</a>
                                <a href="#" class="button button_yellow">Résonance & Extras </a>
                                <a href="#" class="button button_yellow">Jeune public</a>
                                <a href="#" class="button  button_large button_yellow">Billiterie</a>
                            </div>
                        </div>
                        <div class="column">
                            <div class="conc_rec_image"></div>
                        </div>
                    </div>
                </div>

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

                                <a href="#" class="button">Programmation</a>
                                <a href="#" class="button">Intervenants </a>
                                <a href="#" class="button">Participants</a>
                                <a href="#" class="button button_large">Pass pro forum</a>

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