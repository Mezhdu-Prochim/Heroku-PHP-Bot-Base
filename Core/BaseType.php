<?php
namespace Core;

use Models\Inventory;
use Core\Db;

Class BaseType extends Db {
	public $id;
	public $data;
	public $text;
	public $forbidden;
	public $required_item;
	public $image;
	public $user_id;
	
	
    public function __construct($id = false, $data = false)
    {
		$this->id = $id;
		if ($data && !empty($data)) {
			$this->data = $data;
			$this->text = $data['text_yes'];
			$this->forbidden = $data['text_no'];
			$this->required_item = $data['required_item_id'] != 0 ? $data['required_item_id'] : null;
			$this->image = $data['image'];
			$this->price = $data['price'];
		}
		$this->inventory = Inventory::findBy(['user_id' => $_SESSION['USER_ID']]);
		$_SESSION['INVENTORY'] = [];
		if (!empty($this->inventory)) {
			foreach ($this->inventory as $item) {
				$_SESSION['INVENTORY'][$item['item_id']] = $item['item_id'];
				$this->inventory_id[] = $item['item_id'];
			}
		}
		$this->user_id = 1;
    }
	
	static function findBy($params) {
		$impl = [];
		foreach ($params as $title => $data) {
			$impl[] = ' '.$title . ' = :'.$title;
		}
		$db = new Db();
		$sql = "SELECT * FROM `" . static::getTableName() . "` WHERE ". implode(',',$impl);
		return $db::getIdRows($sql, $params);
	}
	
	static function findById($id) {
		$db = new Db();
		return $db::getRow("SELECT * FROM `" . static::getTableName() . "` WHERE `id` = ?", [$id]);
	}
	
	static function findAllWithId() {
		$db = new Db();
		return $db::getIdRows("SELECT * FROM `" . static::getTableName() . "`",[]);
	}
	
	static function findAll() {
		$db = new Db();
		return $db::getRows("SELECT * FROM `" . static::getTableName() . "`",[]);
	}
	
	static function add($params = []) {
		$db = new Db();
		$result = null;
		if (!empty($params)) {
			$titles = '('.implode(', ',array_keys($params[0])).')';
			foreach (array_keys($params[0]) as $param => $val) {
				$paramsForEmpty[] = ':'.$val;
			}
			$titlesEmpty = '('.implode(', ',$paramsForEmpty).')';
			$values = [];
			foreach ($params as $id => $data) {
				$values[] = '("'.implode('", "',$data).'")';
			}
			if (!empty($titles) && !empty($values)) {
				$sql = "INSERT INTO `" . static::getTableName() . "` " . $titles . " VALUES " . implode(", ", $values);
				$result = $db::query($sql);
			}
			return $result;
		}
		return null;
	}
}