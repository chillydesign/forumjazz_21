<?php $website = get_field('website'); ?>
<?php $texte_de_presentation = get_field('texte_de_presentation'); ?>
<?php $date = get_field('date'); ?>
<?php $time = get_field('time'); ?>
<?php $location = get_field('location'); ?>
<?php // $image = thumbnail_of_post_url(get_the_ID(), 'large'); 
?>
<?php $image = get_field('image'); ?>
<?php $ticketing = get_field('ticketing'); ?>
<?php $line_up = get_field('line_up'); ?>
<?php $video_clip = get_field('video_clip'); ?>
<?php $subtitle = get_field('subtitle'); ?>
<?php $intervenants = get_field('intervenants'); ?>
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
                            | <a href="<?php echo $ticketing; ?>"><?php _e('Tickets', 'blankslate'); ?> </a>
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


                <?php if ($intervenants) : ?>
                    <h3><?php _e('Intervenants', 'blankslate'); ?>Line up</h3>
                    <?php var_dump($intervenants); ?>
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
                    <a class="button button_block button_large" href="<?php echo $ticketing; ?>"><?php _e('Tickets', 'blankslate'); ?></a>
                <?php endif; ?>


            </div>
        </div>
    </section>
</article>