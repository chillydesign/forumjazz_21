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
                    <p class="alert alert_success"><?php _e("Votre vote a bien été enregistré !", 'blankslate'); ?> </p>
                <?php endif; ?>
                <?php if (isset($_GET['problem'])) : ?>
                    <p class="alert alert_problem">
                        <?php if ($_GET['problem'] == 'fields') {
                            _e("Veuillez renseigner tous les champs.", 'blankslate');
                        } else {
                            _e("Une erreur s'est produite.", 'blankslate');
                        } ?>
                    </p>
                <?php endif; ?>







                <form id="prix_jeune_form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">

                    <?php
                    $first_name = $last_name = $email =  $etablissement = '';
                    $jcookie = $_COOKIE["jazz_prix_form"];
                    if (isset($jcookie)) {
                        $j = explode(';;', $jcookie);
                        $first_name = $j[0];
                        $last_name = $j[1];
                        $email = $j[2];
                        $etablissement = $j[3];
                    }

                    ?>

                    <div class="field">
                        <label for="first_name"><?php _e('Prénom', 'webfactor'); ?>*</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
                    </div>
                    <div class="field">
                        <label for="last_name"><?php _e('Nom', 'webfactor'); ?>*</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
                    </div>
                    <div class="field">
                        <label for="email"><?php _e('Email', 'webfactor'); ?>*</label>
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                    </div>



                    <div class="field">
                        <label for="etablissement"><?php _e('Etablissement', 'webfactor'); ?>*</label>
                        <input type="text" id="etablissement" name="etablissement" value="<?php echo $etablissement; ?>">
                    </div>


                    <!-- <div class="field">
                        <label><?php _e('Je suis', 'webfactor'); ?>: *</label>
                        <label class="inline_label"> <input type="radio" id="je_suis" name="je_suis" value="Etudiant"> Etudiant </label>
                        <label class="inline_label"> <input type="radio" id="je_suis" name="je_suis" value="Collégien"> Collégien </label>
                        <label class="inline_label"> <input type="radio" id="je_suis" name="je_suis" value="Lycéen"> Lycéen </label>
                    </div> -->


                    <div class="field">
                        <label for="concert_id"><?php _e('Cliquez sur votre groupe coup de coeur Forum Jazz 2021', 'blankslate'); ?></label>
                        <select name="concert_id" id="concert_id">
                            <option value=""><?php _e('Choisir un groupe'); ?></option>
                            <?php foreach ($concerts as $concert) : ?>
                                <option value="<?php echo $concert->ID; ?>"><?php echo $concert->post_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="field">
                        <label for="justification"><?php _e('Merci de justifier votre choix en quelques mots"', 'blankslate'); ?>*</label>
                        <textarea id="justification" name="justification"><?php echo $justification; ?></textarea>
                    </div>


                    <div class="field">
                        <input type="hidden" name="action" value="prix_jeune_form">
                        <input class="button" id="prix_jeune_form_submit_button" type="submit" value="<?php _e('Envoyer', 'webfactor'); ?>">

                    </div>
                </form>

            </div>
        </section>



<?php endwhile;
endif; ?>
<?php get_footer(); ?>