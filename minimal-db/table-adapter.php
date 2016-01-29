<?php

/**
 * Table adapter class for manipulating tables
 *
 * @since 0.1.0
 */

class TableAdapter {
	/**
	 * The name of the table
	 *
	 * @var string $tableName
	 * @since 0.1.0
	 */
	private $tableName;

	/**
	 * Result from the last query
	 *
	 * @var array $result
	 * @since 0.1.0
	 */
	private $result;

	/**
	 * Currently selected row
	 *
	 * @var bool|int $currentRow
	 * @since 0.1.0
	 */
	private $currentRow;

	/**
	 * Class constructor
	 *
	 * @param string $tableName
	 * @since 0.1.0
	 */
	public function __construct( $tableName )
	{
		$this->tableName = ( ! empty( $tableName ) ) ? $tableName : null;
	}

	/**
	 * Checks if the class is correctly setup
	 *
	 * @return bool
	 * @since 0.1.0
	 */
	public function isSetup() {
		if ( isset( $this->tableName ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Select rows from the database
	 *
	 * @param array $where
	 * @return object
	 * @since 0.1.0
	 */
	public function select( $where = array() ) {
		if ( ! $this->isSetup() ) {
			return;
		}

		$database = Database::getInstance();
		$tempResult = $database->executeQuery( Query::generateSelectQuery( $this->tableName, '*', $where ) );

		while ( $row = $tempResult->fetch_object() ) {
			$this->result[] = $row;
		}

		$this->currentRow = 0;
	}

	/**
	 * Insert rows into the database
	 *
	 * @param array $data
	 * @return int
	 * @since 0.1.0
	 */
	public function insert( $data ) {
		if ( ! $this->isSetup() ) {
			return;
		}

		$database = Database::getInstance();
		$database->executeQuery( Query::generateInsertQuery( $data, $this->tableName ) );

		return $database->lastID();
	}

	/**
	 * Deletes data from the table
	 *
	 * @param array $where
	 * @since 0.1.0
	 */
	public function delete( $where ) {
		if ( ! $this->isSetup() ) {
			return;
		}

		$database = Database::getInstance();
		$database->executeQuery( Query::generateDeleteQuery( $this->tableName, $where ) );
	}

	/**
	 * Update data from the table
	 *
	 * @param array $data
	 * @param array $where
	 * @since 0.1.0
	 */
	public function update( $data, $where ) {
		if ( ! $this->isSetup() ) {
			return;
		}

		$query = new Query( 'update', $this->tableName, $data, $where );

		$database = Database::getInstance();
		$database->executeQuery( $query->getQuery() );
	}

	/**
	 * Returns the result
	 *
	 * @return array
	 * @since 0.1.0
	 */
	public function getResults() {
		return $this->result;
	}

	/**
	 * Returns the current row
	 *
	 * @return object
	 * @since 0.1.0
	 */
	public function currentRow() {
		return $this->result[ $this->currentRow ];
	}

	/**
	 * Moves to the next row in the results
	 *
	 * @since 0.1.0
	 */
	public function nextRow() {
		if ( $this->currentRow < $this->lastRowIndex() ) {
			$this->currentRow++;
		}
	}

	/**
	 * Moves to the previous row in the results
	 *
	 * @since 0.1.0
	 */
	public function previousRow() {
		if ( $this->currentRow > $this->firstRowIndex() ) {
			$this->currentRow--;
		}
	}

	/**
	 * Returns the number of rows in the result
	 *
	 * @return int
	 * @since 0.1.0
	 */
	public function rowCount() {
		return count( $this->result );
	}

	/**
	 * Sets the current row to the first row
	 *
	 * @since 0.1.0
	 */
	public function firstRow() {
		$this->currentRow = 0;
	}

	/**
	 * Returns the First row's index
	 *
	 * @return int
	 * @since 0.1.0
	 */
	public function firstRowIndex() {
		return 0;
	}

	/**
	 * Sets the current row to the last row
	 *
	 * @since 0.1.0
	 */
	public function lastRow() {
		$this->currentRow = $this->lastRowIndex();
	}

	/**
	 * Returns the last row's index
	 *
	 * @return int
	 * @since 0.1.0
	 */
	public function lastRowIndex() {
		return ( $this->rowCount() - 1 );
	}

	/**
	 * Checks if value is in the amount of rows available
	 *
	 * @param int $value
	 * @return bool
	 * @since 0.1.0
	 */
	public function inRange( $value ) {
		if ( $value >= $this->firstRowIndex() && $value <= $this->lastRowIndex() ) {

		}
	}

	/**
	 * Selects the row at a specific index
	 *
	 * @param int $id
	 * @since 0.1.0
	 */
	public function rowAt( $id ) {
		if ( $id >= $this->firstRowIndex() && $id <= $this->lastRowIndex() ) {
			$this->currentRow = $id;
		}
	}

	/**
	 * Returns the row at a specific index
	 *
	 * @param int $id
	 * @return object|bool
	 * @since 0.1.0
	 */
	public function getRowAt( $id ) {
		if ( $this->inRange( $id ) ) {
			return $this->result[ $id ];
		} else {
			return false;
		}
	}
}