<?php

namespace TBlack\MondayAPI;

class Item extends MondayAPI
{

	static $struct_arguments_item = array(
		'limit' 		=> 'Int',
		'page' 			=> 'Int',
		'ids' 			=> '[Int]',
		'newest_first' 	=> 'Boolean'
	);

	static $struct_create_item = array(
		'board_id' 		=> 'Int',
		'group_id' 		=> 'String',
		'item_name' 	=> 'String',
		'column_values' => 'JSON'
	);

	public function addItem($get = false, $args = false)
	{
		return $this->request(
			self::TYPE_MUTAT,
			$this->create(
				'create_item',
				$this->buildArguments(
					$this->buildArgsFields(
						Board::$struct_arguments_item,
						$args
					)
				),
				$get
			)
		);
	}
}


?>
