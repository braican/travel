<!doctype html>
<html lang="en">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
    <link href='http://fonts.googleapis.com/css?family=Lato:300|EB+Garamond|Raleway:700' rel='stylesheet' type='text/css'>
    <?php wp_head(); ?>

</head>
<body>

    <header class="site-header full-height" style="background-image:url(<?php header_image(); ?>);">
        <div class="travel-container full-height">
            <div class="logo">
                <a href="http://braican.com"><span>nb</span></a>
            </div>
            <div class="caption inline-caption">
                <h1 class="site-title"><?php bloginfo( 'description' ); ?></h1>
            </div>
        </div>
    </header><!-- .site-header -->
    <section class="travel-container">
        <div class="caption align-right">
            <p><?php echo get_theme_mod( 'banner_image_caption', '' ); ?></p>
        </div>
    </section><!-- section -->