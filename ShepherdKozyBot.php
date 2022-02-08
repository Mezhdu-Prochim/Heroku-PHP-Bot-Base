<?php

use Core\Db;

/**
 * Basic telegram bot example
 * 
 */
//ini_set('display_errors' , 1 );
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once("lib/telegram_bot.php");

class ShepherdKozyBot extends TelegramBot{
	
	protected $token;
	protected $bot_name;
	protected $squadIds;
	protected $admins;
	protected $playersIds;
	protected $url;

    protected $ali_admins;

    protected $gm_id;

	protected $hardCommands = [
	//	'Твои результаты в бою:'					=> 'cmd_battle_reports',
		'🌹KOZY Attack Rating'						=> 'cmd_squad',
		'🌹KOZY Defence Rating'						=> 'cmd_squad',
	//	'/ga_def'									=> 'cmd_ali_target',
		//'/ga_atk'									=> 'cmd_ali_target',
		'🌹KOZY'									=> 'cmd_refresh_squad',
	//	'The trader gave you some gold and left.'	=> 'cmd_trader',
		'Guild Warehouse:' 							=> 'cmd_hide_stock',
		'edit_quest ' 								=> 'cmd_quest',
		'Ты пытался остановить '					=> 'cmd_plus',
		'Ты задержал '								=> 'cmd_plus',
		'Использован предмет: '						=> 'cmd_used_murky',
		'Not enough space on Guild Warehouse'		=> 'cmd_stock_full'
	];
 
	protected $commands = [
		'🎲'			=> 'cmd_dice',
		'🎯'			=> 'cmd_dice',
		'🎳'			=> 'cmd_dice',
		'007'			=> 'cmd_low_ping',
		'112'			=> 'cmd_middle_ping',
		'911'			=> 'cmd_high_ping',
	//	'чистка'		=> 'cmd_clear_ali',
		//'ожидания'		=> 'cmd_get_str',
		//'+'				=> 'cmd_ali_ok',
	//	'атака'			=> 'cmd_get_attack_list',
	//	'защита'		=> 'cmd_get_def_list',
	//	'альянс'		=> 'cmd_ali',
		'лс'			=> 'cmd_lss',
		'команды'		=> 'cmd_commands',
	//	'сено'			=> 'cmd_gethay',
		'сыр' 			=> 'cmd_getcheese',
		'мем'			=> 'cmd_mem',
		'mem'			=> 'cmd_mem',
		'top'			=> 'cmd_top_rep',
		'rich'			=> 'cmd_rich',
		'лучник'		=> 'cmd_luchnik',
		'доб'			=> 'cmd_collect',
		'химик'			=> 'cmd_alch',
		'рыцарь'		=> 'cmd_knight',
		//'чо'			=> 'cmd_cho',
		//'медоед'		=> 'cmd_medoed',
		//'квока'			=> 'cmd_kvoka',
	//	'квокка'		=> 'cmd_kvoka',
		'стрелы'		=> 'cmd_arrows',
		'hi'			=> 'cmd_hi',
		'привет'		=> 'cmd_privet',
		'квесты' 		=> 'cmd_quest_trigger',
		'квест' 		=> 'cmd_quest_trigger',
		'опыт' 			=> 'cmd_exp_trigger',
		'потри'			=> 'cmd_peace_trigger',
		'попять'		=> 'cmd_rage_trigger',
	//	'куй'			=> 'cmd_smithlist_trigger',
	//	'бабло' 		=> 'cmd_openmarket_trigger',
	//	'деньги' 		=> 'cmd_openmarket_trigger',
	//	'леди' 			=> 'cmd_openmarket_trigger',
		'опиум'			=> 'cmd_morph_trigger',
		'мусор'			=> 'cmd_garbage_trigger',
		'грид'			=> 'сmd_greed_trigger',
		'хил'			=> 'cmd_heal_trigger',
	//	'лишнее'		=> 'cmd_gold_trigger',
	//	'лишние'		=> 'cmd_gold_trigger',
		'список_ресов'	=> 'cmd_list_player_resources',
		'мурка'			=> 'cmd_list_murky',
		'/start'		=> 'cmd_start',
		'/quests' 		=> 'cmd_quest_trigger',
		'/quest' 		=> 'cmd_quest_trigger',
		'/exp' 			=> 'cmd_exp_trigger',
		'/three'		=> 'cmd_peace_trigger',
		'/five'			=> 'cmd_rage_trigger',
		'/smith'		=> 'cmd_smithlist_trigger',
		'/gold' 		=> 'cmd_openmarket_trigger',
		'/opium'		=> 'cmd_morph_trigger',
		'/garbage'		=> 'cmd_garbage_trigger',
		'/greed'		=> 'сmd_greed_trigger',
		'/heal'			=> 'cmd_heal_trigger',
		'/excess'		=> 'cmd_gold_trigger',
		'/list_res'		=> 'cmd_list_player_resources',
		'/quests@ShepherdKozyBot' 		=> 'cmd_quest_trigger',
		'/quest@ShepherdKozyBot' 		=> 'cmd_quest_trigger',
		'/exp@ShepherdKozyBot' 			=> 'cmd_exp_trigger',
		'/three@ShepherdKozyBot'			=> 'cmd_peace_trigger',
		'/five@ShepherdKozyBot'			=> 'cmd_rage_trigger',
		'/smith@ShepherdKozyBot'			=> 'cmd_smithlist_trigger',
		'/gold@ShepherdKozyBot' 			=> 'cmd_openmarket_trigger',
		'/opium@ShepherdKozyBot'			=> 'cmd_morph_trigger',
		'/garbage@ShepherdKozyBot'		=> 'cmd_garbage_trigger',
		'/greed@ShepherdKozyBot'			=> 'сmd_greed_trigger',
		'/heal@ShepherdKozyBot'			=> 'cmd_heal_trigger',
		'/excess@ShepherdKozyBot'		=> 'cmd_gold_trigger',
		'/list_res@ShepherdKozyBot'		=> 'cmd_list_player_resources',
    ];
	
	protected $images = [
		0 => [
			'img' => 'botimages/kvokka.jpg',
			'txt' => 'Ты австралийская водяная крыса!'
		],
		1 => [
			'img' => 'botimages/козленок.jpg',
			'txt' => 'Мееееее. Ой, беееее!'
		],
		2 => [
			'img' => 'botimages/лапы вверх.jpg',
			'txt' => 'Лапы вверх! Я всё о тебе знаю'
		],
		3 => [
			'img' => 'botimages/medoed.jpg',
			'txt' => 'Я не спрашиваю сколько вас, я спрашиваю - где вы?'
		]
	];
	
