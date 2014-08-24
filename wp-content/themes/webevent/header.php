<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title><?php echo bloginfo('title'); ?></title>
    
    <?php wp_head(); ?>
  </head>
  
  <body <?php body_class(); ?> role="document">
    <!-- .navbar -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
            <span class="sr-only"><?php _e('Toggle navigation', 'webevent'); ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

          </button>
          
          <a href="<?php echo home_url(); ?>" class="navbar-brand"><?php bloginfo('name'); ?>
          </a>
        </div>
        
        <div class="collapse navbar-collapse navbar-right" id="navbar-collapse">
          <?php webevent_main_nav(); ?>
        </div>
      </div>
    </nav><!-- /.navbar -->
    
    <!-- .content -->
    <div class="content">





