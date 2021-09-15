<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;800&display=swap" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header id="header">
        <div class="container">
            <div class="header_inner">
                <a href="<?php echo  site_url(); ?>" id="branding">Forum Jazz</a>
                <nav>

                    <ul>
                        <?php chilly_nav('primary-navigation'); ?>
                    </ul>

                </nav>
            </div>
        </div>
        <a href="#" id="menu_button" title="Menu"><?php _e('Menu', 'blankslate'); ?></a>


    </header>

    <main id="main" role="main">