	protected $mems = [
		0 => [
			'img' => 'mems/1.jpg',
			'txt' => 'Номер 1 от Palych85'
		],
		1 => [
			'img' => 'mems/2.jpg',
			'txt' => 'Номер 2 от Palych85'
		],
		2 => [
			'img' => 'mems/3.jpg',
			'txt' => 'Номер 3 от Palych85'
		],
		3 => [
			'img' => 'mems/4.jpg',
			'txt' => 'Номер 4 от Palych85'
		],
		4 => [
			'img' => 'mems/5.jpg',
			'txt' => 'Номер 5 от Stacie_15'
		],
		5 => [
			'img' => 'mems/6.jpg',
			'txt' => 'Номер 6 от Stacie_15'
		],
		6 => [
			'img' => 'mems/7.jpg',
			'txt' => 'Номер 7 от Stacie_15'
		],
		7 => [
			'img' => 'mems/8.jpg',
			'txt' => 'Номер 8 от Stacie_15'
		],
		8 => [
			'img' => 'mems/9.jpg',
			'txt' => 'Номер 9 от Stacie_15'
		],
		9 => [
			'img' => 'mems/10.jpg',
			'txt' => 'Номер 10 от Palych85'
		],
		10 => [
			'img' => 'mems/11.jpg',
			'txt' => 'Номер 11 от Woice'
		],
		11 => [
			'img' => 'mems/12.jpg',
			'txt' => 'Номер 12 от Woice'
		],
		12 => [
			'img' => 'mems/13.jpg',
			'txt' => 'Номер 13 от Mezhdu_Prochim'
		],
		 13 => [
			 'img' => 'mems/14.jpg',
			 'txt' => 'Номер 14 от Mezhdu_Prochim'
		 ],
		14 => [
			'img' => 'mems/15.jpg',
			'txt' => 'Номер 15 от maxim1309'
		],
		15 => [
			'img' => 'mems/16.jpg',
			'txt' => 'Номер 16 от maxim1309'
		],
		16 => [
			'img' => 'mems/17.jpg',
			'txt' => 'Номер 17 от maxim1309'
		],
		17 => [
			'img' => 'mems/18.jpg',
			'txt' => 'Номер 18 от Mezhdu_Prochim'
		],
		18 => [
			'img' => 'mems/19.jpg',
			'txt' => 'Номер 19 от Woice'
		],
		19 => [
			'img' => 'mems/20.jpg',
			'txt' => 'Номер 20 от Woice'
		],
		20 => [
			'img' => 'mems/21.jpg',
			'txt' => 'Номер 21 от Woice'
		],
		21 => [
			'img' => 'mems/22.jpg',
			'txt' => 'Номер 22 от Woice'
		],
		22 => [
			'img' => 'mems/23.jpg',
			'txt' => 'Номер 23 от Woice'
		],
		23 => [
			'img' => 'mems/24.jpg',
			'txt' => 'Номер 24 от Woice'
		],
		24 => [
			'img' => 'mems/25.jpg',
			'txt' => 'Номер 25 от Woice'
		],
		25 => [
			'img' => 'mems/26.jpg',
			'txt' => 'Номер 26 от Woice'
		],
		26 => [
			'img' => 'mems/27.jpg',
			'txt' => 'Номер 27 от Woice'
		],
		27 => [
			'img' => 'mems/28.jpg',
			'txt' => 'Номер 28 от maxim1309'
		],
		28 => [
			'img' => 'mems/29.jpg',
			'txt' => 'Номер 29 от maxim1309'
		],
		29 => [
			'img' => 'mems/30.jpg',
			'txt' => 'Номер 30 от a_L1s_a'
		],
		30 => [
			'img' => 'mems/31.jpg',
			'txt' => 'Номер 31 от Woice'
		],
		31 => [
			'img' => 'mems/32.jpg',
			'txt' => 'Номер 32 от Palych85'
		],
		32 => [
			'img' => 'mems/33.jpg',
			'txt' => 'Номер 33 от Woice'
		],
		33 => [
			'img' => 'mems/34.jpg',
			'txt' => 'Номер 34 от Palych85'
		],
		34 => [
			'img' => 'mems/35.jpg',
			'txt' => 'Номер 35 от Palych85'
		],
		35 => [
			'img' => 'mems/36.jpg',
			'txt' => 'Номер 36 от Woice'
		],
		36 => [
			'img' => 'mems/37.jpg',
			'txt' => 'Номер 37 от Palych85'
		],
		37 => [
			'img' => 'mems/38.jpg',
			'txt' => 'Номер 38 от Woice'
		],
		38 => [
			'img' => 'mems/39.jpg',
			'txt' => 'Номер 39 от a_L1s_a'
		],
		39 => [
			'img' => 'mems/40.jpg',
			'txt' => 'Номер 40 от Palych85'
		],
	];
	
	protected $stock_rules = [
		'Ивана'				=> ['04 Bone x ','05 Coal x ','06 Charcoal x '],
		'Леди' 				=> ['01 Thread x ','03 Pelt x ','13 Magic stone x ','15 Sapphire x ','17 Ruby x ','23 Coke x ','21 Bone powder x '],
		'Леди (крафт)' 		=> ['24 Purified powder x ','25 Silver alloy x ','27 Steel mold x ','28 Silver mold x ','29 Blacksmith frame x ','30 Artisan frame x ','32 Silver frame x ','36 Quality Cloth x ','37 Blacksmith mold x '],
		'Леди (крафт 2)' 	=> ['38 Artisan mold x '],
		'Михалыча' 			=> [],
		'Палыча'			=> ['21 Bone powder x ','34 Metallic fiber x '],
		'Войса'				=> ['13 Magic stone x ','35 Crafted leather x '],
	];
	
	public $keyboards = [
		'default' => [
			'keyboard' => [
				["АТАКА", "ЗАЩИТА"],
			]
		],
		'defnull' => [
			'keyboard' => [
				[""],
			]
		],
		'inline' => [
			[
				[
					'text' => "20 - 40",
					'callback_data'=> "type_set 1"
				],
				[
					'text' => "40 - 60",
					'callback_data'=> "type_set 2"
				],
				[
					'text' => "60+",
					'callback_data'=> "type_set 3"
				],
			],
		],
		'back' =>[[['text' => "↩ Назад", 'callback_data'=> "logout"]]]
	];
	

	public function callCommand(){
		try {
			$dice = $this->result['message']['dice'];
			if ( $dice ) {
				$text = $dice['emoji'];
				$cmd = $this->getCommand( $text );
				if( $cmd ){
					$this->$cmd();
				}
			} else {
				parent::callCommand();
			}			
		} catch (Exception $e) {
			$this->api->sendMessage($e->getMessage());
		}
	}

	/**
	 *  Editing the reply markup of messages
	 *
	 * @param int|array $params Identifier of the message to edit. 
	 *
	 * @link https://core.telegram.org/bots/api#editmessagereplymarkup
	 */
	public function editMessageReplyMarkup( $params ){
		if( is_int( $params ) ){
			$params = ['message_id' => $params];
		}
		if( !isset( $params['chat_id'] ) && isset( $this->api->chatId ) ){
			$params['chat_id'] = $this->api->chatId;
		}
		return $this->api->call("editMessageReplyMarkup", $params);
	}

	/**
	 *  Sending an animated emoji that will display a random value
	 *
	 * @param string|array $params Emoji on which the dice throw animation is based. 
	 *
	 * @link https://core.telegram.org/bots/api#sendDice
	 */
	public function sendDice( $params ){
		if( is_string( $params ) ){
			$params = ['emoji' => $params];
		}
		if( !isset( $params['chat_id'] ) && isset( $this->api->chatId ) ){
			$params['chat_id'] = $this->api->chatId;
		}
		return $this->api->call("sendDice", $params);
	}

