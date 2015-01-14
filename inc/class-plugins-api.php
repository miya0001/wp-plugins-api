<?php


class Plugins_API {
	/**
	 * Protected constructor to prevent creating a new instance of the
	 * *Singleton* via the `new` operator from outside of this class.
	 */
	protected function __construct() {}

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @staticvar Singleton $instance The *Singleton* instances of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 */
	public static function getInstance()
	{
		static $instance = null;
		if (null === $instance) {
			$instance = new static();
		}
		return $instance;
	}
	/**
	 * Private clone method to prevent cloning of the instance of the
	 * *Singleton* instance.
	 *
	 * @return void
	 */
	private function __clone() {}

	public static function author( $args, $format = 'table' )
	{
		$result = self::query_plugins( 'query_plugins', array(
			'author' => $args[0],
			'page' => '1',
			'per_page' => '9999',
			'fields' => array(
				'downloaded' => true,
				'rating' => true,
			)
		) );

		if ( ! $result->plugins ) {
			return new WP_Error( 'error', 'The '. $args[0] .'\'s plugins could not be found.' );
		}

		if ( is_wp_error( $result ) ) {
			return new WP_Error( 'error', $result->get_error_message() );
		}

		$plugins = array();
		$downloads = 0;

		foreach ($result->plugins as $plugin) {
			$stat = array();
			foreach ( $plugin as $key => $value ) {
				if ( $key === 'downloaded' ) {
					$downloads = $downloads + $value;
					if ( 'table' === $format ) {
						$value = sprintf( '% 11s', number_format( $value, 0 ) );
					} else {
						$value = intval( $value );
					}
				} elseif ( $key === 'rating' ) {
					if ( 'table' === $format ) {
						$value = sprintf( '% 5s', number_format( $value, 1 ) );
					} else {
						$value = intval( $value );
					}
				}
				$stat[$key] = $value;
			}
			$plugins[] = $stat;
		}

		return array(
			'downloads' => $downloads,
			'number'	=> count( $plugins ),
			'plugins'   => $plugins,
		);
	}


	public static function browse( $args, $format = 'table' )
	{
		if ( ! in_array( $args[0], array( 'popular', 'new', 'updated', 'top-rated' ) ) ) {
			return new WP_Error( 'error', 'The possible values are popular/new/updated/top-rated.' );
		}

		$result = self::query_plugins( 'query_plugins', array(
			'browse' => $args[0],
			'fields' => array(
				'downloaded' => true,
				'rating' => true,
			),
		) );

		if ( is_wp_error( $result ) ) {
			return new WP_Error( 'error', $result->get_error_message() );
		}

		$plugins = array();

		foreach ($result->plugins as $plugin) {
			$stat = array();
			foreach ( $plugin as $key => $value ) {
				if ( $key === 'downloaded' ) {
					if ( 'table' === $format ) {
						$value = sprintf( '% 11s', number_format( $value, 0 ) );
					} else {
						$value = intval( $value );
					}
				} elseif ( $key === 'rating' ) {
					if ( 'table' === $format ) {
						$value = sprintf( '% 5s', number_format( $value, 1 ) );
					} else {
						$value = intval( $value );
					}
				}
				$stat[$key] = $value;
			}
			$plugins[] = $stat;
		}

		return $plugins;
	}


	public static function info( $args, $format = 'table' )
	{
		$result = self::query_plugins( 'plugin_information', array( 'slug' => $args[0] ) );

		if ( is_wp_error( $result ) ) {
			return new WP_Error( 'error', 'The "'. $args[0] .'" could not be found.' );
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

		return $info;
	}


	private static function query_plugins( $query, $args )
	{
		require_once ABSPATH.'wp-admin/includes/plugin-install.php';
		return plugins_api( $query, $args );
	}
}
