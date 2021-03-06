<?php
$lieux = get_posts(array(
    'post_type' => 'lieu',
    'posts_per_page' => -1,
    'suppress_filters' => 0, // stop wpml giving posts from all languages
    'meta_key' => 'show_in_map',
    'meta_query' => array(
        array(
            'key' => 'show_in_map',
            'value' => 1,
            'compare' => '='
        )
    ),
));




$location_objects = [];
foreach ($lieux as $lieu) {
    $lieu_json  = lieu_to_map_json($lieu);
    array_push($location_objects, $lieu_json);
}
?>
<?php $title =  get_sub_field('title'); ?>


<div class="container">
    <?php if ($title) : ?>
        <h2 class="sectiontitle"><?php echo $title; ?></h2>
    <?php endif; ?>

    <div class="columns" id="map_and_lieux">
        <div class="column column_large no_padding">
            <div id="map_container" class="map_container_large"></div>
        </div>

        <div class="column column_small no_padding">

            <div class="lieux_container">
                <?php foreach ($lieux as $lieu) : ?>

                    <?php $description = get_field('description', $lieu->ID); ?>
                    <?php $address = get_field('address', $lieu->ID); ?>
                    <?php $website = get_field('website', $lieu->ID); ?>

                    <div class="lieu_container" data-id="<?php echo $lieu->ID; ?>">

                        <h4><?php echo $lieu->post_title; ?></h4>
                        <?php if ($address) : ?>
                            <p class="address"><?php echo $address; ?></p>
                        <?php endif; ?>
                        <?php if ($description) : ?>
                            <?php echo $description; ?>
                        <?php endif; ?>

                        <?php if ($website) : ?>
                            <p> <a href="<?php echo $website; ?>" target="_blank"><?php echo $website; ?></a> </p>
                        <?php endif; ?>


                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
<script>
    const map_locations = <?php echo  json_encode($location_objects); ?>;
    const theme_directory = '<?php echo get_template_directory_uri(); ?>';
</script>