	function dice_reports()
	{		

		$keyboard = [
			'keyboard' => [['🎲', '🎯', '🎳']],
			"resize_keyboard" => true
		];

		$this->api->sendPhoto([
			'photo' => $this->url.'botimages/saw.jpg', 
			'caption' => 'Я хочу сыграть с тобой в игру...',
			'reply_markup' => json_encode($keyboard)
		]);

		exit;

		$games = ['🎲', '🎯', '🏀', '⚽', '🎳'];
		$index = mt_rand(0, count($games) - 1);

		$result = $this->sendDice([
			'emoji' => $games[$index],
			'chat_id' => $this->api->message['from']['id']
		]);

		$decoded = $result ? @json_decode( $result, 1 ) : [];
		$this->api->sendMessage(strval($decoded['result']['dice']['value']));
	}

	function cmd_dice()
	{
		$diceValue = $this->api->message['dice']['value'];
		$money = ($diceValue == 6) ? 10 : $diceValue;

		$timeLimit = 3; //Дается три минуты на игру
		$minDate = time() - $timeLimit * 60;
		$Db = new Db;
		$sql = 'SELECT id FROM bot_reports WHERE status = 0 AND date > "' . date('Y-m-d H:i:s', $minDate) . '" LIMIT 1';
		$result = $Db::getRow($sql);

		if (!$result) {
			$this->api->sendMessage([
				'text' => 'У тебя нет отчетов, по которым можно сыграть в игру',
				'parse_mode' => 'HTML',
				'reply_markup' => json_encode(['remove_keyboard' => true])	
			]);
			exit;	
		};

		$sql = 'UPDATE bot_reports SET status = 1 WHERE id = ' . $result['id'];
		$Db::query($sql);

		$user_id = $this->result['message']['from']['id'];

		$sql = 'UPDATE bot_users SET money = money + ' . $money . ' WHERE user_id = ' . $user_id;
		$Db::query($sql);

		$sql = 'SELECT money FROM bot_users WHERE user_id = ' . $user_id;
		$result = $Db::getRow($sql);

		$this->api->sendMessage([
			'text' => 'Ты получаешь ' . $money . ' монет' . $this->number($money, ['у!', 'ы!', '!']) . 
				' Итого у тебя ' . $result['money'] . ' монет' . $this->number($result['money'], ['а.', 'ы.', '.']),
			'parse_mode' => 'HTML',
			'reply_markup' => json_encode(['remove_keyboard' => true])
		]);
	}

	function number($n, $titles) {
		$cases = [2, 0, 1, 1, 1, 2];
		return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
	}

	function cmd_battle_reports()
	{
		$id_cw3_chat = 265204902;
		$beginDate = 1629458625;
		if ($this->api->message['forward_from']['id'] == $id_cw3_chat /*&& $this->api->message['forward_date'] > $beginDate*/) {
			if (!empty($this->param)) {
				$Db = new Db;
				$sql = 'SELECT id FROM bot_reports WHERE forward_id = "'.$this->api->message['forward_date'].'" LIMIT 1';
				$result = $Db::getRow($sql);
				if (!$result) {
					$data = explode(' ⚔',$this->param);
					$dataName = explode('[YOB]',$data[0]);
					$playerName = $dataName[1];
					$sql = 'INSERT INTO bot_reports (username,user_id,forward_id) VALUES (';
					$sql .= '"'.$this->api->message['from']['username'].'",';
					$sql .= $this->api->message['from']['id'].',';
					$sql .= $this->api->message['forward_date'].')';
					//$sql .= '"'.$this->param.'"';
					$resultInsert = $Db::query($sql);

					$keyboard = ['inline_keyboard' => [[[
							'text' => 'Давай сыграем',
							'callback_data' => 'game ' . $this->api->message['forward_date']
					]]]];
			
					$this->api->sendPhoto([
						'chat_id' => $this->api->message['from']['id'],
						'photo' => $this->url.'botimages/saw.jpg', 
						'caption' => 'Я хочу сыграть с тобой в игру...',
						'reply_markup' => json_encode($keyboard)
					]);

					//$this->dice_reports();					
				} else {
					$this->api->sendMessage([
						'text' => 'Отчет уже был обработан',
						'parse_mode' => 'HTML',
					]);
				}
			}
		}
	}
	
	function cmd_low_ping()
	{
		$sql = "SELECT tg_username FROM bot_squad WHERE lvl < 41 AND status = 1";
		$Db = new Db;
		$players = $Db::getRows($sql);
		if (!empty($players)) {
			$text = '<b>Необходима ваша помощь</b>

';
			foreach ($players as $player) {
				$text .= '@'.$player['tg_username'].'
';
			}
			$this->api->sendMessage([
				'text' => $text,
				'parse_mode' => 'HTML',
			]);
		exit;
		}
		$this->api->sendMessage([
			'text' => 'Список гильдии не актуален или игроков подходящего уровня в гильдии нет',
			'parse_mode' => 'HTML',
		]);
	}
	
	function cmd_middle_ping()
	{
		$sql = "SELECT tg_username FROM bot_squad WHERE lvl > 40 AND lvl < 61 AND status = 1";
		$Db = new Db;
		$players = $Db::getRows($sql);
		if (!empty($players)) {
			$text = '<b>Необходима ваша помощь</b>

';
			foreach ($players as $player) {
				$text .= '@'.$player['tg_username'].'
';
			}
			$this->api->sendMessage([
				'text' => $text,
				'parse_mode' => 'HTML',
			]);
		exit;
		}
		$this->api->sendMessage([
			'text' => 'Список гильдии не актуален или игроков подходящего уровня в гильдии нет (< 41)',
			'parse_mode' => 'HTML',
		]);
	}
	
	function cmd_high_ping()
	{
		$sql = "SELECT tg_username FROM bot_squad WHERE lvl > 59 AND status = 1";
		$Db = new Db;
		$players = $Db::getRows($sql);
		if (!empty($players)) {
			$text = '<b>Необходима ваша помощь</b>

';
			foreach ($players as $player) {
				$text .= '@'.$player['tg_username'].'
';
			}
			$this->api->sendMessage([
				'text' => $text,
				'parse_mode' => 'HTML',
			]);
		exit;
		}
		$this->api->sendMessage([
			'text' => 'Список гильдии не актуален или игроков подходящего уровня в гильдии нет (< 41)',
			'parse_mode' => 'HTML',
		]);
	}
	
	function cmd_clear_ali() 
	{
		if ($this->result['message']['from']['id'] == $this->gm_id) {
			$Db = new Db;
			$sql = 'UPDATE bot_battle SET status = 4';
			$Db::query($sql);
			
			$this->api->sendMessage([
				'text' => 'Битвы очищены',
				'parse_mode' => 'HTML',
			]);
		}
	}
	
