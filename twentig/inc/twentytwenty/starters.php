<?php

/**
 * Return starter websites list.
 */
function twentig_twentytwenty_get_starter_websites() {

	$starters = array(
		array(
			'id'         => 'default',
			'title'      => __( 'Default' ),
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/twentytwenty.png',
		),
		array(
			'id'         => 'brooklyn',
			'title'      => 'Brooklyn',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/brooklyn.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2020/brooklyn.json',
		),
		array(
			'id'         => 'dakar',
			'title'      => 'Dakar',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/dakar.png',
			'content'    => 'https://blocks.static-twentig.com/content/2020/dakar.json',
		),
		array(
			'id'         => 'kingston',
			'title'      => 'Kingston',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/kingston.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2020/kingston.json',
		),
		array(
			'id'         => 'kyoto',
			'title'      => 'Kyoto',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/kyoto.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2020/kyoto.json',
		),
		array(
			'id'         => 'lutece',
			'title'      => 'Lutece',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/lutece.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2020/lutece.json',
		),
		array(
			'id'         => 'orlando',
			'title'      => 'Orlando',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/orlando.png',
			'content'    => 'https://blocks.static-twentig.com/content/2020/orlando.json',
		),
		array(
			'id'         => 'oslo',
			'title'      => 'Oslo',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/oslo.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2020/oslo.json',
		),
		array(
			'id'         => 'santiago',
			'title'      => 'Santiago',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/santiago.png',
			'content'    => 'https://blocks.static-twentig.com/content/2020/santiago.json',
		),		
		array(
			'id'         => 'valencia',
			'title'      => 'Valencia',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2020/valencia.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2020/valencia.json',
		),
	);

	return $starters;
}
add_filter( 'twentig_starter_websites', 'twentig_twentytwenty_get_starter_websites' );
