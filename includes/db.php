<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tomahock
 * Date: 5/18/13
 * Time: 10:08 AM
 * To change this template use File | Settings | File Templates.
 */

class db
{
	/***
	 * @param $db
	 * @return if error exists the error
	 ***/
	public function  __construct( $db ) {
		//create connection
		$this->mysqli = new mysqli( $db['host'], $db['user'], $db['pass'], $db['table'] );

		if ( mysqli_connect_errno() ) {
			return "Ocorreu um erro a ligar à base de dados: " . mysqli_connect_error();
		}
	}

	/****
	 * @param $query
	 * @return bool|string
	 */
	public function query( $query )
	{
		$this->queryString = $query;
		$this->result = $this->mysqli->query( $this->queryString );

		if ( $this->result ) {
			return true;
		} else {
			return "Ocorreu um erro com a query: " . $this->queryString;
		}
	}

	/***
	 * @param null $field
	 * @return array|bool
	 */
	public function get( $field = null )
	{
		if( $this->result ) {
			if ( $field === NULL ) {
				$data = array();
				while( $row = $this->result->fetch_object( ) ) {
					$data[] = $row;
				}

			} else {
				$row = $this->result->fetch_object( );
				$data = $row->$field;
			}

			$this->result->close();
			return $data;
		} else {
			return false;
		}
	}

	public function getAffectedRows()
	{
		return mysqli_affected_rows( $this->mysqli );
	}

	public function getResult()
	{
		return $this->result;
	}

	public function getLastId()
	{
		return mysqli_insert_id( $this->mysqli );
	}

	/****
	 * @param $string
	 * @return string
	 */
	public function escape_string( $string ) {
		return $this->mysqli->real_escape_string( $string );
	}

	/***
	 *
	 */
	public function __destruct()
	{
		$this->mysqli->close();
	}


}