	function callback_logout(){
		if (in_array($this->result['message']['from']['id'], $this->ali_admins)) {
			$this->api->answerCallbackQuery( $this->result['callback_query']["id"] );
			$this->api->deleteMessage( $this->result['callback_query']['message']['message_id'] );
		}
	}
	
	function callback_type_set( $query ){
			$data = explode(' ',$query);
			$type = explode('.',$this->result['callback_query']['message']['text'])[0];
			if ($type == 'АТАКА') {
				$profession = 1;
			} else {
				$profession = 0;
			}
			switch ($data[1]) {
				case 1:
					$txt = '20 - 40';
					break;
				case 2:
					$txt = '40 - 60';
					break;
				case 3:
					$txt = '60+';
					break;
			}
			$sql = 'SELECT num, name, lvl FROM bot_alliance WHERE attack_type = '.$data[1];
			$Db = new Db;
			$result = $Db::getRows($sql);
			$text = '';
			if ($result) {
				foreach ($result as $playerData) {
					$text .= '<b>'.$playerData['num'].'</b> - уровень: '.$playerData['lvl'].' '.$playerData['name'].'
	';
				}
			} else {
				$this->callbackAnswer( 'ошибка обновления', $this->keyboards['back'] );
			}
			$this->callbackAnswer( $text, $this->keyboards['back'] );
	}
	
	function callback_game( $query ){

		$keyboard = [
			'keyboard' => [['🎲', '🎯', '🎳']],
			"resize_keyboard" => true
		];

		$this->api->sendMessage([
			'text' => 'Выбери игру, в которую хочешь сыграть',
			'parse_mode' => 'HTML',
			'reply_markup' => json_encode($keyboard)
		]);

		$data = explode(' ', $query);
		$Db = new Db;
		$sql = 'UPDATE bot_reports SET date = "' . date('Y-m-d H:i:s') . '" WHERE forward_id = ' . $data[1];
		$Db::query($sql);

		/*$this->editMessageReplyMarkup([
			'message_id' => $this->result['callback_query']['id'],
			'reply_markup' => '{inline_keyboard: []}'
		]);*/

	}

	function cmd_get_str()
	{
		if ($this->api->message['chat']['type'] == 'private' && $this->result['message']['from']['id'] == $this->gm_id) {
			$Db = new Db;
			$sql = 'SELECT * FROM bot_battle WHERE status IN (1,2)';
			$datas = $Db::getRows($sql);
			$result[0] = [];
			$result[1] = [];
			$result[1][1] = [];
			$result[1][2] = [];
			$result[1][3] = [];
			if (!empty($datas)) {
				$users = [];
				foreach ($datas as $data) {
                    if ($data['status'] == 1) {
                        $bad[] = [$data['target'] => $data['username']];
                    } else {
                        $good[] = [$data['target'] => $data['username']];
                    }
				    if ($data['status'] == 2) {
                        if (!in_array($data['user_id'], $users)) {
                            if (!isset($result[$data['operation']][$data['lvl_type']][$data['target']])) {
                                if ($data['operation'] == 0) {
                                    $result[$data['operation']][$data['lvl_type']][$data['target']] = $data['expected_defence'];
                                } else {
                                    $result[$data['operation']][$data['lvl_type']][$data['target']] = $data['expected_attack'];
                                }
                            } else {
                                if ($data['operation'] == 0) {
                                    $result[$data['operation']][$data['lvl_type']][$data['target']] += $data['expected_defence'];
                                } else {
                                    $result[$data['operation']][$data['lvl_type']][$data['target']] += $data['expected_attack'];
                                }
                            }
                            $users[] = $data['user_id'];
                        }
                    }
				}
			} else {
				$this->api->sendMessage([
					'text' => 'Никто еще не подтвердил цель',
					'parse_mode' => 'HTML',
				]);
			}
            $txt = '';
            if (!empty($bad)) {
                $txt .= '<b>Не подтвердили цель</b>
';
                foreach ($bad as $one) {
                    $txt .= array_keys($one)[0].' '.array_values($one)[0].'
';
                }
            }
            if (!empty($good)) {
                $txt .= '
<b>Подтвердили цель</b>
';
                foreach ($good as $one) {
                    $txt .= array_keys($one)[0].' '.array_values($one)[0].'
';
                }
            }
            $this->api->sendMessage([
                'text' => $txt,
                'parse_mode' => 'HTML',
            ]);
			if (!empty($result)) {
			    $txt = '';
				if (!empty($result[0])) {
					foreach ($result[0] as $one) {
						if (!empty($one)) {
							$key = array_keys($one)[0];
							$txt .= 'Защита '.$key.' - '.$one[$key].'
';
						}
					}
				}
				if (!empty($result[1])) {
					foreach ($result[1] as $one) {
						if (!empty($one)) {
							$key = array_keys($one)[0];
							$txt .= 'Атака '.$key.' - '.$one[$key].'
';
						}
					}
				}
				$this->api->sendMessage([
					'text' => $txt,
					'parse_mode' => 'HTML',
				]);
			}
		}
	}
	
	function cmd_ali_ok()
	{
		if ($this->api->message['chat']['type'] == 'private') {
			$Db = new Db;
			$user_id = $this->api->message['chat']['id'];
			$sql = 'SELECT target FROM bot_battle WHERE user_id = '.$this->api->message['chat']['id'].' AND status = 1';
			$data = $Db::getRow($sql);
			if ($data) {
				$sql = 'UPDATE bot_battle SET status = 2 WHERE user_id = '.$this->api->message['chat']['id'] .' AND status = 1';
				$Db::query($sql);
				$this->api->sendMessage([
					'text' => 'Ваши силы учтены. Не забудьте после битвы скинуть отчет с битвы!',
					'parse_mode' => 'HTML',
				]);
				exit;
			}
			$this->api->sendMessage([
				'text' => 'Актуальных целей для вас нет',
				'parse_mode' => 'HTML',
			]);
			exit;
		}
	}
	
