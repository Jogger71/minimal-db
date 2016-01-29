<?php

/**
 * Database handling class
 */

class Database {
	/**
	 * Single instance of the class
	 *
	 * @var Database $instance
	 * @since 0.1.0
	 */
	private static $instance;

	/**
	 * The Database
	 *
	 * @var mysqli $database
	 * @since 0.1.0
	 */
	private $database;

	/**
	 * Connection information
	 *
	 * @var array $connectionInfo
	 * @since 0.1.0
	 */
	private $connectionInfo;

	/**
	 * Class constructor
	 */
	private function __construct()
	{
		$this->loadConfiguration();
		$this->database = new mysqli( $this->connectionInfo[ 'db_host' ], $this->connectionInfo[ 'db_user' ], $this->connectionInfo[ 'db_pass' ], $this->connectionInfo[ 'db_name' ] );
	}

	/**
	 * Returns the single instance of the class
	 *
	 * @return Database
	 * @since 0.1.0
	 */
	public static function getInstance() {
		if ( ! isset( self::$instance ) && ! self::$instance instanceof Database ) {
			self::$instance = new Database();
		}

		return self::$instance;
	}

	/**
	 * Gets the database configuration
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getConfiguration() {
		return include_once BASEDIR . '/config/database.config.php';
	}

	/**
	 * Loads the database configuration into the class
	 *
	 * @since 0.1.0
	 */
	public function loadConfiguration() {
		$databaseConfiguration = $this->getConfiguration();
		$this->connectionInfo = $databaseConfiguration[ 'connection_info' ];
	}

	/**
	 * Execute query on the database
	 *
	 * @param string $query
	 * @return mysqli_result
	 * @since 0.1.0
	 */
	public function executeQuery( $query ) {
		return $this->database->query( $query );
	}

	/**
	 * Return the last insert id
	 *
	 * @return int
	 * @since 0.1.0
	 */
	public function lastID() {
		return $this->database->insert_id;
	}
}