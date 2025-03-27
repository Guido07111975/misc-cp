<?php
/*
 * The knowledge base content used by file page-knowledge.
 */

$exclude_cats = get_post_meta( get_the_ID(), 'myknowledgebase-exclude-cats', true );
if ( ! empty( $exclude_cats ) ) :
	$exclude = $exclude_cats;
else :
	$exclude = '';
endif;
$myknowledgebase_cat_args = array(
	'hide_empty' => 0,
	'exclude' => $exclude,
	'orderby' => 'name',
	'order' => 'ASC',
);
$myknowledgebase_cats = get_categories( $myknowledgebase_cat_args );
if ( ! empty( $myknowledgebase_cats ) && ! is_wp_error( $myknowledgebase_cats ) ) :
	echo '<ul id="'.$args['ul_id'].'">';
	foreach ( $myknowledgebase_cats as $myknowledgebase_cat ) :
		if ( get_theme_mod( 'myknowledgebase_post_count' ) == 'yes' ) :
			$count = '<span class="cat-post-count">( '.$myknowledgebase_cat->category_count.' )</span>';
		else :
			$count = '';
		endif;
		echo '<li class="cat-list '.esc_attr( $myknowledgebase_cat->slug ).'">';
			echo '<div class="cat-name"><a href="'.get_category_link( $myknowledgebase_cat->cat_ID ).'" title="'.$myknowledgebase_cat->name.'" >'.$myknowledgebase_cat->name.'</a> '.$count.'</div>';
			if ( get_theme_mod( 'myknowledgebase_cat_description' ) == 'yes' ) :
				if ( category_description( $myknowledgebase_cat->cat_ID ) ) :
					echo '<div class="cat-description">'.wp_kses_post( category_description( $myknowledgebase_cat->cat_ID ) ).'</div>';
				endif;
			endif;
			$posts_per_cat = get_post_meta( get_the_ID(), 'myknowledgebase-posts-per-cat', true );
			if ( ! empty( $posts_per_cat ) ) :
				$posts_per_category = $posts_per_cat;
			else :
				$posts_per_category = -1;
			endif;
			if ( get_theme_mod( 'myknowledgebase_order' ) == 'name' ) :
				$order_by = 'name';
				$the_order = 'ASC';
			else :
				$order_by = 'date';
				$the_order = 'DESC';
			endif;
			$myknowledgebase_post_args = array(
				'post_type' => 'post',
				'tax_query' => array(
					array(
						'taxonomy' => 'category',
						'field' => 'term_id',
						'terms' => $myknowledgebase_cat->term_id,
						'include_children' => false,
					)
				),
				'posts_per_page' => $posts_per_category,
				'orderby' => $order_by,
				'order' => $the_order,
			);
			$myknowledgebase_posts = get_posts( $myknowledgebase_post_args );
			echo '<ul class="cat-post-list">';
				foreach( $myknowledgebase_posts AS $myknowledgebase_post ) :
					if ( get_the_title( $myknowledgebase_post->ID ) == false ) :
						$title = __( '(no title)', 'myknowledgebase' );
					else :
						$title = get_the_title( $myknowledgebase_post->ID );
					endif;
					$slug = str_replace( ' ', '-', strtolower( $title ) );
					echo '<li class="cat-post '.esc_attr( $slug ).'"><a class="cat-post-name" href="'.get_permalink( $myknowledgebase_post->ID ).'" rel="bookmark" title="'.esc_html( $title ).'">'.esc_html( $title ).'</a>';
					if ( get_theme_mod( 'myknowledgebase_post_meta' ) == 'yes' ) :
						echo '<div class="cat-post-meta">';
						echo '<span class="cat-post-meta-date"><a href="'.esc_url( get_permalink( $myknowledgebase_post->ID ) ).'">'.esc_html( get_the_date( get_option( 'date_format' ), $myknowledgebase_post->ID ) ).'</a></span>';
						echo '<span class="cat-post-meta-sep">'.' | '.'</span>';
						echo '<span class="cat-post-meta-author">'.sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_author_posts_url( $myknowledgebase_post->post_author ) ), esc_html( get_the_author_meta( 'display_name', $myknowledgebase_post->post_author ) ) ).'</span>';
						echo '</div>';
					endif;
					echo '</li>';
				endforeach;
			echo '</ul>';
			if ( get_theme_mod( 'myknowledgebase_view_all' ) == 'yes' ) :
				if ( get_theme_mod( 'myknowledgebase_view_all_label' ) ) :
					$view_all_label = get_theme_mod( 'myknowledgebase_view_all_label' );
				else :
					$view_all_label = __( 'View All', 'myknowledgebase' ).' &raquo;';
				endif;
				echo '<div class="cat-view-all"><a href="'.esc_url( get_category_link( $myknowledgebase_cat->cat_ID ) ).'" title="'.$myknowledgebase_cat->name.'" >'.esc_html( $view_all_label ).'</a></div>';
			endif;
		echo '</li>';
	endforeach;
	echo '</ul>';
endif;