	function cmd_ali_target()
	{							
		if ($this->param && in_array($this->result['message']['from']['id'], $this->ali_admins)) {
			$Db = new Db;
			$template = 'http://t.me/share/url?url=/ga_';
			$numsData = explode('"',$this->param);
			$nums = explode(' ',$numsData[0]);
			$text = '';
			$playersNums = [];
			$target = $nums[0];
			$operation = 0;
			if (strpos($target,'atk') !== false) {
				$operation = 1;
			}
			foreach ($nums as $num) {
				if ($num > 0 && strpos($num,'"') == false) {
					$playersNums[] = $num;
				} else {
					continue;
				}
			}
			$msgData = explode('"',$this->param);
			$msg = $msgData[1];
			if (!empty($playersNums)) {
				$sql = 'SELECT ali.name,ali.lvl,squad.attack,squad.defense,ali.attack_type as lvl_type,ali.user_id FROM bot_alliance ali LEFT JOIN bot_squad squad ON squad.name = ali.name WHERE num IN ('.implode(',',$playersNums).')';
				$result = $Db::getRows($sql);
				if (!empty($result)) {
					$values = [];
					foreach ($result as $player) {
						$values[] = '("'.$target.'",'.$player['user_id'].',"'.$player['name'].'",'.$player['lvl'].','.$player['lvl_type'].','.$operation.','.$player['attack'].','.$player['defense'].')';
					}
					$sql = 'INSERT INTO bot_battle (target,user_id,username,lvl,lvl_type,operation,expected_attack,expected_defence) VALUES ';
					if (!empty($values)) {
						$sql .= implode(',',$values);
						$Db::query($sql);
					}
					foreach ($result as $player) {
						$drink = '';
						if ($player['lvl_type'] > 2) {
							$drink = 'Пей '.($operation == 1 ? 'комплект рейджев. Если закончились - напиши в чате Козы На Расслабоне фразу "<b>попять</b>"' : 'комплект писов. Если закончились - напиши в чате Козы На Расслабоне фразу "<b>потри</b>"');
						}
						$this->api->sendMessage([
							'chat_id' => $player['user_id'],
							'text' => 'Для тебя есть особое задание на ближайшую битву

'.str_replace('/ga_',$template,$msg).'

'.$drink.'
Если ты получил "пин" и поставил отложку или встал в '.($operation == 1 ? 'атаку': 'защиту').' напиши мне "+"
							',
							'parse_mode' => 'HTML'
						]);
						sleep(0.5);
					}
					$this->api->sendMessage([
						'text' => 'Задача поставлена',
						'parse_mode' => 'HTML',
					]);
				}
			}
		}
	}
	
	function cmd_get_attack_list()
	{
		if (in_array($this->result['message']['from']['id'], $this->ali_admins)) {
			$this->api->sendMessage([
				'text'=>"АТАКА. Выберите тип цели, которую будем атаковать",
				'reply_markup' => json_encode( [
					'inline_keyboard'=> $this->keyboards['inline']
				] )
			]);
		}
	}
	
	function cmd_get_def_list()
	{
		if (in_array($this->result['message']['from']['id'], $this->ali_admins)) {
			$this->api->sendMessage([
				'text'=>"ЗАЩИТА. Выберите тип цели, которую будем дефать",
				'reply_markup' => json_encode( [
					'inline_keyboard'=> $this->keyboards['inline']
				] )
			]);
		}
	}
	
	function cmd_squad()
	{
		if ($this->param) {
			$Db = new Db;
			if (strpos($this->param,'YOBA Attack Rating')) {
				$field = 'attack';
			} else if (strpos($this->param,'YOBA Defence Rating')) {
				$field = 'defense';
			}
			$dataPlayers = explode('#',$this->param);
			foreach ($dataPlayers as $key => $playerData) {
				if ($key > 0) {
					$playerNameData = explode(' ',$playerData);
					$playerName = trim($playerNameData[2]); // name
					if ($field == 'attack') {
						$playerData = substr(json_encode($playerNameData[1]),7,-1);
					} else {
						$playerData = substr(json_encode($playerNameData[1]),13,-1);
					}
					$sql = 'UPDATE bot_squad SET '.$field.' = '.$playerData.' WHERE name LIKE "'.$playerName.'%"';;
					$res = $Db::query($sql);
				}
			}
			$this->api->sendMessage([
				'text' => 'Данные отряда обновлены',
				'parse_mode' => 'HTML',
			]);
		}
	}
	
	function cmd_refresh_squad()
	{
		//if ($this->api->message['chat']['id'] == 129144758) {
			$profs = [
				0 => ['⚒',' 📦','🛡','⚗️'],
				1 => ['⚔️','🏹']
			];
			if ($this->param) {
				$Db = new Db;
				$sql = 'TRUNCATE bot_alliance';
				$Db::query($sql);
				$sql = 'INSERT INTO bot_alliance (num,name,user_id,lvl,profession,attack_type,status) VALUES ';
				//$sqlSquad = 'INSERT INTO bot_squad (name,user_id,lvl) VALUES ';
				$dataPlayers = explode('#',$this->param);
				$values = [];
				foreach ($dataPlayers as $key => $playerData) {
					if ($key > 0) {
						$playerNum = (int) $playerData; // num
						$playerNameData = explode(']',$playerData);
						$playerName = $playerNameData[1]; // name
						$playerProf = 0;
						foreach ($profs[1] as $prof) {
							$playerProfDataPos = strpos($playerData,$prof);
							if ($playerProfDataPos !== false) {
								$playerProf = 1;
								continue;
							}
						}
						$playerLvlData = explode('[',$playerData);
						if (json_encode(substr($playerLvlData[0], -3)) != false) {
							$playerLvl = (int) substr($playerLvlData[0], -3);
						} else {
							$playerLvl = (int) substr($playerLvlData[0], -2);
						}
						if ($playerLvl > 19) {
							if ($playerLvl > 19 && $playerLvl < 41) {
								$playerType = 1; //low
							} else if ($playerLvl > 39 && $playerLvl < 61) {
								$playerType = 2; //muiddle
							} else {
								$playerType = 3; //high
							}
						}
						$squadStats[$playerName] = $playerLvl;
						//$squadValues[] = '("'.trim($playerNameData[1]).'",'.$this->squadIds[trim($playerNameData[1])].','.$playerLvl.')';
						$values[] = '('.$playerNum.',"'.trim($playerNameData[1]).'",'.$this->squadIds[trim($playerNameData[1])].','.$playerLvl.','.$playerProf.','.$playerType.',1)';
					}
				}
				if (!empty($values)) {
					$sql .= implode(', ',$values);
					//$sqlSquad .= implode(', ',$squadValues);
					$Db::query($sql);
					//$Db::query($sqlSquad);
					if (!empty($squadStats)) {
						foreach ($squadStats as $name => $level) {
							$sql = 'UPDATE bot_squad SET lvl = '.$level.' WHERE name LIKE "'.trim($name).'%"';
							$Db::query($sql);
						}
					}
					if ($this->api->message['chat']['id'] == $this->gm_id) {
						$this->api->sendMessage([
							'text' => 'Данные отряда обновлены',
							'parse_mode' => 'HTML',
						]);
					}
				}
			}
		//}
	}
	
	function cmd_ali()
	{
		$this->api->sendMessage([
			'text' => "Выберите тип ",
			'reply_markup' => json_encode($this->keyboards['defnull'])
			//'reply_markup' => json_encode($this->keyboards['default'])
		]);
	}
	
