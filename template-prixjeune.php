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
                <?php if (isset($_GET['success'])) : ?>
                    <p class="alert alert_success">Votre suggestion a été enregistrée</p>
                <?php endif; ?>
                <?php if (isset($_GET['problem'])) : ?>
                    <p class="alert alert_problem">A problem occurred. Please try again.</p>
                <?php endif; ?>


                <form id="prix_jeune_form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">


                    <div class="field">
                        <label for="first_name"><?php _e('Prénom', 'webfactor'); ?>*</label>
                        <input type="text" id="first_name" name="first_name">
                    </div>
                    <div class="field">
                        <label for="last_name"><?php _e('Nom', 'webfactor'); ?>*</label>
                        <input type="text" id="last_name" name="last_name">
                    </div>
                    <div class="field">
                        <label for="email"><?php _e('Adresse électronique', 'webfactor'); ?>*</label>
                        <input type="text" id="email" name="email">
                    </div>


                    <div class="field">
                        <label for="etablissement"><?php _e('Etablissement', 'webfactor'); ?>*</label>
                        <input type="text" id="etablissement" name="etablissement">
                    </div>


                    <div class="field">
                        <label><?php _e('Je suis', 'webfactor'); ?>: *</label>
                        <label class="inline_label"> <input type="radio" id="je_suis" name="je_suis" value="Etudiant"> Etudiant </label>
                        <label class="inline_label"> <input type="radio" id="je_suis" name="je_suis" value="Collégien"> Collégien </label>
                        <label class="inline_label"> <input type="radio" id="je_suis" name="je_suis" value="Lycéen"> Lycéen </label>
                    </div>


                    <div class="field">
                        <label for="concert_id">Vote</label>
                        <select name="concert_id" id="concert_id">
                            <?php foreach ($concerts as $concert) : ?>
                                <option value="<?php echo $concert->ID; ?>"><?php echo $concert->post_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <input type="hidden" name="action" value="prix_jeune_form">
                        <input class="button" id="prix_jeune_form_submit_button" type="submit" value="<?php _e('Submit', 'webfactor'); ?>">

                    </div>
                </form>

            </div>
        </section>



<?php endwhile;
endif; ?>
<?php get_footer(); ?>