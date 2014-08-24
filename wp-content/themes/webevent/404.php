<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Trace
 * @since Trace
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div class="background-nav"></div>
		<div id="content" class="site-content" role="main">

			<div class="section">
				<div class="container">
					<h1 class="page-title"><span class="title"><?php _e( 'Not Found', 'webevent' ); ?></span></h1>
					<div class="page-content">
						<h2><?php _e( 'This is somewhat embarrassing, isn’t it?', 'webevent' ); ?></h2>
						<p><?php _e( 'It looks like nothing was found at this location.', 'webevent' ); ?></p>

						<a href="<?php echo home_url(); ?>"><button class="btn btn-primary">Go back to the home page</button>
          	</a>
						

					</div><!-- .page-content -->
				</div>
			</div>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>