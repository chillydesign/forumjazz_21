<?php $categorie = get_sub_field('categorie'); ?>
<?php $title = $categorie->name; ?>
<?php $partenaires  = get_posts(array(
    'post_type' => 'partenaire',
    'posts_per_page' => -1,
    'suppress_filters' => 0, // stop wpml giving posts from all languages
    'tax_query' => array(
        array(
            'taxonomy' => 'partenaire_category',
            'field'    => 'slug',
            'terms'    => $categorie->slug,
        ),
    ),
));

?>

<section class="section  section_partners">

    <div class="container">
        <h2><?php echo $title; ?></h2>
        <div class="partners">
            <?php foreach ($partenaires as $partenaire) : ?>
                <div class="partner">
                    <?php $lien = get_field('lien', $partenaire->ID); ?>
                    <?php $description =  get_the_title( $partenaire->ID); ?>
                    <?php $image =  thumbnail_of_post_url($partenaire->ID, 'medium'); ?>
                    <a href="<?php echo  $lien; ?>" target="_blank">
                        <div class="partner_picture" style="background-image:url('<?php echo $image; ?>')"></div>
                        <div class="partner_description">
                            <p><?php echo $description; ?></p>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

    </div><!--  END OF CONTAINER -->

</section>