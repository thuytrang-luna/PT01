<?php
/**
 * Text block patterns.
 *
 * @package twentig
 */

twentig_register_block_pattern(
	'twentig/heading-and-text',
	array(
		'title'      => __( 'Heading and Text', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet. Fusce sed magna eu ligula commodo hendrerit.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Morbi fringilla sapien libero. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/centered-heading-and-text',
	array(
		'title'      => __( 'Centered Heading and text', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet. Fusce sed magna eu ligula commodo hendrerit.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Morbi fringilla sapien libero. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/large-text',
	array(
		'title'      => __( 'Large Text', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:paragraph {"align":"center","fontSize":"large"} --><p class="has-text-align-center has-large-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Class aptent taciti sociosqu ad litora torquent.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/heading-and-large-text',
	array(
		'title'      => __( 'Heading and Large Text', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","fontSize":"large"} --><p class="has-text-align-center has-large-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/heading-and-lead-paragraph',
	array(
		'title'      => __( 'Heading and Lead Paragraph', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"large"} --><p class="has-large-font-size"><strong>' . esc_html_x( 'Write a lead paragraph.', 'Block pattern content', 'twentig' ) . ' Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore.</strong></p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet. Fusce sed magna eu ligula commodo hendrerit.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Morbi fringilla sapien libero. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/eyebrow-heading',
	array(
		'title'      => __( 'Eyebrow Heading', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"className":"tw-eyebrow"} --><h2 class="tw-eyebrow">' . esc_html_x( 'Short heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:heading {"level":3,"fontSize":"h2"} --><h3 class="has-h-2-font-size">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Class aptent taciti sociosqu ad litora torquent.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet. Fusce sed magna eu ligula commodo hendrerit fringilla ac purus.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/heading-on-left-and-text',
	array(
		'title'      => __( 'Heading on Left and Text', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:columns {"align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide tw-gutter-large tw-cols-stack-md"><!-- wp:column {"className":"tw-mb-2"} --><div class="wp-block-column tw-mb-2"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --></div><!-- /wp:column --><!-- wp:column {"className":"tw-mt-2"} --><div class="wp-block-column tw-mt-2"><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Class aptent taciti sociosqu ad litora torquent per conubia nostra.</p><!-- /wp:paragraph --><!-- wp:paragraph --><p>Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet. Fusce sed magna eu ligula commodo hendrerit fringilla ac purus.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/small-heading-and-wide-text',
	array(
		'title'      => __( 'Small Heading and Wide Text', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"align":"wide","className":"tw-eyebrow"} --><h2 class="alignwide tw-eyebrow">' . esc_html_x( 'Short heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"larger","className":"tw-text-wide"} --><p class="has-larger-font-size tw-text-wide">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Class aptent taciti sociosqu ad litora torquent per conubia nostra.</p><!-- /wp:paragraph --><!-- wp:paragraph {"fontSize":"larger","className":"tw-text-wide"} --><p class="has-larger-font-size tw-text-wide">Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet fusce sed magna eu ligula.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/bordered-heading-and-small-headings',
	array(
		'title'      => __( 'Bordered Heading and Small Headings', 'twentig' ),
		'categories' => array( 'text' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"className":"tw-heading-border-bottom"} --><h2 class="tw-heading-border-bottom">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:heading {"level":3,"fontSize":"h5"} --><h3 class="has-h-5-font-size">' . esc_html_x( 'First item', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus, suscipit eu iaculis sed, ullamcorper at metus. Venenatis nec convallis magna, eu congue velit. Fusce sed magna eu ligula commodo hendrerit fringilla.</p><!-- /wp:paragraph --><!-- wp:heading {"level":3,"fontSize":"h5"} --><h3 class="has-h-5-font-size">' . esc_html_x( 'Second item', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Venenatis nec convallis magna, eu congue velit. Aliquam tempus mi nulla porta luctus. Sed non neque at lectus bibendum blandit. Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet. Fusce sed magna eu ligula commodo hendrerit fringilla ac purus.</p><!-- /wp:paragraph --></div></div><!-- /wp:group -->',
	)
);
