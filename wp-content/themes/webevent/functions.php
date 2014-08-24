<?php
class Bootstrap_walker extends Walker_Nav_Menu {
  function start_el(&$output, $object, $depth = 0, $args = array(), $current_object_id = 0) {
    global $wp_query;
    
    $indent = ($depth) ? str_repeat("\t", $depth) : '';
    
    $class_names = $value = '';
    
    // If the item has children, add the dropdown class for Bootstrap
    if ($args->has_children) {
      $class_names = 'dropdown ';
    }
    
    $classes = empty($object->classes) ? array() : (array) $object->classes;
    
    $class_names .= join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $object));
    $class_names = ' class="' . esc_attr($class_names) . '"';
    
    $output .= $indent . '<li id="menu-item-' . $object->ID . '"' . $value . $class_names . '>';
    
    $attributes  = ! empty($object->attr_title) ? ' title="'  . esc_attr($object->attr_title) . '"' : '';
    $attributes .= ! empty($object->target)     ? ' target="' . esc_attr($object->target    ) . '"' : '';
    $attributes .= ! empty($object->xfn)        ? ' rel="'    . esc_attr($object->xfn       ) . '"' : '';
    $attributes .= ! empty($object->url)        ? ' href="'   . esc_attr($object->url       ) . '"' : '';
    
    $item_output  = $args->before;
    $item_output .= '<a' . $attributes . '>';
    $item_output .= $args->link_before . apply_filters('the_title', $object->title, $object->ID);
    $item_output .= $args->link_after;
    
    // If the item has children add the caret just before closing the anchor tag
    if ($args->has_children) {
      $item_output .= '<b class="caret"></b></a>';
    } else {
      $item_output .= '</a>';
    }
    
    $item_output .= $args->after;
    
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $object, $depth, $args);
  }
  
  function start_lvl(&$output, $depth = 0, $args = array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }
  
  function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output) {
    $id_field = $this->db_fields['id'];
    
    if (is_object($args[0])) {
      $args[0]->has_children = !empty($children_elements[$element->$id_field]);
    }
    
    return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
  }
}

function webevent_main_nav() {
  wp_nav_menu(
    array(
      'menu'           => 'main_nav',
      'menu_class'     => 'nav navbar-nav',
      'theme_location' => 'main_nav',
      'container'      => 'false',
      'fallback_cb'    => 'webevent_main_nav_fallback',
      'walker'         => new Bootstrap_walker()
    )
  );
}

function webevent_main_nav_fallback() {
}

function webevent_support() {
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(120, 120, true); // Default thumbnails size
  
  add_theme_support('menus');
  register_nav_menus(
    array(
      'main_nav'     => 'Main Nav',
      'footer_links' => 'Footer Nav'
    )
  );
}

add_action('after_setup_theme', 'webevent_support');

