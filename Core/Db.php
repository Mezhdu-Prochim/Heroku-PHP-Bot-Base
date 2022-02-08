<?php

namespace Core;

use PDO;
/*
class Db extends PDO
{
	private static $_instance = null;
	
	// для безопасности настройки лучше хранить в файле с конфигом
	

	public function __construct () {
		$this->instance = new PDO(
			'mysql:host=' . self::$DB_HOST . ';dbname=' . self::$DB_NAME,
	    	self::$DB_USER,
	    	self::$DB_PASS,
	    	[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]
	    );

	}

	private function __clone () {}
	private function __wakeup () {}

	public static function getInstance()
	{
		if (self::$_instance != null) {
			return self::$_instance;
		}

		return new self;
	}
}
*/

class Db
{
  /**
   * Настройки подключения
   * Лучше выносить в конфиг
   * self::DB_HOST -> Config::DB_HOST
   */
  const DB_HOST = 'localhost'; // localhost
  const DB_USER = 'sdio_woice';
  const DB_PASSWORD = 'G2Y3Q2hqv';
  const DB_NAME = 'sdio_affari';
  const CHARSET = 'utf8';
  const DB_PREFIX = '';
 
  /**
   * @var PDO
   */
  static private $db;
 
  /**
   * @var null
   */
  protected static $instance = null;
 
  /**
   * DB constructor.
   * @throws Exception
   */
  public function __construct(){
    if (self::$instance === null){
      try {
        self::$db = new PDO(
          'mysql:host='.self::DB_HOST.';dbname='.self::DB_NAME,
          self::DB_USER,
          self::DB_PASSWORD,
          $options = [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
              PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".self::CHARSET
          ]
        );
      } catch (PDOException $e) {
          throw new Exception ($e->getMessage());
      }
    }
    return self::$instance;
  }
 
  /**
   * @param $stmt
   * @return PDOStatement
   */
  public static function query($stmt)  {
    return self::$db->query($stmt);
  }
 
  /**
   * @param $stmt
   * @return PDOStatement
   */
  public static function prepare($stmt)  {
    return self::$db->prepare($stmt);
  }
 
  /**
   * @param $query
   * @return int
   */
  static public function exec($query) {
    return self::$db->exec($query);
  }
 
  /**
   * @return string
   */
  static public function lastInsertId() {
    return self::$db->lastInsertId();
  }
 
  /**
   * @param $query
   * @param array $args
   * @return PDOStatement
   * @throws Exception
   */
  public static function run($query, $args = [])  {
    try{
      if (!$args) {
        return self::query($query);
      }
      $stmt = self::prepare($query);
      $stmt->execute($args);
      return $stmt;
    } catch (PDOException $e) {
        throw new Exception($e->getMessage());
    }
  }
 
  /**
   * @param $query
   * @param array $args
   * @return mixed
   */
  public static function getRow($query, $args = [])  {
    return self::run($query, $args)->fetch();
  }
  
  public static function getIdRows($query, $args = [])  {
	$result = null;
	$sql = self::run($query, $args);
	while ($data = $sql->fetch()) {
		$result[$data['id']] = $data;
	}
	return $result;
  }
 
  /**
   * @param $query
   * @param array $args
   * @return array
   */
  public static function getRows($query, $args = [])  {
    return self::run($query, $args)->fetchAll();
  }
 
  /**
   * @param $query
   * @param array $args
   * @return mixed
   */
  public static function getValue($query, $args = [])  {
    $result = self::getRow($query, $args);
    if (!empty($result)) {
      $result = array_shift($result);
    }
    return $result;
  }
 
  /**
   * @param $query
   * @param array $args
   * @return array
   */
  public static function getColumn($query, $args = [])  {
    return self::run($query, $args)->fetchAll(PDO::FETCH_COLUMN);
  }
 
  public static function sql($query, $args = [])
  {
    self::run($query, $args);
  }
}