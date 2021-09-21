<?php $tax_query = array(
    array(
        'taxonomy' => 'concert_category',
        'field'    => 'slug',
        'terms' => 'showcase',
        'operator' => 'NOT IN'
    )
);
$concerts  = get_posts(array(
    'post_type' => 'concert',
    'posts_per_page' => -1,
    'tax_query'      =>  $tax_query,
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
                        <strong> <?php echo $concert->post_title; ?></strong>
                    </td>
                    <td> <?php echo $concert->time; ?> </td>
                    <td>
                        <?php if ($concert->ticketing) : ?>
                            <a href="<?php echo $concert->ticketing; ?>" class="button"><?php _e('Tickets', 'blankslate'); ?></a>
                        <?php endif; ?>
                    </td>
                </tr>

                <?php $cur_date = $concert->nice_date; ?>
            <?php endforeach; ?>
        </table>
    </div>
</section>