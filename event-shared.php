<?php $website = get_field('website'); ?>
<?php $texte_de_presentation = get_field('texte_de_presentation'); ?>
<?php $date = get_field('date'); ?>
<?php $time =  get_field('time'); ?>
<?php $location = get_field('location'); ?>
<?php // $image = thumbnail_of_post_url(get_the_ID(), 'large'); 
?>
<?php $image = get_field('image'); ?>
<?php $ticketing = get_field('ticketing'); ?>
<?php $line_up = get_field('line_up'); ?>
<?php $video_clip = get_field('video_clip'); ?>
<?php $subtitle = get_field('subtitle'); ?>
<?php $intervenants = get_field('intervenants'); ?>
<?php $moderateurs = get_field('moderateur'); ?>
<?php $facebook = get_field('facebook'); ?>
<?php $instagram = get_field('instagram'); ?>
<?php $spotify = get_field('spotify'); ?>
<?php $youtube = get_field('youtube'); ?>
<?php $socials = ['website', 'facebook', 'instagram', 'spotify', 'youtube']; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <section>
        <header>

            <?php if ($subtitle) : ?>
                <h2 class="event_subtitle"><?php echo $subtitle; ?></h2>
            <?php endif; ?>
        </header>

        <div class="columns">
            <div class="column">

                <div class="event_datetime_container">
                    <?php if ($date) : ?>
                        <?php generate_date_box($date); ?>
                    <?php endif; ?>
                    <div class="event_time_container">
                        <h1 class="entry-title" itemprop="headline"> <?php the_title(); ?></h1>

                        <p>
                            <span class="time"><?php echo $time; ?></span>
                            <?php if ($ticketing) : ?>
                                | <a href="<?php echo $ticketing; ?>"><?php _e('Billets', 'blankslate'); ?> </a>
                            <?php endif; ?>
                        </p>

                    </div>
                </div>

                <?php echo $texte_de_presentation; ?>

                <div class="social_links">
                    <?php foreach ($socials as $social) : ?>
                        <?php if ($$social) : ?>
                            <a class="<?php echo $social; ?>" href="<?php echo $$social; ?>" target="_blank"><span><?php echo $social; ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>


                <?php if ($line_up) : ?>
                    <h3><?php _e('Line up', 'blankslate'); ?></h3>
                    <div class="lineup"> <?php echo $line_up; ?></div>
                <?php endif; ?>




                <?php if ($location) : ?>
                    <?php $location_title = $location->post_title; ?>
                    <?php $location_address = get_field('address', $location->ID); ?>
                    <?php $lieu_json  = lieu_to_map_json($location); ?>
                    <h3><?php _e('Lieu', 'blankslate'); ?>: <?php echo $location_title; ?></h3>
                    <?php if ($lieu_json) : ?>
                        <div id="map_container"></div>
                        <script>
                            const map_locations = [

                                <?php echo json_encode($lieu_json); ?>
                            ];
                            const theme_directory = '<?php echo get_template_directory_uri(); ?>';
                        </script>
                    <?php endif; ?>
                    <?php if ($location_address) : ?>
                        <p><?php echo $location_address; ?></p>
                    <?php endif; ?>
                <?php endif; ?>


            </div>
            <div class="column">

                <?php if ($image) : ?>
                    <img src="<?php echo $image['sizes']['medium']; ?>" alt="<?php echo get_the_title(); ?>" />
                <?php endif; ?>

                <?php if ($video_clip) :; ?>
                    <?php $youtube_id = youtube_id_from_url($video_clip); ?>
                    <iframe style="width: 100%" width="560" height="549" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe>
                <?php endif; ?>

                <?php if ($ticketing) : ?>
                    <a class="button button_block button_large" href="<?php echo $ticketing; ?>"><?php _e('Billets', 'blankslate'); ?></a>
                <?php endif; ?>

                <?php if ($intervenants) : ?>
                    <h3><?php _e('Intervenants', 'blankslate'); ?></h3>
                    <div class="participants_container participants_container_small">
                        <?php foreach ($intervenants as $intervenant) : ?>
                            <?php $user_image = user_structure_image($intervenant['ID']); ?>
                            <?php $structure =  get_field('structure_name',  "user_" . $intervenant['ID']); ?>
                            <div class="participant_container">
                                <div class="participant_image" style="background-image: url('<?php echo $user_image; ?>');">
                                </div>
                                <div class="participant_text">
                                    <h3>
                                        <?php echo ($intervenant['user_firstname']); ?>
                                        <?php echo ($intervenant['user_lastname']); ?>
                                    </h3>
                                    <p> <strong><?php echo $structure; ?> </strong>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif; ?>
                <?php if ($moderateurs) : ?>
                    <h3><?php _e('Modérateur', 'blankslate'); ?></h3>
                    <div class="participants_container participants_container_small">
                        <?php foreach ($moderateurs as $moderateur) : ?>
                            <?php $user_image = user_structure_image($moderateur['ID']); ?>
                            <?php $structure =  get_field('structure_name',  "user_" . $moderateur['ID']); ?>
                            <div class="participant_container">
                                <div class="participant_image" style="background-image: url('<?php echo $user_image; ?>');">
                                </div>
                                <div class="participant_text">
                                    <h3>
                                        <?php echo ($moderateur['user_firstname']); ?>
                                        <?php echo ($moderateur['user_lastname']); ?>
                                    </h3>
                                    <p> <strong><?php echo $structure; ?> </strong>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif; ?>



                <?php $can_signup = get_field('can_signup'); ?>
                <?php $event_id =  get_the_ID(); ?>
                <?php if ($can_signup) : ?>
                    <?php if (isset($_GET['success'])) : ?>
                        <p class="alert alert_success"><?php _e('Votre inscription a été enregistrée.', 'blankslate'); ?></p>
                    <?php endif; ?>
                    <?php if (isset($_GET['problem'])) : ?>
                        <p class="alert alert_problem"> <?php _e("Une erreur s'est produite. Veuillez réessayer.", 'blankslate'); ?></p>
                    <?php endif; ?>
                    <?php $max_signups = get_field('max_signups'); ?>
                    <?php $current_signup_count = current_signup_count($event_id); ?>
                    <?php if ($current_signup_count < $max_signups) : ?>
                        <?php $current_user_id = get_current_user_id(); ?>
                        <?php if ($current_user_id) : ?>
                            <?php $has_signedup_already = user_signup_to_post($event_id, $current_user_id); ?>
                            <?php if (!$has_signedup_already) : ?>

                                <?php $bought_free_prod =  chilly_customer_already_bought_product(2839); ?>
                                <div class="alert">
                                    <p><strong> <?php _e("L’accès gratuit à cet événement est réservé aux professionnels de la diffusion, dans la limite des places disponibles.", 'blankslate'); ?></strong></p>
                                    <p><?php _e("Nombre de places disponibles restantes pour cet évènement :", 'blankslate'); ?>
                                        <?php echo $max_signups - $current_signup_count; ?>
                                    </p>
                                    <?php if ($bought_free_prod) : ?>
                                        <form action="<?php echo   esc_url(admin_url('admin-post.php')); ?>" method="post">
                                            <input type="hidden" name="post_id" value="<?php echo $event_id; ?>" />
                                            <input type="hidden" name="action" value="signup_form">
                                            <button type="submit"> <?php _e("S'inscrire", 'blankslate'); ?></button>
                                        </form>
                                    <?php else : ?>
                                        <p><strong> <?php _e("Veuillez prendre le pass gratuit diffuseurs pour vous inscrire.", 'blankslate'); ?></strong></p>
                                        <a class="button" href="https://forumjazz.com/pass-pro/"><?php _e("Choisir le pass", 'blankslate'); ?></a>
                                    <?php endif; ?>
                                </div>

                            <?php else : ?>
                                <?php if (!isset($_GET['success'])) : ?>
                                    <p class="alert"> <?php _e("Vous êtes déjà inscrit(e) à cet évènement.", 'blankslate'); ?></p>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else : ?>



                            <?php $url = $_SERVER['REQUEST_URI']; ?>
                            <div class="alert">
                                <p><strong> <?php _e("L’accès gratuit à cet événement est réservé aux professionnels de la diffusion, dans la limite des places disponibles.", 'blankslate'); ?></strong></p>
                                <p><?php _e("Veuillez réserver un Pass Pro correspondant à la date de l’événement afin de vous permettre l’accès aux inscriptions.", 'blankslate'); ?></p>
                                <p> <?php _e("Si vous avez déjà réservé le Pass Pro correspondant, veuillez-vous connecter à votre compte personnel afin de vous inscrire à cet événement.", 'blankslate'); ?></p>
                                <div class="button_group">
                                    <a class="button" href="<?php echo  wp_login_url($url); ?> "> <?php _e("Connexion", 'blankslate'); ?></a>

                                    <a class="button" href="<?php echo  site_url('pass-pro'); ?> "><?php _e("Réserver un Pass Pro", 'blankslate'); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <p class="alert"> <?php _e("L'évènement est complet.", 'blankslate'); ?></p>
                    <?php endif; ?>
                <?php endif; ?>



            </div>
        </div>
    </section>
</article>