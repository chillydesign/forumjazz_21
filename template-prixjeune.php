<?php /* Template Name: Prix Jeune Public Template */  ?>
<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <?php

        $concerts  = get_posts(array(
            'post_type' => 'concert',
            'posts_per_page' => -1,
        ));

        ?>

        <header id="page_header">
            <div class="container">
                <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
            </div>
        </header>


        <section>

            <div class="container">


                <form action="">


                    <select name="" id="">
                        <?php foreach ($concerts as $concert) : ?>
                            <option value="<?php echo $concert->ID; ?>"><?php echo $concert->post_name; ?></option>
                        <?php endforeach; ?>
                    </select>

                </form>

            </div>
        </section>



<?php endwhile;
endif; ?>
<?php get_footer(); ?>