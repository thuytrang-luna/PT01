<?php
/**
 * Blocks API: Twentig_Block_Patterns_Registry class
 *
 * @package twentig
 */

/**
 * Class used for interacting with patterns.
 */
final class Twentig_Block_Patterns_Registry {

	/**
	 * Registered patterns array.
	 *
	 * @var array
	 */
	private $registered_patterns = array();

	/**
	 * Container for the main instance of the class.
	 *
	 * @var Twentig_Block_Patterns_Registry|null
	 */
	private static $instance = null;

	/**
	 * Registers a pattern.
	 *
	 * @param string $pattern_name       Pattern name including namespace.
	 * @param array  $pattern_properties Array containing the properties of the pattern: title,
	 *                                   content, description, viewportWidth, categories, keywords.
	 * @return bool True if the pattern was registered with success and false otherwise.
	 */
	public function register( $pattern_name, $pattern_properties ) {
		$this->registered_patterns[ $pattern_name ] = array_merge(
			$pattern_properties,
			array( 'name' => $pattern_name )
		);

		return true;
	}

	/**
	 * Retrieves all registered patterns.
	 *
	 * @return array Array of arrays containing the registered patterns properties.
	 */
	public function get_all_registered() {
		return array_values( $this->registered_patterns );
	}

	/**
	 * Utility method to retrieve the main instance of the class.
	 *
	 * @return Twentig_Block_Patterns_Registry The main instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}

/**
 * Registers a new page block pattern.
 *
 * @param string $pattern_name       Pattern name including namespace.
 * @param array  $pattern_properties Array containing the properties of the pattern.
 *
 * @return boolean True if the pattern was registered with success and false otherwise.
 */
function twentig_register_block_page( $pattern_name, $pattern_properties ) {
	return Twentig_Block_Patterns_Registry::get_instance()->register( $pattern_name, $pattern_properties );
}

