<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article itemprop="mainContentOfPage" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


            <?php $image = thumbnail_of_post_url(get_the_ID(), 'large'); ?>
            <?php $image_html = ($image) ? 'class="background_image" style="background-image:url(' . $image . ')"'  : ''; ?>
            <header id="page_header" <?php echo $image_html; ?>>
                <div class="container">
                    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                </div>
            </header>



            <?php if (isset($_GET['product_error'])) : ?>

                <div class="container">
                    <p class="alert alert_problem"><?php _e("L'achat du Pass est nominatif, nous vous demanderons d'ajouter votre adresse mail, une photographie, votre structure & poste occupé afin de vous faire figurer dans notre liste de participants. Vous ne pouvez donc ajouter chaque jour qu'une seule fois au panier.", 'webfactor'); ?></p>
                </div>



            <?php endif; ?>

            <?php include('section-loop.php'); ?>
            <div class="container">
                <?php // required for woocommerce 
                ?>
                <?php the_content();   ?>
            </div>




        </article>




<?php endwhile;
endif; ?>
<?php get_footer(); ?>