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
		'slug',
		'version',
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
		$result = $this->query_plugins( array(
			'author' => $args[0],
			'page' => '1',
			'per_page' => '9999',
		) );

		if ( ! $result->plugins ) {
			WP_CLI::error( 'The '. $args[0] .'\'s plugins could not be found.' );
		}

		$plugins = array();
		$downloads = 0;

		foreach ($result->plugins as $plugin) {
			$stat = array();
			foreach ( $plugin as $key => $value ) {
				if ( $key === 'downloaded' ) {
					$downloads = $downloads + $value;
					$value = sprintf( '% 11s', number_format( $value, 0 ) );
				} elseif ( $key === 'rating' ) {
					$value = sprintf( '% 5s', number_format( $value, 1 ) );
				}
				$stat[$key] = $value;
			}
			$plugins[] = $stat;
		}

		WP_CLI\Utils\format_items( 'table', $plugins, $this->fields );
		WP_CLI::line(count( $plugins ) . ' plugins. ' . number_format( $downloads ) . ' downloads.' );
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

		$result = $this->query_plugins( array( 'browse' => $args[0] ) );

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


	/**
	* Get a plugin information specific plugin.
	*
	* ## OPTIONS
	*
	* <slug>
	* : The slug of the plugin.
	*
	* ## EXAMPLES
	*
	*    wp plugins-api info wp-total-hacks
	*
	* @subcommand info
	*/
	public function info( $args )
	{
		$result = plugins_api( 'plugin_information', array( 'slug' => $args[0] ) );

		if ( is_wp_error( $result ) ) {
			WP_CLI::error( 'The "'. $args[0] .'" could not be found.' );
		}

		$keys = array(
			'name',
			'slug',
			'version',
			'author',
			'contributors',
			'requires',
			'tested',
			'rating',
			'downloaded',
			'last_updated',
			'added',
			'homepage',
		);

		$info = array();

		foreach ( $keys as $key ) {
			switch ( $key ) {
				case 'author':
					$value = strip_tags( $result->$key );
					break;
				case 'contributors':
					$value = str_replace( '//profiles.wordpress.org/', '', join( ', ', $result->$key ) );
					break;
				case 'downloaded':
					$value = number_format( $result->$key );
					break;
				default:
					$value = $result->$key;
			}

			$info[] = array( 'Field' => $key, 'Value' => $value );
		}

		WP_CLI\Utils\format_items( 'table', $info, array( 'Field', 'Value' ) );
	}


	private function query_plugins( $query )
	{
		$args = array(
			'fields' => array(
				'downloaded' => true,
				'rating' => true,
			)
		);

		$args = array_merge( $query, $args );

		return plugins_api( 'query_plugins', $args );
	}
}

WP_CLI::add_command( 'plugins-api', 'Plugins_API' );
