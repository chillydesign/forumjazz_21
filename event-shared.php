<?php $website = get_field('website'); ?>
<?php $texte_de_presentation = get_field('texte_de_presentation'); ?>
<?php $date = get_field('date'); ?>
<?php $month = month_of($date); ?>
<?php $day = day_of($date); ?>
<?php $time = get_field('time'); ?>
<?php $location = get_field('location'); ?>
<?php $ticketing = get_field('ticketing'); ?>
<?php $line_up = get_field('line_up'); ?>
<?php $video_clip = get_field('video_clip'); ?>
<?php $subtitle = get_field('subtitle'); ?>
<?php $facebook = get_field('facebook'); ?>
<?php $instagram = get_field('instagram'); ?>
<?php $spotify = get_field('spotify'); ?>
<?php $youtube = get_field('youtube'); ?>
<?php $socials = ['website', 'facebook', 'instagram', 'spotify', 'youtube']; ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <section>
        <header>
            <h1 class="entry-title" itemprop="headline"> <?php the_title(); ?></h1>
            <?php if ($subtitle) : ?>
                <h2 class="event_subtitle"><?php echo $subtitle; ?></h2>
            <?php endif; ?>
        </header>

        <div class="columns">
            <div class="column">



                <div class="event_datetime_container">
                    <div class="event_date_container">
                        <div class="month"><?php echo $month; ?></div>
                        <div class="day"><?php echo $day; ?></div>
                    </div>
                    <div class="event_time_container">

                        <p>
                            <?php echo $time; ?>
                            <?php if ($ticketing) : ?>
                                | <a href="<?php echo $ticketing; ?>">Tickets</a>
                            <?php endif; ?>

                        </p>
                        <?php echo $line_up; ?>
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

                <?php if ($location) : ?>
                    <?php $location_title = $location->post_title; ?>
                    <?php $location_address = get_field('address', $location->ID); ?>
                    <?php $partenaire_json  = partenaire_to_map_json($location); ?>
                    <h3> Lieu: <?php echo $location_title; ?></h3>
                    <?php if ($partenaire_json) : ?>
                        <div id="map_container"></div>
                        <script>
                            const map_locations = [

                                <?php echo json_encode($partenaire_json); ?>
                            ];
                        </script>
                    <?php endif; ?>
                    <?php if ($location_address) : ?>
                        <p><?php echo $location_address; ?></p>
                    <?php endif; ?>
                <?php endif; ?>


            </div>
            <div class="column">

                <?php if ($video_clip) :; ?>
                    <?php $youtube_id = youtube_id_from_url($video_clip); ?>
                    <iframe style="width: 100%" width="560" height="549" src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope" allowfullscreen></iframe>
                <?php endif; ?>

                <?php if ($ticketing) : ?>
                    <a class="button button_block button_large" href="<?php echo $ticketing; ?>">Tickets</a>
                <?php endif; ?>


            </div>
        </div>
    </section>
</article>