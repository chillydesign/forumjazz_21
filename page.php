<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>


            <?php $image = thumbnail_of_post_url(get_the_ID(), 'large'); ?>
            <?php $image_html = ($image) ? 'class="background_image" style="background-image:url(' . $image . ')"'  : ''; ?>

            <header id="page_header" <?php echo $image_html; ?>>
                <div class="container">
                    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                </div>
            </header>
            <div class="entry-content" itemprop="mainContentOfPage">

                <?php
                // the_content(); 
                ?>

                <?php include('section-loop.php'); ?>

            </div>


        </article>




<?php endwhile;
endif; ?>
<?php get_footer(); ?>