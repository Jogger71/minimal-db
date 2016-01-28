<?php


/**
 * Sql Query
 *
 * @version 1.0.0
 * @since 1.0.0
 */

class Query {
	/**
	 * The final query string
	 *
	 * @var string $query
	 * @since 1.0.0
	 */
	private $query;

	/**
	 * Returns the query
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * Generates a SELECT query
	 *
	 * @param array|string $columns
	 * @param string $table
	 * @param array $where
	 * @return string
	 * @since 1.0.0
	 */
	public static function generateSelectQuery( $table, $columns = '*', $where = array() ) {
		if ( is_array( $columns ) ) {
			$columnString = implode( ', ', $columns );
		} else  {
			$columnString = $columns;
		}

		$selectQuery = "SELECT $columnString FROM $table";

		if ( ! empty( $where ) ) {
			$whereString = $this->generateWhere( $where );
			$selectQuery .= " WHERE $whereString";
		}

		$selectQuery .= ";";

		return $selectQuery;
	}

	/**
	 * Generates a INSERT query
	 *
	 * @param array $data
	 * @param string $table
	 * @return string
	 * @since 1.0.0
	 */
	public static function generateInsertQuery( $data, $table ) {
		$columns = array();
		$values = array();

		foreach( $data as $k => $v ) {
			$columns[] = $k;
			if ( is_string( $v ) ) {
				$values[] = '"' . $v . '"';
			} else {
				$values[] = $v;
			}
		}

		$columnsString = implode( ', ', $columns );
		$valuesString = implode( ', ', $values );

		$insertQuery = "INSERT INTO $table ( $columnsString ) VALUES ( $valuesString );";

		return $insertQuery;
	}

	/**
	 * Generates an UPDATE query
	 *
	 * @param array $data
	 * @param string $table
	 * @param array $where
	 * @return string
	 * @since 1.0.0
	 */
	public static function generateUpdateQuery( $data, $table, $where = array() ) {
		$setValues = array();

		foreach( $data as $k => $v ) {
			$setValues[] = ( is_string($v) ) ? sprintf( '%1$s="%2$s"', $k, $v ) : sprintf( '%1$s=%2$s', $k, $v );
		}

		$setValuesString = implode( ', ', $setValues );

		$updateQuery = sprintf( 'UPDATE %1$s SET %2$s', $table, $setValuesString );

		if ( ! empty( $where ) ) {
			$whereString = $this->generateWhere( $where );
			$updateQuery .= " WHERE $whereString";
		}

		$updateQuery .= ";";

		return $updateQuery;
	}

	/**
	 * Generates a DELETE query
	 *
	 * @param string $table
	 * @param array $where
	 * @return string
	 * @since 1.0.0
	 */
	public static function generateDeleteQuery( $table, $where ) {
		$deleteQuery = sprintf( 'DELETE FROM %s', $table );

		if ( ! empty( $where ) ) {
			$whereString = $this->generateWhere( $where );
			$deleteQuery .= " WHERE $whereString";
		}

		$deleteQuery .= ';';

		return $deleteQuery;
	}

	/**
	 * Generates the WHERE section
	 *
	 * @param array $where
	 * @return string
	 * @since 1.0.0
	 */
	private static function generateWhere( $where ) {
		$whereStrings = array();

		foreach ( $where as $key => $value ) {
			if ( is_string( $value ) ) {
				$whereStrings[] = sprintf( '%1$s="%2$s"', $key, $value );
			} else {
				$whereStrings[] = sprintf( '%1$s=%2$s', $key, $value );
			}
		}

		$whereQuery = implode( ' AND ', $whereStrings );

		return $whereQuery;
	}
}