<?php
/**
 * Blog functionalities.
 *
 * @package twentig
 */

/**
 * Set the excerpt more link.
 *
 * @param string $more The string shown within the more link.
 */
function twentig_twentyone_excerpt_more( $more ) {
	if ( is_home() || is_archive() || ( is_search() && 'blog-layout' === get_theme_mod( 'twentig_page_search_layout' ) ) ) {
		if ( ! get_theme_mod( 'twentig_blog_excerpt_more', true ) ) {
			return '&hellip;';
		}
		return '&hellip; <div class="more-link-container"><a class="more-link" href="' . esc_url( get_permalink() ) . '">' . twenty_twenty_one_continue_reading_text() . '</a></div>';
	}

	return $more;
}
add_filter( 'excerpt_more', 'twentig_twentyone_excerpt_more', 20 );

/**
 * Set excerpt length.
 *
 * @param int $excerpt_length The maximum number of words.
 */
function twentig_twentyone_custom_excerpt_length( $excerpt_length ) {
	if ( is_home() || is_archive() || ( is_search() && 'blog-layout' === get_theme_mod( 'twentig_page_search_layout' ) ) ) {
		$newlength = get_theme_mod( 'twentig_blog_excerpt_length' );
		if ( $newlength ) {
			return $newlength;
		}
	}
	return $excerpt_length;
}
add_filter( 'excerpt_length', 'twentig_twentyone_custom_excerpt_length' );

/**
 * Removes the post excerpt displayed on the archive pages based on Customizer setting.
 */
function twentig_twentyone_filter_excerpt() {
	if ( ! get_theme_mod( 'twentig_blog_content', true ) && ( is_home() || is_archive() ) ) {
		add_filter( 'the_excerpt', '__return_empty_string' );
	}
}
add_action( 'get_template_part_template-parts/content/content-excerpt', 'twentig_twentyone_filter_excerpt' );

/**
 * Removes the post content displayed on the archive pages based on Customizer setting.
 */
