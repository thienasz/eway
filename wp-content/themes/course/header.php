<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BUNTINGTON Public Schools</title>
    
    <!-- Styles -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,700,800" rel="stylesheet" type="text/css"><!-- Google web fonts -->
    <link href="<?php bloginfo('template_directory'); ?>/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"><!-- font-awesome -->
    <link href="<?php bloginfo('template_directory'); ?>/js/dropdown-menu/dropdown-menu.css" rel="stylesheet" type="text/css"><!-- dropdown-menu -->
    <link href="<?php bloginfo('template_directory'); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"><!-- Bootstrap -->
    <link href="<?php bloginfo('template_directory'); ?>/js/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css"><!-- Fancybox -->
    <link href="<?php bloginfo('template_directory'); ?>/js/audioplayer/audioplayer.css" rel="stylesheet" type="text/css"><!-- Audioplayer -->
    <link href="<?php bloginfo('template_directory'); ?>/style.css" rel="stylesheet" type="text/css"><!-- theme styles -->
    <?php wp_head(); ?>
  </head>
  
  <body role="document">
  
    <!-- device test, don't remove. javascript needed! -->
    <span class="visible-xs"></span><span class="visible-sm"></span><span class="visible-md"></span><span class="visible-lg"></span>
    <!-- device test end -->
    
    <div id="k-head" class="container"><!-- container + head wrapper -->
    
    	<div class="row"><!-- row -->
<!--            top nav-->
            <nav class="k-functional-navig"><!-- functional navig -->
            <?php
            wp_nav_menu( array(
                    'theme_location'    => 'top-menu',
                    'container'         => 'ul',
                    'menu_id'      => 'top_menu',
                    'menu_class'        => 'list-inline pull-right',
            ));
            ?>
            </nav>
<!--            end top nav-->
        	<div class="col-lg-12">
        
        		<div id="k-site-logo" class="pull-left"><!-- site logo -->
                
                    <h1 class="k-logo">
                        <a href="index.html" title="Home Page">
                            <img src="<?php bloginfo('template_directory'); ?>/img/site-logo.png" alt="Site Logo" class="img-responsive" />
                        </a>
                    </h1>
                    
                    <a id="mobile-nav-switch" href="#drop-down-left"><span class="alter-menu-icon"></span></a><!-- alternative menu button -->
            
            	</div><!-- site logo end -->

            	<nav id="k-menu" class="k-main-navig"><!-- main navig -->

                    <?php
                    wp_nav_menu( array(
                        'theme_location'    => 'primary-menu',
                        'container'         => 'ul',
                        'menu_id'      => 'drop-down-left',
                        'menu_class'        => 'k-dropdown-menu',
                        'walker'            => new Thien_Nav_Walker(),
                    ));
                    ?>

            	</nav><!-- main navig end -->
            
            </div>
            
        </div><!-- row end -->
    
    </div><!-- container + head wrapper end -->
    
    <div id="k-body"><!-- content wrapper -->
    
    	<div class="container"><!-- container -->
