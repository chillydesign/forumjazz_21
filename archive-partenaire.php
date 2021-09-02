<?php get_header(); ?>
<?php
$partenaires = get_posts(array('post_type' => 'partenaire'));
$locations = [];
foreach ($partenaires as $partenaire) {
    $partenaire_json  = partenaire_to_map_json($partenaire);
    array_push($locations, $partenaire_json);
}
?>

<header id="page_header">
    <div class="container">
        <h1 class="entry-title" itemprop="name">Partenaires</h1>
    </div>
</header>
<div id="map_container" class="map_container_large"></div>
<script>
    const map_locations = <?php echo  json_encode($locations); ?>;
</script>

</div>
<?php get_footer(); ?>