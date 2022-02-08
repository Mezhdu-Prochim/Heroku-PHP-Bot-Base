<?php

namespace Core;

use Core\Db;

Class Users extends Db {
	
	public function getData($name) {
		$db = new Db;
		$sql = "SELECT * FROM `user` WHERE `name` = ?";
		if (is_numeric($name)) {
			$sql = "SELECT * FROM `user` WHERE `id` = ?";
		}
		return $db::getRow($sql, [$name]);
	}
	
	public function add($name,$location) {
		$db = new Db;
		$location = (int) $location;
		if ($location > 0) {
			$sql = 'INSERT INTO `user` (name, location_id) VALUES ("' . $name . '", '. $location .')';
			$result = $db::query($sql);
			return $result;
		}
		return false;
	}
	
	static function update($id, $location) {
		$db = new Db;
		$id = (int) $id;
		$location = (int) $location;
		if ($id > 0 && $location > 0) {
			$sql = 'UPDATE `user` SET `location_id` = ' . $location . ' WHERE `id` = '. $id;
			$result = $db::query($sql);
			return $result;
		}
	}
}