<?php
/** image size post **/
add_image_size( 'excerpt-thumbnail', 200, 200 );

if ( ! function_exists( 'twentyeleven_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Twenty Eleven 1.0
 */
function twentyeleven_posted_on() {
	printf( __( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'twentyeleven' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'twentyeleven' ), get_the_author() ) ),
		get_the_author()
	);
}
endif;

/* BYX: afiseaza XX posturi pe paginile de categorii, arhive, taguri etc in loc de numarul implicit de pagini din blog */
function limit_posts_per_archive_page() {
	if ( is_tag() || is_date() || is_search() || is_category() )
		set_query_var('posts_per_archive_page', 1000); // or use variable key: posts_per_page
}
add_filter('pre_get_posts', 'limit_posts_per_archive_page');

// add a favicon
function blog_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_bloginfo('stylesheet_directory').'/images/favicon.ico" />';
}
add_action('wp_head', 'blog_favicon');

/**
 * Display navigation to next/previous pages when applicable
 */
function twentyeleven_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentyeleven' ); ?></h3>
				<?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
		</nav><!-- #nav-above -->
	<?php endif;
}

/**
 * Returns a "Citeste continuarea" link for excerpts
 */
function twentyeleven_continue_reading_link() {
	return ' <a href="'. esc_url( get_permalink() ) . '">' . __( 'Citeste continuarea <span class="meta-nav">&rarr;</span>', 'twentyeleven' ) . '</a>';
}

/**
 * custom excerpt length 
 */
remove_filter ( 'excerpt_length', 'twentyeleven_excerpt_length' );
function alergotura_excerpt_length( $length ) {
	return 80;
}
add_filter ( 'excerpt_length', 'alergotura_excerpt_length' );
/* .custom excerpt length */
