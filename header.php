<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;800&display=swap" rel="stylesheet">
    <?php $tdu = get_template_directory_uri(); ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $tdu; ?>/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $tdu; ?>/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $tdu; ?>/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $tdu; ?>/img/favicon/site.webmanifest">

    <?php $smp = social_meta_properties(); ?>
    <meta name="description" content="<?php echo $smp->description; ?>">
    <!-- Open Graph -->
    <meta property="og:url" content="<?php echo $smp->url; ?>">
    <meta property="og:type" content="<?php echo $smp->type; ?>" />
    <meta property="og:site_name" content="<?php echo $smp->site_name; ?>">
    <meta property="og:title" content="<?php echo $smp->title; ?>">
    <meta property="og:description" content="<?php echo $smp->description; ?>">
    <meta property="og:img" content="<?php echo $smp->image; ?>">
    <meta property="og:image" content="<?php echo $smp->image; ?>">
    <!-- TWITTER -->
    <meta name="twitter:card" value="<?php echo $smp->description; ?>">
    <meta name="twitter:title" content="<?php echo $smp->title; ?>">
    <meta name="twitter:description" content="<?php echo $smp->description; ?>">
    <meta name="twitter:image" content="<?php echo $smp->image; ?>">
    <!-- GOOGLE -->
    <meta itemprop="name" content="<?php echo $smp->title; ?>">
    <meta itemprop="description" content="<?php echo $smp->description; ?>">
    <meta itemprop="image" content="<?php echo $smp->image; ?>">


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