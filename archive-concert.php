<?php get_header(); ?>

<?php
$dates =  array(
    array('date' => '2021-11-24', 'nice_date' =>  'Wednesday 24', 'concerts' => array()),
    array('date' => '2021-11-25', 'nice_date' =>  'Thursday 25', 'concerts' => array()),
    array('date' => '2021-11-26', 'nice_date' =>  'Friday 26', 'concerts' => array()),
    array('date' => '2021-11-27', 'nice_date' =>  'Saturday 27', 'concerts' => array()),
);

$concerts  = get_posts(array(
    'post_type' => 'concert',
    'posts_per_page' => -1
));

foreach ($concerts as $concert) {
    $concert_date = get_field('date',  $concert->ID);
    $date_index = array_search($concert_date, array_column($dates, 'date'));
    if (is_int($date_index)) {
        $concert->location = get_field('location', $concert->ID);
        if ($concert->location) {
            $concert->location_name = $concert->location->post_title;
            array_push($dates[$date_index]['concerts'], $concert);
        }
    }
}

// for some reason this doesnt work with a normal foreach loop
for ($d = 0; $d < sizeof($dates); $d++) {
    usort($dates[$d]['concerts'], "sort_by_location_name");
}




?>

<header id="page_header">
    <div class="container">
        <h1 class="entry-title" itemprop="name">Concerts</h1>
    </div>
</header>


<section>


    <div class="container">
        <div id="concert_grid">
            <div class="columns">
                <?php foreach ($dates as $date) : ?>
                    <div class="column">

                        <h2><?php echo $date['nice_date']; ?></h2>

                        <?php $cur_location = false; ?>
                        <?php foreach ($date['concerts'] as $concert) : ?>
                            <div class="concerts">
                                <?php if ($concert->location_name && $cur_location != $concert->location_name) : ?>
                                    <h3> <?php echo ($concert->location_name); ?> </h3>
                                <?php endif; ?>
                                <h4>
                                    <a href="<?php echo $concert->guid; ?>">
                                        <span> <?php echo ($concert->post_title); ?></span>
                                    </a>
                                </h4>
                            </div>
                            <?php $cur_location = $concert->location_name; ?>
                        <?php endforeach; ?>
                    </div>

                <?php endforeach; ?>


            </div>
        </div>
    </div>
</section>


<section>

    <div class="container">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>



                <div class="event_summary">

                    <div class="event_datetime_container">

                        <?php $categories = get_the_terms(get_the_ID(), 'concert_category'); ?>
                        <?php $cat_names = cat_names_from_categories($categories); ?>
                        <?php $date = get_field('date',  get_the_ID()); ?>
                        <?php $url  = get_the_permalink();    ?>
                        <?php if ($date) : ?>
                            <?php generate_date_box($date); ?>
                        <?php endif; ?>
                        <div class="event_time_container">
                            <h2> <a href="<?php echo $url; ?>"><?php the_title(); ?></a></h2>
                            <?php if ($cat_names) : ?>
                                <p class="category"><?php echo $cat_names; ?></p>
                            <?php endif; ?>
                            <a href="<?php echo $url; ?>" class="button">Lire plus</a>
                        </div>
                    </div>
                </div>

        <?php endwhile;
        endif; ?>

    </div>


</section>



</div>
<?php get_footer(); ?>