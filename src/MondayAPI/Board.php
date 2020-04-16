<?php

namespace TBlack\MondayAPI;

use TBlack\MondayAPI\MondayAPI as MondayAPI;
use TBlack\MondayAPI\Columns as Columns;
use TBlack\MondayAPI\Item as Item;

class Board extends MondayAPI
{
	static $struct_arguments_board = array(
		'limit' 		=> 'Int',
		'page' 			=> 'Int',
		'ids' 			=> '[Int]',
		'board_kind' 	=> 'BoardKind',	// (public / private / share)
		'state' 		=> 'State',		// (all / active / archived / deleted)
		'newest_first' 	=> 'Boolean',
	);

	static $struct_collection_board = array(
		'activity_logs' 		=> [ 'type' => '[ActivityLogType]' ],
		'board_folder_id' 		=> [ 'type' => 'Int' ],
		'board_kind' 			=> [ 'type' => 'BoardKind' ],
		'columns' 				=> [ 'type' => '[Column]' ],
		'communication' 		=> [ 'type' => 'JSON' ],
		'description' 			=> [ 'type' => 'String' ],
		'groups' 				=> [ 'type' => '[Group]' ],
		'id' 					=> [ 'type' => '!ID' ],
		'items' 				=> [ 'type' => '[Item]' ],
		'name' 					=> [ 'type' => '!String' ],
	);

	private $board_id = false;

	public function enter( Int $board_id )
	{
		$this->board_id = $board_id;
		return $this;
	}

	public function getBoards( Array $fields = [], Array $values = [] )
	{
		if($this->board_id!==false&&!isset($values['ids'])){
			$values['ids']=$this->board_id;
		}
		$boards = $this->create(
			'boards',
			$this->buildArguments(
				$this->buildArgsFields(
					Board::$struct_arguments_board,
					$values
				)
			),
			$this->collection(Board::$struct_collection_board, $fields)
		);

		return $this->request( self::TYPE_QUERY, $boards );
	}

	public function getColumns( Array $fields = [] )
	{
		$columns = $this->create(
			'columns', 
			'', 
			$this->collection(Columns::$struct_columns, $fields)
		);

		$boards = $this->create(
			'boards', 
			$this->buildArguments(
				$this->buildArgsFields( 
					Board::$struct_arguments_board, 
					['ids'=>$this->board_id] 
				)
			), 
			[$columns]
		);

		return $this->request( self::TYPE_QUERY, $boards );
	}
}


?>
