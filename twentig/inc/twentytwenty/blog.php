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
function twentig_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'twentig_excerpt_more' );

/**
 * Display Continue Reading link after the excerpt.
 *
 * @param string  $post_excerpt The post excerpt.
 * @param WP_Post $post         Post object.
 */
function twentig_add_more_to_excerpt( $post_excerpt, $post ) {
	if ( 'summary' === get_theme_mod( 'blog_content', 'full' ) && get_theme_mod( 'twentig_blog_excerpt_more', false ) && 'post' === $post->post_type && ! is_singular() && ! is_search() ) {
		return $post_excerpt . '<a href="' . get_permalink( $post->ID ) . '" class="more-link"><span>' . esc_html__( 'Continue reading', 'twentytwenty' ) . '</span><span class="screen-reader-text">' . $post->post_title . '</span></a>';
	}
	return $post_excerpt;
}
add_filter( 'get_the_excerpt', 'twentig_add_more_to_excerpt', 10, 2 );

/**
 * Set excerpt length.
 *
 * @param int $excerpt_length The maximum number of words.
 */
function twentig_custom_excerpt_length( $excerpt_length ) {
	if ( is_home() || is_archive() ) {
		$newlength = get_theme_mod( 'twentig_blog_excerpt_length' );
		if ( $newlength ) {
			return $newlength;
		}
	}
	return $excerpt_length;
}
add_filter( 'excerpt_length', 'twentig_custom_excerpt_length' );

/**
 * Change the read more button style to a normal link when changing blog layout.
 *
 * @param string $more_link_element Read More link element.
 */
function twentig_read_more_tag( $more_link_element ) {
	if ( '' === get_theme_mod( 'twentig_blog_layout' ) ) {
		return $more_link_element;
	}
	return str_replace( 'faux-button', 'link-button', $more_link_element );
}
add_filter( 'the_content_more_link', 'twentig_read_more_tag', 20 );

/**
 * Removes the post content displayed on the archive pages based on Customizer setting.
 */
function twentig_filter_content() {
	if ( class_exists( 'bbPress' ) && is_bbpress() ) {
		return;
	}

	if ( ( is_home() || is_archive() ) && ! get_theme_mod( 'twentig_blog_content', true ) ) {
		if ( 'summary' === get_theme_mod( 'blog_content', 'full' ) ) {
			add_filter( 'the_excerpt', '__return_empty_string' );
		} else {
			add_filter( 'the_content', '__return_empty_string' );
		}
	}
}
add_action( 'get_template_part_template-parts/content', 'twentig_filter_content' );

/**
 * Hide the top categories.
 */
function twentig_hide_categories_in_entry_header() {
	if ( is_singular() ) {
		$post_meta = get_theme_mod( 'twentig_post_meta', array( 'top-categories', 'author', 'post-date', 'comments', 'tags' ) );
		if ( ! in_array( 'top-categories', $post_meta, true ) ) {
			return false;
		}
	} else {
		$post_meta = get_theme_mod( 'twentig_blog_meta', array( 'top-categories', 'author', 'post-date', 'comments', 'tags' ) );
		if ( ! in_array( 'top-categories', $post_meta, true ) ) {
			return false;
		}
	}
	return true;
}
add_filter( 'twentytwenty_show_categories_in_entry_header', 'twentig_hide_categories_in_entry_header' );

/**
 * Display the post top meta.
 *
 * @param array $meta The post meta.
 */
function twentig_post_meta_top( $meta ) {
	$post_meta   = is_singular() ? get_theme_mod( 'twentig_post_meta', $meta ) : get_theme_mod( 'twentig_blog_meta', $meta );
	$blog_layout = get_theme_mod( 'twentig_blog_layout' );

	$tags_key = array_search( 'tags', $post_meta, true );
	if ( false !== $tags_key ) {
		unset( $post_meta[ $tags_key ] );
	}

	if ( ! is_singular() ) {
		$post_meta[] = 'sticky';
		if ( in_array( $blog_layout, array( 'grid-card', 'grid-basic' ), true ) ) {
			$post_meta = array();
		}
	}

	return $post_meta;
}
add_filter( 'twentytwenty_post_meta_location_single_top', 'twentig_post_meta_top' );

/**
 * Display the post bottom meta.
 *
 * @param array $meta The post meta.
 */
