<?php
/**
 * Nginx Cache Controller
 *
 * @subpackage commands/community
 * @maintainer Takayuki Miyauchi
 */

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

// it need manually load
require_once( dirname( __FILE__ ) . '/inc/class-plugins-api.php' );

class WP_CLI_Plugins_API extends WP_CLI_Command {

	private $fields = array(
		'name',
		'slug',
		'version',
		'rating',
		'downloaded',
	);

	function __construct() {
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
		$result = Plugins_API::author( $args );

		if ( is_wp_error( $result ) ) {
			WP_CLI::error( $result->get_error_message() );
		} else {
			WP_CLI\Utils\format_items( 'table', $result['plugins'], $this->fields );
			WP_CLI::line( sprintf(
				'%s plugins. %s downloads.',
				$result['number'],
				number_format( $result['downloads'] )
			) );
		}
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
		$result = Plugins_API::browse( $args );

		if ( is_wp_error( $result ) ) {
			WP_CLI::error( $result->get_error_message() );
		} else {
			WP_CLI\Utils\format_items( 'table', $result, $this->fields );
		}
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
		$result = Plugins_API::info( $args );

		if ( is_wp_error( $result ) ) {
			WP_CLI::error( $result->get_error_message() );
		} else {
			WP_CLI\Utils\format_items( 'table', $result, array( 'Field', 'Value' ) );
		}
	}
}

WP_CLI::add_command( 'plugins-api', 'WP_CLI_Plugins_API' );
