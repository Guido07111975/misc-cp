<?php
/*
 * The content used by files archive, index and search.
 */
?>

<?php if ( is_home() && ( get_theme_mod( 'gridbulletin_blog_sidebar' ) != 'yes' ) ) { ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-four' ); ?>>
<?php } elseif ( is_archive() && ( get_theme_mod( 'gridbulletin_archive_sidebar' ) == 'no' ) ) { ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-four' ); ?>>
<?php } else { ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-three' ); ?>>
<?php } ?>
	<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<p class="sticky-title"><?php esc_html_e( 'Featured post', 'gridbulletin' ); ?></p>
	<?php endif; ?>

	<?php the_title( '<h2 class="entry-title post-title" rel="bookmark"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>

	<div class="entry-content post-content">
		<?php if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'list', array( 'class' => 'list-image' ) );
		} ?>
		<?php if ( get_theme_mod( 'gridbulletin_content_type' ) == 'no' ) { ?>
			<?php the_content(); ?>
		<?php } else { ?>
			<?php the_excerpt(); ?>
		<?php } ?>
	</div>

	<?php if ( get_theme_mod( 'gridbulletin_read_more_label' ) ) {
		$read_more_label = get_theme_mod( 'gridbulletin_read_more_label' );
	} else {
		$read_more_label = __( 'Read More', 'gridbulletin' ).' &raquo;';
	} ?>
	<?php if ( get_theme_mod( 'gridbulletin_read_more' ) == 'yes' ) { ?>
		<div class="more">
			<a class="read-more" href="<?php the_permalink(); ?>" rel="bookmark"><?php echo esc_html( $read_more_label ); ?><span class="screen-reader-text"><?php the_title(); ?></span></a>
		</div>
	<?php } ?>

	<?php get_template_part( 'content-postmeta' ); ?>
</article>