function twentig_post_meta_bottom( $meta ) {
	$post_meta   = is_singular() ? get_theme_mod( 'twentig_post_meta', $meta ) : get_theme_mod( 'twentig_blog_meta', $meta );
	$blog_layout = get_theme_mod( 'twentig_blog_layout' );

	if ( ! in_array( 'tags', $post_meta, true ) ) {
		$meta = array();
	}

	if ( ! is_singular() && in_array( $blog_layout, array( 'grid-card', 'grid-basic' ), true ) ) {
		$meta   = get_theme_mod( 'twentig_blog_meta', $meta );
		$meta[] = 'sticky';
	}

	return $meta;
}
add_filter( 'twentytwenty_post_meta_location_single_bottom', 'twentig_post_meta_bottom' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param string[] $classes An array of post class names.
 * @param string[] $class   An array of additional class names added to the post.
 * @param int      $post_id The post ID.
 */
function twentig_post_class( $classes, $class, $post_id ) {
	$post = get_post( $post_id );

	if ( 'post' === $post->post_type ) {
		if ( ! is_singular() && ! is_search() ) {
			if ( ! get_theme_mod( 'twentig_blog_content', true ) ) {
				$classes[] = 'tw-post-no-content';
			}
			$image_ratio = get_theme_mod( 'twentig_blog_image_ratio' );
			if ( in_array( 'has-post-thumbnail', $classes, true ) && $image_ratio ) {
				$classes[] = 'tw-post-has-image-' . $image_ratio;
			}
		}
		if ( ! get_theme_mod( 'twentig_blog_meta_icon', true ) ) {
			$classes[] = 'tw-meta-no-icon';
		}
	}
	return $classes;
}
add_filter( 'post_class', 'twentig_post_class', 10, 3 );

/**
 * Add link to featured image on archives page.
 *
 * @param string $html The post thumbnail HTML.
 * @param int    $post_id The post ID.
 */
function twentig_twentytwenty_add_link_to_featured_image( $html, $post_id ) {
	if ( ( is_home() || is_archive() || is_post_type_archive( 'post' ) ) ) {
		return '<a href="' . esc_url( get_permalink( $post_id ) ) . '" tabindex="-1" aria-hidden="true">' . $html . '</a>';
	}
	return $html;
}
add_filter( 'post_thumbnail_html', 'twentig_twentytwenty_add_link_to_featured_image', 10, 2 );

/**
 * Determines if post thumbnail should be displayed.
 *
 * @param bool $has_thumbnail Whether the post has a thumbnail.
 */
function twentig_display_featured_image( $has_thumbnail ) {

	if ( ! get_theme_mod( 'twentig_blog_image', true ) && ( is_home() || is_archive() || is_post_type_archive( 'post' ) ) ) {
		return false;
	}

	if ( is_singular( 'post' ) && ( 'no-image' === get_theme_mod( 'twentig_post_hero_layout' ) ) && ! is_page_template( 'templates/template-cover.php' ) ) {
		if ( in_the_loop() ) {
			static $ran = false;
			if ( $ran ) {
				remove_filter( 'has_post_thumbnail', 'twentig_display_featured_image', 12 );
			}
			$ran = true;
		}
		return false;
	}

	if ( is_singular( 'page' ) && ( 'no-image' === get_theme_mod( 'twentig_page_hero_layout' ) ) && ( ! is_page_template() || is_page_template( 'templates/template-full-width.php' ) ) ) {
		if ( in_the_loop() ) {
			static $ran = false;
			if ( $ran ) {
				remove_filter( 'has_post_thumbnail', 'twentig_display_featured_image', 12 );
			}
			$ran = true;
		}
		return false;
	}

	return $has_thumbnail;
}
add_filter( 'has_post_thumbnail', 'twentig_display_featured_image', 12 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality.
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 */
function twentig_calculate_image_sizes( $sizes ) {

	if ( ! in_the_loop() ) {
		return $sizes;
	}

	if ( is_home() || is_author() || is_category() || is_tag() || is_date() || is_tax( get_object_taxonomies( 'post' ) ) ) {
		$blog_layout = get_theme_mod( 'twentig_blog_layout' );
		if ( 'grid-basic' === $blog_layout || 'grid-card' === $blog_layout ) {
			$blog_columns = get_theme_mod( 'twentig_blog_columns', '3' );
			if ( '2' === $blog_columns ) {
				$sizes = '(min-width: 1280px) 584px, (min-width: 700px) calc(50vw - 56px), calc(100vw - 40px)';
			} else {
				$sizes = '(min-width: 1280px) 378px, (min-width: 1220px) calc(33.33vw - 48px), (min-width: 700px) calc(50vw - 56px), calc(100vw - 40px)';
			}
		} elseif ( 'stack' === $blog_layout ) {
			$content_width = get_theme_mod( 'twentig_text_width' );
			if ( 'wide' === $content_width ) {
				$sizes = '(min-width: 880px) 800px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
			} elseif ( 'medium' === $content_width ) {
				$sizes = '(min-width: 780px) 700px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
			} else {
				$sizes = '(min-width: 620px) 580px, calc(100vw - 40px)';
			}
		}
	} elseif ( is_singular( array( 'post', 'page' ) ) && has_post_thumbnail() && ! is_page_template() ) {
		$hero_layout = is_page() ? get_theme_mod( 'twentig_page_hero_layout' ) : get_theme_mod( 'twentig_post_hero_layout' );
		if ( 'narrow-image' === $hero_layout ) {
			static $ran = false;
			if ( ! $ran ) {
				$content_width = get_theme_mod( 'twentig_text_width' );
				if ( 'wide' === $content_width ) {
					$sizes = '(min-width: 880px) 800px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
				} elseif ( 'medium' === $content_width ) {
					$sizes = '(min-width: 780px) 700px, (min-width: 700px) calc(100vw - 80px), calc(100vw - 40px)';
				} else {
					$sizes = '(min-width: 620px) 580px, calc(100vw - 40px)';
				}
			}
			$ran = true;
		}
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentig_calculate_image_sizes' );

/**
 * Changes the hero image size based on selected layout.
 */
function twentig_content_hero_image() {
	if ( is_singular( array( 'post', 'page' ) ) ) {
		$hero_layout = is_page() ? get_theme_mod( 'twentig_page_hero_layout' ) : get_theme_mod( 'twentig_post_hero_layout' );
		if ( 'full-image' === $hero_layout ) {
			add_filter(
				'post_thumbnail_size',
				function() {
					return 'full';
				}
			);
		}
	}
}
add_action( 'get_template_part_template-parts/featured-image', 'twentig_content_hero_image' );

/**
 * Hide excerpt on single post.
 */
function twentig_remove_excerpt_single_post() {
	if ( is_singular( 'post' ) && ! get_theme_mod( 'twentig_post_excerpt', true ) ) {
		add_filter( 'the_excerpt', '__return_empty_string' );
	}
}
add_action( 'get_template_part_template-parts/entry-header', 'twentig_remove_excerpt_single_post', 10, 2 );
add_action( 'get_template_part_template-parts/content-cover', 'twentig_remove_excerpt_single_post', 10, 2 );

/**
 * Filters whether all posts are open for comments.
 *
 * @param bool $open Whether the current post is open for comments.
 */
function twentig_comments_open( $open ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return false;
	}
	return $open;
}
add_filter( 'comments_open', 'twentig_comments_open' );

/**
 * Filters the comment count for all posts.
 *
 * @param string|int $count A string representing the number of comments a post has, otherwise 0.
 */
function twentig_comments_number( $count ) {
	if ( ! get_theme_mod( 'twentig_blog_comments', true ) ) {
		return 0;
	}
	return $count;
}
add_filter( 'get_comments_number', 'twentig_comments_number' );

/**
 * Removes the single navigation by excluding all the terms.
 */
function twentig_filter_navigation() {
	if ( 'none' === get_theme_mod( 'twentig_post_navigation' ) ) {
		add_filter( 'get_next_post_excluded_terms', 'twentig_exclude_terms' );
		add_filter( 'get_previous_post_excluded_terms', 'twentig_exclude_terms' );

		if ( ( comments_open() || get_comments_number() ) && ! post_password_required() ) {
			echo '<hr class="styled-separator is-style-wide section-inner" aria-hidden="true">';
		}
	}
}
add_action( 'get_template_part_template-parts/navigation', 'twentig_filter_navigation' );

/**
 * Returns all the post categories.
 */
function twentig_exclude_terms() {
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
 * Adds featured image as background image to single post navigation elements.
 */
function twentig_twentytwenty_post_nav_background() {
	if ( is_singular( 'post' ) && 'image' === get_theme_mod( 'twentig_post_navigation' ) ) {
		$next_post = get_next_post();
		$prev_post = get_previous_post();
		$css       = '';

		if ( $prev_post && (bool) get_post_thumbnail_id( $prev_post ) ) {
			$prev_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'large' );
			$css       .= 'a.previous-post { background-image: url(' . esc_url( $prev_thumb[0] ) . '); }';
		}

		if ( $next_post && (bool) get_post_thumbnail_id( $next_post ) ) {
			$next_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'large' );
			$css       .= 'a.next-post { background-image: url(' . esc_url( $next_thumb[0] ) . '); }';
		}

		wp_add_inline_style( 'twentig-twentytwenty', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'twentig_twentytwenty_post_nav_background', 13 );

/**
 * Filters the content of the latest posts block to change the image sizes attribute.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attribute.
 */
function twentig_twentytwenty_change_latest_posts_image_sizes( $block_content, $block ) {
	if ( 'core/latest-posts' === $block['blockName'] ) {
		$image = $block['attrs'] && isset( $block['attrs']['displayFeaturedImage'] ) ? $block['attrs']['displayFeaturedImage'] : 0;

		if ( $image ) {
			$image_width = $block['attrs'] && isset( $block['attrs']['featuredImageSizeWidth'] ) ? $block['attrs']['featuredImageSizeWidth'] : '';
			$sizes       = '';

			if ( '' === $image_width ) {
				$layout        = $block['attrs'] && isset( $block['attrs']['postLayout'] ) ? $block['attrs']['postLayout'] : '';
				$block_align   = $block['attrs'] && isset( $block['attrs']['align'] ) ? $block['attrs']['align'] : '';
				$image_align   = $block['attrs'] && isset( $block['attrs']['featuredImageAlign'] ) ? $block['attrs']['featuredImageAlign'] : '';
				$content_width = get_theme_mod( 'twentig_text_width' );

				if ( 'grid' === $layout ) {
					$columns      = $block['attrs'] && isset( $block['attrs']['columns'] ) ? $block['attrs']['columns'] : 3;
					$medium_sizes = '(min-width: 700px) calc(50vw - 56px), calc(100vw - 40px)';

					if ( 'left' === $image_align || 'right' === $image_align ) {
						if ( '' === $block_align ) {
							$sizes = '(min-width: 700px) 96px, calc(25vw - 10px)';
						} elseif ( 'wide' === $block_align ) {
							$sizes = '(min-width: 1280px) 146px, (min-width: 700px) calc(12.5vw - 14px), calc(25vw - 10px)';
						}
					} else {
						if ( 'wide' === $block_align ) {
							$sizes = '(min-width: 1280px) 276px, (min-width: 1024px) calc(25vw - 44px),' . $medium_sizes;
							if ( 2 === $columns ) {
								$sizes = '(min-width: 1280px) 584px,' . $medium_sizes;
							} elseif ( 3 === $columns ) {
								$sizes = '(min-width: 1280px) 378px, (min-width: 1024px) calc(33.33vw - 48px), ' . $medium_sizes;
							}
						} elseif ( 'full' === $block_align ) {
							$sizes = '(min-width: 1024px) calc(25vw - 44px),' . $medium_sizes;
							if ( 2 === $columns ) {
								$sizes = $medium_sizes;
							} elseif ( 3 === $columns ) {
								$sizes = '(min-width: 1024px) calc(33.33vw - 48px),' . $medium_sizes;
							}
						} else {
							if ( 'wide' === $content_width ) {
								$sizes = '(min-width: 1024px) 245px, (min-width: 880px) 384px, ' . $medium_sizes;
								if ( 2 === $columns ) {
									$sizes = '(min-width: 880px) 384px,' . $medium_sizes;
								}
							} elseif ( 'medium' === $content_width ) {
								$sizes = '(min-width: 1024px) 212px, (min-width: 780px) 334px, ' . $medium_sizes;
								if ( 2 === $columns ) {
									$sizes = '(min-width: 780px) 334px, ' . $medium_sizes;
								}
							} else {
								$sizes = '(min-width: 700px) 274px, (min-width: 620px) 580px, calc(100vw - 40px)';
							}
						}
					}
				} else {
					if ( 'left' === $image_align || 'right' === $image_align ) {
						if ( '' === $block_align ) {
							$sizes = '(min-width: 620px) 145px, calc(25vw - 10px)';
							if ( 'wide' === $content_width ) {
								$sizes = '(min-width: 880px) 200px, (min-width: 700px) calc(25vw - 20px), calc(25vw - 10px)';
							} elseif ( 'medium' === $content_width ) {
								$sizes = '(min-width: 780px) 175px, (min-width: 700px) calc(25vw - 20px), calc(25vw - 10px)';
							}
						} else {
							$sizes = '(min-width: 1280px) 300px, (min-width: 700px) calc(25vw - 20px), calc(25vw - 10px)';
						}
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
add_filter( 'render_block', 'twentig_twentytwenty_change_latest_posts_image_sizes', 10, 2 );
