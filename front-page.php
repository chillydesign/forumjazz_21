<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <section id="welcome_section">
                <div class="container">


                    <div class="welcome_text">
                        <h1>Forum Jazz</h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit libero molestiae sed tempore, inventore quasi reprehenderit, nihil tenetur a illo itaque commodi quod aspernatur optio provident laudantium asperiores? Illo, rem.</p>
                    </div>

                    <ul class="welcome_buttons">
                        <li><a href="#"><strong> CONCERTS & SHOWCASES</strong><span>Ouverts au public & aux professionnels dans la limite des places disponibles.</span></a></li>
                        <li><a href="#"><strong>RENCONTRES</strong><span>Uniquement accessible aux professionnels et étudiants sur inscription.</span></a></li>
                        <li><a href="#"><strong>EXTRAS</strong><span>
                                    Expositions, masterclass & autres évènements autour du forum.</span></a></li>
                    </ul>



                    <?php include('img/truck.svg'); ?>
                </div>
            </section>


            <section id="who_are_we">
                <div class="container">

                    <h2>Qui sommes nous</h2>
                    <div class="columns">
                        <div class="column">
                            <iframe height="315" src="https://www.youtube-nocookie.com/embed/aHwzzSYhHrs" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                        <div class="column">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid doloremque numquam quas facilis necessitatibus tenetur illum laboriosam modi dolorum fuga excepturi porro nemo vel ullam fugiat rem, facere sunt dicta.</p>

                            <a href="#" class="button">A propos du forum jazz</a>
                        </div>
                    </div>
                </div>

            </section>

            <section id="concerts_and_rencontres">

                <div class="concert_recontre_thing" id="concerts_thing">

                    <h3>GRAND PUBLIC / PROFESSIONNELS / JEUNE PUBLIC</h3>
                    <div class="columns">
                        <div class="column">
                            <div class="concert_recontre_text">
                                <h2> CONCERTS & SHOWCASES</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur odit, quidem nam eligendi placeat fuga mollitia voluptas et magnam similique sapiente eveniet deleniti necessitatibus temporibus natus ipsum.</p>

                                <a href="#" class="button">Programmation</a>
                                <a href="#" class="button">Résonance & Extras </a>
                                <a href="#" class="button">Jeune public</a>
                                <a href="#" class="button">Billiterie</a>
                            </div>
                        </div>
                        <div class="column">
                            <div style="width:100%;height:400px;background:#666">IMAGE</div>
                        </div>
                    </div>
                </div>

                <div class="concert_recontre_thing" id="recontres_thing">

                    <div class="columns">
                        <div class="column">
                            <div style="width:100%;height:400px;background:#666">IMAGE</div>

                        </div>
                        <div class="column">
                            <div class="concert_recontre_text">
                                <h3>
                                    <div class="columns">
                                        <div class="column"></div>
                                        <div class="column">
                                            <span class="h3_offset">
                                                PROFESSIONNELS / ETUDIANTS
                                            </span>
                                        </div>
                                    </div>
                                </h3>
                                <h2>RENCONTRES</h2>


                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sapiente reiciendis ipsa deserunt officiis est possimus ea id blanditiis beatae illum, at iusto nulla, libero quo fuga quasi quos ipsum dolor.</p>

                                <a href="#" class="button">Programmation</a>
                                <a href="#" class="button">Intervenants </a>
                                <a href="#" class="button">Participants</a>
                                <a href="#" class="button">Pass pro forum</a>

                            </div>
                        </div>
                    </div>
                </div>






            </section>

        </article>

<?php endwhile;
endif; ?>
<?php get_footer(); ?>