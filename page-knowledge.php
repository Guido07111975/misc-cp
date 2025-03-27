<?php
/*
 * Template Name: Knowledge Base
 * Description: Template for displaying Categories and Posts
 * Template Post Type: page
 */
?>

<?php get_header(); ?>
<?php if ( get_post_meta( $post->ID, 'myknowledgebase-sidebar', true ) != 'no' ) { ?>
	<div id="content" role="main">
<?php } else { ?>
	<div id="content-full" role="main">
<?php } ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<?php if ( get_theme_mod( 'myknowledgebase_page_title' ) == 'yes' ) { ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
		<?php } ?>
		<div class="page-content">
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'post-thumbnail', array( 'class' => 'single-image' ) );
			} ?>
			<?php the_content(); ?>
		</div>
	<?php endwhile; ?>
	<?php $columns = get_post_meta( $post->ID, 'myknowledgebase-columns', true );
	if ( $columns == 'two' ) {
		$ul_id = 'categories-two';
	} else if ( $columns == 'three' ) {
		$ul_id = 'categories-three';
	} else {
		$ul_id = 'categories-four';
	} ?>
	<?php get_template_part( 'content-knowledge', null, array( 'ul_id' => $ul_id ) ); ?>
</div>
<?php if ( get_post_meta( $post->ID, 'myknowledgebase-sidebar', true ) != 'no' ) { ?>
	<?php get_sidebar(); ?>
<?php } ?>
<?php get_footer(); ?>