	function cmd_commands()
	{
		$text = '<b>007</b> - попросить помощи у игроков ниже 40 уровня
<b>112</b> - попросить помощи у мидлов
<b>911</b> - попросить помощи у игроков выше 59го уровня
<b>потри</b> - попросить комплект писов (peace)
<b>попять</b> - попросить комплект рейджев (rage)
<b>опиум</b> - попросить комплект морфов (morph)
<b>грид</b> - попросить комплект грида (greed)
<b>хил</b> - попросить на хил...
<b>стрелы</b> - попросить выдать стрелы
<b>опыт</b> - попросить ресов на крафт для опыта
<b>мусор</b> - попросить ресов на гномов
<b>куй</b> - ссылки наших кузнецов для починки
<b>мем</b> - показать рандомный мем с конкурса
<b>mem</b> - показать рандомный мем с конкурса
<b>сено</b> - попросить сена
<b>сыр</b> - попросить сыра
<b>леди</b> - показать ссылку на магазин Леди
<b>деньги</b> - показать ссылку на магазин Леди
<b>бабло</b> - показать ссылку на магазин Леди
<b>лишнее {N}</b> - выдает ссылку для леди для слива N суммы денег
<b>лишние {N}</b> - выдает ссылку для леди для слива N суммы денег
<b>квесты</b> - показать список актуальных квестов
<b>квест</b> - показать список актуальных квестов
<b>quest</b> - показать список актуальных квестов
<b>quests</b> - показать список актуальных квестов
		';
		$this->api->sendMessage([
			'text' => $text,
			'parse_mode' => 'HTML',
		]);
	}
	
	function cmd_getcheese()
	{
		$this->api->sendMessage([
			'text' => '<a href="http://t.me/share/url?url=/g_withdraw%20621%2010">Выдать сырок</a>

@Mezhdu_Prochim
',
			'parse_mode' => 'HTML'
		]);
	}
	
	function cmd_gethay()
	{
		$this->api->sendMessage([
			'text' => '<a href="http://t.me/share/url?url=/g_withdraw%20618%2010">Выдать сено</a>

			@Mezhdu_Prochim
',
			'parse_mode' => 'HTML'
		]);
	}
	
	function cmd_mem()
	{
		
		$count = mt_rand(0,count($this->mems));
		/*$this->api->sendMessage([
			'text' => 'Номер '.$count,
			'parse_mode' => 'HTML'
		]);*/
		if ($count == count($this->mems)) $count--;
		if (isset($this->mems[$count]['img'])) {
			$this->api->sendPhoto([
				'photo' => $this->url.$this->mems[$count]['img'], 
				'caption' => $this->mems[$count]['txt']
			]);
		}
	}
	
	function cmd_top_rep()
	{
		$Db = new Db;
		$sql = 'SELECT username, reputation FROM bot_reputation ORDER BY reputation DESC';
		$result = $Db::getRows($sql);
		if (!empty($result)) {
			$text = '';
			$place = 1;
			foreach ($result as $one) {
				$text .= '<b>'.$place.'</b> -  <b>'.$one['reputation'].'</b> '.$one['username'].'
				';
				$place++;
			}
			$this->api->sendMessage([
				'text' => $text,
				'parse_mode' => 'HTML'
			]);
		} else {
			$this->api->sendMessage([
				'text' => 'Данные в этом сезоне отсутствуют',
				'parse_mode' => 'HTML'
			]);
		}
	}

	function cmd_rich()
	{
		$Db = new Db;
		$sql = 'SELECT username, money FROM bot_users WHERE money > 0 ORDER BY money DESC';
		$result = $Db::getRows($sql);
		if (!empty($result)) {
			$text = '';
			$place = 1;
			foreach ($result as $one) {
				$text .= '<b>'.$place.'. </b>'.$one['username'].' -  <b>'.$one['money'].'</b>💰
				';
				$place++;
			}
			$this->api->sendMessage([
				'text' => $text,
				'parse_mode' => 'HTML'
			]);
		} else {
			$this->api->sendMessage([
				'text' => 'Данные по монетам отсутствуют',
				'parse_mode' => 'HTML'
			]);
		}
	}
	
	function cmd_alch()
	{
		$this->api->sendPhoto([
			'photo' => $this->url.'botimages/alсh.jpg',
			'caption' => 'Не злите тех, кто может плюнуть в ваш стакан с зельем'
		]);
	}
	function cmd_collect()
	{
		$this->api->sendPhoto([
			'photo' => $this->url.'botimages/доб.jpg',
			'caption' => 'Доб - погоподобный класс!'
		]);
	}
	function cmd_knight()
	{
		$count = mt_rand(0,1);
		if ($count == 0) {
			$this->api->sendDocument([
				'document' => $this->url.'botimages/normal_knight.mp4',
			]);
		} else {
			$this->api->sendPhoto([
				'photo' => $this->url.'botimages/knight.jpg',
			]);
		}
	}

	function cmd_luchnik()
	{
		$this->api->sendPhoto([
			'photo' => $this->url.'botimages/luchnik.png', 
			'caption' => 'Лучник - хуйня]!'
		]);
	}
	
	function cmd_cho()
	{
	    $texts = [
	        'Хуйвачо',
            'Хуй через плечо!',
            'Не ЧО, а ШО!',
            'Быдло безкультурное!',
			'Другие вон чë, и то ничë, а ты чë?'
        ];
		$this->api->sendMessage([
			'text' => $texts[array_rand($texts)],
			'parse_mode' => 'HTML'
		]);
	}
	
	function cmd_medoed()
	{
		$this->api->sendPhoto($this->url.$this->images[3]['img']);
	}
	
	function cmd_lss()
	{
		$this->api->sendMessage([
				'chat_id' => 89848066,
				'text' => 'Тестирование ЛС рассылки. Саня привет!)',
				'parse_mode' => 'HTML'
			]);
	}
	
	function cmd_ls()
	{
		$players = [
			'Войса','Палыча'
		];
		foreach ($players as $player) {
			$this->api->sendMessage([
				'chat_id' => $this->playersIds[$player],
				'text' => 'Тестирование ЛС рассылки',
				'parse_mode' => 'HTML'
			]);
		}
		$count = mt_rand(0,count($this->images));
		if ($count == count($this->images)) $count--;
		$this->api->sendMessage([
			'chat_id' => $this->gm_id,
			'text' => $this->images[$count]['txt'],
			'parse_mode' => 'HTML'
		]);
		$this->api->sendDocument(['chat_id' => $this->gm_id,'document' => 'http://i.giphy.com/13IC4LVeP5NGNi.gif']);
	}
	
	function cmd_kvoka()
	{
		$this->api->sendPhoto($this->url.'botimages/kvokka.jpg');
	}
	
	function cmd_stock_full()
	{
		$this->api->sendMessage([
			'text' => '

			@Mezhdu_Prochim Сток забит
			',
			'parse_mode' => 'HTML'
		]);
	}
	
	function cmd_arrows()
	{
		$this->api->sendMessage([
						'text' => '
<a href="http://t.me/share/url?url=/g_withdraw%2008%2001%2002%2006">Wooden</a>
<a href="http://t.me/share/url?url=/g_withdraw%2019%2001%2002%2004">Steel</a>
<a href="http://t.me/share/url?url=/g_withdraw%2007%2005%2010%2005%2002%2007">Silver</a>

<a href="http://t.me/share/url?url=/g_withdraw%2021%2002%2023%2001%2008%2003%2036%2001%2002%2007">Broad</a> (vs robe)
<a href="http://t.me/share/url?url=/g_withdraw%2023%2002%2008%2007%2036%2001%2002%2007">Heavy</a> (vs heavy)
<a href="http://t.me/share/url?url=/g_withdraw%2021%2001%2023%2001%2008%2002%2036%2001%2010%2002%2002%2007">Compound</a> (vs light)

<a href="http://t.me/share/url?url=/g_withdraw%2002%2009%2019%2004%2010%2006%2021%2001%2023%2001%2036%2001">Mechblade</a> (vs robe)
<a href="http://t.me/share/url?url=/g_withdraw%2002%2009%2019%2006%2023%2001%2036%2001">Piercing</a> (vs heavy)
<a href="http://t.me/share/url?url=/g_withdraw%2002%2009%2019%2004%2010%2006%2021%2001%2023%2001%2036%2001">Bodkin</a>(vs light)
						',
						'parse_mode' => 'HTML'
					]);
	}
	
