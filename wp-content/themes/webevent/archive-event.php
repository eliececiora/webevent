<?php get_header(); ?>

<div class="archives">
  <div class="event-list">
    <div class="heading-event">
      <?php
      $args = array(
        'post_type'      => 'event',
        'posts_per_page' => 1
      );
      $next_event_query = new WP_Query($args);
      ?>
      
      <?php if ($next_event_query->have_posts()) : ?>
        <?php while ($next_event_query->have_posts()) : $next_event_query->the_post(); ?>
          <?php
          $path_array = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
          $path = $path_array['0'];
          ?>
          
          <div class="heading-cover-event" style="background: url(<?php echo $path; ?>) no-repeat center; background-size: cover;">
            <div class="heading-meta-event text-left">
              <div class="container">
                <div class="ThisMonth">This Month</div>
                <div class="infos-event">
                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                  <p class="infos-pratique"><strong><?php echo get_post_meta(get_the_ID(), 'wpcf-city', true); ?></strong>, <?php echo date('F d Y', get_post_meta(get_the_ID(), 'wpcf-date', true)); ?></p>
                  <?php the_excerpt(); ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      <?php endif; ?>
      
      <?php wp_reset_postdata(); ?>
    
    
    <div class="container">
      <?php
      $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
      $args = array(
        'post_type'      => 'event',
        'offset'         => 1,
        'posts_per_page' => 10,
        'paged'          => $paged
      );
      $events_query = new WP_Query($args);
      ?>
      
      <?php if ($events_query->have_posts()) : ?>
        <?php while ($events_query->have_posts()) : $events_query->the_post(); ?>
          <?php get_template_part('event-item'); ?>
        <?php endwhile; ?>
        
        <?php
        $big = 999999999;
        
        echo paginate_links(array(
          'base'    => str_replace($big, '%#%', esc_url( get_pagenum_link($big))),
          'format'  => '?paged=%#%',
          'current' => max(1, get_query_var('paged')),
          'total'   => $the_query->max_num_pages
        ));
        ?>
      <?php else : ?>
        <p><?php _e('Sorry, no events were found.', 'webevent'); ?></p>
      <?php endif; ?>
      
      <?php wp_reset_postdata(); ?>

    </div>
  </div>
</div>

<?php get_footer(); ?>