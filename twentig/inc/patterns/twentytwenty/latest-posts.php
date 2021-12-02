<?php
/**
 * Latest posts block patterns.
 *
 * @package twentig
 */

twentig_register_block_pattern(
	'twentig/posts-list',
	array(
		'title'      => __( 'Posts: List', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 tw-heading-size-medium","postsToShow":3,"displayPostDate":true} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-list-with-separator',
	array(
		'title'      => __( 'Posts: List with Separator', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 is-style-tw-posts-border tw-heading-size-medium","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayPostDate":true} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-list-with-image-on-right',
	array(
		'title'      => __( 'Posts: List with Image on Right', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading --><h2>' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 is-style-tw-posts-border tw-img-ratio-3-2 tw-heading-size-medium tw-stretched-link","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageAlign":"right","featuredImageSizeSlug":"medium"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-list-with-image-on-left',
	array(
		'title'      => __( 'Posts: List with Image on Left', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading --><h2>' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"className":"tw-mt-8 tw-img-ratio-3-2 tw-heading-size-medium is-style-tw-posts-border tw-stretched-link","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeSlug":"medium"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-2-columns-image-on-left',
	array(
		'title'      => __( 'Posts 2 Columns: Image on Left', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-img-ratio-3-2 tw-stretched-link","postsToShow":4,"displayPostDate":true,"postLayout":"grid","columns":2,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeSlug":"medium"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-2-columns',
	array(
		'title'      => __( 'Posts 2 Columns', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-heading-size-medium tw-img-ratio-16-9 tw-stretched-link","postsToShow":2,"displayPostDate":true,"postLayout":"grid","columns":2,"displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-columns',
	array(
		'title'      => __( 'Posts 3 Columns', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-img-ratio-3-2 tw-heading-size-medium tw-stretched-link","postsToShow":3,"displayPostDate":true,"postLayout":"grid","displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-column-cards',
	array(
		'title'      => __( 'Posts 3 Columns: Card', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 is-style-tw-posts-card tw-img-ratio-3-2 tw-heading-size-medium tw-stretched-link","postsToShow":3,"displayPostDate":true,"postLayout":"grid","displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-column-cards-text-only',
	array(
		'title'      => __( 'Posts 3 Columns: Card with Text Only', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 is-style-tw-posts-card tw-stretched-link tw-heading-size-medium","postsToShow":3,"displayPostContent":true,"excerptLength":20,"displayPostDate":true,"postLayout":"grid"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-3-columns-top-border',
	array(
		'title'      => __( 'Posts 3 Columns: Top Border', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 is-style-tw-posts-border tw-heading-size-medium","postsToShow":6,"displayPostDate":true,"postLayout":"grid"} /--></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/posts-4-columns',
	array(
		'title'      => __( 'Posts 4 Columns', 'twentig' ),
		'categories' => array( 'latest-posts' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Latest posts', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:latest-posts {"align":"wide","className":"tw-mt-8 tw-img-ratio-3-2 tw-stretched-link","postsToShow":4,"displayPostDate":true,"postLayout":"grid","columns":4,"displayFeaturedImage":true,"featuredImageSizeSlug":"large"} /--></div></div><!-- /wp:group -->',
	)
);