	function cmd_plus()
	{
		$id_cw3_chat = 265204902;
		$beginDate = 1629458625;
		if ($this->api->message['forward_from']['id'] == $id_cw3_chat && $this->api->message['forward_date'] > $beginDate) {
			$Db = new Db;
			$sql = 'SELECT id FROM bot_messages WHERE message_id = "'.$this->api->message['forward_date'].'" LIMIT 1';
			$result = $Db::getRow($sql);
			if (!$result) {
				$sql = 'INSERT INTO bot_messages (username,message_id) VALUES ("'.$this->api->message['from']['username'].'","'.$this->api->message['forward_date'].'")';
				$Db::query($sql);
				
				$sql = 'SELECT reputation FROM bot_reputation WHERE username = "'.$this->api->message['from']['username'].'"';
				$res = $Db::getRow($sql);
				if (!$res) {
					$sql = 'INSERT INTO bot_reputation (username,reputation) VALUES ("'.$this->api->message['from']['username'].'",1)';
					$resultInsert = $Db::query($sql);
					$this->api->sendMessage([
						'text' => 'Репутация <b>'.$this->api->message['from']['username'].'</b> теперь равна <b>1</b>',
						'parse_mode' => 'HTML'
					]);
				} else {
					$reputation = $res['reputation'] + 1;
					$sql = 'UPDATE bot_reputation SET reputation = '.$reputation.' WHERE username = "'.$this->api->message['from']['username'].'"';
					$reusltUpdate = $Db::query($sql);
					$this->api->sendMessage([
						'text' => 'Репутация <b>'.$this->api->message['from']['username'].'</b> теперь равна <b>'.$reputation.'</b>',
						'parse_mode' => 'HTML'
					]);
				}
			} else {
				$this->api->sendMessage([
					'text' => 'Сообщение уже было обработано',
					'parse_mode' => 'HTML'
				]);
			}
		} else {
			$count = mt_rand(0,count($this->images));
			if ($count == count($this->images)) $count--;
			$this->api->sendMessage([
				'text' => $this->images[$count]['txt'],
				'parse_mode' => 'HTML'
			]);
			$this->api->sendPhoto($this->url.$this->images[$count]['img']);
			
			// $this->api->sendMessage([
				// 'text' => 'Ты австралийская водяная крыса!!!',
				// 'parse_mode' => 'HTML'
			// ]);
			// $chat_id = $this->api->message['chat']['id'];
			// $this->api->sendPhoto('https://affari.com.ua/botimages/kvokka.jpg');
		}
	}
	
	function cmd_edit_quest()
	{
		if ($this->param) {
			$data = explode(' ',$this->param);
			$questName = $data[1];
			$questTarget = $data[2];
			foreach ($data as $key => $str) {
				if ($key > 2) {
					$questTarget .= ' '.$str;
				}
			}
			$file = __DIR__.'/files/'.$questName;
			if (!empty($questName) && !empty($questTarget) && file_exists($file)) {
				file_put_contents($file,$questTarget);
				$data = file_get_contents($file);
				$this->api->sendMessage([
					'text' => 'Цель на квест <b>'.$questName.'</b> УСТАНОВЛЕНА',
					'parse_mode' => 'HTML'
				]);
			}
		}
	}
	
	function cmd_list_player_resources() {
		foreach ($this->stock_rules as $player => $resources) {
			if (!empty($resources)) {
				$txt = '<b>'.$player.'</b>'."
	";
				foreach ($resources as $resource) {
					$txt .= substr($resource,0,-2)."
	";
				}
				$this->api->sendMessage([
					'text' => $txt,
					'parse_mode' => 'HTML'
				]);
			}
		}
	}

	function cmd_list_murky() {
		$this->api->sendMessage([
			'text' => file_get_contents('murky.txt'),
			'parse_mode' => 'HTML'
		]);
	}

	function cmd_used_murky() {

		$data = explode('Навык ', $this->param);
		if (count($data) == 1) {
			return;
		}

		$data = explode(' усилен', $data[1]);
		$skill = $data[0];

		$file = file("murky.txt");
		foreach ($file as $lineNumber => $line) {
			if (strpos($line, $skill) !== false) {
			   
				$this->api->sendMessage([
					'text' => $file[$lineNumber + 1],
					'parse_mode' => 'HTML'
				]);			   
			   break;
			}
		}
		
	}
	
