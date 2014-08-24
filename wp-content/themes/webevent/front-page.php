<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <div class="heading">
    <?php
    $path_array = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
    $path = $path_array['0'];
    ?>
    <div class="heading-cover" style="background: url(<?php echo $path; ?>) no-repeat center; background-size: cover;">
      <div class="lead">
        <h1 class="big-title"><?php the_title(); ?></h1>

        <?php
        $args = array(
          'post_type'      => 'event',
          'posts_per_page' => 1
        );
        $next_event_query = new WP_Query($args);
        ?>

        <?php if ($next_event_query->have_posts()) : ?>
          <?php while ($next_event_query->have_posts()) : $next_event_query->the_post(); ?>
            <a href="<?php the_permalink(); ?>" class="btn">This month's event</a>
          <?php endwhile; ?>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
      </div>
    </div>
  </div>

<?php the_content(); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>