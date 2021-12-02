<?php
/**
 * Call-To-Action block patterns.
 *
 * @package twentig
 * @phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
 */

twentig_register_block_pattern(
	'twentig/cta-colored-background',
	array(
		'title'      => __( 'CTA: Colored Background', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"backgroundColor":"subtle-background","align":"full"} --><div class="wp-block-group alignfull has-subtle-background-background-color has-background"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-colored-background-with-text',
	array(
		'title'      => __( 'CTA: Colored Background with Text', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"backgroundColor":"subtle-background","align":"full"} --><div class="wp-block-group alignfull has-subtle-background-background-color has-background"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","fontSize":"medium"} --><p class="has-text-align-center has-medium-font-size"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p><!-- /wp:paragraph --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-wide-gradient-background',
	array(
		'title'      => __( 'CTA: Wide Gradient Background', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:cover {"customGradient":"linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)","align":"wide"} --><div class="wp-block-cover alignwide has-background-dim has-background-gradient" style="background:linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)"><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center","fontSize":"medium"} --><p class="has-text-align-center has-medium-font-size"> Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt ut labore.</p><!-- /wp:paragraph --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-gradient-background-with-buttons',
	array(
		'title'      => __( 'CTA: Gradient Background with Buttons', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:cover {"customGradient":"linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)","align":"full"} --><div class="wp-block-cover alignfull has-background-dim has-background-gradient" style="background:linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)"><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --><!-- wp:button {"textColor":"white","className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-white-color has-text-color">' . esc_html_x( 'Learn more', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-cover',
	array(
		'title'      => __( 'CTA: Cover', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'wide.jpg' ) . '","minHeight":500,"align":"full"} --><div class="wp-block-cover alignfull has-background-dim" style="background-image:url(' . twentig_get_pattern_asset( 'wide.jpg' ) . ');min-height:500px"><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a call to action heading to engage your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-heading-on-left',
	array(
		'title'      => __( 'CTA: Heading on Left', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:columns {"align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide tw-gutter-large tw-cols-stack-md"><!-- wp:column {"className":"tw-mb-2"} --><div class="wp-block-column tw-mb-2"><!-- wp:heading --><h2>' . esc_html_x( 'Write a call to action heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --></div><!-- /wp:column --><!-- wp:column {"className":"tw-mt-2"} --><div class="wp-block-column tw-mt-2"><!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Venenatis nec convallis magna, eu congue velit.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-image-on-right',
	array(
		'title'      => __( 'CTA: Image on Right', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:media-text {"mediaPosition":"right","mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide has-media-on-the-right is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-horizontal-card',
	array(
		'title'      => __( 'CTA: Horizontal Card', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:media-text {"mediaType":"image","imageFill":true,"className":"is-style-tw-shadow","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile is-image-fill is-style-tw-shadow tw-stack-md"><figure class="wp-block-media-text__media" style="background-image:url(' . twentig_get_pattern_asset( 'landscape1.jpg' ) . ');background-position:50% 50%"><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"medium"} --><p class="has-medium-font-size">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-2-columns',
	array(
		'title'      => __( 'CTA: 2 Columns', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:columns {"align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide tw-gutter-large tw-cols-stack-md"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","fontSize":"h3"} --><h2 class="has-text-align-center has-h-3-font-size">' . esc_html_x( 'Write a call to action heading to engage your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --><!-- wp:separator {"className":"tw-lg-hidden"} --><hr class="wp-block-separator tw-lg-hidden"/><!-- /wp:separator --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"textAlign":"center","fontSize":"h3"} --><h2 class="has-text-align-center has-h-3-font-size">' . esc_html_x( 'Write a call to action heading to engage your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link">' . esc_html_x( 'Contact us', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-gradient-background-with-2-columns',
	array(
		'title'      => __( 'CTA: Gradient Background with 2 Columns', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:cover {"customGradient":"linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)","align":"full"} --><div class="wp-block-cover alignfull has-background-dim has-background-gradient" style="background:linear-gradient(135deg,rgb(6,147,227) 0%,rgb(155,81,224) 100%)"><div class="wp-block-cover__inner-container"><!-- wp:columns {"twColumnStyle":"card-gray","twTextAlign":"center","twStretchedLink":true} --><div class="wp-block-columns tw-cols-card tw-cols-card-gray has-text-align-center tw-stretched-link"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"fontSize":"h4"} --><h2 class="has-h-4-font-size">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet commodo erat elit.</p><!-- /wp:paragraph --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"fontSize":"h4"} --><h2 class="has-h-4-font-size">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Integer enim risus suscipit eu iaculis sed metus.</p><!-- /wp:paragraph --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Contact us', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:cover -->',
	)
);

twentig_register_block_pattern(
	'twentig/cta-2-columns-with-cover',
	array(
		'title'      => __( 'CTA: 2 Columns with Cover', 'twentig' ),
		'categories' => array( 'cta' ),
		'content'    => '<!-- wp:columns {"align":"full","className":"tw-mt-0","twGutter":"no","twStack":"md","twTextAlign":"center"} --><div class="wp-block-columns alignfull tw-mt-0 tw-gutter-no tw-cols-stack-md has-text-align-center"><!-- wp:column --><div class="wp-block-column"><!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '","twStretchedLink":true,"twHover":"opacity"} --><div class="wp-block-cover has-background-dim tw-stretched-link tw-hover-opacity" style="background-image:url(' . twentig_get_pattern_asset( 'landscape1.jpg' ) . ')"><div class="wp-block-cover__inner-container"><!-- wp:heading {"fontSize":"h3"} --><h2 class="has-h-3-font-size">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Get started', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:cover {"url":"' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '","twStretchedLink":true,"twHover":"opacity"} --><div class="wp-block-cover has-background-dim tw-stretched-link tw-hover-opacity" style="background-image:url(' . twentig_get_pattern_asset( 'landscape2.jpg' ) . ')"><div class="wp-block-cover__inner-container"><!-- wp:heading {"fontSize":"h3"} --><h2 class="has-h-3-font-size">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:buttons {"align":"center"} --><div class="wp-block-buttons aligncenter"><!-- wp:button {"backgroundColor":"white"} --><div class="wp-block-button"><a class="wp-block-button__link has-white-background-color has-background">' . esc_html_x( 'Contact us', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover --></div><!-- /wp:column --></div><!-- /wp:columns -->',
	)
);
