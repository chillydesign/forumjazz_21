<?php /* Template Name: Concerts Template */  ?>
<?php get_header(); ?>

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

foreach ($concerts as $concert) {
    $concert_date = get_field('date',  $concert->ID);

    $date_index = array_search($concert_date, array_column($dates, 'date'));
    if (is_int($date_index)) {
        $concert->location = get_field('location', $concert->ID);
        $concert->time = get_field('time',  $concert->ID);
        $concert->image = thumbnail_of_post_url($concert->ID, 'medium');

        if ($concert->location) {
            $concert->location_name = $concert->location->post_title;
            $concert->search = sanitize_title($concert->location_name . ' ' . $concert->post_title);
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

        <form>
            <input type="text" id="search_concerts" placeholder="rechercher ..." />
        </form>
        <div id="concert_grid">
            <div class="columns">
                <?php foreach ($dates as $date) : ?>
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
<?php get_footer(); ?>