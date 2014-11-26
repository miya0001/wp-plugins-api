<?php
/**
* Retrieve plugin information from WordPress Plugins API.
*
* @author miya0001
*/

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

class Plugins_API extends WP_CLI_Command {

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
		$this->query_plugins( array( 'author' => $args[0] ) );
	}


	/**
	* Get a list of plugins for popular/new/updated/top-rated.
	*
	* ## OPTIONS
	*
	* <browse>
	* : The possible values are popular/new/updated/top-rated.
	*
	* ## EXAMPLES
	*
	*    wp plugins-api browse popular
	*
	* @subcommand browse
	*/
	public function browse( $args )
	{
		if ( ! in_array( $args[0], array( 'popular', 'new', 'updated', 'top-rated' ) ) ) {
			WP_CLI::error( 'The possible values are popular/new/updated/top-rated.' );
		}

		$this->query_plugins( array( 'browse' => $args[0] ) );
	}

	private function query_plugins( $query )
	{
		$args = array(
			'fields' => array(
				'downloaded' => true,
				'rating' => true,
				'last_updated' => true,
				'tested' => true,
				'requires' => true,
			)
		);

		$args = array_merge( $query, $args );

		$result = plugins_api( 'query_plugins', $args );

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

WP_CLI::add_command( 'plugins-api', 'Plugins_API' );
