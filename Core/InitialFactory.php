<?php

namespace Core;

use Core\Db;

Class InitialFactory extends Db {
	
    public function __construct()
    {
		$db = new Db();
		$result = $db::getIdRows("SELECT * FROM `location`",[]);
		foreach ($result as $data) {
			$this->locations[$data['id']] = $data;
		}
		
		// $result = $db::getIdRows("SELECT * FROM `inventory` WHERE user_id = :user_id", ['user_id' => 1]);
		// if ($result) {
			// foreach ($result as $data) {
				// $this->inventory[$data['id']] = $data;
			// }
		// }
    }
}