	function cmd_hide_stock() {
		$flag = false;
		if (!empty($this->param)) {
			foreach ($this->stock_rules as $player => $resources) {
				if (!empty($resources)) {
					$txt = '';
					foreach ($resources as $resource) {
						if (strpos($this->param,$resource) !== false) {
							$resName = (int) $resource;
							$tmp = explode($resource,$this->param)[1];
							$counter = explode("
",$tmp)[0];
							if ($resName < 10) {
								$resName = '0'.$resName;
							}
							$txt .= $resName.' '.$counter.' ';
							$flag = true;
						}
					}
				} else {
					$flag = false;
				}
				if ($flag && !empty($txt)) {
					$link[0] = "<a href='http://t.me/share/url?url=/g_withdraw ";
					$link[1] = "'>Ресурсы</a>";
					$this->api->sendMessage([
						'text' => 'Для '.$player.' '.$link[0].$txt.$link[1]." (".$txt.')',
						'parse_mode' => 'HTML'
					]);
					if (isset($this->playersIds[$player]) && $this->playersIds[$player] != $this->api->message['chat']['id']) {
						$forward = str_replace(' ','%20',$txt);
						// $this->api->sendMessage([
							// 'chat_id' => $this->playersIds[$player],
							// 'text' => 'Там твои ресурсы валяются
// '.$link[0].$forward.$link[1]." (".$txt.")",
							// 'parse_mode' => 'HTML'
						// ]);
					}
				}
			}
		}
		return false;
	}
	
	function cmd_trader() {
		if (!empty($this->param)) {
			$tmp = explode(' exp and ',$this->param);
			$price = (int)$tmp[1];
			$this->api->sendMessage([
				'text' => "<a href='http://t.me/share/url?url=/s_165_add 28 ".$price."'>Ссылка для Леди</a>
				
@woice @palych85",
				'parse_mode' => 'HTML'
			]);
		}
	}
	
	function cmd_gold_trigger() {
		$this->api->sendMessage([
            'text' => "<a href='http://t.me/share/url?url=/s_165_add 28 ".$this->param."'>Ссылка для Леди</a>

@woice @palych85",
			'parse_mode' => 'HTML'
		]);
	}
	
	function cmd_heal_trigger() {
		$this->api->sendMessage([
            'text' => '
<a href="http://t.me/share/url?url=/g_withdraw%2065%201%2072%201%2070%201%2017%201">Дайте на хилку</a>

<a href="http://t.me/share/url?url=/ws_fdwdw">Магазин Ана</a>
<a href="http://t.me/share/url?url=/ws_LIM0e">Олин магазин</a>

@a_L1s_a @SonOf_The_Sun
			',
			'parse_mode' => 'HTML']);
	}
	
	function сmd_greed_trigger() {
		$this->api->sendMessage([
            'text' => '
@woice @SonOf_The_Sun @TheKingLeon @Stacie_15 дайте грида
<a href="http://t.me/share/url?url=/g_withdraw%20p07%2010%20p08%2010%20p09%2010">ГРИД ТУТ</a>
			',
			'parse_mode' => 'HTML']);
	}
	
	function cmd_garbage_trigger() {
		$this->api->sendMessage([
            'text' => '
<a href="http://t.me/share/url?url=/g_withdraw%2002%2075">Ветки</a>
<a href="http://t.me/share/url?url=/g_withdraw%2005%2075">Уголь</a>
<a href="http://t.me/share/url?url=/g_withdraw%2006%2075">Др.уголь</a>
<a href="http://t.me/share/url?url=/g_withdraw%2007%2075">Порошок</a>
<a href="http://t.me/share/url?url=/g_withdraw%2010%2075">Серебро</a>
<a href="http://t.me/share/url?url=/g_withdraw%2022%2075">Стринги</a>

<a href="http://t.me/share/url?url=/g_withdraw%2010%2075%2007%2003%2009%2011">Серебро+Quality cloth</a>
<a href="http://t.me/share/url?url=/g_withdraw%2008%2075%2007%2003%2009%2011">Руда+Quality cloth</a>

/ws_DEz8O_36
@Mezhdu_Prochim
			',
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_morph_trigger() {
		$this->api->sendMessage([
            'text' => '
			@Mezhdu_Prochim Есть чо?
			',
			'parse_mode' => 'HTML'
        ]);
		$this->api->sendMessage([
           'text' => '
<a href="http://t.me/share/url?url=/g_withdraw%20p19%203%20p20%203%20p21%203">МОРФ ТУТ</a>
			',
			'parse_mode' => 'HTML'
       ]);
	}
	
	function cmd_openmarket_trigger() {
		$this->api->sendMessage([
            'text' => '
<a href="http://t.me/share/url?url=/ws_DEz8O">Куплю что-нибудь тут</a>
			',
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_smithlist_trigger() {
		$this->api->sendMessage([
            'text' => '
http://t.me/share/url?url=/ws_bKYea
@Omnissiah открой кузню, если закрыто!
			',
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_peace_trigger() {
		$this->api->sendMessage([
            'text' => '
			@Mezhdu_Prochim Выпить дай!

<a href="http://t.me/share/url?url=/g_withdraw%20p04%206%20p05%206%20p06%206">Peace</a>
			',
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_rage_trigger() {
		$this->api->sendMessage([
            'text' => '
			@Mezhdu_Prochim Выпить дай!

<a href="http://t.me/share/url?url=/g_withdraw%20p01%208%20p02%208%20p03%208">Rage</a>',
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_exp_trigger() {
		$this->api->sendMessage([
            'text' => '
<a href="http://t.me/share/url?url=/g_withdraw%2004%2020">Костяная пудра</a>
<a href="http://t.me/share/url?url=/g_withdraw%2005%2015%2006%2015">Кокс</a>
<a href="http://t.me/share/url?url=/g_withdraw%2002%2015">Стринги</a>

@Mezhdu_Prochim
			',
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_quest_trigger()
	{
		$Db = new Db;
		$sql = 'SELECT champion,mutants,beasts,date FROM bot_quests LIMIT 1';
		$result = $Db::getRow($sql);
		$this->api->sendMessage([
			'text' => "
Чемпион - <b>".mb_strtoupper($result['champion'])."</b>
Мутанты - <b>".mb_strtoupper($result['mutants'])."</b>
Звери - <b>".mb_strtoupper($result['beasts'])."</b>
Данные от ".$result['date']."
			",
			'parse_mode' => 'HTML'
        ]);
	}
	
	function cmd_quest() {
		$Db = new Db;
		$questsNames = [
			'чемпион' => 'champion',
			'мутанты' => 'mutants',
			'звери' => 'beasts',
		];
		
		if (!in_array($this->api->message['chat']['id'],$this->admins)) {
			$this->api->sendMessage([
				'text' => 'Данная функция доступна только администраторам. Если вы хотите изменить параметры триггера "квесты", то обратитесь к @Mezhdu_Prochim',
				'parse_mode' => 'HTML'
			]);
		}
		if ($this->param) {
			$data = explode(' ',$this->param);
			$questName = $data[1];
			$questTarget = $data[2];
			foreach ($data as $key => $str) {
				if ($key > 2) {
					$questTarget .= ' '.$str;
				}
			}
			if (!empty($questName) && !empty($questTarget)) {
				if (!in_array($questName,array_keys($questsNames))) {
					$this->api->sendMessage([
						'text' => 'Название квеста должно соответствовать шаблону:
<b>чемпион</b>
<b>мутанты</b>
<b>звери</b>

Примеры: 
edit_quest чемпион РЫЦАРИ
edit_quest мутанты Мутанты с мутациями
edit_quest звери кабаны или медведи
',
						'parse_mode' => 'HTML'
					]);
				} else {
					$sql = 'UPDATE bot_quests SET '.$questsNames[$questName].' = "'.$questTarget.'", date = "'.date('Y-m-d H:i:s').'" WHERE id = 1';
					$Db::query($sql);
					$this->api->sendMessage([
						'text' => 'Цель на квест <b>'.$questName.'</b> УСТАНОВЛЕНА',
						'parse_mode' => 'HTML'
					]);
					$this->cmd_quest_trigger();
				}
				
			}
		} 
	}

    function cmd_start()
{
		$Db = new Db;
		$sql = 'SELECT id FROM bot_users WHERE user_id = '.$this->result['message']['from']['id'];
		$result = $Db::getRow($sql);
		$txt = '';
		if ($result) {
			$txt = ' Я тебя уже знаю';
		} else {
			$sql = 'INSERT INTO bot_users (user_id,username) VALUES ('.$this->result['message']['from']['id'].',"'.$this->result['message']['from']['username'].'")';
			$result = $Db::query($sql);
		}
		$this->api->sendMessage([
			'text' => "Добро пожаловать в бота ".$this->result['message']['from']['username']."!".$txt,
			'parse_mode' => 'HTML'
		]);
		
    }

    function cmd_privet(){
        $this->api->sendMessage([
            'text' => "Привет, я Пастух, бот Коз. Кто понял, тот понял. Остальные идите мимо",
        ]);
    }

    function cmd_hi() {
        $this->api->sendMessage([
            'text' => "Ты автстралийская водяная крыса! Вот ты кто",
        ]);
    }
}

?>