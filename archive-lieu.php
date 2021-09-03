<?php get_header(); ?>
<?php
$lieux = get_posts(array(
    'post_type' => 'lieu',
    'posts_per_page' => -1
));
$location_objects = [];
foreach ($lieux as $lieu) {
    $lieu_json  = lieu_to_map_json($lieu);
    array_push($location_objects, $lieu_json);
}
?>

<header id="page_header">
    <div class="container">
        <h1 class="entry-title" itemprop="name">Lieux</h1>
    </div>
</header>
<div id="map_container" class="map_container_large"></div>
<script>
    const map_locations = <?php echo  json_encode($location_objects); ?>;
</script>

</div>
<?php get_footer(); ?>