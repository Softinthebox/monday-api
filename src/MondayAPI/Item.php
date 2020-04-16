<?php

namespace TBlack\MondayAPI;

class Item extends MondayAPI
{

	public function newItem( Int $board_id, String $group_id, String $item_name, $column_values = [])
	{
		$data = 'create_item (board_id: '.$board_id.', group_id: "'.$group_id.'", item_name: "'.$item_name.'") {
			id
		}';

		return $this->request(
			self::TYPE_MUTAT,
			$this->buildQuery($data)
		);
	}
}


?>
