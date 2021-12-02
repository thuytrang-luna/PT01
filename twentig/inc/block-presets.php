<?php
/**
 * Twentig utility classes for blocks.
 *
 * @package twentig
 */

/**
 * Retrieves additional CSS classes for blocks.
 */
function twentig_get_block_css_classes() {

	$classes = array(

		'core/paragraph'    => array(
			'tw-text-uppercase'       => __( 'Make the text uppercase.', 'twentig' ),
			'tw-eyebrow'              => __( 'Make the text small and uppercase.', 'twentig' ),
			'tw-letter-spacing-tight' => __( 'Make the letter spacing tight.', 'twentig' ),
			'tw-letter-spacing-loose' => __( 'Make the letter spacing loose.', 'twentig' ),
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'    => __( 'Remove underline from link.', 'twentig' ),
			'tw-rounded'              => __( 'Make the corners of the block rounded if a background color is set.', 'twentig' ),
			'tw-sm-text-left'         => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center'       => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'        => __( 'Align text right on mobile.', 'twentig' ),
			'tw-md-text-left'         => __( 'Align text left on medium screens.', 'twentig' ),
			'tw-md-text-center'       => __( 'Align text center on medium screens.', 'twentig' ),
			'tw-md-text-right'        => __( 'Align text right on medium screens.', 'twentig' ),
		),
		'core/heading'      => array(
			'tw-heading-border-bottom' => __( 'Add a border below the heading.', 'twentig' ),
			'tw-heading-dash-bottom'   => __( 'Add a short line below the heading.', 'twentig' ),
			'tw-text-uppercase'        => __( 'Make the text uppercase.', 'twentig' ),
			'tw-eyebrow'               => __( 'Make the text small and uppercase.', 'twentig' ),
			'tw-letter-spacing-normal' => __( 'Make the letter spacing normal.', 'twentig' ),
			'tw-letter-spacing-loose'  => __( 'Make the letter spacing loose.', 'twentig' ),
			'tw-link-hover-underline'  => __( 'Underline link only on hover.', 'twentig' ),
			'tw-link-no-underline'     => __( 'Remove underline from link.', 'twentig' ),
			'tw-rounded'               => __( 'Make the corners of the block rounded if a background color is set.', 'twentig' ),
			'tw-sm-text-left'          => __( 'Align text left on mobile.', 'twentig' ),
			'tw-sm-text-center'        => __( 'Align text center on mobile.', 'twentig' ),
			'tw-sm-text-right'         => __( 'Align text right on mobile.', 'twentig' ),
			'tw-md-text-left'          => __( 'Align text left on medium screens.', 'twentig' ),
			'tw-md-text-center'        => __( 'Align text center on medium screens.', 'twentig' ),
			'tw-md-text-right'         => __( 'Align text right on medium screens.', 'twentig' ),
		),
		'core/list'         => array(
			'has-small-font-size'     => __( 'Make the font size small.', 'twentig' ),
			'has-medium-font-size'    => __( 'Make the font size medium.', 'twentig' ),
			'has-large-font-size'     => __( 'Make the font size large.', 'twentig' ),
			'has-larger-font-size'    => __( 'Make the font size larger.', 'twentig' ),
			'tw-font-bold'            => __( 'Make the text bold.', 'twentig' ),
			'tw-font-italic'          => __( 'Make the text italic.', 'twentig' ),
			'tw-text-uppercase'       => __( 'Make the text uppercase.', 'twentig' ),
			'has-text-align-center'   => __( 'Align text center.', 'twentig' ),
			'tw-list-spacing-medium'  => __( 'Set a medium spacing between the list items.', 'twentig' ),
			'tw-list-spacing-loose'   => __( 'Set a loose spacing between the list items.', 'twentig' ),
			'tw-link-hover-underline' => __( 'Underline link only on hover.', 'twentig' ),
			'tw-text-wide'            => __( 'Make the block wide width.', 'twentig' ),
		),
		'core/table'        => array(
			'has-small-font-size' => __( 'Make the font size small.', 'twentig' ),
			'tw-row-valign-top'   => __( 'Vertically align top the text in the cells.', 'twentig' ),
		),
		'core/group'        => array(
			'tw-height-full'          => __( 'Make the block full height.', 'twentig' ),
			'tw-pt-0'                 => __( 'Remove the top padding.', 'twentig' ),
			'tw-pb-0'                 => __( 'Remove the bottom padding.', 'twentig' ),
			'tw-group-overlap-bottom' => __( 'Make the last block of the group overlap the group just below.', 'twentig' ),
			'tw-rounded'              => __( 'Make the corners of the block rounded.', 'twentig' ),
		),
		'core/cover'        => array(
			'tw-pt-0'    => __( 'Remove the top padding.', 'twentig' ),
			'tw-pb-0'    => __( 'Remove the bottom padding.', 'twentig' ),
			'tw-rounded' => __( 'Make the corners of the block rounded.', 'twentig' ),
		),
		'core/columns'      => array(
			'tw-cols-rounded'     => __( 'Make the corners of the cards rounded.', 'twentig' ),
			'tw-justify-center'   => __( 'Center the columns horizontally.', 'twentig' ),
			'tw-stretched-blocks' => __( 'Make the blocks inside the columns (Group, Cover) the same height.', 'twentig' ),
		),
		'core/media-text'   => array(
			'tw-content-narrow' => __( 'Limit the text width when the block is full width.', 'twentig' ),
			'tw-media-narrow'   => __( 'Limit the media width when the media and the text are stacked.', 'twentig' ),
			'tw-height-full'    => __( 'Make the block full height. You must enable the “Crop image to fill entire column” setting.', 'twentig' ),
			'tw-rounded'        => __( 'Make the corners of the block rounded.', 'twentig' ),
			'tw-img-rounded'    => __( 'Make the corners of the image rounded.', 'twentig' ),
		),
		'core/image'        => array(
			'tw-img-bw'        => __( 'Add a black & white filter to the image.', 'twentig' ),
			'tw-img-sepia'     => __( 'Add a sepia filter to the image.', 'twentig' ),
			'tw-caption-large' => __( 'Make the font size of the caption larger.', 'twentig' ),
		),
		'core/gallery'      => array(
			'tw-caption-large'    => __( 'Make the font size of the caption larger.', 'twentig' ),
			'tw-img-border'       => __( 'Add a border around the images (useful for logos and illustrations).', 'twentig' ),
			'tw-img-border-inner' => __( 'Add an inner border between the images (useful for logos).', 'twentig' ),
			'tw-img-bw'           => __( 'Add a black & white filter to the images.', 'twentig' ),
			'tw-img-sepia'        => __( 'Add a sepia filter to the images.', 'twentig' ),
			'tw-img-center'       => __( 'Center the images of the last row. You must enable the “Fixed width columns” setting.', 'twentig' ),
		),
		'core/embed'        => array(
			'is-style-tw-frame' => __( 'Add a frame around the block.', 'twentig' ),
		),
		'core/video'        => array(
			'is-style-tw-frame' => __( 'Add a frame around the block.', 'twentig' ),
		),
		'core/buttons'      => array(
			'tw-btn-full' => __( 'Make the buttons full width.', 'twentig' ),
		),
		'core/spacer'       => array(
			'tw-sm-hidden' => __( 'Hide the block only on small screens (only visible on live page).', 'twentig' ),
			'tw-md-hidden' => __( 'Hide the block only on medium screens (only visible on live page).', 'twentig' ),
			'tw-lg-hidden' => __( 'Hide the block only on large screens (only visible on live page).', 'twentig' ),
		),
		'core/separator'    => array(
			'tw-sm-hidden' => __( 'Hide the block only on small screens (only visible on live page).', 'twentig' ),
			'tw-md-hidden' => __( 'Hide the block only on medium screens (only visible on live page).', 'twentig' ),
			'tw-lg-hidden' => __( 'Hide the block only on large screens (only visible on live page).', 'twentig' ),
		),
		'core/latest-posts' => array(
			'tw-posts-rounded'      => __( 'Make the corners of the cards rounded.', 'twentig' ),
			'tw-img-rounded'        => __( 'Make the corners of the image rounded.', 'twentig' ),
			'has-text-align-center' => __( 'Align text center.', 'twentig' ),
		),
	);

	if ( is_wp_version_compatible( '5.7' ) ) {
		unset( $classes['core/list']['has-small-font-size'] );
		unset( $classes['core/list']['has-medium-font-size'] );
		unset( $classes['core/list']['has-large-font-size'] );
		unset( $classes['core/list']['has-larger-font-size'] );
		unset( $classes['core/buttons']['tw-btn-full'] );
		unset( $classes['core/group']['tw-pt-0'] );
		unset( $classes['core/group']['tw-pb-0'] );
		unset( $classes['core/cover']['tw-pt-0'] );
		unset( $classes['core/cover']['tw-pb-0'] );
	}

	return apply_filters( 'twentig_block_classes', $classes );
}

/**
 * Filters the columm block output to add a CSS var to store the width attribute.
 *
 * @param string $block_content The block content about to be appended.
 * @param array  $block         The full block, including name and attributes.
 */
function twentig_filter_column_block( $block_content, $block ) {
	if ( 'core/column' === $block['blockName'] && isset( $block['attrs'] ) && isset( $block['attrs']['width'] ) ) {
		$block_content = str_replace( 'flex-basis', '--col-width:' . $block['attrs']['width'] . ';flex-basis', $block_content );
	}
	return $block_content;
}
add_filter( 'render_block', 'twentig_filter_column_block', 10, 2 );
