<?php get_header(); ?>


<header id="page_header">
    <div class="container">
        <h1 class="entry-title" itemprop="name">Concerts</h1>
    </div>
</header>



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