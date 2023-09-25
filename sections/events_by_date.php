<?php $tax_query = array(
    array(
        'taxonomy' => 'concert_category',
        'field'    => 'slug',
        'terms' => 'showcase',
        'operator' => 'NOT IN'
    )
);

// only display events if show_in_ticketing is true
$concerts  = get_posts(array(
    'post_type' => 'concert',
    'posts_per_page' => -1,
    // 'tax_query'      =>  $tax_query,  // use if you want to hide showcases
    'meta_key' => 'show_in_ticketing',
    'meta_query' => array(
        array(
            'key' => 'show_in_ticketing',
            'value' => 1,
            'compare' => '='
        )
    ),
    'suppress_filters' => 0, // stop wpml giving posts from all languages
));






$sorted_concerts = processDatesForConcertsByDate($concerts);

?>


<section class="section section_events_by_date">


    <div class="container">
        <table class="zebra">
            <?php $cur_date = false; ?>
            <?php foreach ($sorted_concerts as $concert) : ?>
                <?php if ($cur_date  != $concert->nice_date) : ?>
                    <tr class="date_row">
                        <td colspan="3"><?php echo $concert->nice_date; ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>
                        <strong>
                            <a href="<?php echo $concert->url; ?>">
                                <?php echo $concert->alt_title; ?>
                            </a>
                        </strong>
                    </td>
                    <td> <?php echo $concert->time; ?> </td>
                    <td>
                        <?php if ($concert->ticketing) : ?>
                            <a href="<?php echo $concert->ticketing; ?>" class="button"><?php _e('Billets', 'blankslate'); ?></a>
                        <?php elseif ($concert->ticketing_text) :  ?>
                            <?php echo $concert->ticketing_text; ?>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php $cur_date = $concert->nice_date; ?>
            <?php endforeach; ?>
        </table>
    </div>
</section>