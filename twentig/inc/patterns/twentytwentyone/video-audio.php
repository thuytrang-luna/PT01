<?php
/**
 * Video & audio block patterns.
 *
 * @package twentig
 */

twentig_register_block_pattern(
	'twentig/hero-with-video',
	array(
		'title'      => __( 'Hero with Video', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center","level":1,"align":"wide"} --><h1 class="alignwide has-text-align-center">' . esc_html_x( 'Write the page title', 'Block pattern content', 'twentig' ) . '</h1><!-- /wp:heading --><!-- wp:paragraph {"align":"center","fontSize":"medium"} --><p class="has-text-align-center has-medium-font-size" >Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","align":"wide","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube alignwide wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/Text and Video',
	array(
		'title'      => __( 'Text and Video', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading that captivates your audience', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus. Class aptent taciti sociosqu ad litora torquent.</p><!-- /wp:paragraph --><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"tw-mt-8 wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube tw-mt-8 wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/video-with-text-on-left',
	array(
		'title'      => __( 'Video with Text on Left', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:columns {"verticalAlignment":"center","align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide are-vertically-aligned-center tw-gutter-large tw-cols-stack-md"><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus, suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/video-with-frame-and-text-on-right',
	array(
		'title'      => __( 'Video with Frame and Text on Right', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:columns {"verticalAlignment":"center","align":"wide","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide are-vertically-aligned-center tw-gutter-large tw-cols-stack-md"><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio is-style-tw-frame"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio is-style-tw-frame"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div><!-- /wp:column --><!-- wp:column {"verticalAlignment":"center"} --><div class="wp-block-column is-vertically-aligned-center"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus, suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/Text Columns and Video',
	array(
		'title'      => __( 'Text Columns and Video', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:columns {"align":"wide","className":"tw-mb-8","twGutter":"large","twStack":"md"} --><div class="wp-block-columns alignwide tw-mb-8 tw-gutter-large tw-cols-stack-md"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading --><h2>' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore. Integer enim risus suscipit eu iaculis sed, ullamcorper at metus.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns --><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","align":"wide","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube alignwide wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/column-cards-with-video',
	array(
		'title'      => __( 'Column Cards with Video', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'Write a heading', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:columns {"align":"wide","twStack":"md","twColumnStyle":"card-shadow","twStretchedMedia":true} --><div class="wp-block-columns alignwide tw-cols-stack-md tw-cols-card tw-cols-card-shadow tw-stretched-media"><!-- wp:column --><div class="wp-block-column"><!-- wp:core-embed/youtube {"url":"https://youtu.be/F7815PXurV8","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/F7815PXurV8 </div></figure><!-- /wp:core-embed/youtube --><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">' . esc_html_x( 'First item', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Lorem ipsum dolor sit amet, commodo erat adipiscing elit. Sed do eiusmod ut tempor incididunt ut labore et dolore.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:core-embed/youtube {"url":"https://youtu.be/4dSQPEFWhgM","type":"video","providerNameSlug":"youtube","className":"wp-embed-aspect-16-9 wp-has-aspect-ratio"} --><figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio"><div class="wp-block-embed__wrapper"> https://youtu.be/4dSQPEFWhgM </div></figure><!-- /wp:core-embed/youtube --><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">' . esc_html_x( 'Second item', 'Block pattern content', 'twentig' ) . '</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Integer enim risus suscipit eu iaculis sed ullamcorper at metus. Venenatis nec convallis magna eu congue velit.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/audio-list',
	array(
		'title'      => __( 'Audio List', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center","className":"tw-mb-8"} --><h2 class="has-text-align-center tw-mb-8">' . esc_html_x( 'All episodes', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">01: Lorem ipsum dolor sit amet</h3><!-- /wp:heading --><!-- wp:audio {"className":"tw-mt-0"} --><figure class="wp-block-audio tw-mt-0"><audio controls src="https://s.w.org/audio.mp3"></audio></figure><!-- /wp:audio --><!-- wp:separator --><hr class="wp-block-separator"/><!-- /wp:separator --><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">02: Integer enim risus suscipit eu iaculis sed</h3><!-- /wp:heading --><!-- wp:audio {"className":"tw-mt-0"} --><figure class="wp-block-audio tw-mt-0"><audio controls src="https://s.w.org/audio.mp3"></audio></figure><!-- /wp:audio --><!-- wp:separator --><hr class="wp-block-separator"/><!-- /wp:separator --><!-- wp:heading {"level":3,"fontSize":"medium"} --><h3 class="has-medium-font-size">03: Aliquam tempus mi eu nulla porta luctus</h3><!-- /wp:heading --><!-- wp:audio {"className":"tw-mt-0"} --><figure class="wp-block-audio tw-mt-0"><audio controls src="https://s.w.org/audio.mp3"></audio></figure><!-- /wp:audio --></div></div><!-- /wp:group -->',
	)
);

twentig_register_block_pattern(
	'twentig/media-list-with-image-and-button',
	array(
		'title'      => __( 'Media List with Image and Button', 'twentig' ),
		'categories' => array( 'video-audio' ),
		'content'    => '<!-- wp:group {"align":"full"} --><div class="wp-block-group alignfull"><div class="wp-block-group__inner-container"><!-- wp:heading {"textAlign":"center"} --><h2 class="has-text-align-center">' . esc_html_x( 'All episodes', 'Block pattern content', 'twentig' ) . '</h2><!-- /wp:heading --><!-- wp:media-text {"mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape1.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">01: Lorem ipsum dolor sit amet</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Duis enim elit, porttitor id feugiat at, blandit at erat. Proin varius libero sit amet tortor volutpat diam laoreet.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link">' . esc_html_x( 'Listen on Spotify', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --><!-- wp:media-text {"mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape2.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">02: Integer enim risus suscipit</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Fusce sed magna eu ligula commodo hendrerit fringilla ac purus. Integer sagittis efficitur rhoncus justo.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link">' . esc_html_x( 'Listen on Spotify', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --><!-- wp:media-text {"mediaType":"image","twStackedMd":true} --><div class="wp-block-media-text alignwide is-stacked-on-mobile tw-stack-md"><figure class="wp-block-media-text__media"><img src="' . twentig_get_pattern_asset( 'landscape3.jpg' ) . '" alt=""/></figure><div class="wp-block-media-text__content"><!-- wp:heading {"level":3,"fontSize":"large"} --><h3 class="has-large-font-size">03: Aliquam tempus mi eu nulla</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Mauris dui tellus mollis quis varius, sit amet ultrices in leo. Cras et purus sit amet velit congue convallis nec id diam.</p><!-- /wp:paragraph --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} --><div class="wp-block-button is-style-outline"><a class="wp-block-button__link">' . esc_html_x( 'Listen on Spotify', 'Block pattern content', 'twentig' ) . '</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:media-text --></div></div><!-- /wp:group -->',
	)
);