function twentig_twentyone_filter_content() {
	if ( ! get_theme_mod( 'twentig_blog_content', true ) && ( is_home() || is_archive() ) ) {
		add_filter( 'the_content', '__return_empty_string' );
	}
}
add_action( 'get_template_part_template-parts/content/content', 'twentig_twentyone_filter_content' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param string[] $classes An array of post class names.
 * @param string[] $class   An array of additional class names added to the post.
 * @param int      $post_id The post ID.
 */
function twentig_twentyone_post_class( $classes, $class, $post_id ) {
	if ( is_singular() ) {
		$post_type   = get_post_type();
		$hero_layout = get_theme_mod( 'twentig_' . $post_type . '_hero_layout' );
		if ( false === $hero_layout && twentig_twentyone_is_cpt_single() ) {
			$cpt_layout = get_theme_mod( 'twentig_cpt_single_layout' );
			if ( $cpt_layout ) {
				$hero_layout = get_theme_mod( 'twentig_' . $cpt_layout . '_hero_layout' );
			}
		}
		if ( 'no-image' === $hero_layout ) {
			$classes = array_diff( $classes, array( 'has-post-thumbnail' ) );
		}
	}
	return $classes;
}
add_filter( 'post_class', 'twentig_twentyone_post_class', 10, 3 );

/**
 * Determines if post thumbnail should be displayed.
 *
 * @param bool $can_show Whether the post thumbnail can be displayed.
 */
function twentig_twentyone_display_featured_image( $can_show ) {

	if ( twentig_twentyone_is_blog_page()
		|| ( is_search() && 'blog-layout' === get_theme_mod( 'twentig_page_search_layout' ) )
		|| ( 'blog' === get_theme_mod( 'twentig_cpt_archive_layout' ) && twentig_twentyone_is_cpt_archive() )
	) {
		if ( ! get_theme_mod( 'twentig_blog_image', true ) ) {
			return false;
		}
	} elseif ( is_singular() ) {
		$post_type   = get_post_type();
		$hero_layout = get_theme_mod( 'twentig_' . $post_type . '_hero_layout' );
		if ( false === $hero_layout && twentig_twentyone_is_cpt_single() ) {
			$cpt_layout = get_theme_mod( 'twentig_cpt_single_layout' );
			if ( $cpt_layout ) {
				$hero_layout = get_theme_mod( 'twentig_' . $cpt_layout . '_hero_layout' );
			}
		}
		if ( 'no-image' === $hero_layout ) {
			return false;
		}
	}
	return $can_show;
}
add_filter( 'twenty_twenty_one_can_show_post_thumbnail', 'twentig_twentyone_display_featured_image' );

/**
 * Filters the content of the latest posts block to change the image sizes attribute.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attribute.
 */
function twentig_twentyone_change_latest_posts_image_sizes( $block_content, $block ) {
	if ( 'core/latest-posts' === $block['blockName'] ) {
		$image = $block['attrs'] && isset( $block['attrs']['displayFeaturedImage'] ) ? $block['attrs']['displayFeaturedImage'] : 0;

		if ( $image ) {
			$image_width = $block['attrs'] && isset( $block['attrs']['featuredImageSizeWidth'] ) ? $block['attrs']['featuredImageSizeWidth'] : '';
			$sizes       = '';

			if ( '' === $image_width ) {
				$layout        = $block['attrs'] && isset( $block['attrs']['postLayout'] ) ? $block['attrs']['postLayout'] : '';
				$block_align   = $block['attrs'] && isset( $block['attrs']['align'] ) ? $block['attrs']['align'] : '';
				$image_align   = $block['attrs'] && isset( $block['attrs']['featuredImageAlign'] ) ? $block['attrs']['featuredImageAlign'] : '';
				$wide_width    = get_theme_mod( 'twentig_wide_width', 1240 );
				$wide_width    = $wide_width ? $wide_width : 1240;
				$default_width = get_theme_mod( 'twentig_default_width', 610 );
				$default_width = $default_width ? $default_width : 610;

				if ( 'grid' === $layout ) {
					$columns = $block['attrs'] && isset( $block['attrs']['columns'] ) ? intval( $block['attrs']['columns'] ) : 3;

					if ( 'left' === $image_align || 'right' === $image_align ) {
						$sizes = '(min-width: 1280px) ' . intval( $wide_width * 0.125 - 5 ) . 'px, (min-width: 652px) calc(12.5vw - 15px), calc(25vw - 10px)';
					} else {
						if ( 'wide' === $block_align || 'full' === $block_align ) {
							$sizes = '(min-width: 1280px) ' . intval( $wide_width / 4 - 30 ) . 'px, (min-width: 1024px) calc(25vw - 60px), (min-width: 822px) calc(50vw - 80px), (min-width: 652px) calc(50vw - 52px), (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							if ( 2 === $columns ) {
								$sizes = '(min-width: 1280px) ' . intval( $wide_width / 2 - 20 ) . 'px, (min-width: 822px) calc(50vw - 80px), (min-width: 652px) calc(50vw - 52px), (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							} elseif ( 3 === $columns ) {
								$sizes = '(min-width: 1280px) ' . intval( $wide_width / 3 - 27 ) . 'px, (min-width: 1024px) calc(33.33vw - 66px), (min-width: 822px) calc(50vw - 80px), (min-width: 652px) calc(50vw - 52px), (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							}
						} else {
							$sizes = '(min-width: 1024px) ' . intval( $default_width / 3 - 27 ) . 'px, (min-width: 652px) ' . intval( $default_width / 2 - 16 ) . 'px, (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							if ( 2 === $columns ) {
								$sizes = '(min-width: 652px) ' . intval( $default_width / 2 - 16 ) . 'px, (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
							}
						}
					}
				} else {
					if ( 'left' === $image_align || 'right' === $image_align ) {
						if ( '' === $block_align ) {
							$sizes = '(min-width: 652px) ' . intval( $default_width * 0.25 ) . 'px, calc(25vw - 10px)';
						} else {
							$sizes = '(min-width: 1280px) ' . intval( $wide_width * 0.25 ) . 'px, (min-width: 652px) calc(25vw - 25px), calc(25vw - 10px)';
						}
					} else {
						$sizes = '(min-width: 652px) ' . intval( $default_width ) . 'px, (min-width: 482px) calc(100vw - 80px), calc(100vw - 40px)';
					}
				}
			} else {
				$sizes = $image_width . 'px';
			}
			if ( $sizes ) {
				return preg_replace( '/sizes="([^>]+?)"/', 'sizes="' . $sizes . '"', $block_content );
			}
		}
	}
	return $block_content;
}
add_filter( 'render_block', 'twentig_twentyone_change_latest_posts_image_sizes', 10, 2 );

/**
 * Filters whether all posts are open for comments.
 *
 * @param bool $open Whether the current post is open for comments.
 */
function twentig_twentyone_comments_open( $open ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'twentig_twentyone_comments_open' );

/**
 * Filters the comment count for all posts.
 *
 * @param string|int $count A string representing the number of comments a post has, otherwise 0.
 */
function twentig_twentyone_comments_number( $count ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return 0;
	}
	return $count;
}
add_filter( 'get_comments_number', 'twentig_twentyone_comments_number' );

/**
 * Removes the single navigation by excluding all the terms.
 */
function twentig_twentyone_filter_navigation() {
	if ( 'none' === get_theme_mod( 'twentig_post_navigation' ) ) {
		add_filter( 'get_next_post_excluded_terms', 'twentig_twentyone_exclude_terms' );
		add_filter( 'get_previous_post_excluded_terms', 'twentig_twentyone_exclude_terms' );
	}
}
add_action( 'get_template_part_template-parts/post/author-bio', 'twentig_twentyone_filter_navigation' );

/**
 * Returns all the post categories.
 */
function twentig_twentyone_exclude_terms() {
	$cat_ids = get_terms(
		'category',
		array(
			'fields' => 'ids',
			'get'    => 'all',
		)
	);
	return $cat_ids;
}

/**
 * Wraps the archive title prefix with a span.
 *
 * @param string $prefix Archive title prefix.
 */
function twentig_twentyone_set_archive_title_prefix( $prefix ) {
	return '<span class="archive-title-prefix">' . $prefix . '</span>';
}
add_filter( 'get_the_archive_title_prefix', 'twentig_twentyone_set_archive_title_prefix' );
