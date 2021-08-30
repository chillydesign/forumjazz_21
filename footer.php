</main>
<footer id="footer" role="contentinfo">
    <div class="container">
        <div class="columns">
            <div class="column">
                <h4>Liens utiles</h4>
                <ul>
                    <?php chilly_nav('footer-navigation'); ?>

                </ul>
            </div>
            <div class="column">


                <?php dynamic_sidebar('footer-widget-area') ?>



            </div>
            <div class="column">
                <h4>Suivez-nous</h4>
                <ul>
                    <?php chilly_nav('social-navigation'); ?>
                </ul>
            </div>
        </div>

    </div>
    <div id="copyright_container">
        <div class="container">
            <p>
                &copy; <?php echo esc_html(date_i18n(__('Y', 'blankslate'))); ?> <?php echo esc_html(get_bloginfo('name')); ?>
                | Website by Webfactor
            </p>
        </div>
    </div>

</footer>
<?php wp_footer(); ?>
</body>

</html>