function webevent_assets() {
  global $wp_styles;
  
  // Stylesheets to load in the head
  wp_register_style('stylesheet', get_stylesheet_directory_uri() . '/assets/css/main.css', array(), '', 'all');
  
  // Scripts to load in the head
  wp_deregister_script('jquery');
  wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js', array(), '1.9.1', false);
  
  // Scripts to load in the body
  wp_register_script('affix', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/affix.js', array('jquery'), '3.1.1', true);
  wp_register_script('alert', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/alert.js', array('jquery'), '3.1.1', true);
  wp_register_script('button', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/button.js', array('jquery'), '3.1.1', true);
  wp_register_script('carousel', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/carousel.js', array('jquery'), '3.1.1', true);
  wp_register_script('collapse', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/collapse.js', array('jquery'), '3.1.1', true);
  wp_register_script('dropdown', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/dropdown.js', array('jquery'), '3.1.1', true);
  wp_register_script('modal', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/modal.js', array('jquery'), '3.1.1', true);
  wp_register_script('popover', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/popover.js', array('jquery'), '3.1.1', true);
  wp_register_script('scrollspy', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/scrollspy.js', array('jquery'), '3.1.1', true);
  wp_register_script('tab', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/tab.js', array('jquery'), '3.1.1', true);
  wp_register_script('tooltip', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/tooltip.js', array('jquery'), '3.1.1', true);
  wp_register_script('transition', get_stylesheet_directory_uri() . '/assets/bootstrap/vendor/assets/javascripts/bootstrap/transition.js', array('jquery'), '3.1.1', true);
  wp_register_script('main', get_stylesheet_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true);
  wp_register_script('post-like', get_stylesheet_directory_uri() . '/assets/js/post-like.js', array('jquery'), '1.0', true);
  // Enqueue styles and scripts
  wp_enqueue_style('stylesheet');
  
  wp_enqueue_script('jquery');
  
  wp_enqueue_script('affix');
  wp_enqueue_script('alert');
  wp_enqueue_script('button');
  wp_enqueue_script('carousel');
  wp_enqueue_script('collapse');
  wp_enqueue_script('dropdown');
  wp_enqueue_script('modal');
  wp_enqueue_script('popover');
  wp_enqueue_script('scrollspy');
  wp_enqueue_script('tab');
  wp_enqueue_script('tooltip');
  wp_enqueue_script('transition');
  wp_enqueue_script('main');
  wp_enqueue_script('post-like');
}

add_action('wp_enqueue_scripts', 'webevent_assets', 999);

function webevent_paging() {
  global $wp_query;
  $bignum = 999999999;
  
  if ($wp_query->max_num_pages <= 1) return;
  
  echo '<nav class="pagination">';
  
  echo paginate_links(array(
    'base'      => str_replace($bignum, '%#%', esc_url(get_pagenum_link($bignum))),
    'format'    => '',
    'current'   => max(1, get_query_var('paged')),
    'total'     => $wp_query->max_num_pages,
    'prev_text' => '&larr;',
    'next_text' => '&rarr;',
    'type'      => 'list',
    'end_size'  => 3,
    'mid_size'  => 3
  ));
  
  echo '</nav>';
}

/**
 * (1) Enqueue scripts for like system
 */
function like_scripts() {
  wp_enqueue_script( 'jm_like_post', get_template_directory_uri().'/js/post-like.js', array('jquery'), '1.0', 1 );
  wp_localize_script( 'jm_like_post', 'ajax_var', array(
    'url' => admin_url( 'admin-ajax.php' ),
    'nonce' => wp_create_nonce( 'ajax-nonce' )
    )
  );
}
add_action( 'init', 'like_scripts' );

/**
 * (2) Add Fontawesome Icons
 */
function enqueue_icons () {
  wp_register_style( 'icon-style', 'http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css' );
    wp_enqueue_style( 'icon-style' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_icons' );

/**
 * (3) Save like data
 */
add_action( 'wp_ajax_nopriv_jm-post-like', 'jm_post_like' );
add_action( 'wp_ajax_jm-post-like', 'jm_post_like' );
function jm_post_like() {
  $nonce = $_POST['nonce'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
        die ( 'Nope!' );
  
  if ( isset( $_POST['jm_post_like'] ) ) {
  
    $post_id = $_POST['post_id']; // post id
    $post_like_count = get_post_meta( $post_id, "_post_like_count", true ); // post like count
    
    if ( is_user_logged_in() ) { // user is logged in
      $user_id = get_current_user_id(); // current user
      $meta_POSTS = get_user_option( "_liked_posts", $user_id  ); // post ids from user meta
      $meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
      $liked_POSTS = NULL; // setup array variable
      $liked_USERS = NULL; // setup array variable
      
      if ( count( $meta_POSTS ) != 0 ) { // meta exists, set up values
        $liked_POSTS = $meta_POSTS;
      }
      
      if ( !is_array( $liked_POSTS ) ) // make array just in case
        $liked_POSTS = array();
        
      if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
        $liked_USERS = $meta_USERS[0];
      }   

      if ( !is_array( $liked_USERS ) ) // make array just in case
        $liked_USERS = array();
        
      $liked_POSTS['post-'.$post_id] = $post_id; // Add post id to user meta array
      $liked_USERS['user-'.$user_id] = $user_id; // add user id to post meta array
      $user_likes = count( $liked_POSTS ); // count user likes
  
      if ( !AlreadyLiked( $post_id ) ) { // like the post
        update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Add user ID to post meta
        update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
        update_user_option( $user_id, "_liked_posts", $liked_POSTS ); // Add post ID to user meta
        update_user_option( $user_id, "_user_like_count", $user_likes ); // +1 count user meta
        echo $post_like_count; // update count on front end

      } else { // unlike the post
        $pid_key = array_search( $post_id, $liked_POSTS ); // find the key
        $uid_key = array_search( $user_id, $liked_USERS ); // find the key
        unset( $liked_POSTS[$pid_key] ); // remove from array
        unset( $liked_USERS[$uid_key] ); // remove from array
        $user_likes = count( $liked_POSTS ); // recount user likes
        update_post_meta( $post_id, "_user_liked", $liked_USERS ); // Remove user ID from post meta
        update_post_meta($post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
        update_user_option( $user_id, "_liked_posts", $liked_POSTS ); // Remove post ID from user meta      
        update_user_option( $user_id, "_user_like_count", $user_likes ); // -1 count user meta
        echo "already".$post_like_count; // update count on front end
        
      }
      
    } else { // user is not logged in (anonymous)
      $ip = $_SERVER['REMOTE_ADDR']; // user IP address
      $meta_IPS = get_post_meta( $post_id, "_user_IP" ); // stored IP addresses
      $liked_IPS = NULL; // set up array variable
      
      if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
        $liked_IPS = $meta_IPS[0];
      }
  
      if ( !is_array( $liked_IPS ) ) // make array just in case
        $liked_IPS = array();
        
      if ( !in_array( $ip, $liked_IPS ) ) // if IP not in array
        $liked_IPS['ip-'.$ip] = $ip; // add IP to array
      
      if ( !AlreadyLiked( $post_id ) ) { // like the post
        update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Add user IP to post meta
        update_post_meta( $post_id, "_post_like_count", ++$post_like_count ); // +1 count post meta
        echo $post_like_count; // update count on front end
        
      } else { // unlike the post
        $ip_key = array_search( $ip, $liked_IPS ); // find the key
        unset( $liked_IPS[$ip_key] ); // remove from array
        update_post_meta( $post_id, "_user_IP", $liked_IPS ); // Remove user IP from post meta
        update_post_meta( $post_id, "_post_like_count", --$post_like_count ); // -1 count post meta
        echo "already".$post_like_count; // update count on front end
        
      }
    }
  }
  
  exit;
}

/**
 * (4) Test if user already liked post
 */
function AlreadyLiked( $post_id ) { // test if user liked before
  if ( is_user_logged_in() ) { // user is logged in
    $user_id = get_current_user_id(); // current user
    $meta_USERS = get_post_meta( $post_id, "_user_liked" ); // user ids from post meta
    $liked_USERS = ""; // set up array variable
    
    if ( count( $meta_USERS ) != 0 ) { // meta exists, set up values
      $liked_USERS = $meta_USERS[0];
    }
    
    if( !is_array( $liked_USERS ) ) // make array just in case
      $liked_USERS = array();
      
    if ( in_array( $user_id, $liked_USERS ) ) { // True if User ID in array
      return true;
    }
    return false;
    
  } else { // user is anonymous, use IP address for voting
  
    $meta_IPS = get_post_meta( $post_id, "_user_IP" ); // get previously voted IP address
    $ip = $_SERVER["REMOTE_ADDR"]; // Retrieve current user IP
    $liked_IPS = ""; // set up array variable
    
    if ( count( $meta_IPS ) != 0 ) { // meta exists, set up values
      $liked_IPS = $meta_IPS[0];
    }
    
    if ( !is_array( $liked_IPS ) ) // make array just in case
      $liked_IPS = array();
    
    if ( in_array( $ip, $liked_IPS ) ) { // True is IP in array
      return true;
    }
    return false;
  }
  
}

/**
 * (5) Front end button
 */
function getPostLikeLink( $post_id ) {
  $like_count = get_post_meta( $post_id, "_post_like_count", true ); // get post likes
  $count = ( empty( $like_count ) || $like_count == "0" ) ? 'Be part of this event' : esc_attr( $like_count );
  if ( AlreadyLiked( $post_id ) ) {
    $class = esc_attr( ' participated' );
    $title = esc_attr( 'Unparticipate' );
    $heart = '<i class="fa fa-user"></i>';
  } else {
    $class = esc_attr( '' );
    $title = esc_attr( 'Be part of this event' );
    $heart = '<i class="fa fa-user-o"></i>';
  }
  $output = '<a href="#" class="jm-post-like'.$class.'" data-post_id="'.$post_id.'" title="'.$title.'">'.$heart.'&nbsp;'.$count.'</a>';
  return $output;
}

/**
 * (6) Retrieve User Likes and Show on Profile
 */
add_action( 'show_user_profile', 'show_user_likes' );
add_action( 'edit_user_profile', 'show_user_likes' );
function show_user_likes( $user ) { ?>        
    <table class="form-table">
        <tr>
      <th><label for="user_likes"><?php _e( 'You Like:' ); ?></label></th>
      <td>
            <?php
      $user_likes = get_user_option( "_liked_posts", $user->ID );
      if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) {
        $the_likes = $user_likes;
      } else {
        $the_likes = '';
      }
      if ( !is_array( $the_likes ) )
      $the_likes = array();
      $count = count( $the_likes ); 
      $i=0;
      if ( $count > 0 ) {
        $like_list = '';
        echo "<p>\n";
        foreach ( $the_likes as $the_like ) {
          $i++;
          $like_list .= "<a href=\"" . esc_url( get_permalink( $the_like ) ) . "\" title=\"" . esc_attr( get_the_title( $the_like ) ) . "\">" . get_the_title( $the_like ) . "</a>\n";
          if ($count != $i) $like_list .= " &middot; ";
          else $like_list .= "</p>\n";
        }
        echo $like_list;
      } else {
        echo "<p>" . _e( 'You don\'t like anything yet.' ) . "</p>\n";
      } ?>
            </td>
    </tr>
    </table>
<?php }

/**
 * (7) Add a shortcode to your posts instead
 * type [jmliker] in your post to output the button
 */
function jm_like_shortcode() {
  return getPostLikeLink( get_the_ID() );
}
add_shortcode('jmliker', 'jm_like_shortcode');

/**
 * (8) If the user is logged in, output a list of posts that the user likes
 * Markup assumes sidebar/widget usage
 */
function frontEndUserLikes() {
  if ( is_user_logged_in() ) { // user is logged in
    $like_list = '';
    $user_id = get_current_user_id(); // current user
    $user_likes = get_user_option( "_liked_posts", $user_id );
    if ( !empty( $user_likes ) && count( $user_likes ) > 0 ) {
      $the_likes = $user_likes;
    } else {
      $the_likes = '';
    }
    if ( !is_array( $the_likes ) )
      $the_likes = array();
    $count = count( $the_likes );
    if ( $count > 0 ) {
      $limited_likes = array_slice( $the_likes, 0, 5 ); // this will limit the number of posts returned to 5
      $like_list .= "<aside>\n";
      $like_list .= "<h3>" . __( 'You Like:' ) . "</h3>\n";
      $like_list .= "<ul>\n";
      foreach ( $limited_likes as $the_like ) {
        $like_list .= "<li><a href='" . esc_url( get_permalink( $the_like ) ) . "' title='" . esc_attr( get_the_title( $the_like ) ) . "'>" . get_the_title( $the_like ) . "</a></li>\n";
      }
      $like_list .= "</ul>\n";
      $like_list .= "</aside>\n";
    }
    echo $like_list;
  }
}

/**
 * (9) Outputs a list of the 5 posts with the most user likes TODAY
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular_today() {
  global $post;
  $today = date('j');
    $year = date('Y');
  $args = array(
    'year' => $year,
    'day' => $today,
    'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
    'meta_key' => '_post_like_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'posts_per_page' => 5
    );
  $pop_posts = new WP_Query( $args );
  if ( $pop_posts->have_posts() ) {
    echo "<aside>\n";
    echo "<h3>" . _e( 'Today\'s Most Popular Posts' ) . "</h3>\n";
    echo "<ul>\n";
    while ( $pop_posts->have_posts() ) {
      $pop_posts->the_post();
      echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
    }
    echo "</ul>\n";
    echo "</aside>\n";
  }
  wp_reset_postdata();
}

/**
 * (10) Outputs a list of the 5 posts with the most user likes for THIS MONTH
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular_month() {
  global $post;
  $month = date('m');
    $year = date('Y');
  $args = array(
    'year' => $year,
    'monthnum' => $month,
    'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
    'meta_key' => '_post_like_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'posts_per_page' => 5
    );
  $pop_posts = new WP_Query( $args );
  if ( $pop_posts->have_posts() ) {
    echo "<aside>\n";
    echo "<h3>" . _e( 'This Month\'s Most Popular Posts' ) . "</h3>\n";
    echo "<ul>\n";
    while ( $pop_posts->have_posts() ) {
      $pop_posts->the_post();
      echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
    }
    echo "</ul>\n";
    echo "</aside>\n";
  }
  wp_reset_postdata();
}

/**
 * (11) Outputs a list of the 5 posts with the most user likes for THIS WEEK
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular_week() {
  global $post;
  $week = date('W');
    $year = date('Y');
  $args = array(
    'year' => $year,
    'w' => $week,
    'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
    'meta_key' => '_post_like_count',
    'orderby' => 'meta_value_num',
    'order' => 'DESC',
    'posts_per_page' => 5
    );
  $pop_posts = new WP_Query( $args );
  if ( $pop_posts->have_posts() ) {
    echo "<aside>\n";
    echo "<h3>" . _e( 'This Week\'s Most Popular Posts' ) . "</h3>\n";
    echo "<ul>\n";
    while ( $pop_posts->have_posts() ) {
      $pop_posts->the_post();
      echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
    }
    echo "</ul>\n";
    echo "</aside>\n";
  }
  wp_reset_postdata();
}

/**
 * (12) Outputs a list of the 5 posts with the most user likes for ALL TIME
 * Markup assumes sidebar/widget usage
 */
function jm_most_popular() {
  global $post;
  echo "<aside>\n";
  echo "<h3>" . _e( 'Most Popular Posts' ) . "</h3>\n";
  echo "<ul>\n";
  $args = array(
     'post_type' => array( 'post', 'enter-your-comma-separated-post-types-here' ),
     'meta_key' => '_post_like_count',
     'orderby' => 'meta_value_num',
     'order' => 'DESC',
     'posts_per_page' => 5 
     );
  $pop_posts = new WP_Query( $args );
  while ( $pop_posts->have_posts() ) {
    $pop_posts->the_post();
    echo "<li><a href='" . get_permalink($post->ID) . "'>" . get_the_title() . "</a></li>\n";
  }
  wp_reset_postdata();
  echo "</ul>\n";
  echo "</aside>\n";
}