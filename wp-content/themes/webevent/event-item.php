<div class="item-event">
  <div class="row">
    <div class="col-md-4">
      <?php
      $path_array = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail');
      $path = $path_array['0'];
      ?>
      
      <a href="<?php the_permalink(); ?>" class="thumbnail-event-cover" style="background: url(<?php echo $path; ?>) no-repeat center; background-size: cover;" rel="bookmark"></a>
    </div>
    <div class="col-md-8">
      <div class="meta-infos">
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <p class="infos-pratique"><strong><?php echo get_post_meta(get_the_ID(), 'wpcf-city', true); ?></strong>, <?php echo date('F d Y', get_post_meta(get_the_ID(), 'wpcf-date', true)); ?></p>
        <p><?php the_excerpt(); ?></p>
      </div>
    </div>
  </div>
</div>