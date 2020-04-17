<?php

namespace TBlack\MondayAPI\ObjectTypes;

use TBlack\MondayAPI\ObjectTypes\ObjectModel;
use TBlack\MondayAPI\ObjectTypes\Column;
use TBlack\MondayAPI\ObjectTypes\Item;

class Board extends ObjectModel
{
	static $scope = 'boards';

	// Arguments
	static $arguments = array(
		'limit' 		=> [ 'type' => 'Int', 		'validate' => 'isInt' 		],
		'page' 			=> [ 'type' => 'Int', 		'validate' => 'isInt' 		],
		'ids' 			=> [ 'type' => '[Int]', 	'validate' => 'isArrayInt' 	],
		'board_kind' 	=> [ 'type' => 'BoardKind', 'validate' => 'isBoardKind' ],	// (public / private / share)
		'state' 		=> [ 'type' => 'State', 	'validate' => 'isState' 	],	// (all / active / archived / deleted)
		'newest_first' 	=> [ 'type' => 'Boolean', 	'validate' => 'isBool' 		]
	);

	// Fields
	static $fields = array(
		'activity_logs' 		=> [ 'type' => '[ActivityLogType]' 	],
		'board_folder_id' 		=> [ 'type' => 'Int' 				],
		'board_kind' 			=> [ 'type' => 'BoardKind' 			],
		'columns' 				=> [ 'type' => '[Column]' 			],
		'communication' 		=> [ 'type' => 'JSON'				],
		'description' 			=> [ 'type' => 'String' 			],
		'groups' 				=> [ 'type' => '[Group]' 			],
		'id' 					=> [ 'type' => '!ID' 				],
		'items' 				=> [ 'type' => '[Item]'				],
		'name' 					=> [ 'type' => '!String'			],
		'owner' 				=> [ 'type' => '!User'				],
		'permissions' 			=> [ 'type' => '!String'			],
		'pos' 					=> [ 'type' => 'String'				],
		'state' 				=> [ 'type' => '!State'				],
		'subscribers' 			=> [ 'type' => '![User]'			],
		'tags' 					=> [ 'type' => '[Tag]'				],
		'top_group' 			=> [ 'type' => '!Group'				],
		'updates' 				=> [ 'type' => '[Update]'			],
		'views' 				=> [ 'type' => '[BoardView]'		]
	);

	
}


?>
