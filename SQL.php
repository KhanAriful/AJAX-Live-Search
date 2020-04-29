<?php
 /**
  *	PHP MySQL CRUD Class PDO
  *
  * @author 	Ariful Khan <khan.ariful@hotmail.com>
  * @copyright 	Copyright (c) 2020 Ariful Khan
  * @license	https://github.com/KhanAriful/PHP-MySQL-CRUD-Class-PDO/blob/master/LICENSE MIT License
  * @link 		https://khanariful.github.io/PHP-MySQL-CRUD-Class-PDO
  */
require 'config.php';
class SQL {
	protected $hostname = DB_HOST;
	protected $username = DB_USER;
	protected $password = DB_PASSWORD;
	protected $dbname = DB_NAME;
	protected $charset = DB_CHARSET;
	protected $pdo;
	/**
	 * Default constructor
	 *
	 * Triggers the connect function by default
	 */
	public function __construct(){
		$this->connect();
	}
	/**
	 * @return Connection using the pdo extension
	 */
  	public function connect(){
		try{
		    $this->pdo = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->dbname . ";charset=" . $this->charset, $this->username, $this->password);
		    /**
		     * Set the PDO error mode to exception
		     */
		    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e){
		    die("ERROR: Could not connect. " . $e->getMessage());
		}
		return $this->pdo;
	}
	/**
	 * @param  Sql query
	 * @return Data from MySQL DB
	 */
	public function getData($sql){
		$rows = array();
	    try{
	        $result = $this->pdo->query($sql);
	        if($result->rowCount() > 0){
	            while($row = $result->fetch()){
	                $rows[] = $row;
	            }
	            unset($result);
	        } else{
	            echo "No records matching your query were found.";
	        }
	    } catch(PDOException $e){
	        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
	    }
	    return $rows;
	}
	/**
	 * @param  string $sql Sql query
	 */
	public function execute($sql){
	    try{
	        $this->pdo->exec($sql);
	    } catch(PDOException $e){
	        die("ERROR: Could not able to execute $sql. " . $e->getMessage());
	    }
	}
	/**
	 * @param  string $input1 SELECT
	 * @param  string $input2 FROM
	 * @param  string $input3 WHERE
	 * @return string
	 */
	public function select($input1, $input2, $input3){
		$rows = $this->getData("SELECT $input1 FROM $input2 WHERE $input3");
		$input1 = explode('.', $input1);
		$input1 = end($input1);
		foreach ($rows as $row) {
			return $row["$input1"];
		}
	}
	/**
	 * Default destructor
	 *
	 * Closes the DB connection
	 */
	public function __destruct(){
		unset($this->pdo);
	}
}