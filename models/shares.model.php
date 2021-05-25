<?php

/**
 * Share Model Class
 */
class ShareModel extends Model
{
	public function index()
	{
		$this->query( 'SELECT * FROM shares' );
		$rows = $this->resultSet();
		echo '<pre>';
		print_r($rows);
		echo '</pre>';
		return $rows;
	}
}