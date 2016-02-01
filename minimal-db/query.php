<?php


/**
 * Sql Query
 *
 * @version 1.0.0
 * @since 1.0.0
 */

class Query {
	/**
	 * Stores the value of the generated Query
	 *
	 * @var string $query
	 * @since 1.1.0
	 */
	private $query;

	/**
	 * Stores the query type
	 *
	 * @var string $queryType
	 * @since 1.1.0
	 */
	private $queryType;

	/**
	 * Class Constructor
	 *
	 * @param string $queryType
	 * @since 1.1.0
	 */
	public function __construct( $queryType ) {
		if (
		  $queryType === 'select'
		  || $queryType === 'insert'
		  || $queryType === 'update'
		  || $queryType === 'delete'
		) {
			$this->queryType = $queryType;
		}
	}

	/**
	 * Generates a SELECT query
	 *
	 * @param array|string $columns
	 * @param string $table
	 * @param array $where
	 * @param string $schema
	 * @return string
	 * @since 1.0.0
	 */
	public static function generateSelectQuery( $table, $columns = '*', $where = array(), $schema ) {
		if ( is_array( $columns ) ) {
			$columnString = implode( ', ', $columns );
		} else  {
			$columnString = $columns;
		}

		$selectQuery = sprintf( 'SELECT %1$s FROM %2$s', $columnString, $table );

		if ( ! empty( $where ) ) {
			$whereString = self::generateWhere( $where );
			$selectQuery .= sprintf( ' WHERE %s', $whereString );
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
				$values[] = sprintf( "'%s'", $v );
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
			$whereString = self::generateWhere( $where );
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
			$whereString = self::generateWhere( $where );
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
			$whereStrings[] = is_string( $value ) ? sprintf( '%1$s="%2$s"', $key, $value ) : sprintf( '%1$s=%2$s', $key, $value );
		}

		$whereQuery = implode( ' AND ', $whereStrings );

		return $whereQuery;
	}

	/**
	 * Generates the list of columns including their schemas
	 *
	 * @param string $schema
	 * @param array $columns
	 * @since 1.1.0
	 */
	private static function generateSchemaString( $schema, $columns ) {

	}
}