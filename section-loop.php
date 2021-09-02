<?php if (have_rows('sections')) :  while (have_rows('sections')) : the_row(); ?>

<?php $row_layout =  get_row_layout();    ?>


<?php get_template_part('sections/' . $row_layout); ?>


<?php endwhile;
endif; ?>