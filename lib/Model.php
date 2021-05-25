<?php

/**
 * Model Class that handles database related.
 */
abstract class Model
{
	/**
	 * Databse handle
	 * @var PDO
	 */
	protected $dbh;

	/**
	 * Statement Handle
	 * @var Object
	 */
	protected $stmt;

	/**
	 * PDO error message
	 * @var String
	 */
	protected $error;


	public function __construct()
	{
		// Set DNS
		$dns  =  'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
		// Set pdo options
		$options = [
			PDO:: ATTR_PERSISTENT	=> true,
			PDO:: ATTR_ERRMODE		=> PDO:: ERRMODE_EXCEPTION
		];

		try {
			$this->dbh  =  new PDO($dns, DB_USER, DB_PASS, $options);
		} catch (PDOException $e) {

			$this->error  =  $e->getMessage();
			$errorLine    =  $e->getLine();

			// Print error message.
			echo '<pre>';
			echo '<strong>Error in line: '. $errorLine .'</strong>';
			print_r($this->error);
			echo '</pre>';

		}
	}


	/**
	 * Prepare mysql query statement
	 *
	 * @param string $query The query string.
	 */
	public function query( $query )
	{
		// Prepare query statement
		$this->stmt  =  $this->dbh->prepare( $query );
	}


	/**
	 * Executes the prepared statement
	 *
	 * @return bool return true when success or false when failed.
	 */
	public function execute()
	{
		return $this->stmt->execute();
	}


	/**
	 * Binds a value to a mysql query string parameter
	 *
	 * @param mixed Parameter identifier. For a prepared statement using named placeholders, this will be a parameter name of the form :name. For a prepared statement using question mark placeholders, this will be the 1-indexed position of the parameter.
	 * @param mixed The value to bind to the parameter.
	 * @param mixed The type of value (Optional).
	 */
	public function bind( $param, $value, $type = null )
	{
		if( $type === null )
		{
			switch (true) {
				case  is_int( $value )  : 
				$type = PDO:: PARAM_INT;
					break;

				case  is_bool( $value )  : 
				$type = PDO:: PARAM_BOOL;
					break;

				case  is_null( $value )  : 
				$type = PDO:: PARAM_NULL;

				      default  : 
				$type = PDO:: PARAM_STR;
					break;
			}
		}

		$this->stmt->bindValue( $param, $value, $type );
	}

	/**
	 * Featch data to the database
	 *
	 * @return array|false Returns an array containing all of the remaining rows in the result set. The array represents each row as either an array of column values or an object with properties corresponding to each column name. An empty array is returned if there are zero results to fetch, or false on failure.
	 */
	public function resultSet()
	{
		$this->execute();
		return $this->stmt->fetchAll( PDO::FETCH_ASSOC );
	}

	/**
	 * Returns the ID of the last inserted row or sequence value
	 *
	 * @return string ID
	 */
	public function lastInsertedID()
	{
		return $this->dbh->lastInsertId();
	}


}