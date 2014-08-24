<?php get_header(); ?>

<?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <?php
    $path_array = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
    $path = $path_array['0'];
    ?>
    
    <div class="single-event">  
      <div class="heading-event">
        <div class="heading-cover-event" style="background: url(<?php echo $path; ?>) no-repeat center; background-size: cover;">
          <div class="heading-cover-bg heading-meta-event text-center">
            <h1 class="title-event"><?php the_title(); ?></h1>
            <div class="infos-event">
              <p><span class="place"><strong><?php echo get_post_meta(get_the_ID(), 'wpcf-city', true); ?></strong></span>, <span class="date"><?php echo date('F d Y', get_post_meta(get_the_ID(), 'wpcf-date', true)); ?></span></p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="about-event">
        <section class="section1">
          <div class="container">
            <div class="row">
              <div class="description col-md-7">
                <?php the_content(); ?>
              </div>
              <div class="sidebar col-md-4">
                <a href="https://www.paypal.com/" target="_blank" class="btn btn-primary">Register</a>
                
                <div class="location">
                  <h5>Location</h5>
                  <p class="serif-sentence"><strong><?php echo get_post_meta(get_the_ID(), 'wpcf-standing-place', true); ?></strong><br><?php echo get_post_meta(get_the_ID(), 'wpcf-address', true); ?></p>
                </div>
                
                <div class="schedule">
                  <h5>Schedule</h5>
                  <p class="serif-sentence"><strong><?php echo date('D F d', get_post_meta(get_the_ID(), 'wpcf-date', true)); ?></strong><br>From <?php echo get_post_meta(get_the_ID(), 'wpcf-from-hour', true); ?>AM to <?php echo get_post_meta(get_the_ID(), 'wpcf-to-hour', true); ?>PM<br><a href="#">Add to calendar</a></p>
                </div>
                <div class="share-btn">
                  <a href="https://www.facebook.com/" target="_blank" class="btn btn-fb"><div class="facebook-icon"></div><span class="text">Share</span></a>
                  <a href="https://www.twitter.com/" target="_blank" class="btn btn-tw"><div class="twitter-icon"></div><span class="text">Tweet</span></a>
                </div>
              </div>
            </div>
          </div>
        </section>
        
        <section class="section2">
          <div class="container">
            <h2 class="text-center">Speakers</h2>
            
            <?php $speakers = types_child_posts('speaker'); ?>
            
            <?php if (sizeof($speakers) > 0) : ?>
              <div class="row">
                <?php foreach ($speakers as $speaker) : ?>
                  <div class="speaker col-md-4">
                    <?php
                    $path_array = wp_get_attachment_image_src(get_post_thumbnail_id($speaker->ID), 'thumbnail');
                    $path = $path_array['0'];
                    ?>
                    
                    <div class="speaker-avatar" style="background-image: url(<?php echo $path; ?>);"></div>
                    <p class="text-center"><strong><?php echo $speaker->post_title; ?></strong><br><span class="serif-sentence"><?php echo $speaker->post_content; ?></span></p>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
          </div>
        </section>

        <section class="links text-center">
          <ul>
            <li><a href="#">Website</a></li>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
          </ul>
        </section>
      </div>

      <div class="about-place">
        <img class="banner-place" src="<?php echo get_post_meta(get_the_ID(), 'wpcf-city-banner', true); ?>" style="background: url(<?php echo $path; ?>) no-repeat center; background-size: cover;">
        <div class="section1">
          <div class="container">
            <div class="WhereToStay">
              <h2 class="text-center">Where to stay</h2>
              
              <?php $stay_places = types_child_posts('stay-place'); ?>
              
              <?php if (sizeof($stay_places) > 0) : ?>
                <div class="row">
                  <?php foreach ($stay_places as $stay_place) : ?>
                    <div class="stay col-md-3">
                      <h3><a href="#"><?php echo $stay_place->post_title; ?></a></h3>
                      <?php echo $stay_place->post_content; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
            <div class="FoodAndDrink">
              <h2 class="text-center">Food and drink</h2>
              
              <?php $eat_places = types_child_posts('eat-place'); ?>
              
              <?php if (sizeof($eat_places) > 0) : ?>
                <div class="row">
                  <?php foreach ($eat_places as $eat_place) : ?>
                    <div class="stay col-md-3">
                      <h3><a href="#"><?php echo $eat_place->post_title; ?></a></h3>
                      <?php echo $eat_place->post_content; ?>
                    </div>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div><!-- END SINGLE EVENT -->


  <?php endwhile; ?>
<?php else : ?>
  <p><?php _e('Sorry, the event was not found.', 'webevent'); ?></p>
<?php endif; ?>

<?php get_footer(); ?>