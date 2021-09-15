<section class="section section_event_form">

    <div class="container">
        DONT USE DONT USE
        DONT USE DONT USE
        DONT USE DONT USE
        DONT USE DONT USE
        DONT USE DONT USE
        DONT USE DONT USE
        DONT USE DONT USE
        DONT USE DONT USE


        <?php if (is_user_logged_in()) : ?>


            <form id="inscription_form" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">

                <input type="text" id="website" name="website">
                <input type="text" id="texte_de_presentation" name="texte_de_presentation">
                <input type="text" id="date" name="date">
                <input type="text" id="time" name="time">
                <input type="text" id="location" name="location">
                <input type="text" id="ticketing" name="ticketing">
                <input type="text" id="image" name="image">
                <input type="text" id="line_up" name="line_up">
                <input type="text" id="video_clip" name="video_clip">
                <input type="text" id="subtitle" name="subtitle">
                <input type="text" id="facebook" name="facebook">
                <input type="text" id="instagram" name="instagram">
                <input type="text" id="spotify" name="spotify">
                <input type="text" id="youtube" name="youtube">



                <input type="hidden" name="action" value="inscription_form">
                <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">
                <input type="hidden" name="event_title" value="<?php echo get_the_title(); ?>">
                <div id="inscription_submit_button_outer" style="margin-top:30px;">
                    <input id="inscription_submit_button" type="submit" value="<?php _e('Inscrivez-vous', 'blankslate'); ?>">
                </div>

                <p id="form_alert" class="alert_message alert_error">Veuillez remplir tous les champs obligatoires pour valider votre inscription. Pensez à bien numéroter tous les ateliers par ordre de préférence.</p>


            </form>

        <?php else : ?>
            <p>You must be logged in</p>
        <?php endif; ?>



    </div>
</section>