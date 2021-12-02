<?php

/**
 * Return starter websites list.
 */
function twentig_twentyone_get_starter_websites() {

	$starters = array(
		array(
			'id'         => 'default',
			'title'      => __( 'Default' ),
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/twentytwentyone.jpg',
		),
		array(
			'id'         => 'brooklyn',
			'title'      => 'Brooklyn',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/brooklyn.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/brooklyn.json',
		),
		array(
			'id'         => 'dakar',
			'title'      => 'Dakar',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/dakar.png',
			'content'    => 'https://blocks.static-twentig.com/content/2021/dakar.json',
		),
		array(
			'id'         => 'kingston',
			'title'      => 'Kingston',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/kingston.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/kingston.json',
		),
		array(
			'id'         => 'kyoto',
			'title'      => 'Kyoto',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/kyoto.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/kyoto.json',
		),
		array(
			'id'         => 'lutece',
			'title'      => 'Lutece',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/lutece.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/lutece.json',
		),
		array(
			'id'         => 'orlando',
			'title'      => 'Orlando',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/orlando.png',
			'content'    => 'https://blocks.static-twentig.com/content/2021/orlando.json',
		),
		array(
			'id'         => 'oslo',
			'title'      => 'Oslo',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/oslo.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/oslo.json',
		),
		array(
			'id'         => 'santiago',
			'title'      => 'Santiago',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/santiago.png',
			'content'    => 'https://blocks.static-twentig.com/content/2021/santiago.json',
		),
		array(
			'id'         => 'thane',
			'title'      => 'Thane',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/thane.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/thane.json',
		),
		array(
			'id'         => 'valencia',
			'title'      => 'Valencia',
			'screenshot' => 'https://blocks.static-twentig.com/screenshots/2021/valencia.jpg',
			'content'    => 'https://blocks.static-twentig.com/content/2021/valencia.json',
		),
	);

	return $starters;
}
add_filter( 'twentig_starter_websites', 'twentig_twentyone_get_starter_websites' );
