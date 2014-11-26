<?php
/**
* Retrieve plugin information from WordPress Plugins API.
*
* @author miya0001
*/

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

class Plugins_Api extends WP_CLI_Command {

	private $fields = array(
		'name',
		'version',
		'tested',
		'requires',
		'rating',
		'downloaded',
	);

	function __construct() {
		require_once ABSPATH.'wp-admin/includes/plugin-install.php';
		parent::__construct();
	}

	/**
	* Get a list of plugins for specific author.
	*
	* ## OPTIONS
	*
	* <author>
	* : A plugin author's name of wordpress.org
	*
	* ## EXAMPLES
	*
	*    wp plugins-api author miyauchi
	*
	* @subcommand author
	*/
	public function author( $args )
	{
		$result = plugins_api( 'query_plugins',
			array(
				'author' => $args[0],
				'fields' => array(
					'downloaded' => true,
					'rating' => true,
					'last_updated' => true,
					'tested' => true,
					'requires' => true,
				)
			)
		);

		$plugins = array();
		foreach ($result->plugins as $plugin) {
			$stat = array();
			foreach ( $plugin as $key => $value ) {
				if ( $key === 'downloaded' ) {
					$value = sprintf( '% 11s', number_format( $value, 0 ) );
				} elseif ( $key === 'rating' ) {
					$value = sprintf( '% 5s', number_format( $value, 1 ) );
				}
				$stat[$key] = $value;
			}
			$plugins[] = $stat;
		}

		WP_CLI\Utils\format_items( 'table', $plugins, $this->fields );
	}

}

WP_CLI::add_command( 'plugins-api', 'Plugins_Api' );
