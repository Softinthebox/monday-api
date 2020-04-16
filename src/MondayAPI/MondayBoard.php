<?php 

namespace TBlack\MondayAPI;

class MondayBoard extends MondayAPI
{
	protected $struct_board = array(
		'limit' 		=> 'Int',
		'page' 			=> 'Int',
		'ids' 			=> 'Array',
		'board_kind' 	=> 'BoardKind',	// (public / private / share)
		'state' 		=> 'State',		// (all / active / archived / deleted)
		'newest_first' 	=> 'Bool',
	);

	private function board($query, $get)
	{
		$fields = (is_array($get)&&!empty($get))?implode(' ', $get):'';
		return 'boards'.$query.' { '.$fields.' }';
	}

	public function getBoards( $get = false, $args = false )
	{
		return $this->request( 
			self::TYPE_QUERY, 
			$this->board(
				$this->buildArgs( 
					$this->build( 
						'struct_board', 
						$args
					) 
				), 
				$get
			)
		);	
	}
}


?>